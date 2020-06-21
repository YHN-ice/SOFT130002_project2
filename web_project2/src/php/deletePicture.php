<?php
if(isset($_GET['ImageID'])){
    require_once("config.php");
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM travelimage WHERE ImageID = '{$_GET['ImageID']}'";
        $pdo->exec($sql);
        echo "successfully deleted";
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    $pdo = null;

}

