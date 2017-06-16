<?php
   exec("E:/xapp/php/php.exe   E:/xapp/htdocs/phpmailer/test.php",$output, $return_val);
   var_dump($output);
   echo '<hr>';
   var_dump($return_val);
?>