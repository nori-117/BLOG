<?php
// db_connect.phpの読み込み
require_once('db_connect.php');

// function.phpの読み込み
require_once('functions.php');

// ログインしていなければ、login.phpにリダイレクト
check_login();

// URLの?以降で渡されるIDを取得 = 記事のID
$id = $_GET['id'];

// $idが空の場合、main.phpにリダイレクト = 不正アクセス対策
redirect_main($id);

// idからpostsテーブルを検索する
$row = find_post($id);

// 関数から取得した値を格納
$id = $row['id'];
$title = $row['title'];
$content = $row['content'];
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
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
        
          <h1 class="c-heading"><?php echo htmlspecialchars($row['title'], ENT_QUOTES); ?></h1>

          <div class="p-view">
            <p class="p-view__content"><?php echo htmlspecialchars($row['content'], ENT_QUOTES); ?></p>
          </div>

        </div>
      </main>

    </div> <!-- /l-wrapper -->

  </body>
</html>