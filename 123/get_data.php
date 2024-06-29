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


// 获取查询参数
$searchCity = isset($_GET['city']) ? $_GET['city'] : '';
$searchSection = isset($_GET['section']) ? $_GET['section'] : '';
$searchTime = isset($_GET['stime']) ? $_GET['stime'] : '';


// 查询数据库
$sql = "SELECT city, SectionName, time, WaterTemperature, PH, DissolvedOxygen, ElectricalConductivity, TotalPhosphorus, TotalNitrogen 
        FROM WaterQuality 
        WHERE city LIKE '$searchCity' 
        AND SectionName LIKE '$searchSection'
        AND time LIKE '$searchTime'"; 
        
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // 输出数据
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo  json_encode([]);
}
$conn->close();

echo json_encode($data);
?>