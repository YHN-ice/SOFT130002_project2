<?php
require_once("config.php");
$country = $_REQUEST["country"];
$upload = $_REQUEST['upload'];
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($upload=='true') {
            $sql = "SELECT AsciiName,GeoNameID
        FROM geocities
        WHERE Country_RegionCodeISO = '{$country}'
       ";
        } else {
            $sql = "SELECT AsciiName,GeoNameID
        FROM geocities
        WHERE Country_RegionCodeISO = '{$country}'
        AND GeoNameID IN (
            SELECT DISTINCT CityCode
            FROM travelimage
        )
       ";
        }
        $result = $pdo->query($sql);

        while ($row = $result->fetch()) {
            echo $row['AsciiName'];
            echo "∝";
            echo $row['GeoNameID'];
            echo "ℸ";
        }
        $pdo = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}