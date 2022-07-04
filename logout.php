<?php
// セッション開始
session_start();

// セッション変数のクリア
$_SESSION = array();

// セッションクリア
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>My Blog</title>
  <meta name=viewport content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
</head>
  <body>
    <div class="l-wrapper">

      <!-- header -->
      <header class="l-header">
        <p class="l-header__title">My Blog</p>
      </header>

      <!-- main -->
      <main class="l-main">
        <div class="l-main__inner">

          <h1 class="c-heading">ログアウトしました</h1>

          <div class="p-logout">
            <div class="p-logout__link">
              <a href="login.php">ログイン画面へ</a>
            </div>
          </div>

        </div>
      </main>

    </div> <!-- /l-wrapper -->

  </body>
</html>