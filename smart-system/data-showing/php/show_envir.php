<?php
function is_leap_year($year) {
    return $year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0);
}

function days_in_year($year) {
    return is_leap_year($year) ? 366 : 365;
}

function days_in_month($year, $month) {
    if (in_array($month, [4, 6, 9, 11])) {
        return 30;
    } elseif ($month == 2) {
        return is_leap_year($year) ? 29 : 28;
    } else {
        return 31;
    }
}

function calculate_days_since_base($year, $month, $day) {
    $base_year = 1900;
    $base_month = 1;
    $base_day = 1;
    $days = 0;
    
    // Add days for the years
    for ($y = $base_year; $y < $year; $y++) {
        $days += days_in_year($y);
    }
    
    // Add days for the months of the current year
    for ($m = 1; $m < $month; $m++) {
        $days += days_in_month($year, $m);
    }
    
    // Add days for the days of the current month
    $days += $day - $base_day;
    
    return $days;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $year = intval($_GET['year']);
    $month = intval($_GET['month']);
    $day = intval($_GET['day']);
    
    $days_since_base = calculate_days_since_base($year, $month, $day);

    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "qawsed09842";
    $dbname = "usr_info";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }

    // 根据计算出的天数差异进行查询
    $sql = "SELECT * FROM wqsample WHERE 监测时间 = '$days_since_base'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }

    $conn->close();

    // 返回 JSON 格式的结果
    echo json_encode($row);
}
?>
