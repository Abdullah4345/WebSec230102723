
<?php
   
if (!function_exists('isPrime')) {
    function isPrime($number)
    {
        if($number<=1) return false;
        $i = $number - 1;
        while($i>1) {
        if($number%$i==0) return false;
        $i--;
        }
        return true;
    }
}
