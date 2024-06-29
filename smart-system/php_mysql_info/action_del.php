<?php
//连接数据库
include 'conn.php';

if (!isset($_GET['usr_id'])) {
    exit("未提供要删除的用户ID");
}

$id = $_GET['usr_id'];
//删除指定数据  
//编写删除sql语句
$sql = "DELETE FROM login_info WHERE usr_id = '$id' and usr_id != 'root'";
//执行查询操作、处理结果集
$result = mysqli_query($link, $sql);
if (!$result) {
    exit('sql语句执行失败。错误信息：'.mysqli_error($link));  // 获取错误信息
}
else{
    //exit("删除成功！<br><br>");
    echo "删除成功";
}

// 删除完跳转到首页
header("Location:index.php");  


