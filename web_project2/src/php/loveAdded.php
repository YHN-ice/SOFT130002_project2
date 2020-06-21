<?php
if (isset($_GET['ImageID']) && isset($_GET['UID'])) {
    require_once("config.php");
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sqlCheck = "SELECT COUNT(FavorID) FROM travelimagefavor WHERE UID = '{$_GET['UID']}' AND ImageID = '{$_GET['ImageID']}'";
        $result = $pdo->query($sqlCheck);
        $count = 0;
        while ($row = $result->fetch())
            $count = $row['COUNT(FavorID)'];

        if($count != 0)
            exit('您已喜欢过');

        $sql = "INSERT INTO travelimagefavor (UID, ImageID) VALUES ('{$_GET['UID']}','{$_GET['ImageID']}')";
        $pdo->exec($sql);
        echo "successfully liked";
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    $pdo = null;

}

header("Location: ".$_SERVER['HTTP_REFERER']);
