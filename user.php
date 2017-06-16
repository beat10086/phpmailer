<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>注册</title>
	<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
    <style>
    	 .reg-contain{
    	 	 width:600px;
    	 	 margin: 30px auto;
    	 }
    </style>
   <?php
        require dirname(__FILE__).'/DB.php';
        $db=DB::getInstance();
        $_addData=array();
        if(isset($_POST['user_email']) && isset($_POST['user_password'])){
             if(!empty($_POST['user_email']) && !empty($_POST['user_password'])){
               $user_email   =htmlspecialchars(trim($_POST['user_email']));
               $user_password=htmlspecialchars(trim($_POST['user_password']));
               $_addData=array(
                   'user_email'   =>$user_email,
                   'user_password'=>$user_password
               );
               if($db->add('users',$_addData)){
                   //echo '<script>alert("注册成功")</script>';
                   $_addTaskData=array(
                       'user_email'   =>$user_email,
                       'status'       =>0,
                       'create_time' =>date('Y-m-d h:i:s'),
                       'update_time' =>date('Y-m-d h:i:s')
                  );
                  if($db->add('task_list',$_addTaskData)){
                     ?>
                    <script>
                       $.post('do_queue.php',function(res){
                           if(res.code==200){
                              alert(res.message);
                           }
                       });
                    </script>
                     <?php
                  }
               }
           }
           exit();
        }
    ?>
</head>
<body>
	<div class="reg-contain">
	    <form class="form-horizontal" method="post" action="user.php">
			  <div class="form-group">
			    <label for="inputEmail" class="col-sm-2 control-label">邮件</label>
			    <div class="col-sm-9">
			      <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="user_email">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="inputPassword" class="col-sm-2 control-label">密码</label>
			    <div class="col-sm-9">
			      <input type="password" class="form-control"  id="inputPassword" placeholder="Password" name="user_password">
			    </div>
			  </div>
			  <div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-default">注册</button>
			    </div>
			  </div>
        </form>
    </div>
</body>
</html>