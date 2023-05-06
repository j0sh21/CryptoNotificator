<?php
    include('dbconnect.php');

    $html = "";

    $sql =  "SELECT datum, round(percent_change_1h, 2) as percent_change_1h,  round(percent_change_24h, 2) as percent_change_24h,  round(percent_change_7d, 2) as percent_change_7d, round(percent_change_30d, 2) as percent_change_30d, round(percent_change_60d, 2) as percent_change_60d, round(percent_change_90d, 2) as percent_change_90d FROM btc WHERE datum = (SELECT MAX(datum) FROM btc)";

    $stmt = $conn->query($sql);
    while ($row = $stmt->fetch()) {

        $html = $html . '<tr id="btc">
        <td>' .$row['percent_change_1h'] . '</td>
        <td>' . $row['percent_change_24h'] . '</td>
        <td>' . $row['percent_change_7d'] . '</td>
        <td>' . $row['percent_change_30d'] . '</td>
        <td>' . $row['percent_change_60d'] . '</td>
        <td>' . $row['percent_change_90d'] . '</td>
    </tr>';
    }


    echo $html;
?>