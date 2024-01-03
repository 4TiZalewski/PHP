<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: black;
            color: white;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        fieldset {
            display: flex;
            flex-direction: column;
        }

        fieldset > div {
            text-align: center;
        }
    </style>
</head>
<body>
<?php

$tab = [];
$n = 51;
fibo($n, $tab);

// for ($i = count($tab) - 1; $i >= 0; $i--) {
//     echo $tab[$i]."<br>";
// }

$result = "";
foreach($tab as $element) {
    $result = $element."<br>".$result;
}

echo $result;

function fibo(int $n, array &$tab): void {
    $a = 1;
    $b = 1;

    $m = min($n, 2);
    for ($i = 0; $i < $m; $i++) {
        $tab[] = 1;
    }

    for ($i = 3; $i <= $n; $i++) {
        $c = $a + $b;
        $tab[] = $c;
        $a = $b;
        $b = $c;
    }
}

?>
</body>
</html>