<!DOCTYPE html>
<html lang="en">
<?php
if (!isset($_COOKIE['Username']))
    header("Location: index.php");
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/nav.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/upload.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/footer.css" media="all">
    <script src="../js/upload.js"></script>
    <script type="text/javascript" src="../js/selector-onchange.js"></script>

    <title>上传页</title>
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

<form method="post" enctype="multipart/form-data" <?php
if (isset($_GET['ImageID']))
    echo "action = 'uploadHandler.php?ImageID={$_GET['ImageID']}'";
else
    echo "action = 'uploadHandler.php'";
?>>
    <?php
    require_once('config.php');
    if (isset($_GET['ImageID'])) {
        try {
            $conn = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT PATH FROM travelimage WHERE ImageID = '{$_GET['ImageID']}'";

            $result = $conn->query($sql);


            while ($row = $result->fetch()) {
                echo "<img src=\"../../travel-images/large/{$row['PATH']}\" alt=\"{$row['PATH']}\" id=\"preview\" class=\"text\"/>";
            }
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
    }
    else
        echo "<img src=\"\" alt=\"图片未上传\" id=\"preview\" class=\"text\"/>";

    ?>


<input type="file" name="file" onchange="previewFile(this)" class="text" required>
    <div><span class="text">图片标题</span><input type="text" name="title" required
            <?php
            require_once('config.php');
            if (isset($_GET['ImageID'])) {
                try {
                    $conn = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT Title, Country_RegionCodeISO, CityCode FROM travelimage WHERE ImageID = '{$_GET['ImageID']}'";

                    $result = $conn->query($sql);


                    while ($row = $result->fetch()) {
                        echo "value = '{$row['Title']}'";
                        $ISO = $row['Country_RegionCodeISO'];
                        $CityCode = $row['CityCode'];
                    }

                } catch (PDOException $e) {
                    echo $sql . "<br>" . $e->getMessage();
                }

                $conn = null;
            }
            ?>
        ></div>
    <p class="text">图片描述</p>
    <textarea name="description" required><?php
        require_once('config.php');
        if (isset($_GET['ImageID'])) {
            try {
                $conn = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT Description FROM travelimage WHERE ImageID = '{$_GET['ImageID']}'";

                $result = $conn->query($sql);


                while ($row = $result->fetch()) {
                    echo $row['Description'];
                }

            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }

            $conn = null;

        }
        ?></textarea>
    <p class="text">图片主题</p>
    <select name="content" id="content-selector"
    <?php
    require_once('config.php');
    $contentSelected = null;
    if (isset($_GET['ImageID'])) {
        try {
            $conn = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT Content FROM travelimage WHERE ImageID = '{$_GET['ImageID']}'";

            $result = $conn->query($sql);


            while ($row = $result->fetch()) {
                $contentSelected = $row['Content'];
                echo "value = '{$row['Content']}'";
            }
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;
    }

    echo "required>";
    if (isset($_GET['ImageID'])) {
        if ('scenery' == "{$contentSelected}")
            echo "<option value=\"scenery\" selected>Scenery</option>";
        else
            echo "<option value=\"scenery\">Scenery</option>";


        if ('city' == "{$contentSelected}")
            echo "<option value=\"city\" selected>City</option>";
        else
            echo "<option value=\"city\">City</option>";


        if ('people' == "{$contentSelected}")
            echo "<option value=\"people\" selected>People</option>";
        else
            echo "<option value=\"people\">People</option>";


        if ('animal' == "{$contentSelected}")
            echo "<option value=\"animal\" selected>Animal</option>";
        else
            echo "<option value=\"animal\">Animal</option>";

        if ('building' == "{$contentSelected}")
            echo "<option value=\"building\" selected>Building</option>";
        else
            echo "<option value=\"building\">Building</option>";

        if ('wonder' == "{$contentSelected}")
            echo "<option value=\"wonder\" selected>Wonder</option>";
        else
            echo "<option value=\"wonder\">Wonder</option>";

        if ('other' == "{$contentSelected}")
            echo "<option value=\"other\" selected>Other</option>";
        else
            echo "<option value=\"other\">Other</option>";
    } else {
        echo "<option value=\"scenery\">Scenery</option>";
        echo "<option value=\"city\">City</option>";
        echo "<option value=\"people\">People</option>";
        echo "<option value=\"animal\">Animal</option>";
        echo "<option value=\"building\">Building</option>";
        echo "<option value=\"wonder\">Wonder</option>";
        echo "<option value=\"other\">Other</option>";
    }
    ?>
    </select>
    <p class="text">拍摄国家</p>

    <select name="countries" id="country-selector" onchange="getCities(this, this.form.cities,true)"

        <?php
        $countrySelected = null;
        require_once('config.php');
        if (isset($_GET['ImageID'])) {
            try {
                $conn = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT Country_RegionCodeISO FROM travelimage WHERE ImageID = '{$_GET['ImageID']}'";

                $result = $conn->query($sql);


                while ($row = $result->fetch()) {
                    $countrySelected = $row['Country_RegionCodeISO'];
                    echo "value = '{$row['Country_RegionCodeISO']}'";
                }

            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }

            $conn = null;
        }
        ?>
            required>
        <?php
        require_once("config.php");
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'SELECT Country_RegionName, ISO FROM geocountries_regions';
            $result = $pdo->query($sql);
            while ($row = $result->fetch()) {
                if ($row['ISO'] == $countrySelected)
                    echo "<option value=\"{$row['ISO']}\" selected>{$row['Country_RegionName']}</option>";
                else
                    echo "<option value=\"{$row['ISO']}\">{$row['Country_RegionName']}</option>";
            }
            $pdo = null;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        ?>
    </select>
    <p class=" text">拍摄城市</p>
    <select name="cities" id="city-selector"
    <?php
    require_once('config.php');
    $citySelected = null;
    if (isset($_GET['ImageID'])) {
        try {
            $conn = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT CityCode FROM travelimage WHERE ImageID = '{$_GET['ImageID']}'";
            $sqlForCityList = "SELECT AsciiName,GeoNameID FROM geocities WHERE Country_RegionCodeISO = '{$countrySelected}'";

            $result = $conn->query($sql);
            $resultForCityList = $conn->query($sqlForCityList);


            while ($row = $result->fetch()) {
                $citySelected = $row['CityCode'];
                echo "value = '{$row['CityCode']}'";
            }

            while ($row = $resultForCityList->fetch()) {
                if ($row['GeoNameID'] == $citySelected)
                    echo "<option value=\"{$row['GeoNameID']}\" selected>{$row['AsciiName']}</option>";
                else
                    echo "<option value=\"{$row['GeoNameID']}\">{$row['AsciiName']}</option>";
            }

        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;
    }
    echo "required>";
    ?>

    </select>
    <?php
    if (isset($_GET['ImageID']))
        echo "<input type=\"submit\" value=\"modify\" name=\"modify\" class=\"text\">";
    else
        echo "<input type=\"submit\" value=\"upload\" name=\"upload\" class=\"text\">";
    ?>

</form>
<footer>
    © 2020 fdu19ss沪·证书·备 19302010042·联系我们:<img src="../../images/icons/wechat2DCode.JPG"/>19302010042@fudan.edu.cn·举报
</footer>
</body>
</html>