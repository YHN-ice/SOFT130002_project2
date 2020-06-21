<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/login.css" media="all">
    <title>登录</title>
</head>


<body>
<header>Log In</header>
<?php
if (!isset($_COOKIE['Username']))
    echo "<form method=\"post\" action=\"\" role='form'>
    <div>用户名<input type=\"text\" name=\"id\" required></div>
    <div id=\"last\">密码<input type=\"password\" name=\"password\" required></div>
    <input type=\"submit\" value=\"登陆\">
</form>";
?>
<h5>
    <?php
    function hashNew($a)
    {
        $salt = "icesalt";  //定义一个salt值，程序员规定下来的随机字符串
        $b = $a . $salt;  //把密码和salt连接
        $b = md5($b);  //执行MD5散列
        return $b;  //返回散列
    }


    require_once("config.php");

    function validLogin()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
        $sql = "SELECT * FROM traveluser WHERE UserName=:user AND Pass=:pass";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(':user', hashNew($_POST['id']));
        $statement->bindValue(':pass', hashNew($_POST['password']));
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return true;
        }
        return false;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (validLogin()) {
            $expiryTime = time() + 60 * 60 * 24;
            setcookie("Username", hashNew($_POST['id']), $expiryTime);
            $_COOKIE['Username'] = hashNew($_POST['id']);
            header("Location: index.php");
            exit;
        } else {
            echo "账号密码错误";
        }
    } elseif (isset($_COOKIE['Username'])) {
        echo "您已登陆 点击跳转至<a href='index.php'>主页</a>";
    }
    ?>
</h5>
<div>新用户？<a href="register.php">请先注册账户</a>
    <a href="register.php">
        <button>注册</button>
    </a></div>
<footer>
    © 2020 fdu19ss沪·证书·备 19302010042·联系我们:<img src="../images/icons/wechat2DCode.JPG"/>19302010042@fudan.edu.cn·举报
</footer>
</body>
</html>