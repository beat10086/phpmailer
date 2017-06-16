<?php
  //exe 要用绝对地址
  if(exec("E:/xapp/php/php.exe E:/xapp/htdocs/phpmailer/index.php")){
  	    $result=[
              "code"=>200,
              "message"=>'发送邮件成功'
  	    ];
  	    echo json_encode($result);
  }
?>