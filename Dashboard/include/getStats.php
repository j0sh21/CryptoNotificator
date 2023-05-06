<?php
    include('dbconnect.php');
    $html = "";
    $userid = $_POST['userid'];
    $sql = "SELECT coins.coin FROM confpy, coins WHERE confpy.usid = " . $userid . " AND confpy.curid = coins.id";

    $stmt = $conn->query($sql);
    while ($row = $stmt->fetch()) {

        $table = $row['coin'];


        $sqlb =  "SELECT datum, price, round(percent_change_1h, 2) as percent_change_1h,  round(percent_change_24h, 2) as percent_change_24h,  round(percent_change_7d, 2) as percent_change_7d, round(percent_change_30d, 2) as percent_change_30d, round(percent_change_60d, 2) as percent_change_60d, round(percent_change_90d, 2) as percent_change_90d FROM " . $table . " WHERE datum = (SELECT MAX(datum) FROM btc)";

        $stmtb = $conn->query($sqlb);
        while ($rowb = $stmtb->fetch()) {

            $html = $html . '<tr id="btc">
            <td>' . $table . '</td>
            <td>' . $rowb['price'] . '</td>
            <td>' . $rowb['percent_change_1h'] . '</td>
            <td>' . $rowb['percent_change_24h'] . '</td>
            <td>' . $rowb['percent_change_7d'] . '</td>
            <td>' . $rowb['percent_change_30d'] . '</td>
            <td>' . $rowb['percent_change_60d'] . '</td>
            <td>' . $rowb['percent_change_90d'] . '</td>
        </tr>';
        }



    }
    echo $html;
?>