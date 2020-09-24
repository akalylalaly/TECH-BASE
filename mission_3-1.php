<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-1</title>
</head>
<body>
    <form action="" method="post">   <!--入力フォーム、POST送信-->
        <input type="text" name="name" value="名前"> <br/> <!--「名前」のフォーム-->
        <input type="text" name="str" value="コメント">  <!--「コメント」のフォーム-->
        <input type="submit" name="submit">            <!--送信ボタン-->
    </form>
    
    <?php
         $name=$_POST["name"];        //名前のPOST受信
         $str=$_POST["str"];         //コメントのPOST受信
         if($name==""){              //最初にページを開いたときに「を受け付け～」を表示させない
             echo "";
         }elseif($str==""){               //最初にページを開いたときに「を受け付け～」を表示させない
             echo "";
         }elseif($name=="名前"){     //「名前」のまま送信されたときに表示させない
             echo "";
         }elseif($str=="コメント"){  //「コメント」のまま送信されたときに表示させない
             echo "";
         }else{
             echo $name."<br>".$str."を受け付けました<br>";   //「名前」「コメント」が送信されたときに表示
         }
         

         
         if($name==""){                     //名前が空欄だったら何も表示しない
             echo "";
         }elseif($name=="名前"){            //名前がそのままだったら何も表示しない
             echo "";
         }elseif($str==""){                 //コメントが空欄だったら何も表示しない
             echo "";
         }elseif($str=="コメント"){         //コメントがそのままだったら何も表示しない
             echo "";
         }else{
             $filename="mission_3-1.txt";   //テキストファイル
             
             if(file_exists($filename)){    //投稿番号
                 $number=count(file($filename))+1;  //ファイルがあったら番号を1ずつ増やす
             }else{
                 $number=1;                 //ファイルがなかったら番号を1にする
             }
             
             $date=date("Y/m/d H:i:s");   //投稿日時
             
             $write=$number."<>".$name."<>".$str."<>".$date;  //番号、名前、コメント、日時を一列に結合
             $fp = fopen($filename,"a");     //追記モードでテキストファイルオープン
             fwrite($fp,$write.PHP_EOL);     //ファイルに書き込み  
             fclose($fp);                    //ファイルクローズ
         }
    ?>
</body>
</html>