<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_2-1</title>
</head>
<body>
    <form action="" method="post">   <!--入力フォーム、POST送信-->
        <input type="text" name="str" value="コメント">
        <input type="submit" name="submit">
    </form>
    
    <?php
         $str=$_POST["str"];         //POST受信
           echo $str."<br>";
         if($str==""){               //最初にページを開いたときに「を受け付け～」を表示させない
          echo"";
         }else{
          echo $str."を受け付けました";
         }
    ?>
</body>
</html>