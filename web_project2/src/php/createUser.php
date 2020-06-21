<?php
function hashNew($a)
{
    $salt = "icesalt";  //定义一个salt值，程序员规定下来的随机字符串
    $b = $a . $salt;  //把密码和salt连接
    $b = md5($b);  //执行MD5散列
    return $b;  //返回散列
}

require_once('config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $password = hashNew($_POST['password']);
    $username = hashNew($_POST['id']);
    try {
        $conn = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO traveluser (Email,UserName,Pass) VALUES ('{$_POST['email']}','{$username}','{$password}')";

        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;

}

header("Location: login.php");
