<?php
    $year = $_POST['year'];
    $month = $_POST['month'];
    $region = $_POST['region'];

    // 根据传入的参数生成或查询需要的内容
    // 这是一个示例，实际实现中可能需要查询数据库或进行其他操作
    echo "<div class='dataAllNo01 maginS01'>
            <div class='dataAllBorder01'>
                <div class='dataAllBorder02'>
                    <div class='data_tit3'>$year 年 $month 月 $region 的鱼类捕捞情况</div>
                    <iframe src='bar-negative.html' width='100%' height='100%' frameborder='0'></iframe>
                </div>
            </div>
          </div>";
?>