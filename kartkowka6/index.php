<?php

if (file_exists("../test-teacher-DEFINITLY-THERE-WILL-NOT-BE-DUPLICATE.php")) {
    $db_name = "5ti_gr1_filmy";
} else {
    $db_name = "5ti_g1_filmy";
}

$connect = mysqli_connect("127.0.0.1", "root", "", $db_name);

$litera = NULL;

if (
    isset($_GET['litera']) && trim($_GET['litera']) != ""
) {
    $litera = trim($_GET['litera']);
    if ($litera == "wszyscy") {
        $litera = NULL;
    }
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table, th, td {
            border: 1px solid white;
        }

        th, td {
            padding: 0.3rem;
        }

        tr:hover {
            background-color: gray;
        }

        table {
            border-collapse: collapse;
            margin-bottom: 0.5rem;
        }

        form {
            display: flex;
            align-items: center;
        }

        form > * {
            margin: 0.4rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <form>
            <p>Litera</p>
            <select name="litera" id="litera">
                <option value="wszyscy">wszyscy</option>
                <?php
                    $sql = "SELECT DISTINCT LEFT(klienci.nazwisko,1) AS litery FROM klienci ORDER BY litery";

                    $result = mysqli_query($connect, $sql);
                    while($row = mysqli_fetch_assoc($result)) {
                        $l = $row['litery'];
                        $selected = $litera == $l ? "selected" : "";
                        echo "<option value=\"$l\" $selected>$l</option>\n";
                    }
                ?>
            </select>
            <input type="submit" value="Pokaż">
        </form>
        <?php
        $sql = "
            SELECT CONCAT(klienci.Imie, \" \", klienci.Nazwisko) AS full_name, SUM(Cena_w_zl) AS wydatki
            FROM klienci
            JOIN wypozyczenia USING(Pesel)
            JOIN filmy USING(ID_filmu)
            WHERE klienci.Nazwisko LIKE ?
            GROUP BY klienci.Pesel
            ORDER BY wydatki DESC;
        ";

        if ($litera) {
            $litera = "$litera%";
        } else {
            $litera = "%";
        }

        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "s", $litera);
        mysqli_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) < 1) {
            echo "Brak wyników!";
        } else {
        ?>
        <table>
            <tr>
                <th>Klient</th>
                <th>Wydatki</th>
            </tr>
            <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>\n";
                    echo "<td>".($row['full_name'])."</td>\n";
                    echo "<td>".($row['wydatki'])."</td>\n";
                    echo "</tr>\n";
                }
            ?>
        </table>
        <?php } ?>
    </div> 
</body>
</html>
<?php

mysqli_close($connect);

?>