<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_1-27</title>
</head>
<body>
    <form action="" method="post">   <!--入力フォーム、POST送信-->
        <input type="number" name="number" placeholder="数字を入力してください" >
        <input type="submit" name="submit">
    </form>
    <?php
       $number = $_POST["number"];  //変数にPOSTされた数値を代入する
       $filename="mission_1-27.txt";  //ファイル名を決める
       $FP=fopen($filename,"a");      //ファイルを追記モードでオープンする
       fwrite($FP,$number.PHP_EOL);   //ファイルに書き込む
       fclose($FP);                   //ファイルをクローズする
       if($number==""){               //最初にページを開いたときに「書き込み～」を表示させない
          echo"";
       }else{
          echo "書き込み成功！<br>";   //「書き込み成功！」と表示する
       }
       
       
       if(file_exists($filename)){      //ファイルが存在するときに下記の処理を行う
        $lines=file($filename,FILE_IGNORE_NEW_LINES);  //変数に最終行を無視してファイルの中身を配列として代入する
        foreach($lines as $line){       //配列内のすべての変数について、下記の処理を行う
            if($line==0){
                echo $line.PHP_EOL;
            }elseif($line%3==0 && $line%5==0){
                echo "FizzBuzz".PHP_EOL;
            }elseif($line%3==0){
                echo "Fizz".PHP_EOL;
            }elseif($line%5==0){
                echo "Buzz".PHP_EOL;
            }else{
                echo $line.PHP_EOL;
            }
       }
       }
    
    ?>
</body>
</html>