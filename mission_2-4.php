<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_2-4</title>
</head>
<body>
    <form action="" method="post">   <!--入力フォーム、POST送信-->
        <input type="text" name="str" value="コメント">
        <input type="submit" name="submit">
    </form>
    
    <?php
         $str=$_POST["str"];         //POST受信
         if($str==""){               //最初にページを開いたときに「を受け付け～」を表示させない
             echo "";
         }elseif($str=="コメント"){
             echo "";
         }else{
          echo $str."を受け付けました<br>";
         }

         if($str==""){
             echo "";
         }elseif($str=="コメント"){
             echo "";
         }else{
             $filename="mission_2-4.txt";
             $fp = fopen($filename,"a");
             fwrite($fp,$str.PHP_EOL);
             fclose($fp);
         
         if($str=="完成！"){
             echo "おめでとう！<br>";
         }
         }
         
         if(file_exists($filename)){
             $lines=file($filename,FILE_IGNORE_NEW_LINES);
             foreach($lines as $line){
                 echo $line."<br>";
             }
         }
    ?>
</body>
</html>