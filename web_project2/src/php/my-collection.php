<!DOCTYPE html>
<html lang="en">
<?php
if (!isset($_COOKIE['Username']))
    header("Location: index.php");
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/nav.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/my-collection.css" media="all">

    <link rel="stylesheet" type="text/css" href="../css/section-footer-pages.css" media="all">

    <link rel="stylesheet" type="text/css" href="../css/footer.css" media="all">
    <script src="../js/clamp.js"></script>
    <script src="../js/search.js"></script>
    <script type="text/javascript" src="../js/changePages.js"></script>

    <title>我的收藏</title>
</head>
<body>
<header>
    <nav>
        <div id=homepage><a href="index.php">首页</a></div>
        <div id=browser><a href="browser.php">浏览页</a></div>
        <div id=search><a href="search.php">搜索页</a></div>
        <?php require_once("nav-login.php"); ?>
    </nav>
</header>
<section>
    <header>My Collection</header>

    <?php
    require_once("config.php");
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT PATH, ImageID, Title, Description FROM travelimage WHERE ImageID IN (SELECT ImageID FROM travelimagefavor WHERE UID IN (SELECT UID FROM traveluser WHERE UserName = '{$_COOKIE['Username']}')) LIMIT 100";


        $result = $pdo->query($sql);

        $index = 0;
        while ($row = $result->fetch()) {
            if ($index < 20)
                echo "<div class='show-zone-container'><a href=\"detail.php?ImageID={$row['ImageID']}\"><img class='{$row['ImageID']} show-zone-image' id='{$index}' src=\"../../travel-images/large/{$row['PATH']}\"/></a>
        <div>
            <h3>{$row['Title']}
                <button class=\"remove\"><a href='cancelLove.php?ImageID={$row['ImageID']}'>取消收藏</a></button>
            </h3>
            <p class=\"to-be-trimmed\">{$row['Description']}.</p>
        </div>
    </div>";
            else
                echo "<div class='show-zone-container' style='display: none'><a href=\"detail.php?ImageID={$row['ImageID']}\"><img class='{$row['ImageID']} show-zone-image' id='{$index}' src=\"../../travel-images/large/{$row['PATH']}\"/></a>
        <div>
            <h3>{$row['Title']}
                <button class=\"remove\"><a href='cancelLove.php?ImageID={$row['ImageID']}'>取消收藏</a></button>
            </h3>
            <p class=\"to-be-trimmed\">{$row['Description']}.</p>
        </div>
    </div>";
            $index++;
        }
        $pdo = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    if($index==0)
        echo "<h1>您还没有收藏照片!</h1>";
    ?>


    <div id="pages"><?php
        echo "<a href=\"#\" onclick=\"changePage(this)\" id=\"last-page\"><</a>";
        echo "<a href=\"#\" onclick=\"changePage(this)\" class=\"page-index\" id=\"current-page\">1</a>";
        $i = 0;
        while ($i < ($index / 20) - 1) {
            $ii = $i + 2;
            echo "<a href=\"#\" onclick=\"changePage(this)\" class=\"page-index\">{$ii}</a>";
            $i++;
        }
        echo "<a href=\"#\" onclick=\"changePage(this)\" id=\"next-page\">></a>";
        ?>
    </div>
</section>
<footer>
    © 2020 fdu19ss沪·证书·备 19302010042·联系我们:<img src="../../images/icons/wechat2DCode.JPG"/>19302010042@fudan.edu.cn·举报
</footer>
</body>
</html>