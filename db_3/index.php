<?php
    // Copyright (c) 4TiZalewski
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            background-color: black;
            color: white;
        }

        .container {
            margin: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table, tr, th, td {
            border: solid 1px white;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $db = "4ti_gr1_psy";

    $connection = mysqli_connect($servername, $username, $password, $db);

    if (!$connection) {
        die("Połączenie z bazą danych nie udało się: ".mysqli_connect_error());
    }

    echo "Połączenie udane<br><br>";
    $sql = "SELECT `osoby`.id_osoby, `osoby`.imię, `osoby`.nazwisko, `osoby`.nr_tel, COUNT(`psy`.id_osoby) AS ilosc_psow FROM `osoby` LEFT JOIN `psy` ON `psy`.id_osoby = `osoby`.id_osoby GROUP BY `osoby`.id_osoby ORDER BY `osoby`.nazwisko DESC, `osoby`.imię;";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Lp.</th><th>ID</th><th>Imię</th><th>Nazwisko</th><th>Nr tel.</th><th>Ilość psów</th></tr>";
        $index = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $index += 1;
            echo "<tr><td>$index</td><td>".$row['id_osoby']."</td><td>".$row['imię']."</td><td>".$row['nazwisko']."</td><td>".$row['nr_tel']."</td><td>".$row['ilosc_psow']."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "Brak wyników";
    }

    mysqli_close($connection);

    ?>
    </div> 
</body>
</html>
<?php



?>