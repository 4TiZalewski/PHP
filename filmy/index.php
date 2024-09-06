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
            min-height: 100vh;
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            align-items: flex-start;
        }

        table {
            margin: 1rem;
        }

        table, tr, th, td {
            border: 1px solid white;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.2rem;
        }

        tr:has(th) {
            background-color: grey;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            $conn = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_filmy");

            if (!$conn) {
                die("Failed to connect to error: ".mysqli_connect_error());
            }
        ?>
        <table>
            <tr>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Ilość wypożyczeń</th>
            </tr>
            <?php
                $sql = "
                    SELECT
                        klienci.Imie,
                        klienci.Nazwisko,
                        COUNT(*) AS ilosc_wypozyczen
                    FROM
                        klienci
                    JOIN wypozyczenia USING(Pesel)
                    GROUP BY
                        klienci.Pesel
                    ORDER BY
                        klienci.Nazwisko,
                        klienci.Imie;";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row['Imie']."</td>";
                    echo "<td>".$row['Nazwisko']."</td>";
                    echo "<td>".$row['ilosc_wypozyczen']."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <table>
            <tr>
                <th>Film</th>
                <th>Ilość wypożyczeń</th>
            </tr>
            <?php
                $sql = "
                    SELECT
                        filmy.tytul,
                        COUNT(*) AS ilosc_wypozyczen
                    FROM
                        filmy
                    JOIN wypozyczenia USING(ID_filmu)
                    GROUP BY
                        filmy.ID_filmu;";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row['tytul']."</td>";
                    echo "<td>".$row['ilosc_wypozyczen']."</td>";
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