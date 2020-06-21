<?php
require_once('config.php');
if(isset($_GET['ImageID'])&&isset($_COOKIE['Username'])){

        try {
            $conn = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM travelimagefavor WHERE ImageID = '{$_GET['ImageID']}' AND UID IN (SELECT UID FROM traveluser WHERE UserName = '{$_COOKIE['Username']}')";

            $conn->exec($sql);
            echo "successfully canceled love";
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;

}

header("Location: ".$_SERVER['HTTP_REFERER']);
