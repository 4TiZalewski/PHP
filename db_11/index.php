<?php

$conn = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_filmy");

$now = date_create();
$now = date_format($now, "Y-m-d");

if (
    isset($_POST['movie']) && 
    trim($_POST['movie']) != "" && 
    isset($_POST['client']) && 
    trim($_POST['client']) != "" &&
    isset($_POST['date']) &&
    trim($_POST['date']) != ""
) {
    $movie_id = trim($_POST['movie']);
    $client = trim($_POST['client']);
    $date = trim($_POST['date']);
    $verified = date_create_from_format("Y-m-d", $date);

    if ($verified) {
        $verified_format = date_format($verified, "Y-m-d");
        $sql = "INSERT INTO wyporzyczenia (Data_wyp, ID_filmu, Pesel) VALUES (?, ?, ?);";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $verified_format, $movie_id, $client);
        mysqli_stmt_execute($stmt);

        header("Location: index.php");
        die();
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
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
        }

        table, th, td {
            border: 1px solid white;
        }

        form {
            margin: 1rem;
        }

        table {
            margin: 1rem;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.3rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST">
            <label for="movie">
                Film
                <select name="movie" id="movie">
                    <?php
                        $sql = "SELECT filmy.ID_filmu, filmy.Tytul FROM filmy ORDER BY filmy.Tytul;";

                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)) {
                            $movie_id = $row['ID_filmu'];
                            $tytul = $row['Tytul'];
                            echo "<option value=\"$movie_id\">$tytul</option>";
                        }
                    ?>
                </select>
            </label>
            <label for="client">
                Klient
                <select name="client" id="client">
                    <?php
                        $sql = "SELECT klienci.Pesel, (CONCAT(klienci.Imie, \" \", klienci.Nazwisko)) AS full_name FROM klienci ORDER BY klienci.Nazwisko, klienci.Imie;";

                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)) {
                            $pesel = $row['Pesel'];
                            $client_name = $row['full_name'];
                            echo "<option value=\"$pesel\">$client_name</option>";
                        }
                    ?>
                </select>
            </label>
            <input type="date" value="<?php echo "$now"; ?>" name="date">
            <input type="submit" value="Dodaj">
        </form>
        <table>
            <tr>
                <th>Data</th>
                <th>Klient</th>
                <th>Tytul</th>
            </tr>
            <?php
                $sql = "SELECT wyporzyczenia.Data_wyp, CONCAT(klienci.Imie, \" \", klienci.Nazwisko) AS full_name, filmy.Tytul
                    FROM wyporzyczenia
                    JOIN klienci USING(Pesel)
                    JOIN filmy USING(ID_filmu)
                    ORDER BY wyporzyczenia.Data_wyp DESC;";
                
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".($row['Data_wyp'])."</td>";
                    echo "<td>".($row['full_name'])."</td>";
                    echo "<td>".($row['Tytul'])."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div> 
</body>
</html>
<?php

mysqli_close($conn);

?>