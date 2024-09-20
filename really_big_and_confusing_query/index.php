<?php

$connection = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_perfumy");

if (!$connection) {
    echo "Failed to connect to DB: ".mysqli_connect_error();
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table, tr, th, td {
            border: 1px solid white;
        }

        table {
            margin: 1rem;
            border-collapse: collapse;
        }

        th {
            width: 10rem;
        }

        th, td {
            padding: 0.3rem;
        }
    </style>
</head>
<body>
    <div class="container">
    <table>
        <tr>
            <th>Rodzina zapachów</th>
            <th>Cena</th>
            <th>Nazwa perfumu</th>
            <th>Składniki</th>
        </tr>
        <?php
            $sql = "
                SELECT
                    perfumy.rodzina_zapachow,
                    perfumy.id_perfum,
                    perfumy.cena,
                    perfumy.nazwa_p
                FROM
                    perfumy
                WHERE
                    (
                        perfumy.rodzina_zapachow,
                        perfumy.cena
                    ) IN(
                    SELECT
                        perfumy.rodzina_zapachow,
                        MIN(perfumy.cena)
                    FROM
                        perfumy
                    GROUP BY
                        perfumy.rodzina_zapachow
                )
                ORDER BY
                    perfumy.rodzina_zapachow;
            ";

            $result = mysqli_query($connection, $sql);

            while($row = mysqli_fetch_assoc($result)) {
                $sql = "
                    SELECT sklad.nazwa_skladnika
                    FROM sklad
                    WHERE sklad.id_perfum = '".($row['id_perfum'])."';
                ";

                $result2 = mysqli_query($connection, $sql);

                echo "<tr>";
                echo "<td>".($row['rodzina_zapachow'])."</td>";
                echo "<td>".($row['cena'])."</td>";
                echo "<td>".($row['nazwa_p'])."</td>";

                echo "<td>";
                $skladniki = "";
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $skladniki .= $row2['nazwa_skladnika'].", ";
                }
                $skladniki = substr($skladniki, 0, strlen($skladniki) - 2);
                echo $skladniki;
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

?>