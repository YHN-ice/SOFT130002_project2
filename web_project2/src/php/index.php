<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/nav.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/homepage.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/footer.css" media="all">
    <script src="../js/homepage.js"></script>
    <script src="../js/refresh-images.js"></script>
    <title>首页</title>
</head>
<body>
<header>
    <nav>
        <div id=this-page><a href="index.php">首页</a></div>
        <div id=browser><a href="browser.php">浏览页</a></div>
        <div id=search><a href="search.php">搜索页</a></div>
        <?php require_once("nav-login.php"); ?>
    </nav>
</header>

<aside>
    <div id="show-zone">
        <?php
        require_once("config.php");
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = 'SELECT PATH, Title, Description, travelimage.ImageID FROM travelimage WHERE travelimage.ImageID IN (SELECT travelimagefavor.ImageID FROM travelimagefavor GROUP BY ImageID ORDER BY COUNT(ImageID) DESC) LIMIT 10';
            $result = $pdo->query($sql);

            while ($row = $result->fetch()) {
                outputSingleGenre($row);
            }
            $pdo = null;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        function outputSingleGenre($row)
        {
            echo "<div><a href=\"detail.php?ImageID={$row['ImageID']}\"><img class='{$row['ImageID']} show-zone-image' src=\"../../travel-images/large/{$row['PATH']}\"/></a>
            <h3 class='show-zone-title'>{$row['Title']}</h3>
            <p class='show-zone-description'>{$row['Description']}</p></div>";
        }
        ?>
    </div>
</aside>
<div id="accessibility-icons">
    <button id="back-to-top" onclick="back_to_top()"><img src="../../images/icons/Back-to-top.png"/>️</button>
    <button id="refresh" onclick="refresh()"><img src="../../images/icons/Refresh.png"/></button>
</div>
<footer>
    © 2020 fdu19ss沪·证书·备 19302010042·联系我们:<img src="../../images/icons/wechat2DCode.JPG"/>19302010042@fudan.edu.cn·举报
</footer>
</body>
</html>