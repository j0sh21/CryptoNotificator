<?php
$a = $_POST['text'];
$html = "";

include '../inc/dbconnect.php';

$html = "<table>
    <tr>
        <th>Tag</th>
        <th>Durchschnitts Preis</th>
        <th>Max Uhrzeit</th>
        <th>Max Preis</th>
        <th>Min Uhrzeit</th>
        <th>Min Preis</th>
        <th>Schwankung in Dollar</th>
        <th>Stunden zwischen Max und Min</th>
        <th>Schwankungsgröße</th>
    </tr>";

$stmt = $con->query("select MAX" . $a . ".Tag, round(AVG" . $a . ".AVGP) as AVG_Price, MAX" . $a . ".Uhrzeit as MAX_UHRZEIT, MAX" . $a . ".maxp as MAX_PRICE, MIN" . $a . ".Uhrzeit as MIN_UHRZEIT, MIN" . $a . ".minp as MIN_PRICE, MAX" . $a . ".maxp-MIN" . $a . ".minp as USD_tages_schwankung, MAX" . $a . ".Uhrzeit-MIN" . $a . ".Uhrzeit as Stunden_zwischen_max_min, case when MAX" . $a . ".maxp-MIN" . $a . ".minp > 900 then 'mehr als 900' when MAX" . $a . ".maxp-MIN" . $a . ".minp > 500 then '> 500' else 'weniger' end as Schwankungsgroesse from MIN" . $a . ", MAX" . $a . ", AVG" . $a . " where MIN" . $a . ".Tag=MAX" . $a . ".Tag and MAX" . $a . ".Tag= AVG" . $a . ".Tag order by STR_TO_DATE(MAX" . $a . ".Tag,'%d.%m.%Y') DESC");

while ($row = $stmt->fetch()) {
    if ($row['Stunden_zwischen_max_min'] < 0) {
        $test = "lightcoral";
    } else if ($row['Stunden_zwischen_max_min'] > 0) {
        $test = "lightgreen";
    } else {
        $test = "lightblue";
    }

    $html = $html . "
                        <tr>
                            <td style='cursor: pointer;' onclick='showDay(this, \"" . $a . "\")'>" . $row['Tag'] . "</td>
                            <td>" . $row['AVG_Price'] . " $</td>
                            <td>" . $row['MAX_UHRZEIT'] . "</td>
                            <td>" . $row['MAX_PRICE'] . " $</td>
                            <td>" . $row['MIN_UHRZEIT'] . "</td>
                            <td>" . $row['MIN_PRICE'] . " $</td>
                            <td>" . $row['USD_tages_schwankung'] . " $</td>
                            <td style='background-color: " . $test . ";'>" . $row['Stunden_zwischen_max_min'] . "</td>
                            <td>" . $row['Schwankungsgroesse'] . "</td>
                        </tr>
                        ";
}

$stmt = $con->query("select price from " . $a . " where datum = (SELECT max(datum)from " . $a . ")");
$row = $stmt->fetch();

if ($row['price'] < 1000) {
    $price = $row['price'];
} else {
    $price = number_format($row['price']);
}

$html = $html . "\t<h2>Aktueller " . $a . " Preis: " . $price . " $ *¹</h2>";

$html = $html . "</table>";

$stmt = $con->query("SELECT time FROM log");
$row = $stmt->fetch();

$html = $html . "<br>Letztes Update: " . $row['time'];

$con = null;

echo $html;
