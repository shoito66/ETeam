<?php

// データベース接続情報
$serverName = "koko.database.windows.net"; // サーバー名
$username = "koko-sql"; // ユーザー名
$password = "Admintest1"; // パスワード
$database = "kokoDataBase"; // データベース名

// ユーザーからの検索キーワードを受け取る
$search_term = urldecode($_GET['search_term']);
$search_gamen = urldecode($_GET['search_gamen']);

// データベースへの接続
$conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 検索クエリの作成
$sql = "SELECT id, name, type1, type2, series, detail FROM dbo.pokemon where series = '" .$search_term ."'";
$stmt = $conn->prepare($sql);

// クエリを実行
$stmt->execute();

// 結果を取得
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
// 結果をセッションに保存してリダイレクト
session_start();
$_SESSION['results'] = $results;
header('Location: result.php');

// データベース接続のクローズ
$conn = null;
?>
