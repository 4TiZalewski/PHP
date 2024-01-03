<?php
// $mode == -1 -> Access denied!
// $mode == 0 -> Show results
// $mode == 1 -> Wrong data
$mode = -1;
$a;
$b;

// Verification and logic
if (
    isset($_GET['session']) && 
    $_GET['session'] === 'qwertyui'
) {
    $mode = 1;
    if (
        isset($_GET['a']) &&
        isset($_GET['b'])
    ) {
        $a = $_GET['a'];
        $b = $_GET['b'];

        if (
            is_numeric($a) &&
            is_numeric($b) &&
            $a > 0 &&
            $b > 0
        ) {
            $mode = 0;
        }
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
            background-color: green;
            color: white;
            margin: 0;
        }

        .container {
            display: flex;
            height: 100vh;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <?php
        if ($mode === 1) {
            // Wrong data
            header("Location: error.php?erc=2");
        } else if ($mode === 0) {
            // Correct data
            $pole = $a * $b;
            $obw = 2 * $a + 2 * $b;

            echo "Pole: ".$pole."cm\u{B2}";
            echo "<br>";
            echo "Obwód: ".$obw."cm";
        } else {
            // Unathorized
            header("Location: error.php?erc=1");
        }
        ?>
    </div>
    
</body>
</html>