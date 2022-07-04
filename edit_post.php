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

// 入力値・エラーメッセージ初期化
$titleError = '';
$contentError = '';
$completeMessage = '';


// POSTでcreateが送られた時（=ボタンが押されたとき）以下の処理
if (!empty($_POST['update'])) {

  // 各項目の入力をチェックし、値があれば変数に格納
  if (empty($_POST['title'])) {
    $titleError = '未入力です';
  } else {
    $title = $_POST['title'];
  }
  if (empty($_POST['content'])) {
    $contentError = '未入力です';
  } else {
    $content = $_POST['content'];
  }

  // 両方共入力されている場合以下の処理
  if (!empty($_POST['title']) && !empty($_POST['content'])) {

    // PDOのインスタンスを取得
    $pdo = db_connect();

    try {
      // SQL文：一致するidのtitleとcontentを書き換える
      $sql = "UPDATE posts SET title = :title, content = :content WHERE id = :id";

      // プリペアドステートメントの作成
      $stmt = $pdo->prepare($sql);

      // プレースホルダーに値をバインドする
      $stmt->bindParam(':title', $title);
      $stmt->bindParam(':content', $content);
      $stmt->bindParam(':id', $id);

      // 処理の実行
      $stmt->execute();

      // 出力メッセージ
      $completeMessage = '更新が完了しました！';

    } catch (PDOException $e) {
      // エラーメッセージの出力
      // echo 'Error: ' . $e->getMessage();
      echo 'エラーが発生しました。';

      // 終了
      die();
    }
  }
}
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
        
        <h1 class="c-heading">投稿記事編集</h1>

        <!-- リンク -->
        <div class="c-links">
          <a href="main.php">トップへ</a>
          <a href="logout.php">ログアウト</a>
        </div>

        <!-- コンテンツ -->
        <div class="p-edit">

            <!-- フォーム -->
            <form class="p-edit__form" method="POST" action="">
              <input type="text" name="title" placeholder="タイトル" value="<?php echo htmlspecialchars($title, ENT_QUOTES);?>">
              <p class="c-error"><?php echo $titleError; ?></p>

              <textarea name="content" cols="30" rows="10" placeholder="内容"><?php echo htmlspecialchars($content, ENT_QUOTES);?></textarea>
              <p class="c-error"><?php echo $contentError; ?></p>

              <div class="buttons">
                <input class="back-button c-small-button" type="button" value="戻る" onClick="history.back()" />
                <input class="update-button c-small-button"  type="submit" value="更新" name="update">
              </div>

            </form>

            <!-- メッセージ -->
            <p class="p-create__message"><?php echo $completeMessage; ?></p>


        </div>


        </div>
      </main>

    </div> <!-- /l-wrapper -->

  </body>
</html>