<?php
// error codes:
//      0 -> OK
//      1 -> Login Failed
//      2 -> Wrong Data
$error_code = 0;

if (isset($_GET["erc"])) {
    $error_code = intval($_GET["erc"]);
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
            background-color: red;
            color: white;
        }

        .container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            if ($error_code === 1) {
                echo "Brak dostępu";
            } else if ($error_code === 2) {
                echo "Złe dane";
            } else {
                // Return to login page
                header("Location: index.php");
            }
        ?>
    </div>
</body>
</html>