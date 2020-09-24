<?php
	// DB接続設定
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	//UPDATE文で入力済のデータレコードの内容を編集
	$id = 1;   //編集する投稿番号
	$name = "編集";  //名前を編集
	$comment = "したよ";  //コメントを編集
	$sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
	//WHERE句省略するとテーブルの全レコードが更新される
	//WHERE句で名前を指定するとその名前のデータレコードが更新される
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	
	//入力したデータレコードを抽出し表示
	$sql = 'SELECT * FROM tbtest';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中はテーブルのカラム名に合わせる
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
	echo "<hr>";
	}
?>