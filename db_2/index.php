<?php
    // Copyright (c) 4TiZalewski
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

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $db = "4ti_gr1_psy";

    $connection = mysqli_connect($servername, $username, $password, $db);

    if (!$connection) {
        die("Połączenie z bazą danych nie udało się: ".mysqli_connect_error());
    }

    echo "Połączenie udane<br><br>";
    $sql = "SELECT * FROM `osoby`;";
    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['imię']." ".$row['nazwisko']." (".$row['id_osoby'].") tel. ".$row['nr_tel']."<br>";
        }
    } else {
        echo "Brak wyników";
    }

    mysqli_close($connection);

    ?>
    </div> 
</body>
</html>
<?php



?>