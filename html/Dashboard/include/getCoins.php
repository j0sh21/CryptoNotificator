<?php
    include('dbconnect.php');

    $html = "";

    $sql = "SELECT id, coin FROM coins";

    $stmt = $conn->query($sql);
    while($row = $stmt->fetch()) {
        $html = $html . '<option value="' . $row['id'] . '">' . $row['coin'] .'</option>';
    }

    echo $html;
?>