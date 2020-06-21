<?php
function hashNew($a)
{
    $salt = "icesalt";  //定义一个salt值，程序员规定下来的随机字符串
    $b = $a . $salt;  //把密码和salt连接
    $b = md5($b);  //执行MD5散列
    return $b;  //返回散列
}

require_once('config.php');
if($_SERVER["REQUEST_METHOD"] == "GET"&&isset($_GET['id'])){
    $existed = false;
    try {
        $conn = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT UserName FROM traveluser";
        $result = $conn->query($sql);
        while($row=$result->fetch())
            if($row['UserName']== hashNew($_GET['id']))
                $existed = true;
        echo $existed;
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;

}





