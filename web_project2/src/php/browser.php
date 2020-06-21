<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/nav.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/browser.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/section-footer-pages.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/footer.css" media="all">
    <script type="text/javascript" src="../js/cities.js"></script>
    <script type="text/javascript" src="../js/selector-onchange.js"></script>
    <script type="text/javascript" src="../js/changePages.js"></script>
    <title>浏览页</title>
</head>
<body>
<header>
    <nav>
        <div id=homepage><a href="index.php">首页</a></div>
        <div id=this-page><a href="browser.php">浏览页</a></div>
        <div id=search><a href="search.php">搜索页</a></div>
        <?php require_once("nav-login.php"); ?>
    </nav>
</header>
<aside>
    <div id="popular-countries">
        <div>热门国家快速浏览</div>
        <form method="post" class="aside-form">
            <ul>
                <?php
                require_once("config.php");
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = 'SELECT Country_RegionName FROM geocountries_regions WHERE ISO IN(SELECT Country_RegionCodeISO FROM travelimage GROUP BY Country_RegionCodeISO ORDER BY COUNT(ImageID) DESC) LIMIT 6';
                    $result = $pdo->query($sql);
                    while ($row = $result->fetch()) {
                        echo "<li><input type='submit' name='hotCountry' value='{$row['Country_RegionName']}'></li>";
                    }
                    $pdo = null;
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
                ?>
            </ul>
        </form>
    </div>

    <div id="popular-cities">
        <div>热门城市快速浏览</div>
        <form method="post" class="aside-form">
            <ul>
                <?php
                require_once("config.php");
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = 'SELECT AsciiName FROM geocities WHERE GeoNameID IN(SELECT CityCode FROM travelimage GROUP BY CityCode ORDER BY COUNT(ImageID) DESC) LIMIT 6';
                    $result = $pdo->query($sql);
                    while ($row = $result->fetch()) {
                        echo "<li><input type='submit' name='hotCity' value='{$row['AsciiName']}'></li>";
                    }
                    $pdo = null;
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
                ?>
            </ul>
        </form>
    </div>

    <div id="hot-content">
        <div>热门内容快速浏览</div>
        <form method="post" class="aside-form">
            <ul>
                <?php
                require_once("config.php");
                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = 'SELECT Content FROM travelimage GROUP BY Content ORDER BY COUNT(ImageID) DESC LIMIT 3';
                    $result = $pdo->query($sql);
                    while ($row = $result->fetch()) {
                        echo "<li><input type='submit' name='hotContent' value='{$row['Content']}'></li>";
                    }
                    $pdo = null;
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
                ?>
            </ul>
        </form>
    </div>
</aside>

<div id="filter">
    <form method="post" action="">
        <select name="content">
            <option>Filter by Content</option>
            <?php
            require_once("config.php");
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = 'SELECT DISTINCT Content FROM travelimage';
                $result = $pdo->query($sql);

                while ($row = $result->fetch()) {
                    echo "<option value=\"{$row['Content']}\">{$row['Content']}</option>";
                }
                $pdo = null;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
            ?>
        </select>
        <select name="countries" onchange="getCities(this, this.form.cities,false)">
            <option value="default" id="default">Filter by Country</option>
            <?php
            require_once("config.php");
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = 'SELECT Country_RegionName, ISO FROM geocountries_regions WHERE ISO IN(SELECT DISTINCT Country_RegionCodeISO FROM travelimage)';
                $result = $pdo->query($sql);
                while ($row = $result->fetch()) {
                    echo "<option value=\"{$row['ISO']}\">{$row['Country_RegionName']}</option>";
                }
                $pdo = null;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
            ?>
        </select>
        <select name="cities">
            <option>Filter by City</option>
        </select>
        <input type="submit" name="multiSelector" value="Filter">
    </form>
</div>
<div>
    <form method="post" action="">
        <input type="text" name="title" id=single-filter>
        <input type="submit" name="titleFilter" value="filter">
    </form>
</div>

<section>
    <div id="show-zone">
        <?php
        require_once("config.php");
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['titleFilter']) && $_POST['title'] != NULL) {
                    $title = $_POST['title'];
                    $sql = "SELECT PATH, ImageID FROM travelimage  WHERE Title LIKE '%{$title}%' LIMIT 100";
                } elseif (isset($_POST['multiSelector']) && $_POST['content'] != 'Filter by Content' && $_POST['countries'] != 'Filter by Country' && $_POST['countries'] != 'default' && $_POST['cities'] != 'Filter by City') {
                    $content = $_POST['content'];
                    $country = $_POST['countries'];
                    $city = $_POST['cities'];
                    $sql = "SELECT PATH, ImageID FROM travelimage  WHERE Content = '{$content}' AND Country_RegionCodeISO = '{$country}' AND CityCode = '{$city}' LIMIT 100";
                } elseif (isset($_POST['hotCity'])) {
                    $hotCity = $_POST['hotCity'];
                    $sql = "SELECT PATH, ImageID FROM travelimage  WHERE CityCode IN(SELECT GeoNameID FROM geocities WHERE AsciiName = '{$hotCity}') LIMIT 100";
                } elseif (isset($_POST['hotCountry'])) {
                    $hotCountry = $_POST['hotCountry'];
                    $sql = "SELECT PATH, ImageID FROM travelimage  WHERE Country_RegionCodeISO IN(SELECT ISO FROM geocountries_regions WHERE Country_RegionName = '{$hotCountry}') LIMIT 100";
                } elseif (isset($_POST['hotContent'])) {
                    $hotContent = $_POST['hotContent'];
                    $sql = "SELECT PATH, ImageID FROM travelimage  WHERE Content = '{$hotContent}' LIMIT 100";
                } else {
                    $sql = 'SELECT PATH, ImageID FROM travelimage ORDER BY  RAND() LIMIT 100';
                }

            } else {
                $sql = 'SELECT PATH, ImageID FROM travelimage ORDER BY  RAND() LIMIT 100';
            }
            $result = $pdo->query($sql);

            $index = 0;
            while ($row = $result->fetch()) {
                if ($index < 20)
                    echo "<a class='show-zone-container' href=\"detail.php?ImageID={$row['ImageID']}\"><img class='{$row['ImageID']} show-zone-image' id='{$index}' src=\"../../travel-images/large/{$row['PATH']}\"/>";
                else
                    echo "<a class='show-zone-container' style='display: none' href=\"detail.php?ImageID={$row['ImageID']}\"><img class='{$row['ImageID']} show-zone-image' id='{$index}' src=\"../../travel-images/large/{$row['PATH']}\"/>";
                $index++;
            }
            $pdo = null;
        } catch (PDOException $e) {
            die($e->getMessage());
        }


        ?>
    </div>


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