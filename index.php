<?php
  header( 'Content-Type:text/html;charset=utf-8 ');
  $dirname=dirname(__FILE__);
  require $dirname.'/PHPMailer-master/PHPMailerAutoload.php';
  function sendEmail ($host,$fromEmail,$fromPwd,$fromName,$toEmail,$toName,$subject,$content) {
      $mail = new PHPMailer;  
      $mail->isSMTP();                                      // 设置邮件使用SMTP  
      $mail->Host = $host;                     // 邮件服务器地址  
      $mail->SMTPAuth = true;                               // 启用SMTP身份验证  
      $mail->CharSet = "UTF-8";                             // 设置邮件编码  
      $mail->setLanguage('zh_cn');                          // 设置错误中文提示  
      $mail->Username = $fromEmail;              // SMTP 用户名，即个人的邮箱地址  
      $mail->Password = $fromPwd;                        // SMTP 密码，即个人的邮箱密码  
      $mail->SMTPSecure = 'tls';                            // 设置启用加密，注意：必须打开 php_openssl 模块  
      $mail->Priority = 3;                                  // 设置邮件优先级 1：高, 3：正常（默认）, 5：低  
      $mail->From = $fromEmail;                 // 发件人邮箱地址  
      $mail->FromName = $fromName;                         // 发件人名称  
      $mail->addAddress($toEmail,$toName);     // 添加接受者  
      $mail->WordWrap = 50;                                 // 设置自动换行50个字符  
      $mail->isHTML(true);                                  // 设置邮件格式为HTML  
      $mail->Subject = $subject;  
      $mail->msgHTML($content);      
      return  $mail->send();
  }
  //连接数据(php+mysql 模拟队列发送邮件)
  $db=mysql_connect('127.0.0.1','root','');
  mysql_select_db('phpmailer');
  mysql_query("set names utf8");
  $maillist=array();
  while(true){
     $sql="select * from task_list where status=0";
     $result=mysql_query($sql); 
     $mailList = array();
     while(!!$row=mysql_fetch_assoc($result)){
        $mailList[] = $row;
     }
     if(empty($mailList)){
         break;
       }else{
        if(is_array($mailList)){
           foreach ($mailList as $key => $value) {
                $content=file_get_contents($dirname.'/email.html');
                if(sendEmail('smtp.aliyun.com','caolei1@aliyun.com','caolei1','aliyun',$value['user_email'],'sina','this is  many users',$content)){
                   $sql="update task_list set status =1 where id=".$value['id'];
                   mysql_query($sql);
                }else{
                   $updatesql="update task_list set status =2 where id=".$value['id'];
                   mysql_query($sql);
                }
           }
        }
     }
  }
  return true;
?>