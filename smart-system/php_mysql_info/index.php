<?php
//连接数据库
$link = mysqli_connect('localhost', 'root', 'qawsed09842', 'usr_info');
mysqli_set_charset($link, 'utf8');


//编写查询sql语句
$sql2 = 'SELECT * FROM `login_info`';
//执行查询操作、处理结果集
$result = mysqli_query($link, $sql2);
if (!$result) {
    exit('查询sql语句执行失败。错误信息：'.mysqli_error($link));  // 获取错误信息
}
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

//编写查询数量sql语句
$sql = 'SELECT COUNT(*) FROM `login_info`';
//执行查询操作、处理结果集
$n = mysqli_query($link, $sql);
if (!$n) {
    exit('查询数量sql语句执行失败。错误信息：'.mysqli_error($link));  // 获取错误信息
}
$num = mysqli_fetch_assoc($n);
//将一维数组的值转换为一个字符串
$num = implode($num);


?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>用户信息管理系统</title>
</head>
<style type="text/css">
    body {
        background-image: url(student.jpg);
        background-size: 100%;
        margin: 0;
        padding: 0;
		color: while;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 200px;
        background-color: #222222;
        padding: 10px;
        height: 100%;
    }

    .content {
        margin-left: 220px; /* sidebar width + space */
        padding: 20px;
		color: white;
    }

    h1 {
        text-align: center;
    }

    .add a {
        text-decoration: none;
        color: white; /* 字体颜色为白色 */
        background-color: #333; /* 深黑色 */
        display: block;
        padding: 10px;
        margin-bottom: 10px;
		border-radius: 5px;
		padding-right: 20px;
    }

    .add a:hover {
        background-color: #555; /* 深灰色 */
    }

    td {
        text-align: center;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #dddddd;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
		color: black;
    }

		.operation {
            display: flex;
            justify-content: center;
        }

        .operation div {
            margin-right: 10px;
            padding: 3px 16px;
            border-radius: 20px; /* 圆角按钮 */
            background-color: #ffffff; /* 白色背景 */
            color: red; /* 黑色字体 */
            cursor: pointer;
            border: 1px solid #ffffff; /* 白色边框 */
            transition: background-color 0.3s, color 0.3s, border-color 0.3s; /* 过渡效果 */
        }

        .operation div:hover {
            background-color: transparent; /* 鼠标悬停时背景色变为透明 */
            color: white; /* 字体变为白色 */
            border-color: white; /* 边框变为白色 */
        }

		.operation div a {
            color: black; /* 修改链接的字体颜色 */
            text-decoration: none; /* 去除链接下划线 */
        }

        .operation div:hover a {
            color: white; /* 鼠标悬停时修改链接的字体颜色 */
        }
</style>
<body>
<div class="sidebar">
    <div class="add">
        <a href="addStudent.html">添加用户</a>
        <a href="searchStudent.html">查找用户</a>
        <a href="../data-showing/data-visitile.html">去往数据前端</a>
        <a href="../index.html">返回主页</a>
    </div>
</div>
<div class="content">
    <h1>用户信息管理系统</h1>
    <?php
    include 'conn.php';

    $sql = 'SELECT * FROM `login_info`';
    $result = mysqli_query($link, $sql);
    if (!$result) {
        exit('查询sql语句执行失败。错误信息：'.mysqli_error($link));
    }
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $sql = 'SELECT COUNT(*) FROM `login_info`';
    $n = mysqli_query($link, $sql);
    if (!$n) {
        exit('查询数量sql语句执行失败。错误信息：'.mysqli_error($link));
    }
    $num = mysqli_fetch_assoc($n);
    $num = implode($num);
    ?>
    <div class="add">
        共 <?php echo $num; ?> 个用户
    </div>
    <table>
        <tr>
            <th>用户ID</th>
            <th>密码</th>
            <th>权限</th>
            <th>操作</th>
        </tr>
        <?php
        foreach ($data as $arr) {
            echo "<tr>";
            echo "<td>{$arr['usr_id']}</td>";
            echo "<td>{$arr['usr_password']}</td>";
            echo "<td>{$arr['usr_permission']}</td>";
            echo "<td class='operation'>
                    <div onclick=\"del('{$arr['usr_id']}')\">删除</div>
                    <div><a href='editStudent.php?usr_id={$arr['usr_id']}'>修改</a></div>
                  </td>";
            echo "</tr>";
        }
        mysqli_close($link);
        ?>
    </table>
</div>

<script type="text/javascript">
    function del(id) {
        //var encodedId = encodeURIComponent(id);
        if (confirm("确定删除这个用户吗？")) {
            window.location = "action_del.php?usr_id=" + id;
        }
    }
</script>

</body>
</html>
