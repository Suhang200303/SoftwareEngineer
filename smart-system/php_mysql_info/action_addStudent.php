<?php
//连接数据库
$link = mysqli_connect('localhost', 'root', 'qawsed09842', 'usr_info');

if($link === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
}

// 获取增加的用户信息
$name = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$md5_usr_pd = MD5($password);

if($role == '管理员')
	$role1 = 1;
else
	$role1 = 0;

$sql = "INSERT INTO login_info(usr_id, usr_password, usr_permission) VALUES ('$name', '$md5_usr_pd', $role1)";
	
	if ($name && $password && $role) {
		// 执行预处理（第1次执行）
		$result = mysqli_query($link, $sql);
		//关闭连接
		mysqli_close($link);

		if ($result) {
    		//添加用户成功, 跳转到首页
			header("Location:index.php");
		}
		else
		{
			exit('添加用户sql语句执行失败。错误信息：' . mysqli_error($link));
		}
	}
	else {
		//添加用户失败
		//输出提示，跳转到首页
		echo "添加用户失败！<br>name: $name <br>password: $password <br>role: $role <br>";
		header('Refresh: 3; url=index.php');  //3s后跳转
	}

?>

