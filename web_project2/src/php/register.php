<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/login.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/register.css" media="all">
    <script type="text/javascript" src="../js/idCheck.js"></script>

    <title>注册</title>
</head>
<body>
<header>Sign Up</header>
<?php
echo "<form method=\"post\" action=\"createUser.php\">";
echo "<div>邮箱<input type=\"email\" name=\"email\" required></div>";
echo "<div>用户名<input type=\"text\" placeholder=\"a-z A-Z 0-9 or _\" pattern=\"\w+\" name=\"id\" onchange='idCheck(this.value)' required></div>";
echo "<div id='tips'>请起一个独特的用户名</div>";
echo "<div>密码<input type=\"password\" onchange='passwordCheck()' name=\"password\" placeholder=\"a-z A-Z or 0-9, length > 8\" pattern=\"[a-zA-Z0-9]{9,}\" required></div>";
echo "<div>再次输入<input type=\"password\" onchange='passwordCheck()' name=\"password-again\" required></div>";
echo "<div id='password-tips'>请再次输入密码</div>";
echo "<input type=\"submit\" id='submit-button' disabled name='register' value=\"注册\">";
echo "</form>";
?>
<footer>
    © 2020 fdu19ss沪·证书·备 19302010042·联系我们:<img src="../../images/icons/wechat2DCode.JPG"/>19302010042@fudan.edu.cn·举报
</footer>
</body>
</html>