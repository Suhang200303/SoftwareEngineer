<?php
//连接数据库
include 'conn.php';

// 获取修改后的用户信息
$name = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$md5_usr_pd = MD5($password);

if($role == '管理员')
	$role1 = 1;
else
	$role1 = 0;
	

	if ($name && $password) {

		//编写预处理sql语句
		$sql = "UPDATE `login_info` SET `usr_password`= '$md5_usr_pd', `usr_permission`= $role1 WHERE `usr_id`= '$name'";

		// 执行预处理（第1次执行）
		$result = mysqli_query($link, $sql);
		//关闭连接
		//mysqli_close($link);

		if ($result) {
    		//修改用户成功
			//跳转到首页
			header("Location:index.php");
		}else{
			exit('修改用户信息sql语句执行失败。错误信息：' . mysqli_error($link));
		}
	}else{
		//修改用户失败
		//输出提示，跳转到首页
		echo "修改用户失败！<br><br>";
		header('Refresh: 3; url=index.php');  //3s后跳转

    	
	}

  

