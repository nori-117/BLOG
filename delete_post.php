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


// PDOのインスタンスを取得
$pdo = db_connect();

try {
  // SQL文：一致するidのデータを削除
  $sql = "DELETE FROM posts WHERE id = :id";
  
  // プリペアドステートメントの作成
  $stmt = $pdo->prepare($sql);

  // プレースホルダーに値をバインドする
  $stmt->bindParam(':id', $id);

  // 処理の実行
  $stmt->execute();

  // main.phpにリダイレクト
  header("Location: main.php");
  exit;

} catch (PDOException $e) {
  // エラーメッセージの出力
  // echo 'Error: ' . $e->getMessage();
  echo 'エラーが発生しました。';

  // 終了
  die();
}