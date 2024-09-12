<?php

$connection = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_filmy");

$mode = 0;
$selected_year = NULL;
$selected_month = NULL;

if (
    ISSET($_GET['month']) && is_numeric(trim($_GET['month'])) && intval(trim($_GET['month'])) > 0 && intval(trim($_GET['month'])) < 13 &&
    ISSET($_GET['year']) && is_numeric(trim($_GET['year']))
) {
    $mode = 1;
    $selected_year = intval(trim($_GET['year']));
    $selected_month = intval(trim($_GET['month']));
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

        form {
            margin-top: 2rem;
        }

        table, tr, td, th {
            border: 1px solid white;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="container">
        <form>
            <select name="month" id="month">
                <option value="1">Styczeń</option>
                <option value="2">Luty</option>
                <option value="3">Marzec</option>
                <option value="4">Kwiecień</option>
                <option value="5">Maj</option>
                <option value="6">Czerwiec</option>
                <option value="7">Lipiec</option>
                <option value="8">Sierpień</option>
                <option value="9">Wrzesień</option>
                <option value="10">Październik</option>
                <option value="11">Listopad</option>
                <option value="12">Grudzień</option>
            </select>
            <select name="year" id="year">
                <?php
                    $sql = "SELECT DISTINCT YEAR(wypozyczenia.Data_wyp) AS year FROM wypozyczenia;";
                    $result = mysqli_query($connection, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $year = $row['year'];
                        echo "<option value=\"$year\">$year</option>\n";
                    }
                ?>
            </select>
            <input type="submit" value="Wybierz">
        </form>
        <?php if ($mode === 1) {
            $sql = "
                SELECT filmy.Tytul, wypozyczenia.Data_wyp, klienci.Imie, klienci.Nazwisko
                FROM wypozyczenia
                JOIN filmy USING(ID_filmu)
                JOIN klienci USING(Pesel)
                WHERE YEAR(wypozyczenia.Data_wyp) = ? AND MONTH(wypozyczenia.Data_wyp) = ?;
            ";

            $stmt = mysqli_prepare($connection, $sql);
        
            mysqli_stmt_bind_param($stmt, "ii", $selected_year, $selected_month);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <tr>
                <th>Tytuł</th>
                <th>Data</th>
                <th>Imię</th>
                <th>Nazwisko</th>
            </tr>
            <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".($row['Tytul'])."</td>";
                    echo "<td>".($row['Data_wyp'])."</td>";
                    echo "<td>".($row['Imie'])."</td>";
                    echo "<td>".($row['Nazwisko'])."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <?php 
            } else {
                echo "Brak wypożyczeń!";
            } 
        } ?>
    </div> 
</body>
</html>
<?php

mysqli_close($connection);

?>