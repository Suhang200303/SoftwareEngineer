<?php
$servername = "localhost";
$username = "root";
$password = "qawsed09842";
$dbname = "usr_info";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 查询数据库
$sql = "SELECT city, SectionName, time, WaterTemperature, PH, DissolvedOxygen, ElectricalConductivity, TotalPhosphorus, TotalNitrogen FROM waterquality LIMIT 5";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();

echo json_encode($data);
?>