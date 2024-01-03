<?php
// $mode == -1 -> Access denied!
// $mode == 0 -> Access granted!
$mode = -1;
if (
    isset($_GET['abc']) && 
    $_GET['abc'] === 'qwertyui'
) {
    $mode = 0;
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
            color: white;
            <?php
            if ($mode === 0) {
                echo "background-color: green;";
            } else {
                echo "background-color: red;";
            }
            ?>
        }

        .container {
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($mode === 0) {
            echo "OK!";
        } else {
            echo "Access denied!";
        }
        ?>
    </div>
</body>
</html>