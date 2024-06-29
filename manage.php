<?php 
// 连接数据库
$link = mysqli_connect("localhost", "root", "qawsed09842", "usr_info");

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// 查询数据
$sql1 = "SELECT COUNT(*) AS num_usr_0 , NOW() AS query_time FROM login_info WHERE usr_permission = 0";
$sql2 = "SELECT COUNT(*) AS num_usr_1 FROM login_info WHERE usr_permission = 1";

$result1 = mysqli_query($link, $sql1);
$result2 = mysqli_query($link, $sql2);

if (!$result1) {
    die("Query failed: " . mysqli_error($link));
}

$data = [];

// 获取查询结果
$row1 = mysqli_fetch_assoc($result1);
$row2 = mysqli_fetch_assoc($result2);
$num_usr0 = $row1['num_usr_0'];
$num_usr1 = $row2['num_usr_1'];
$row_time = $row1['query_time'];
$total = $num_usr0 + $num_usr1;

$data[] = htmlspecialchars($num_usr0);
$data[] = htmlspecialchars($num_usr1);
$data[] = htmlspecialchars($total);
$data[] = htmlspecialchars($row_time);


// 关闭数据库连接
mysqli_close($link);

echo implode(',', $data);
?>