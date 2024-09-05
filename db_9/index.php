<?php
    // Copyright (c) 4TiZalewski

    $wlasciciel = NULL;

    if (isset($_GET['wlasciciel'])) {
        $wlasciciel = trim($_GET['wlasciciel']);
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
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table, tr, td, th {
            border: 1px solid white;
        }

        td, th {
            padding: 0.3rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php

        require 'connect.php';

        if (!$connection) {
            die("Nie udało się połączyć z bazą danych: ".mysqli_connect_error());
        }

        ?>
        <form>
            <select name="wlasciciel">
                <?php

                $sql = <<<SQL
                    SELECT `osoby`.id_osoby, `osoby`.imię, `osoby`.nazwisko 
                    FROM `osoby`
                    GROUP BY `osoby`.id_osoby
                    ORDER BY `osoby`.nazwisko, `osoby`.imię ASC;
                SQL;

                $result = mysqli_query($connection, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id_osoby'];

                    if ($wlasciciel === $row['id_osoby']) {
                        echo "<option selected value=\"$id\">";
                    } else {
                        echo "<option value=\"$id\">";
                    }

                    echo $row['imię']." ";
                    echo $row['nazwisko'];
                    echo "</option>\n";
                }

                ?>
            </select>
            <input type="submit">
        </form>

        <?php

        if ($wlasciciel) {
            $sql = <<<SQL
                SELECT `psy`.rasa, `psy`.wiek, `psy`.płeć, `psy`.medale, `osoby`.imię, `osoby`.nazwisko
                FROM `psy`
                JOIN `osoby` ON `psy`.id_osoby = `osoby`.id_osoby
                WHERE `osoby`.id_osoby LIKE ?;
            SQL;

            $stmt = mysqli_prepare($connection, $sql);

            mysqli_stmt_bind_param($stmt, "s", $wlasciciel);
            
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            echo "<table>";
            echo "<tr>";
            echo "<th>Płeć</th>";
            echo "<th>Rasa</th>";
            echo "<th>Wiek</th>";
            echo "<th>Zdobyte medale</th>";
            echo "<th>Właściciel</th>";
            echo "</tr>";
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['płeć']."</td>";
                echo "<td>".$row['rasa']."</td>";
                echo "<td>".$row['wiek']."</td>";
                echo "<td>".$row['medale']."</td>";
                echo "<td>".$row['imię']." ".$row['nazwisko']."</td>";
                echo "</tr>\n";
            }
            echo "</table>";
        }

        mysqli_close($connection);

        ?>
    </div> 
</body>
</html>
<?php



?>