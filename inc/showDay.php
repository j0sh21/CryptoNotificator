<?php 
    include 'dbconnect.php';

    $a = $_POST['text'];
    $date = $_POST['date'];
    $html = "";
    $color = null;
    $time = null;
    $i = 0;

    $stmt = $con->query("select MAX_H_" . $a . ".Tag_Stunde,  MAX_H_" . $a . ".Uhrzeit as Max_Time,  MAX_H_" . $a . ".maxp as MAX_Price, MIN_H_" . $a . ".Uhrzeit as MIN_Time, MIN_H_" . $a . ".minp as MIN_Price, MAX_H_" . $a . ".maxp- MIN_H_" . $a . ".minp as DIFF, TIMEDIFF(MAX_H_" . $a . ".Uhrzeit,MIN_H_" . $a . ".Uhrzeit) as Minuten_zwischen_max_min from MAX_H_" . $a . ", MIN_H_" . $a . " where MAX_H_" . $a . ".Tag_Stunde=MIN_H_" . $a . ".Tag_Stunde and STR_TO_DATE(MAX_H_" . $a . ".Tag_Stunde,'%d.%m.%Y') = STR_TO_DATE('" . $date . "','%d.%m.%Y') order by STR_TO_DATE(MAX_H_" . $a . ".Tag_Stunde,'%d.%m.%Y:%H') DESC");

    $html = $html . "<table>
            <tr><th>Stunde</th><th>Max Uhrzeit</th><th>Max Preis</th><th>Min Uhrzeit</th><th>Min Preis</th><th>Differenz</th><th>Minuten zwischen Max und Min</th></tr>";

    while ($row = $stmt->fetch()) {
        if($row['Minuten_zwischen_max_min'] < "00:00") {
            $color = "lightcoral";
            $time = substr($row['Minuten_zwischen_max_min'], 0, 6);
        } else if ($row['Minuten_zwischen_max_min'] > "00:00") {
            $color = "lightgreen";
            $time = substr($row['Minuten_zwischen_max_min'], 0, 5);
        } else {
            $color = "lightblue";
            $time = substr($row['Minuten_zwischen_max_min'], 0, 5);
        }

        $html = $html . "<tr>
            <td onclick='showHours(this, \"" . $date . "\")'>" . substr($row['Tag_Stunde'], 11) . "</td>
            <td>" . $row['Max_Time'] . "</td>
            <td>" . $row['MAX_Price'] . "</td>
            <td>" . $row['MIN_Time'] . "</td>
            <td>" . $row['MIN_Price'] . "</td>
            <td>" . $row['DIFF'] . "</td>
            <td style='background-color: " . $color . ";'>" . $time . "</td>
        </tr>";
        $i = $i + 1;
    }

    $html = $html . "</table>";

    echo $html;

    $stmt = null;
    $con = null;
?>
