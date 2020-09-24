<?php
$number=4;
if ($number%3==0 && $number%5==0) {
echo "FizzBuzz";
} elseif ($number%3==0) {
echo "Fizz";
} elseif ($number%5==0) {
echo "Buzz";
}
else{
echo $number;
}

"($num = 3の時)
Fizz
($num = 5の時)
Buzz
($num = 15の時)
Fizzbuzz
($num = 4の時)"
?>