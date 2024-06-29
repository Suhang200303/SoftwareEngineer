<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$errorMSG = "";

//if (empty($_POST["email"])) {
//  $errorMSG = "Email is required ";
//} else {
//    $email = $_POST["email"];
//}

if (empty($_POST["name"])) {
    $errorMSG = "Name is required ";
} else {
    $name = $_POST["name"];
}

if (empty($_POST["password"])) {
    $errorMSG = "Password is required ";
} else {
    $password = $_POST["password"];
}

if (empty($_POST["terms"])) {
    $errorMSG = "Terms is required ";
} else {
    $terms = $_POST["terms"];
}

$md5_usr_pd = MD5($password);

$link = mysqli_connect('localhost','root','qawsed09842','usr_info') or die('不能连接到数据库').mysqli_error();

if($link){
    if ($errorMSG == "")
    {
        //echo "successful";
        $sql = "INSERT INTO login_info(usr_id, usr_password, usr_permission) VALUES ('$name', '$md5_usr_pd', 0)";
        $result = mysqli_query($link, $sql);
        if($result)
        {
            echo "successful";
        }
        else
        {
            echo "用户名已存在，请重新注册";
        }
        
    }
    else
    {
        $errorMSG = "数据库连接成功，处理失败";
        echo $errorMSG;
    }
}
else
{
    $errorMSG = "链接数据库失败";
    echo $errorMSG;
}
?>

