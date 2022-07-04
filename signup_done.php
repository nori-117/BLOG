<?php

// function.phpの読み込み
require_once('functions.php');

// ログインしていなければ、login.phpにリダイレクト
check_login();

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>登録完了</title>
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

          <h1 class="l-main__heading">ユーザー登録が完了しました。</h1>

          <p class="p-signup-done">

            <div class="p-signup-done__link">
              <a class="c-link" href="main.php">トップへ</a>
            </div>

          </p>
          
        </div>
      </main>

    </div> <!-- /l-wrapper -->

  </body>
</html>