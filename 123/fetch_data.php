<?php
// 连接数据库
$link = mysqli_connect("localhost", "root", "qawsed09842", "usr_info");

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// 查询数据
$sql = "SELECT usr_id, login_time FROM login_info WHERE usr_permission = 0 ORDER BY login_time DESC LIMIT 2";
$result = mysqli_query($link, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($link));
}

// 初始化计数器
$data = [];
$count = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = '<tr>';
    $data[] = '<td>' . htmlspecialchars($row['usr_id']) . '</td>';
    $data[] = '<td>' . htmlspecialchars($row['login_time']) . '</td>';
    $data[] = '</tr>';

    $count++;
}

// 如果记录少于两个，用“无”填充剩下的单元格
while ($count < 2) {

    $data[] = '<tr>';

    $data[] = '<td>无</td><td>无</td>';

    $data[] = '</tr>';
    
    $count++;
}

// 关闭数据库连接
mysqli_close($link);

echo implode('', $data);
?>
