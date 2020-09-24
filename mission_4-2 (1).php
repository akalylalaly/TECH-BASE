<?php
	// DB接続設定
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	//テーブル作成、テーブル名：tbtest
	$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY," //登録できる項目（カラム）はid・自動で登録されているナンバリング
	. "name char(32)," //名前を入れる。文字列、半角英数で32文字
	. "comment TEXT" //コメントを入れる。文字列、長めの文章も入る
	.");";
	$stmt = $pdo->query($sql);
?>