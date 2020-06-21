<!DOCTYPE html>
<html lang="en">
<?php
if (!isset($_COOKIE['Username']) || !isset($_GET['ImageID']))
    header("Location: index.php");
?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/nav.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/detail.css" media="all">


    <link rel="stylesheet" type="text/css" href="../css/footer.css" media="all">
    <title>图片详情</title>
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
    <?php
    require_once('config.php');
    try {
        $loveURL = '?UID=';
        $conn = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT Title, Description, PATH, ImageID, Content FROM travelimage WHERE ImageID = '{$_GET['ImageID']}'";
        $result = $conn->query($sql);
        while ($row = $result->fetch()) {
            echo "<div id=\"title\">{$row['Title']}";
        }

        $UserUID=null;
        $sqlUsername = "SELECT UserName, UID FROM traveluser WHERE UserName = '{$_COOKIE['Username']}'";
        $resultUsername = $conn->query($sqlUsername);
        while ($row = $resultUsername->fetch()){
            $loveURL .= "{$row['UID']}";
            $UserUID = $row['UID'];
        }


        $sqlForUser = "SELECT UserName, UID FROM traveluser WHERE UID IN(SELECT UID FROM travelimage WHERE ImageID = '{$_GET['ImageID']}')";
        $resultForUser = $conn->query($sqlForUser);
        while ($row = $resultForUser->fetch()) {
            echo "<span id=\"photographer\">by {$row['UserName']}</span></div>";
        }

        echo "<div id=\"trunk\">";

        $result = $conn->query($sql);
        while ($row = $result->fetch()) {
            echo "<div><img id=\"photo\" class={$row['ImageID']} src=\"../../travel-images/large/{$row['PATH']}\">";
            $loveURL .= "&ImageID=" . "{$row['ImageID']}";
        }

        $liked = false;
        $sqlForLikes = "SELECT ImageID FROM travelimagefavor WHERE UID = '{$UserUID}'";
        $resultForLikes = $conn->query($sqlForLikes);
        while($row=$resultForLikes->fetch()){
            if($row['ImageID']==$_GET['ImageID'])
                $liked=true;
        }
        if($liked)
            echo "<button id=\"like\"><a href='cancelLove.php?ImageID={$_GET['ImageID']}'>unlike·取消收藏</a></button>";
        else
        echo "<button id=\"like\"><a href='loveAdded.php{$loveURL}'>like·收藏</a></button>";
        echo "</div>";
        echo "<table>";
        echo "<caption>Details</caption>";
        echo "<tr>";
        echo "<td>likes</td>";


        $sqlForLoveCount = "SELECT COUNT(FavorID) FROM travelimagefavor WHERE ImageID = '{$_GET['ImageID']}'";
        $resultForLoves = $conn->query($sqlForLoveCount);
        while ($row = $resultForLoves->fetch()) {
            echo "<td>{$row['COUNT(FavorID)']}</td>";
        }
        echo "</tr>";
        echo "<tr>";
        echo "<td>content</td>";

        $result = $conn->query($sql);
        while ($row = $result->fetch()) {
            echo "<td>{$row['Content']}</td>";
        }

        echo "</tr>";
        echo "<tr>";
        echo "<td>country</td>";
        $sqlForCountry = "SELECT Country_RegionName FROM geocountries_regions WHERE ISO IN (SELECT Country_RegionCodeISO FROM travelimage WHERE ImageID = '{$_GET['ImageID']}')";
        $resultForCoutry = $conn->query($sqlForCountry);
        while ($row = $resultForCoutry->fetch()) {
            echo "<td>{$row['Country_RegionName']}</td>";
        }
        echo "</tr>";
        echo "<tr>";
        echo "<td>city</td>";
        $sqlForCity = "SELECT AsciiName FROM geocities WHERE GeoNameID IN (SELECT Citycode FROM travelimage WHERE ImageID = '{$_GET['ImageID']}')";
        $resultForCity = $conn->query($sqlForCity);
        while ($row = $resultForCity->fetch()) {
            echo "<td>{$row['AsciiName']}</td>";
        }
        echo "</tr>";
        echo "</table>";
        $result = $conn->query($sql);
        while ($row = $result->fetch()) {
            echo "<p id=\"complete-description\">description:{$row['Description']}.</p>";
        }

        echo "</div>";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;

    ?>
</section>
<footer>
    © 2020 fdu19ss沪·证书·备 19302010042·联系我们:<img src="../../images/icons/wechat2DCode.JPG"/>19302010042@fudan.edu.cn·举报
</footer>
</body>
</html>