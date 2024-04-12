<?php
    // Copyright (c) 4TiZalewski

    $rasa = NULL;

    if (isset($_GET['rasa'])) {
        $rasa = trim($_GET['rasa']);
        if ($rasa === "%") {
            $rasa = NULL;
        }
    }

    $wlasciciel = NULL;

    if (isset($_GET['wlasciciel'])) {
        $wlasciciel = trim($_GET['wlasciciel']);
        if ($wlasciciel === "%") {
            $wlasciciel = NULL;
        }
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
            <select name="rasa">
                <option <?php if ($rasa) { echo "selected"; } ?> value="%">wszystkie rasy</option>
                <?php

                $sql = <<<SQL
                    SELECT DISTINCT `psy`.rasa 
                    FROM `psy`
                    ORDER BY `psy`.rasa ASC;
                SQL;

                $result = mysqli_query($connection, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    if ($rasa === $row['rasa']) {
                        echo "<option selected>";
                    } else {
                        echo "<option>";
                    }

                    echo $row['rasa'];
                    echo "</option>\n";
                }

                ?>
            </select>
            <select name="wlasciciel">
                <option <?php if ($wlasciciel) { echo "selected"; } ?> value="%">wszyscy</option>
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

        $sql = <<<SQL
            SELECT `psy`.rasa, `psy`.wiek, `psy`.płeć, `psy`.medale, `osoby`.imię, `osoby`.nazwisko
            FROM `psy`
            JOIN `osoby` ON `psy`.id_osoby = `osoby`.id_osoby
            WHERE `psy`.rasa LIKE ? AND `osoby`.id_osoby LIKE ?;
        SQL;

        $stmt = mysqli_prepare($connection, $sql);

        if (!$wlasciciel) {
            $wlasciciel = "%";
        }

        if (!$rasa) {
            $rasa = "%";
        }

        mysqli_stmt_bind_param($stmt, "ss", $rasa, $wlasciciel);
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        echo "<ol>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<li>";
            echo $row['płeć']." ";
            echo "rasy ".$row['rasa'].", ";
            echo "wiek ".$row['wiek']." lat, ";
            echo $row['medale']." medale. ";
            echo "Właściciel: ".$row['imię']." ".$row['nazwisko'].".";
            echo "</li>\n";
        }
        echo "</ol>";

        mysqli_close($connection);

        ?>
    </div> 
</body>
</html>
<?php



?>