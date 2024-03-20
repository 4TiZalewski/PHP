<?php

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
            justify-content: center;
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

    // $connection = mysqli_connect($servername, $username, $password, $db);

    // if (!$connection) {
    //     die("Połączenie z bazą danych nie udało się: ".mysqli_connect_error());
    // } else {
    //     echo "Połączenie udane";
    // }

    // mysqli_close($connection);

    $connection = new mysqli($servername, $username, $password, $db);

    if ($connection->connect_error) {
        die("Połączenie z bazą danych nie udało się: ".$connection->connect_error);
    } else {
        echo "Połączenie udane";
    }

    $connection->close();

    ?>
    </div> 
</body>
</html>
<?php



?>