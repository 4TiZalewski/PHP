<?php
    // Copyright (c) 4TiZalewski

    $name_start = $_GET['name_start'] ?? "";
    $minimal_amount = intval($_GET['minimal_amount'] ?? 0);
    $gender = $_GET['gender'] ?? "n";

    if ($gender != "w" && $gender != "m" && $gender != "n") {
        $gender = "n";
    }
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
        <form method="GET">
            <label for="minimal_amount">
                Wartosc minimalna:
                <input type="number" min="0" id="mininal_amount" name="minimal_amount" value="<?php echo "$minimal_amount"; ?>">
            </label>
            <br>
            <label for="name_start">
                Poczatek nazwiska
                <input type="text" id="name_start" name="name_start" value="<?php echo "$name_start"; ?>">
            </label>
            <br>
            <div>
                Płeć
                <label for="w">
                    <input type="radio" value="w" id="w" name="gender">
                    K
                </label>
                <label for="m">
                    <input type="radio" value="m" id="m" name="gender">
                    M
                </label>
            </div>
            <br>
            <input type="submit" value="Zatwierdź">
        </form>
    <?php

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $db = "4ti_gr1_konta";

    $connection = mysqli_connect($servername, $username, $password, $db);

    if (!$connection) {
        die("Połączenie z bazą danych nie udało się: ".mysqli_connect_error());
    }

    echo "<br>Połączenie udane<br><br>";
    $sql = "SELECT `osoby`.imie, `osoby`.nazwisko, SUM(`konta`.dostepne_srodki) AS srodki 
            FROM `osoby` 
            JOIN `konta` ON `osoby`.id_osoby = `konta`.id_osoby 
            WHERE `osoby`.nazwisko LIKE ? 
                AND `osoby`.imie LIKE ? 
                AND `osoby`.imie NOT LIKE ?
            GROUP BY `osoby`.id_osoby 
            HAVING srodki >= ?
            ORDER BY srodki DESC;";

    $stmt = mysqli_prepare($connection, $sql);

    $name_start .= "%";
    $name_end_like = "%";
    $name_end_not_like = "";
    if ($gender === "w") {
        $name_end_like .= "a";
    } else if ($gender === "m") {
        $name_end_not_like = "%a";
    }

    mysqli_stmt_bind_param($stmt, "sssi", $name_start, $name_end_like, $name_end_not_like, $minimal_amount);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

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