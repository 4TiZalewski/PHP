<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
    <?php
        $r = $_GET['r'] ?? NULL;
        $g = $_GET['g'] ?? NULL;
        $b = $_GET['b'] ?? NULL;

        $h = $_GET['h'] ?? NULL;
        $c = $_GET['c'] ?? NULL;
        $l = $_GET['l'] ?? NULL;

        if (
            !is_null($r) &&
            !is_null($g) &&
            !is_null($b)
        ) {
            echo "body {
                    background-color: rgb($r, $g, $b);
                }\n";
            return;
        }

        if (
            !is_null($l) &&
            !is_null($c) &&
            !is_null($l)
        ) {
            echo "body {
                    background-color: lch($h%, $c, $l);
                }\n";
            return;
        }
    ?>
    </style>
</head>
<body>

<?php

// // Don't show warnings :)
// $a = $_GET["a"] ?? NULL;
// $b = $_GET["b"] ?? NULL;

// if (
//     is_null($a) || 
//     is_null($b) ||
//     !is_numeric($a) ||
//     !is_numeric($b) ||
//     $a <= 0 ||
//     $b <= 0
// ) {
//     echo "Podaj poprawne boki a i b prostokątna";
//     return;
// }

// $a = intval($a);
// $b = intval($b);

// $pole = $a * $b;
// $obwod = (2 * $a) + (2 * $b);
// $przekatna = sqrt(($a ** 2) + ($b ** 2));

// echo "Pole prostokąta wynosi: $pole cm\u{B2}";
// echo "<br>";
// echo "Obwód prostokąta wynosi: $obwod cm";
// echo "<br>";
// printf("Przekątna prostokąta wynosi: %.2f cm", $przekatna);

?>

</body>
</html>