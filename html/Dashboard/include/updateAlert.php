<?php
    include('dbconnect.php');

    $userid = $_POST['userid'];
    $curid = $_POST['curid'];

    $sql = "UPDATE confpy SET new = 1 WHERE usid = " . $userid . " AND curid = " . $curid;

    $stmt = $conn->query($sql);
 
?>