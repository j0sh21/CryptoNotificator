<?php
    include('dbconnect.php');

    $max = $_POST['max_price'];
    $min = $_POST['min_price'];
    $userid = $_POST['userid'];
    $curid = $_POST['curid'];

    $sql = "REPLACE INTO confpy (new, upper, lower, usid, curid) VALUES (1, " . $max . ", " . $min . ", " . $userid . ", " . $curid . ")";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    header('Location: ../index.html');
?>