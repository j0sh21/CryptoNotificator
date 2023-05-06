<?php
    include('dbconnect.php');

    $userid = $_POST['userid'];
    $curid = $_POST['curid'];

    $sql = "DELETE FROM confpy WHERE usid = " . $userid . " AND curid = " . $curid;

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    header('Location: ../index.html');
?>