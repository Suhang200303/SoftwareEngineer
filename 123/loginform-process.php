<?php
session_start();
$errorMSG = "";
//2222
if (empty($_POST["name"])) {
    $errorMSG = "usr_name is required ";
} else {
    $name = $_POST["name"];
}

if (empty($_POST["password"])) {
    $errorMSG = "Password is required ";
} else {
    $password = $_POST["password"];
}

if (empty($_POST["captcha"])) {
    $errorMSG = "Please enter the captcha ";
} else {
    $captcha = $_POST["captcha"];
}
$correctCaptcha = $_SESSION['captcha'];


if($captcha != $correctCaptcha){
    $errorMSG = "Captcha is incorrect, correct captcha is: ".$correctCaptcha;
}

$link = mysqli_connect('localhost','root','qawsed09842','usr_info') or die('不能连接到数据库').mysqli_error();

$md5_usr_pd = MD5($password);

if($link){
    if ($errorMSG == "")
    {
        $sql = "SELECT * FROM login_info WHERE usr_id = '$name'";
        $result = mysqli_query($link, $sql);
        if($result && mysqli_num_rows($result) > 0)
        {
            $sql1 = "SELECT * FROM login_info WHERE usr_id = '$name' and usr_password = '$md5_usr_pd'";
            $result1 = mysqli_query($link, $sql1);
            if($result1 && mysqli_num_rows($result1) > 0)
            {
                $sql3 = "UPDATE login_info SET login_time=NOW() WHERE usr_id = '$name'";
                mysqli_query($link, $sql3);
                echo "successful";
            }
            else
            {
                echo "密码错误";
            }
        }
        else
        {
            echo "用户名不存在，请注册";
        }
        
    }
    else
    {
        //$errorMSG = "数据库连接成功，处理失败";
        echo $errorMSG;
    }
}
else
{
    $errorMSG = "链接数据库失败";
    echo $errorMSG;
}

?>