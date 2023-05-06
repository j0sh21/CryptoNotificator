<?php 
    include 'dbconnect.php';

    $a = $_POST['a'];
    $date = $_POST['date'];
    $hour = $_POST['hour'];
    $html = "";

    $html = "<table>
    <tr>
        <th>Minute</th>
        <th>Preis</th>
    </tr>";

    $stmt = $con->query("select price, extract(MINUTE from ADDDATE(datum,INTERVAL 2 HOUR)) as Minute from " . $a . " where DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR),'%d.%m.%Y') = DATE_FORMAT(STR_TO_DATE('" . $date . "','%d.%m.%Y'),'%d.%m.%Y') and extract(HOUR from ADDDATE(datum, INTERVAL 2 HOUR))=" . $hour);

    while ($row = $stmt->fetch()) {
        $html = $html . "<tr>
            <td>" . $row['Minute'] . "</td>
            <td>" . $row['price'] . "</td>
        </tr>";
    }

    $html = $html . "</table>";

    $stmt = null;
    $con = null;

    echo $html;
?>