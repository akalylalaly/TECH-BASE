<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-4</title>
</head>
<body>
    <?php
         $name=$_POST["name"];        //名前のPOST受信
         $str=$_POST["str"];         //コメントのPOST受信
         $hide=$_POST["hiddennumber"]; //後で隠す編集対象番号のPOST受信
         $delete=$_POST["delete"];    //削除のPOST受信
         $edit=$_POST["edit"];   //編集番号指定のPOST受信
         $filename="mission_3-4.txt";   //テキストファイル
         if(file_exists($filename)){    //投稿番号
             $number=count(file($filename))+1;  //ファイルがあったら番号を1ずつ増やす
         }else{
             $number=1;                 //ファイルがなかったら番号を1にする
         }
         $date=date("Y/m/d H:i:s");   //投稿日時
         $write=$number."<>".$name."<>".$str."<>".$date;  //番号、名前、コメント、日時を一列に結合
        
        
         //削除フォームについて
         if(isset($delete)){                   //削除が送信されたら
             $dellines=file($filename,FILE_IGNORE_NEW_LINES); //txtファイルの中身を配列に格納
             $fp = fopen($filename,"w");     //上書きモードでテキストファイルオープン
             for($i=0; $i<$number; $i++){
                  $array=explode("<>",$dellines[$i],4);
                 
                  if($array[0]!=$delete){             //投稿番号が削除対象番号でなければ
                       fwrite($fp,$dellines[$i].PHP_EOL);     //ファイルに書き込み
                  }else{                              //投稿番号が削除対象番号だったら
                       fwrite($fp,"削除しました。".PHP_EOL); //と書き込む
                  }
             }
             fclose($fp);                        //ファイルクローズ
         
         
         //送信フォームについて
         }else{
             if(isset($name)&&isset($str)&&empty($hide)){      //名前とコメントだけが送信されたら
             $fp = fopen($filename,"a");     //追記モードでテキストファイルオープン
             fwrite($fp,$write.PHP_EOL);     //ファイルに書き込み  
             fclose($fp);                    //ファイルクローズ
             }
         }
         
         
         
         //編集フォームについて
         if(isset($edit)&&empty($name)&&empty($str)&&empty($hide)){ //編集対象番号だけが送信されたら
             $edlines=file($filename,FILE_IGNORE_NEW_LINES); //txtファイルの中身を配列に格納
             for($i=0; $i<$number; $i++){               //配列の数だけループ
                $array=explode("<>",$edlines[$i],4);     //explode関数でそれぞれの値を取得
                if($array[0]==$edit){     //投稿番号が編集対象番号だったら
                     $editnumber=$array[0];     //編集対象番号表示用フォームに番号表示のためデータ取得
                     $editname=$array[1];       //名前フォームに名前を表示のためデータ取得
                     $editstr=$array[2];       //コメントフォームにコメントを表示のためデータ取得
                     //表示機能はフォームのvalue属性で対応
                }
             }
          }
         
          
         if(isset($name)&&isset($str)&&isset($hide)){  //編集内容が送信されたら
             $editlines=file($filename,FILE_IGNORE_NEW_LINES); //txtファイルの中身を配列に格納
             $fp=fopen($filename,"w");                 //上書きモードでテキストファイルオープン
             foreach($editlines as $editline){         //配列の数だけループ
                 $array=explode("<>",$editline);       //explode関数でそれぞれの値を取得
                 if($array[0]==$hide){                 //投稿番号が編集対象番号だったら
                     fwrite($fp,$hide."<>".$name."<>".$str."<>".$date.PHP_EOL); //編集内容に更新して書き込む
                 }else{
                     fwrite($fp,$editline.PHP_EOL);    //その他の行はそのまま書き込む
                 }
             }
             fclose($fp);
         }
    ?>
    
    <form action="" method="post">   <!--入力フォーム、POST送信-->
        <input type="text" name="name" placeholder="名前" 
               value="<?php if(isset($editname)) {echo $editname;} ?>"> <br/> <!--「名前」のフォーム、編集で指定されたらその名前表示-->
        <input type="text" name="str" placeholder="コメント"
               value="<?php if(isset($editstr)) {echo $editstr;} ?>"> <!--「コメント」のフォーム、編集で指定されたらそのコメント表示-->
        <input type="hidden" name="hiddennumber"
               value="<?php if(isset($editnumber)) {echo $editnumber;} ?>">   <!--後で隠す編集対象番号表示フォーム、編集で指定されたらその番号表示-->
        <input type="submit" name="submit">            <!--送信ボタン-->
    </form>
    
    <br>
    
    <form action="" method="post">   <!--入力フォーム、POST送信-->
        <input type="text" name="delete" placeholder="削除対象番号"> <!--「削除」のフォーム-->
        <input type="submit" name="deletebutton" value="削除">            <!--送信ボタン-->
    </form>
    
    <br>
    
    <form action="" method="post">   <!--入力フォーム、POST送信-->
        <input type="text" name="edit" placeholder="編集対象番号"> <!--「編集番号指定」のフォーム-->
        <input type="submit" name="editbutton" value="編集">            <!--送信ボタン-->
    </form>
    
    
    <?php
    //ブラウザに表示させる
             $deletelines=file($filename,FILE_IGNORE_NEW_LINES);  //txtファイルの中身を配列に格納
             foreach($deletelines as $deleteline){           //配列の数だけループ
                $array=explode("<>",$deleteline);         //explode関数でそれぞれの値を取得
                echo $array[0]." ";                 //表示
                echo $array[1]." ";
                echo $array[2]." ";
                echo $array[3]."<br>";
             }
    ?>

</body>
</html>