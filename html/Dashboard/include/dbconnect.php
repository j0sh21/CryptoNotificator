<?php
    ini_set('display_errors', 1);

    $dbuser = "<dbUser>";
    $dbpass = "<dbPassword>";

    

    try {
        $conn = new PDO('mysql:host=<dbIp>;dbname=<dbName>', $dbuser, $dbpass);
        return $conn;
    } catch (PDOException $e) {
        echo("Verbindung Fehlgeschlagen!");
        exit();
    }
?>