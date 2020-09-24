<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-3</title>
</head>
<body>
    <form action="" method="post">   <!--入力フォーム、POST送信-->
        <input type="text" name="name" value="名前"> <br/> <!--「名前」のフォーム-->
        <input type="text" name="str" value="コメント">  <!--「コメント」のフォーム-->
        <input type="submit" name="submit">            <!--送信ボタン-->
    </form>
    
    <br>
    
    <form action="" method="post">   <!--入力フォーム、POST送信-->
        <input type="text" name="delete" value="削除対象番号"> <!--「削除」のフォーム-->
        <input type="submit" name="deletebutton" value="削除">            <!--送信ボタン-->
    </form>
    
    
    <?php
         $name=$_POST["name"];        //名前のPOST受信
         $str=$_POST["str"];         //コメントのPOST受信
         $delete=$_POST["delete"];    //削除のPOST受信
         $filename="mission_3-3.txt";   //テキストファイル
         if(file_exists($filename)){    //投稿番号
                 $number=count(file($filename))+1;  //ファイルがあったら番号を1ずつ増やす
             }else{
                 $number=1;                 //ファイルがなかったら番号を1にする
             }
         $date=date("Y/m/d H:i:s");   //投稿日時
         $write=$number."<>".$name."<>".$str."<>".$date;  //番号、名前、コメント、日時を一列に結合
        
         
         
         //送信フォームについて
         if($name==""){                 //名前が空欄だったら何も表示しない
             echo "";
         }elseif($name=="名前"){            //名前がそのままだったら何も表示しない
             echo "";
         }elseif($str==""){                 //コメントが空欄だったら何も表示しない
             echo "";
         }elseif($str=="コメント"){         //コメントがそのままだったら何も表示しない
             echo "";
         }else{
             $fp = fopen($filename,"a");     //追記モードでテキストファイルオープン
              fwrite($fp,$write.PHP_EOL);     //ファイルに書き込み  
              fclose($fp);                    //ファイルクローズ
         
         //ブラウザに表示させる
             $lines=file($filename,FILE_IGNORE_NEW_LINES);  //txtファイルの中身を配列に格納
             foreach($lines as $line){
             $array=explode("<>",$line);
             echo $array[0]." ";
             echo $array[1]." ";
             echo $array[2]." ";
             echo $array[3]."<br>";
             }
             
         }
        
        
        
         //削除フォームについて
         if($delete==""){                   //削除が空欄だったら何も表示しない
             echo "";
         }elseif($delete=="削除対象番号"){    //削除がそのままだったら何も表示しない
             echo "";
         }else{
             $lines=file($filename,FILE_IGNORE_NEW_LINES); //txtファイルの中身を配列に格納
             $fp = fopen($filename,"w");     //上書きモードでテキストファイルオープン
             for($i=0; $i<$number; $i++){
                 $array=explode("<>",$lines[$i],4);
                 
                 if($array[0]!=$delete){             //投稿番号が削除対象番号でなければ
                     fwrite($fp,$lines[$i].PHP_EOL);     //ファイルに書き込み
                 }else{                              //投稿番号が削除対象番号だったら
                     fwrite($fp,"この投稿は削除しました。".PHP_EOL); //と書き込む
                 }
             }
             fclose($fp);                        //ファイルクローズ
         //ブラウザに表示させる
             $lines=file($filename,FILE_IGNORE_NEW_LINES);  //txtファイルの中身を配列に格納
             foreach($lines as $line){
             $array=explode("<>",$line);
             echo $array[0]." ";
             echo $array[1]." ";
             echo $array[2]." ";
             echo $array[3]."<br>";
             }
         }
    ?>
</body>
</html>