<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
<?php
	// DB接続設定
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	//テーブル作成、テーブル名：mission5
	$sql = "CREATE TABLE IF NOT EXISTS mission5"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY," //登録できる項目（カラム）はid・自動で登録されているナンバリング
	. "name char(32)," //名前を入れる。文字列、半角英数で32文字
	. "comment TEXT," //コメントを入れる。文字列、長めの文章も入る
	. "pass TEXT,"    //パスワードを入れる。
	. "date DATETIME" //日付を入れる。
	.");";
	$stmt = $pdo->query($sql);
	

	//削除機能について（DELETE文で入力したデータレコードを削除）
	if(isset($_POST["delete"])&&isset($_POST["delpassword"])){   //削除対象番号とそのパスワードが送信されたら
        $delete=$_POST["delete"];           //削除対象番号のPOST受信
        $delpassword=$_POST["delpassword"]; //削除のときのパスワードのPOST受信
    	$sql = 'SELECT * FROM mission5 WHERE id=:delete'; //削除対象番号の投稿を選択
    	$stmt = $pdo->prepare($sql);
    	$stmt->bindParam(':delete', $delete, PDO::PARAM_INT);
    	$stmt->execute();
    	$results = $stmt->fetchAll();
    	foreach ($results as $row){
	        if($row['pass']==$delpassword){                    //パスワードが一致したら
	            $sql = 'delete from mission5 WHERE id=:delete';//その投稿を削除し
	            $stmt = $pdo->prepare($sql);
    	        $stmt->bindParam(':delete', $delete, PDO::PARAM_INT);
    	        $stmt->execute();
    	        echo "削除しました。";          //と表示
	        }else{                              //パスワードが一致しなかったら
	            echo "パスワードが違います。";  //と表示
	        }
    	}
	}
	
	//新規投稿機能について（INSERT文でデータを入力）
	if(isset($_POST["name"])&&isset($_POST["comment"])&&isset($_POST["pass"])&&empty($_POST["hide"])){ //名前とコメントとパスワードだけが送信されたら
        $name=$_POST["name"];         //名前のPOST受信
        $comment=$_POST["comment"];   //コメントのPOST受信
        $pass=$_POST["pass"];         //新規投稿のときのパスワードのPOST受信
        $date=date("Y/m/d H:i:s");    //投稿日時
        //名前、コメント、パスワード、投稿日時を入力
        $sql = $pdo -> prepare("INSERT INTO mission5 (name, comment, pass, date) VALUES (:name, :comment, :pass, :date)");
	    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
        $sql -> execute();
	}
	
    
    //編集機能について
    if(isset($_POST["edit"])&&empty($_POST["name"])&&empty($_POST["comment"])&&empty($_POST["hide"])){ //編集対象番号だけが送信されたら
        $edit=$_POST["edit"];                 //編集対象番号のPOST受信
        $editpassword=$_POST["editpassword"]; //編集のときのパスワードのPOST受信
        $sql = 'SELECT * FROM mission5 WHERE id=:edit'; //編集対象番号の投稿を選択
	    $stmt = $pdo->prepare($sql);
	    $stmt->bindParam(':edit', $edit, PDO::PARAM_INT);
	    $stmt->execute();
	    $results = $stmt->fetchAll();
	    foreach ($results as $row){
	        if($row['pass']==$editpassword){  //パスワードが一致したら
	            $editnumber=$row['id'];       //隠してある編集対象番号表示用フォームに番号表示のためデータ取得
                $editname=$row['name'];       //名前フォームに名前を表示のためデータ取得
                $editcomment=$row['comment']; //コメントフォームにコメントを表示のためデータ取得
                $editpass=$row['pass'];       //パスワードフォームにパスワードを表示のためデータ取得
                //表示機能はフォームのvalue属性で対応
            }elseif($row['id']==$edit && $row['pass']!=$editpassword){ //パスワードが一致しなかったら
                echo "パスワードが違います。";                         //と表示
            }   
        }
    
    
	//編集実行（UPDATE文でデータレコードの内容を編集）
	}if(isset($_POST["name"])&&isset($_POST["comment"])&&isset($_POST["hide"])){  //編集内容が送信されたら
        $hide=$_POST["hide"];         //編集対象番号のPOST受信
        $name=$_POST["name"];         //名前のPOST受信
        $comment=$_POST["comment"];   //コメントのPOST受信
        $pass=$_POST["pass"];         //パスワードのPOST受信
        $date=date("Y/m/d H:i:s");    //投稿日時
        //編集対象番号の投稿の、名前、コメント、パスワード、投稿日時を編集
        $sql = 'UPDATE mission5 SET name=:name, comment=:comment, pass=:pass, date=:date WHERE id=:hide';
	    $stmt = $pdo->prepare($sql);
	    $stmt->bindParam(':hide', $hide, PDO::PARAM_STR);
	    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
	    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
	    $stmt->execute();
	}
?>
	
	<form action="" method="post">   <!--入力フォーム、POST送信-->
        <input type="text" name="name" placeholder="名前" 
               value="<?php if(isset($editname)) {echo $editname;} ?>"> <br> <!--「名前」のフォーム、編集で指定されたらその名前表示-->
        <input type="text" name="comment" placeholder="コメント"
               value="<?php if(isset($editcomment)) {echo $editcomment;} ?>"> <br><!--「コメント」のフォーム、編集で指定されたらそのコメント表示-->
        <input type="text" name="pass" placeholder="パスワード"
               value="<?php if(isset($editpass)) {echo $editpass;} ?>"><!--「パスワード」のフォーム、編集で指定されたらそのパスワード表示-->
        <input type="hidden" name="hide"
               value="<?php if(isset($editnumber)) {echo $editnumber;} ?>">   <!--隠しておく編集対象番号表示フォーム、編集で指定されたらその番号表示-->
        <input type="submit" name="submit">            <!--送信ボタン-->
    </form>
    
    <br>
    
    <form action="" method="post">   <!--入力フォーム、POST送信-->
        <input type="number" name="delete" placeholder="削除対象番号"> <br/> <!--「削除」のフォーム-->
        <input type="text" name="delpassword" placeholder="パスワード"> <!--「パスワード」のフォーム-->
        <input type="submit" name="deletebutton" value="削除">            <!--送信ボタン-->
    </form>
    
    <br>
    
    <form action="" method="post">   <!--入力フォーム、POST送信-->
        <input type="number" name="edit" placeholder="編集対象番号"> <br/><!--「編集」のフォーム-->
        <input type="text" name="editpassword" placeholder="パスワード"> <!--「パスワード」のフォーム-->
        <input type="submit" name="editbutton" value="編集">            <!--送信ボタン-->
    </form>
    
    
<?php    
	//入力したデータレコードを抽出し表示
	$sql = 'SELECT * FROM mission5';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['pass'].',';
		echo $row['date'].'<br>';
	echo "<hr>";
	}
?>

</body>
</html>