<?php
session_start();

$visits = 0;
if (isset($_COOKIE['visits'])) {
    $visits = $_COOKIE['visits'];
}

if (
    !isset($_SESSION['visited'])
) {
    $visits += 1;
    setcookie('visits', $visits, time() + 3600 * 24 * 365);
    $_SESSION['visited'] = true;
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
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php

    echo "<p>Odwiedziłeś nas $visits razy</p>";

    ?>
    </div> 
</body>
</html>
<?php



?>