<?php
    include('dbconnect.php');

    $userid = $_POST['userid'];
    $html = "";
    $button = "";

    $sql = "SELECT confpy.new AS Aktiv, confpy.upper, confpy.lower, coins.coin, coins.id FROM confpy, coins WHERE usid = " . $userid . " AND confpy.curid = coins.id";

    $stmt = $conn->query($sql);
    while ($row = $stmt->fetch()) {
        if ($row['Aktiv'] == 1) {$aktiv = "Ja";} else {$aktiv = "Nein";}

        if ($row['Aktiv'] == 0) {
            $button = '<td><button onclick="updateAlert(\'' . $row['id'] . '\')">+</button></td>';
        }

        $html = $html . '<tr id="' . $row['id'] . '">
        <td>' . $aktiv . '</td>
        <td>' . $row['upper'] . '</td>
        <td>' . $row['lower'] . '</td>
        <td>' . $row['coin'] . '</td>
        <td><button onclick="removeAlert(\'' . $row['id'] . '\')">X</button></td>
        ' . $button . '
    </tr>';

    $button = "";
    }

    echo $html;

?>


<!-- <td><button onclick="updateAlert(\'' . $row['id'] . '\')">+</button></td> -->