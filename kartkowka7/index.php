<?php

require 'lib.php';

$connection = get_connection();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mecze</title>
    <style>
        body {
            margin: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background-color: black;
            color: white;
        }

        table, th, td {
            border: 1px solid white;
        }

        table {
            border-collapse: collapse;
        }

        th, td {
            padding: 0.4rem;
        }

        td {
            text-align: center;
        }

        a {
            padding: 0.3rem;
            background-color: wheat;
            color: black;
            text-decoration: none;
            border-radius: 0.2rem;
        }

        p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Drużyny</h1>
        <table>
            <tr>
                <th>Nazwa drużyny</th>
                <th>Miasto</th>
                <th></th>
            </tr>
            <?php
                $sql = "SELECT druzyny.Id_druzyny, druzyny.Nazwa, druzyny.Miasto FROM druzyny ORDER BY druzyny.Nazwa";
                $result = mysqli_query($connection, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row['Nazwa']."</td>";
                    echo "<td>".$row['Miasto']."</td>";
                    echo "<td><a href=\"modify.php?druzyna=".$row['Id_druzyny']."\">Modyfikuj</a></td>";
                    echo "<td><a href=\"mecze.php?druzyna=".$row['Id_druzyny']."\">Mecze</a></td>";
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