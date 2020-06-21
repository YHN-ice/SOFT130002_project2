<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/nav.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/search.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/section-footer-pages.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/footer.css" media="all">
    <script src="../js/clamp.js"></script>
    <script src="../js/search.js"></script>
    <script type="text/javascript" src="../js/changePages.js"></script>
    <title>搜索页</title>
</head>
<body>
<header>
    <nav>
        <div id=homepage><a href="index.php">首页</a></div>
        <div id=browser><a href="browser.php">浏览页</a></div>
        <div id=this-page><a href="search.php">搜索页</a></div>
        <?php require_once("nav-login.php"); ?>
    </nav>
</header>
<div id="filter">
    <form method="post">
        <input type="radio" name="title-or-description" value="description">描述
        <input type="radio" name="title-or-description" value="title" checked>标题
        <input type="text" name="keyword" placeholder="type keyword here">
        <input type="submit" name="text-search" value="Search">
    </form>
</div>
<section>
    <?php
    require_once("config.php");
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['text-search']) && $_POST['keyword'] != NULL) {
                $keyword = $_POST['keyword'];
                if ($_POST['title-or-description'] == 'title')
                    $sql = "SELECT PATH, ImageID, Title, Description FROM travelimage  WHERE Title LIKE '%{$keyword}%' LIMIT 100";
                elseif ($_POST['title-or-description'] == 'description')
                    $sql = "SELECT PATH, ImageID, Title, Description FROM travelimage  WHERE Description LIKE '%{$keyword}%' LIMIT 100";

            } else {
                $sql = 'SELECT PATH, ImageID, Title, Description FROM travelimage ORDER BY  RAND() LIMIT 100';
            }

        } else {
            $sql = 'SELECT PATH, ImageID, Title, Description FROM travelimage ORDER BY  RAND() LIMIT 100';
        }
        $result = $pdo->query($sql);

        $index = 0;
        while ($row = $result->fetch()) {
            if ($index < 20)
                echo "<div class = 'show-zone-container'><a href=\"detail.php?ImageID={$row['ImageID']}\"><img class='{$row['ImageID']} show-zone-image' id='{$index}' src=\"../../travel-images/large/{$row['PATH']}\"/></a>
        <div><h3>{$row['Title']}</h3>
            <p class=\"to-be-trimmed\">{$row['Description']}.</p>
        </div>
    </div>";
            else
                echo "<div class = 'show-zone-container' style='display: none'><a href=\"detail.php?ImageID={$row['ImageID']}\"><img class='{$row['ImageID']} show-zone-image' id='{$index}' src=\"../../travel-images/large/{$row['PATH']}\"/></a>
        <div><h3>{$row['Title']}</h3>
            <p class=\"to-be-trimmed\">{$row['Description']}.</p>
        </div>
    </div>";
            $index++;
        }
        $pdo = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
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