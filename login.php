<?php

// db_connect.php読み込み
require_once('db_connect.php');

// セッション開始
session_start();

// 入力値・エラーメッセージ初期化
$name = '';
$password = '';
$nameError = '';
$passwordError = '';


// POSTでloginが送られた時（=ボタンが押されたとき）以下の処理
if (isset($_POST['login'])) {

  // 各項目の入力をチェックし、値があれば変数に格納
  if (empty($_POST['name'])) {
    $nameError = '未入力です';
  } else {
    $name = $_POST['name'];
  }
  if (empty($_POST['password'])) {
    $passwordError = '未入力です';
  } else {
    $password = $_POST['password'];
  }
  
  // 両方共入力されている場合以下の処理
  if (!empty($_POST['name']) && !empty($_POST['password'])) {

    // PDOのインスタンスを取得
    $pdo = db_connect();

    try {
      // SQL文：入力されたnameに一致するデータを取得
      $sql = "SELECT * FROM users WHERE name = :name";

      // プリペアドステートメントの作成
      $stmt = $pdo->prepare($sql);

      // プレースホルダーに値をバインドする
      $stmt->bindParam(':name', $name);
            
      // 処理の実行
      $stmt->execute();

    } catch (PDOException $e) {
      // エラーメッセージの出力
      // echo 'Error: ' . $e->getMessage();
      echo 'エラーが発生しました。';

      // 終了
      die();
    }

    // 結果が1行取得できたら以下の処理
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

      // 入力されたpasswordと、ハッシュ化して登録していたpasswordの値が同じか判定
      if (password_verify($password, $row['password'])) {

        // セッションに値を保存
        $_SESSION['user_name'] = $row['name'];

        // main.phpにリダイレクト
        header("Location: main.php");
        exit;

      // パスワードが一致しなかった場合
      } else {
        $passwordError = 'ユーザー名かパスワードに誤りがあります。';
      }
    
    // ユーザー名がテーブルになかった時の処理
    } else {
      $passwordError = 'ユーザー名かパスワードに誤りがあります。';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>ログイン</title>
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

          <h1 class="l-main__heading">ログイン</h1>

          <!-- コンテンツ -->
          <div class="p-login">

            <!-- フォーム -->
            <form class="p-login__form" method="POST" action="">
              <input type="text" name="name" placeholder="ユーザー名" value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>">
              <p class="c-error"><?php echo htmlspecialchars($nameError, ENT_QUOTES); ?></p>
              <input type="password" name="password" placeholder="パスワード" value="<?php echo htmlspecialchars($password, ENT_QUOTES); ?>">
              <p class="c-error"><?php echo $passwordError; ?></p>
              <div class="p-login__button">
                <input class="c-button" type="submit" value="ログイン" name="login">
              </div>
            </form>

            <!-- 新規登録リンク -->
            <div class="p-login__link">
              <a href="signup.php">新規登録はこちら</a>
            </div>

          </div>


        </div>
      </main>

    </div> <!-- /l-wrapper -->

  </body>
</html>