<?php
// db_connect.phpの読み込み
require_once('db_connect.php');

// function.phpの読み込み
require_once('functions.php');

// ログインしていなければ、login.phpにリダイレクト
check_login();


// PDOのインスタンスを取得
$pdo = db_connect();

try {
  // SQL文：postテーブルの情報をid降順で全て取得
  $sql = "SELECT * FROM posts ORDER BY id desc";

  // プリペアドステートメントの作成
  $stmt = $pdo->prepare($sql);

  // 実行
  $stmt->execute();

} catch (PDOException $e) {
  // エラーメッセージの出力
  // echo 'Error: ' . $e->getMessage();
  echo 'エラーが発生しました。';

  // 終了
  die();
}

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>記事一覧</title>
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

          <h1 class="l-main__heading">投稿記事一覧</h1>

          <div class="c-links">
            <span>ようこそ <?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES); ?> さん</span>
            <a href="create_post.php">新規投稿</a>
            <a href="logout.php">ログアウト</a>
          </div>

          <div class="p-main">

            <div class="p-main__table">
              <table>
                
                <tr>
                  <th>タイトル</th>
                  <th>投稿日</th>
                  <th></th>
                  <th></th>
                  <th></th>
                </tr>
    
                <!-- SQL文で取得したデータをあるだけ表示 -->
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['title'], ENT_QUOTES); ?></td>
                  <td><?php echo $row['time']; ?></td>
                  <td><a class="c-small-button view-button" href="view.php?id=<?php echo $row['id']; ?>">view</a></td>
                  <td><a class="c-small-button edit-button" href="edit_post.php?id=<?php echo $row['id']; ?>">編集</a></td>
                  <td><a class="c-small-button delete-button" href="delete_post.php?id=<?php echo $row['id']; ?>">削除</a></td>
                </tr>
                <?php } ?>
  
              </table>
            </div>
            
          </div>
          
        </div>
      </main>

    </div> <!-- /l-wrapper -->

  </body>
</html>