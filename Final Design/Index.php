<?php
require_once 'config.php';

session_start();

$uidError = null;
$successMessage = null;
$loginIn = null;

if (isset($_SESSION['username'])) {
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
      session_destroy();
      header("Location: login.php");
      exit();
  }
}
  function makeApiRequest($uid) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://enka.network/api/uid/$uid?Info",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "User-Agent: YourCustomUserAgent",
            "cache-control: no-cache"
        ),
    ));

    $retry = 0;
    $maxRetries = 3;
    $data = null;

    while($retry < $maxRetries) {
      $response = curl_exec($curl);
      if($response === false) {
          $retry++;
          sleep(1);
      } else {
          $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
          $body = substr($response, $header_size);
          $data = json_decode($body, true);
          if (isset($data['error']) || empty($data) || (isset($data['message']) && $data['message'] == 'This player does not exist.')) {
              $data = null;

              $host = 'localhost';
              $dbname = 'Artiseeker';
              $username = 'bit_academy';
              $password = 'bit_academy';
              $charset = 'utf8mb4';

              $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
              $opt = [
                  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                  PDO::ATTR_EMULATE_PREPARES   => false,
              ];
              $pdo = new PDO($dsn, $username, $password, $opt);

              $_SESSION['successMessage'] = "UID was invalid.";
              echo "test";

              $userId = $_SESSION['user_id'];
              $stmt = $pdo->prepare("DELETE FROM genshin_uids WHERE user_id = ? AND genshin_uid = ?");
              $stmt->execute([$userId, $uid]);
          }
          break;
        }
    } 

    curl_close($curl);

    return $data;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["uid"])) {
        $uid = $_POST["uid"];
        $uid = trim($uid);
        if (empty($uid)) {
            $uidError = "UID cannot be empty.";
        } else
        if (!ctype_digit($uid)) {
            $uidError = "UID must be an integer.";
        } elseif (strlen($uid) < 9 || strlen($uid) > 10) {
            $uidError = "UID must be 9 to 10 digits long.";
        } else {
            $userId = $_SESSION['user_id'];

            $stmt = $pdo->prepare("SELECT * FROM genshin_uids WHERE user_id = ? AND genshin_uid = ?");
            $stmt->execute([$userId, $uid]);
            $existingUid = $stmt->fetch();

            if ($existingUid) {
                $uidError = "This UID already exists for the current user.";
            } else {
                $stmt = $pdo->prepare("SELECT * FROM genshin_uids WHERE genshin_uid = ?");
                $stmt->execute([$uid]);
                $existingUid = $stmt->fetch();

                if ($existingUid) {
                    $uidError = "This UID is already in use by another user.";
                } else {
                    $apiResponse = makeApiRequest($uid);
                    if ($apiResponse === null) {
                        $uidError = "Invalid UID.";
                    } else {
                        $stmt = $pdo->prepare("INSERT INTO genshin_uids (user_id, genshin_uid) VALUES (?, ?)");
                        $stmt->execute([$userId, $uid]);

                        $_SESSION['successMessage'] = "UID added successfully.";

                        header("Location: Index.php");
                        exit;
                    }
                }
            }
        }
    }

    if (isset($_POST["delete_uid"])) {
      if (empty($_POST["delete_uid"])) {
          $uidError = "UID cannot be empty.";
      }

      $deleteUid = $_POST["delete_uid"];
      $deleteUid = trim($deleteUid);

      if (!ctype_digit($deleteUid)) {
          $uidError = "UID must be an integer.";
      } elseif (strlen($deleteUid) < 9 || strlen($deleteUid) > 10) {
          $uidError = "UID must be 9 to 10 digits long.";
      } else {
          $userId = $_SESSION['user_id'];

          $stmt = $pdo->prepare("DELETE FROM genshin_uids WHERE user_id = ? AND genshin_uid = ?");
          $stmt->execute([$userId, $deleteUid]);

          $_SESSION['successMessage'] = "UID deleted successfully.";

          header("Location: Index.php");
          exit;
      }
    }
  } // This is the closing bracket that was missing


  if (isset($_POST["edit_uid"]) && isset($_POST["new_uid"])) {
    $editUid = trim($_POST["edit_uid"]);
    $newUid = trim($_POST["new_uid"]);
    if (empty($editUid) || empty($newUid)) {
        $uidError = "UIDs cannot be empty.";
    } else
    if (!ctype_digit($editUid) || !ctype_digit($newUid)) {
        $uidError = "UIDs must be integers.";
    } elseif ((strlen($editUid) < 9 || strlen($editUid) > 10) || (strlen($newUid) < 9 || strlen($newUid) > 10)) {
        $uidError = "UIDs must be 9 to 10 digits long.";
    } else {
        $userId = $_SESSION['user_id'];

        $stmt = $pdo->prepare("SELECT * FROM genshin_uids WHERE genshin_uid = ?");
        $stmt->execute([$newUid]);
        if ($stmt->rowCount() > 0) {
            $uidError = "The new UID is already in use.";
        } else {
            $stmt = $pdo->prepare("UPDATE genshin_uids SET genshin_uid = ? WHERE user_id = ? AND genshin_uid = ?");

            $stmt->execute([$newUid, $userId, $editUid]);

            if ($stmt->rowCount() > 0) {
                $_SESSION['successMessage'] = "UID was successfully edited.";
            } else {
                $uidError = "Failed to update UID. Please ensure the old UID exists.";
            }

            header("Location: Index.php");
            exit;
        }
    }
  }

  if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
  }

  $stmt = $pdo->prepare("SELECT genshin_uid FROM genshin_uids WHERE user_id = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $uids = $stmt->fetchAll(PDO::FETCH_ASSOC);

  ?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="genshin-impact.css">
  </head>
  <body>
      
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Artiseeker</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="ShowcasePre.php">Showcase</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Index.php">Profile</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="Settings.php"><?php echo $_SESSION['username']; ?></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <?php

  if ($loginIn) {
    echo "<span style='color:black;'>$loginIn</span>";
  }

  ?>

  <form method="POST">
      <input type="text" name="uid" placeholder="Enter UID">
      <input type="submit" value="Submit">
  </form>

  <form method="POST">
      <input type="text" name="delete_uid" placeholder="Delete UID">
      <input type="submit" value="Delete">
  </form>

  <form method="POST">
      <input type="text" name="edit_uid" placeholder="Old UID">
      <input type="text" name="new_uid" placeholder="New UID">
      <input type="submit" value="Edit">
  </form>

  <?php

  if ($uidError) {
    echo "<span style='color:red;'>$uidError</span><br>";
  }

  if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
    echo "<span style='color:green;'>$successMessage</span><br>";

    unset($_SESSION['successMessage']);
  }
  ?>

  <br>
  <h4>Home / Profile</h4>
  <h1><strong>Accounts</strong></h1>
  <br>

  <?php

  $counter = 0;
  foreach ($uids as $uid) {

    if ($counter >= 10) {
      break;
    }

    $uidValue = $uid['genshin_uid'];

    $data = makeApiRequest($uidValue);
    if ($data === null || isset($data['error'])) {
      $uidError = "Invalid UID.";
      continue;
    }

    $pfpsJson = file_get_contents('Redesign\json\pfps.json');
    $pfpsData = json_decode($pfpsJson, true);

    $profileId = $data['playerInfo']['profilePicture']['avatarId'] ?? $data['playerInfo']['profilePicture']['id'] ?? null;
    $uid = $uid['genshin_uid'] ?? null;
    $nickname = $data['playerInfo']['nickname'] ?? null;
    $level = $data['playerInfo']['level'] ?? null;
    $signature = $data['playerInfo']['signature'] ?? '';
    $iconPath = $pfpsData[$profileId]['iconPath'] ?? null;

    echo '<div style="background-color: rgb(218, 218, 219); width: 80%; padding: 5px 10px 5px 10px; margin: 10px auto; display: flex; align-items: center; border-radius: 50px;">';
    echo '<img src="https://enka.network/ui/' . $iconPath . '.png" class="rounded-circle" style="border: 3px solid white; margin-right: 10px;" width="100" height="100">';
    echo "<p style='margin-top: -3%; margin-left: 2%; font-size: 40px;'>$nickname</p>";
    echo "<p style='margin-top: -2%; margin-left: 1%; font-size: 20px;'>$uid</p>";
    echo "<p style='position: absolute; margin-top: 3%; margin-left: 9%; font-size: 25px;'>Adventure Rank: {$level}</p>";
    echo "<p style='position: absolute; margin-top: 3.2%; margin-left: 24.5%; color: #93806a !important; font-size: 20px;'>" . (!empty($data['playerInfo']['signature']) ? $data['playerInfo']['signature'] : '') . "</p>";
    echo '</div>';

    $counter++;
  }

  ?>

  </body>
  </html>