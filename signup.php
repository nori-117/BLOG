<?php

// db_connect.php読み込み
require_once('db_connect.php');

// セッション開始
session_start();

// 入力値・エラーメッセージ初期化
$name = '';
$password01 = '';
$password02 = '';

$nameError = '';
$password01Error = '';
$password02Error = '';


// POSTでsignupが送られた時（=ボタンが押されたとき）以下の処理
if (isset($_POST['signup'])) {

  // 各項目の入力をチェックし、値があれば変数に格納
  if (empty($_POST['name'])) {
    $nameError = '未入力です';
  } else {
    $name = $_POST['name'];
  }
  if (empty($_POST['password01'])) {
    $password01Error = '未入力です';
  } else {
    $password01 = $_POST['password01'];
  }
  if (empty($_POST['password02'])) {
    $password02Error = '未入力です';
  } else {
    $password02 = $_POST['password02'];
  }


  // 全ての項目が入力済みの場合以下の処理
  if (!empty($_POST['name']) && !empty($_POST['password01']) && !empty($_POST['password02'])) {

    // ユーザー名が既に存在するか確認
    // PDOのインスタンスを取得
    $pdo = db_connect();

    try {
      // SQL文：入力されたnameに一致するデータが存在するか確認
      $sql = "SELECT EXISTS (SELECT * FROM users WHERE name = :name) as userA";

      // プリペアドステートメントの作成
      $stmt = $pdo->prepare($sql);
    
      // プレースホルダーに値をバインドする
      $stmt->bindParam(':name', $name);
    
      // 処理の実行
      $stmt->execute();

      // exit;

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      //  1 = true（存在するとき）
      if($row['userA'] == 1) {
        $nameError = '既にユーザー名が使用されています';
        
      // 0 = false（存在しないとき）→パスワードチェックへ
      } else if($row['userA'] == 0) {

        // パスワード01・02が一致するとき
        if($_POST['password01'] === $_POST['password02']) {

          // パスワードをハッシュ化
          $password_hash = password_hash($password01, PASSWORD_DEFAULT);
      
          // PDOのインスタンスを取得
          $pdo = db_connect();
      
          try {
            // SQL文：nameとpasswordをusersテーブルに登録する
            $sql = "INSERT INTO users (name, password) VALUES (:name, :password)";
      
            // プリペアドステートメントの作成
            $stmt = $pdo->prepare($sql);
          
            // プレースホルダーに値をバインドする
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':password', $password_hash);
          
            // 処理の実行
            $stmt->execute();

            // セッションに値を保存
            $_SESSION['user_name'] = $name;

            // signup_done.phpにリダイレクト
            header("Location: signup_done.php");
            exit;
          
          }catch (PDOException $e) {
      
            // エラーメッセージの出力
            // echo 'Error: ' . $e->getMessage();
            echo 'エラーが発生しました。';
            
            // 終了
            die();
          }

        // パスワード01・02が一致しないとき
        } else {
          $password02Error = 'パスワードが一致しません';
        }

      }
    
    }catch (PDOException $e) {
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
    <title>新規登録</title>
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

          <h1 class="l-main__heading">ユーザー新規登録</h1>

          <!-- コンテンツ -->
          <div class="p-signup">

            <!-- フォーム -->
            <form class="p-signup__form" method="POST" action="">
              <input type="text" name="name" placeholder="ユーザー名" value="<?php echo $name; ?>">
              <p class="c-error"><?php echo $nameError; ?></p>
              <input type="password" name="password01" placeholder="パスワード" value="<?php echo $password01; ?>">
              <p class="c-error"><?php echo $password01Error; ?></p>
              <input type="password" name="password02" placeholder="パスワード（確認）" value="<?php echo $password02; ?>">
              <p class="c-error"><?php echo $password02Error; ?></p>
              <div class="p-signup__button">
                <input class="c-button" type="submit" value="新規登録" name="signup">
              </div>
            </form>

          </div>


        </div>
      </main>

    </div> <!-- /l-wrapper -->

  </body>
</html>