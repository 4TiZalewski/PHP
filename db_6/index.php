<?php
    // Copyright (c) 4TiZalewski

    $mode = 0;
    $min = 0;
    $max = 200;
    $order = 0;

    if (
        isset($_GET['order'])
    ) {
        $order_txt = $_GET['order'];
        if ($order_txt === "desc") {
            $order = 1;
        }
    }

    if (
        isset($_GET['min-age']) &&
        is_numeric($_GET['min-age'])
    ) {
        $min = $_GET['min-age'];
    }

    if (
        isset($_GET['max-age']) &&
        is_numeric($_GET['max-age'])
    ) {
        $max = $_GET['max-age'];
    }

    if ($min > $max) {
        $mode = 1;
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
        <form method="GET">
            <div>Wiek od <input type="number" min="0" max="200" name="min-age" value="<?php echo "$min"; ?>" required> do <input type="number" min="0" max="200" value="<?php echo "$max"; ?>" name="max-age"></div>
            <div>
                <label for="asc">
                    <input type="radio" value="asc" name="order" id="asc" <?php if ($order === 0) { echo "checked"; } ?>>
                    rosnąco
                </label>
                <label for="desc">
                    <input type="radio" value="desc" name="order" id="desc" <?php if ($order === 1) { echo "checked"; } ?>>
                    malejąco
                </label>
            </div>
            <input type="submit" value="Wyślij">
        </form>
    <?php

    if ($mode === 0) {
        $address = "127.0.0.1";
        $username = "root";
        $password = "";
        $db = "4ti_gr1_gry";
        $connection = mysqli_connect($address, $username, $password, $db);

        if (!$connection) {
            die("Nie udało się połączyć z bazą danych: ".mysqli_connect_error());
        }

        $sql = <<<SQL
            SELECT `gracze`.imie, `gracze`.nazwisko, `gracze`.wiek
            FROM `gracze`
            WHERE `gracze`.wiek BETWEEN ? AND ?
            ORDER BY `gracze`.wiek 
        SQL;

        if ($order === 1) {
            $sql .= "DESC;";
        } else {
            $sql .= "ASC;";
        }

        $stmt = mysqli_prepare($connection, $sql);

        mysqli_stmt_bind_param($stmt, "ii", $min, $max);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $num_rows = mysqli_num_rows($result);
        echo "Znaleziono $num_rows graczy";

        echo "<ol>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>";
            echo $row['imie']." ";
            echo $row['nazwisko']." ";
            echo $row['wiek']." lat";
            echo "</li>";
        }
        echo "</ol>";

        mysqli_close($connection);
    } else if ($mode === 1) {
        echo "Niepoprawne dane!";
    }

    ?>
    </div> 
</body>
</html>
<?php



?>