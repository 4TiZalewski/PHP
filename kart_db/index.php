<?php
// Copyright (c) 4TiZalewski

$address = "127.0.0.1";
$username = "root";
$password = "";
$db = "4ti_gr1_gry";
$connection = mysqli_connect($address, $username, $password, $db);

if (!$connection) {
    die("Błąd łączenia się do bazy: ".mysqli_connect_error());
}

$category = get_from_form("category", "%");
$sort = get_from_form("sort", "ASC");
$order_by = get_from_form("order_by", "count");

if (
    $sort !== "ASC" && 
    $sort !== "DESC"
) {
    $sort = "ASC";
}

if (
    $order_by !== "count" && 
    $order_by !== "average"
) {
    $order_by = "count";
}

?>
<!DOCTYPE html>
<html lang="pl">
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
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1rem;
        }

        table, tr, td, th {
            border: solid 1px white;
        }

        td, th {
            padding: 0.5rem;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="GET">
            <label for="category">
                Kategoria
                <select name="category" id="category">
                    <option value="%" <?php if (!option_selected($category)) { echo "selected"; } ?>>wszystkie</option>
                    <?php

                        $sql = <<<SQL
                            SELECT DISTINCT `gry`.kategoria
                            FROM `gry`;
                        SQL;

                        $result = mysqli_query($connection, $sql);
                        while($row = mysqli_fetch_assoc($result)) {
                            if ($category !== $row['kategoria']) {
                                echo "<option>";
                            } else {
                                echo "<option selected>";
                            }

                            echo $row['kategoria'];
                            echo "</option>";
                        }

                    ?>
                </select>
            </label>
            <input type="submit" value="Wyślij">
            <br>
            Sortuj
            <input type="radio" name="sort" value="ASC" <?php if ($sort === "ASC") { echo "checked"; } ?>> rosnąco
            <input type="radio" name="sort" value="DESC" <?php if ($sort === "DESC") { echo "checked"; } ?>> malejąco
            po
            <input type="radio" name="order_by" value="count" <?php if ($order_by === "count") { echo "checked"; } ?>> liczbie
            <input type="radio" name="order_by" value="average" <?php if ($order_by === "average") { echo "checked"; } ?>> średniej
            ocen
        </form>
    <?php

    echo "<h2>";
    if (!option_selected($category)) {
        echo "Wszystkie Kategorie";
    } else {
        echo first_letter_upper_case($category);
    }
    echo "</h2>";

    ?>
    <table>
        <tr>
            <th>Nazwa</th>
            <th>Liczba ocen</th>
            <th>Średnia ocen</th>
        </tr>
        <?php

            $sql = <<<SQL
                SELECT `gry`.nazwa, COUNT(`oceny`.ocena) AS count, AVG(`oceny`.ocena) AS average
                FROM `gry`
                JOIN `oceny` ON `gry`.id_gry = `oceny`.id_gry
                WHERE `gry`.kategoria LIKE ?
                GROUP BY `oceny`.id_gry
                ORDER BY $order_by $sort
            SQL;

            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "s", $category);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['nazwa']."</td>";
                echo "<td>".$row['count']."</td>";
                echo "<td>";
                printf("%.2f", $row['average']);
                echo "</td>";
                echo "</tr>";
            }
        ?>
    </table>
    </div> 
</body>
</html>
<?php

mysqli_close($connection);

function option_selected(string $value): bool {
    return $value !== "%";
}

function get_from_form(string $get_value, string $default): string {
    if (
        isset($_GET[$get_value]) && 
        trim($_GET[$get_value]) !== ""
    ) {
        return trim($_GET[$get_value]);
    }

    return $default;
}

function first_letter_upper_case(string $value): string {
    $value = trim($value);
    $value[0] = strtoupper($value[0]);

    if ($value[-1] === 'a') {
        $value[-1] = 'e';
    }

    return $value;
}

?>