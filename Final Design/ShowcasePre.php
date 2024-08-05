<?php

require_once 'config.php';

session_start();

$body = ''; // Initialize $body

if (isset($_POST['uid'])) {
  $uid = $_POST['uid'];
  if (empty($uid)) {
      $error = "UID cannot be empty.";
  } else if (!ctype_digit($uid)) {
      $error = "UID must be an integer.";
  } else if (strlen($uid) < 9 || strlen($uid) > 10) {
      $error = "UID must be 9 to 10 digits long.";
  } else {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://enka.network/api/uid/$uid?info",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "User-Agent: YourCustomUserAgent",
            "cache-control: no-cache"
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    if ($httpcode == 404) {
        $error = "Invalid UID";
    } else {
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
    
        $data = json_decode($body, true);
    
        if ($data === null) {
            $error = "Invalid UID";
        } else {
            $_SESSION['uid'] = $uid;
            header('Location: Redesign\Character.php');
            exit();
        }
    }
    
    curl_close($curl);

    if ($body) { // Check if $body is not empty before decoding
        $data = json_decode($body, true);

        if ($data === null) {
            $error = "Invalid UID.";
        } else {
            $_SESSION['uid'] = $uid;
            header('Location: Redesign\Character.php');
            exit();
        }
    }
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Artiseeker</title>
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
              <a class="nav-link" href="Redesign\Character.php">Showcase</a>
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
    <h3>Input a genshin uid</h3>

    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>
    
    <form method="post">
        <input type="text" name="uid" required>
        <input type="submit" value="Submit">
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>