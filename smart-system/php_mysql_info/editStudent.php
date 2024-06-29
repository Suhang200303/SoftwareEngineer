<?php
//连接数据库
include 'conn.php';

//获取id
$id = $_GET['usr_id'];
//编写查询sql语句
$sql = "SELECT * FROM login_info WHERE `usr_id`= '$id'";
//执行查询操作、处理结果集
$result = mysqli_query($link, $sql);
if (!$result) {
    exit('查询sql语句执行失败。错误信息：'.mysqli_error($link));  // 获取错误信息
}
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

//将二维数数组转化为一维数组
foreach ($data as $key => $value) {
  foreach ($value as $k => $v) {
    $arr[$k]=$v;
  }
}

?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>修改用户</title>
		<style type="text/css">
			body {
				background-image: url(student.jpg);
				background-size: 100%;
			}

			.box {
				display: table;
				margin: 0 auto;
			}

			h2 {
				text-align: center;
			}

			.add {
				margin-bottom: 20px;
			}
		</style>
	</head>
	<body>
		<!--输出定制表单-->
		<div class="box">
			<h2>修改用户信息</h2>
			<div class="add">
				<form action="action_editStudent.php" method="post" enctype="multipart/form-data">
					<table border="1">

						<tr>
							<th>用户名：</th>
							<td><input type="text" name="username" size="32" value="<?php echo $arr["usr_id"] ?>"readonly></td>
						</tr>
						<tr>
							<th>密码：</th>
							<td><input type="password" name="password" size="32" value="<?php echo $arr["usr_password"] ?>"></td>
						</tr>
						<tr>
							<th>权限：</th>
							<td>
								<select name="role">
									<option <?php if (!$arr["usr_permission"]) { echo "selected" ; } ?>value="管理员">管理员</option>
									<option <?php if (!$arr["usr_permission"]) { echo "selected" ; } ?>value="普通用户">普通用户</option>
								</select>
							</td>
						</tr>
						<tr>
							<th></th>
							<td>
								<input type="button" onClick="javascript :history.back(-1);" value="返回">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" value="提交">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>







