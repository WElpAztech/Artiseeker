<?php

require_once 'config.php';

session_start();

if(!isset($_SESSION['username']) || $_SESSION['username'] == null) {
  header("Location: login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['new_username'])) {
        $new_username = $_POST['new_username'];

        $sql = "UPDATE users SET username = :username WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $new_username);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();

        $_SESSION['username'] = $new_username;
    }

    if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
      $new_password = $_POST['new_password'];
      $confirm_password = $_POST['confirm_password'];

      if ($new_password != $confirm_password) {
          echo "New passwords do not match.";
          exit;
      }

      $sql = "SELECT password FROM users WHERE id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':id', $_SESSION['user_id']);
      $stmt->execute();
      $current_password_hash = $stmt->fetchColumn();

      if (password_verify($new_password, $current_password_hash)) {
          echo "You can't change the password to the same one you have.";
          exit;
      }

      $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

      $sql = "UPDATE users SET password = :password WHERE id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':password', $new_password_hash);
      $stmt->bindParam(':id', $_SESSION['user_id']);
      $stmt->execute();

      session_destroy();
      header("Location: login.php");
      exit;
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit;
    }

    $stmt = null;
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
    <div class="container">
        <h1>Change Username</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="new_username">New Username:</label><br>
            <input type="text" id="new_username" name="new_username" required><br>
            <input type="submit" value="Change Username">
        </form>
        <h1>Change Password</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <label for="new_password">New Password:</label><br>
          <input type="password" id="new_password" name="new_password" required autocomplete="off"><br>
          <label for="confirm_password">Confirm New Password:</label><br>
          <input type="password" id="confirm_password" name="confirm_password" required autocomplete="off"><br>
          <input type="submit" value="Reset Password">
        </form>
        <h1>Logout</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <input type="submit" name="logout" value="Logout">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>