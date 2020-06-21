<?php
require_once("config.php");
try {
    $pdo = new PDO('mysql:host=localhost;dbname=project2', DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT PATH, Title, Description, ImageID FROM travelimage  ORDER BY  RAND() LIMIT 10";
    $result = $pdo->query($sql);

    while ($row = $result->fetch()) {
        echo $row['ImageID'];
        echo '∝';
        echo $row['Title'];
        echo '∝';
        echo $row['Description'];
        echo '∝';
        echo $row['PATH'];
    }
    $pdo = null;
} catch (PDOException $e) {
    die($e->getMessage());
}
