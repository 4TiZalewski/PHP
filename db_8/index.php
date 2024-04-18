<?php
    // Copyright (c) 4TiZalewski

    $osoba = NULL;

    if (isset($_GET['osoba'])) {
        $osoba = trim($_GET['osoba']);
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

        table, th, td {
            border: solid 1px white;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.5rem;
        }

        .money {
            text-align: right;
        }
        
        .hidden {
            border: none;
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
            <select name="osoba">
                <?php

                $imie = "";
                $nazwisko = "";

                $sql = <<<SQL
                    SELECT `osoby`.id_osoby, `osoby`.imie, `osoby`.nazwisko 
                    FROM `osoby`
                    GROUP BY `osoby`.id_osoby
                    ORDER BY `osoby`.nazwisko, `osoby`.imie ASC;
                SQL;

                $result = mysqli_query($connection, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id_osoby'];

                    if ($osoba === $row['id_osoby']) {
                        $imie = $row['imie'];
                        $nazwisko = $row['nazwisko'];
                        echo "<option selected value=\"$id\">";
                    } else {
                        echo "<option value=\"$id\">";
                    }

                    echo $row['imie']." ";
                    echo $row['nazwisko'];
                    echo "</option>\n";
                }

                ?>
            </select>
            <input type="submit" value="Wyślij">
        </form>

        <?php

        $razem = 0;

        echo $imie." ".$nazwisko."<br>";

        $sql = <<<SQL
            SELECT *
            FROM `konta`
            WHERE `konta`.id_osoby LIKE ?;
        SQL;

        $stmt = mysqli_prepare($connection, $sql);

        mysqli_stmt_bind_param($stmt, "s", $osoba);
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        echo "<table>";
        echo "<tr>";
        echo "<th>Bank</th>";
        echo "<th>Nr konta</th>";
        echo "<th>Stan konta</th>";
        echo "</tr>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['bank']."</td>";
            echo "<td>".$row['nr_konta']."</td>";
            echo "<td class=\"money\">".$row['dostepne_srodki']."</td>";
            echo "</tr>\n";

            $razem += intval($row['dostepne_srodki']);
        }
        echo "<tr>";
        echo "<td class=\"hidden\"></td>";
        echo "<td class=\"hidden money\">Razem:</td>";
        echo "<td class=\"money\">$razem</td>";
        echo "</tr>";
        echo "</table>";

        mysqli_close($connection);

        ?>
    </div> 
</body>
</html>
<?php



?>