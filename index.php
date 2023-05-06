<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var last = null;
        var last_2 = null;
        var last_3 = null;

        var lastCurency = null;

        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');

            for(let i = 0; i <ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
                }
            }

            return false;
        }
         
        window.onload = function() {
            const currency = ['ADA', 'ALGO', 'AVAX', 'BCH', 'BUSD', 'CRO', 'DAI', 'DOT', 'ETC', 'FTT', 'LEO', 'LINK', 'LTC', 'NEAR', 'SHIB', 'SOL', 'TRX', 'UNI', 'USDC', 'USDT', 'XLM', 'XMR', 'XRP', 'atom', 'bnb', 'btc', 'doge', 'eth', 'matic', 'wbtc'];

            for (var i = 0; i < currency.length; i++) {
                document.getElementById("main").innerHTML += "<button id='button" + currency[i] + "' onclick='printTable(\"" + currency[i] + "\", this)'>" + currency[i] + "</button>";
            }

            if (getCookie("username")) {
                document.getElementById("main").innerHTML += "<button class='dashboard' onclick='window.location.href = \"../Dashboard/index.html\"')>Dashboard</button>";
            } else {
                document.getElementById("main").innerHTML += "<button class='dashboard' onclick='window.location.href = \"../Dashboard/index.html\"')>Login</button>";
            }
            document.getElementById("main").innerHTML += '<div id="table"></div>';
        }

        function printTable(currency, element) {
            div = document.getElementById("table");

            element.style.backgroundColor = "lightyellow";
            element.style.color = "black";
            try {
                last_2.style.backgroundColor = "darkcyan";
                last_2.style.color = "white";
            } catch {

            }

            last_2 = element;

            $.ajax({
                method: "POST",
                url: "inc/print.php",
                data: { text: currency}
            }).done(function (response) {
                if (getCookie("username")) {
                    div.innerHTML = "<h1>Willkommen " + getCookie("username") + "</h1>";
                } else {
                    div.innerHTML = "";
                }
                div.innerHTML += response;
            })
            document.getElementById("day").innerHTML = "";
            document.getElementById("hour").innerHTML = "";
            lastCurency = currency;
        }

        function showDay(element, currency) {
            element.style.backgroundColor = "lightyellow";
            try {
                last.style.backgroundColor = "lightblue";
            } catch {

            }

            last = element;

            $.ajax({
                method: "POST",
                url: "inc/showDay.php",
                data: { text: currency, date: element.innerHTML}
            }).done(function (response) {
                document.getElementById("day").innerHTML = "<h2>" + currency + " am " + element.innerHTML + "</h2>";
                document.getElementById("day").innerHTML += response;
            })
            document.getElementById("hour").innerHTML = "";
        }

        function showHours(element, date) {
            element.style.backgroundColor = "lightyellow";
            try {
                last_3.style.backgroundColor = "lightblue";
            } catch {

            }

            last_3 = element;

            $.ajax({
                method: "POST",
                url: "inc/showHours.php",
                data: { date: date, hour: element.innerHTML, a: lastCurency}
            }).done(function (response) {
                document.getElementById("hour").innerHTML = "<h2>" + lastCurency + " in der Stunde " + element.innerHTML + " am " + date + "</h2>"
                document.getElementById("hour").innerHTML += response;
            })
        }
    </script>
    <title>Crypto Übersicht | odemsloh.de</title>
</head>
<body>
    <div id="main"></div>
    <div id="day"></div>
    <div id="hour"></div>
    
</body>
</html>
