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
    $db = "4ti_gr1_konta";

    $connection = mysqli_connect($servername, $username, $password, $db);

    if (!$connection) {
        die("Połączenie z bazą danych nie udało się: ".mysqli_connect_error());
    }

    echo "Połączenie udane<br><br>";
    $sql = "SELECT `osoby`.imie, `osoby`.nazwisko, SUM(`konta`.dostepne_srodki) AS srodki 
            FROM `osoby` 
            JOIN `konta` ON `osoby`.id_osoby = `konta`.id_osoby 
            GROUP BY `osoby`.id_osoby 
            ORDER BY srodki DESC;";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>Imię</th>";
        echo "<th>Nazwisko</th>";
        echo "<th>Kasa</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['imie']."</td>"; 
            echo "<td>".$row['nazwisko']."</td>";
            echo "<td>".$row['srodki']."</td>"; 
            echo "</tr>";
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