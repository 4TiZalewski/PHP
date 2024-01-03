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

        table, th, td {
            border: 1px solid white;
            border-collapse: collapse;
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
// $osoby = [];
// for ($i=0; $i < (sizeof($_GET) - 1) / 2; $i++) { 
//     $imie = $_GET["imie$i"];
//     $wiek = $_GET["wiek$i"];

//     if (!is_numeric($wiek) || intval($wiek) < 0) {
//         continue;
//     }

//     $osoby[$imie] = $wiek;
// }

$osoby = [];
for ($i=0; $i < (sizeof($_GET) - 1) / 2; $i++) { 
    $imie = $_GET["imie$i"];
    $wiek = $_GET["wiek$i"];

    if (!is_numeric($wiek) || intval($wiek) < 0) {
        continue;
    }

    $osoby[] = [$imie, $wiek];
}

echo "<ol>";
// $type = $_GET["sort"];
// $type($osoby);

// foreach ($osoby as $imie => $wiek) {
//     echo "<li>$imie ma $wiek lat.</li>\n";
// }

$type = $_GET["sort"];
if ($type === "ksort") {
    sort($osoby);
} else if ($type === "krsort") {
    rsort($osoby);
} else if ($type === "asort") {
    usort($osoby, "wiek_sort_rosnaco");
} else if ($type === "arsort") {
    usort($osoby, "wiek_sort_malejaco");
}

function wiek_sort_rosnaco($a, $b) {
    return $a[1] - $b[1];
}

function wiek_sort_malejaco($a, $b) {
    return $b[1] - $a[1];
}

foreach ($osoby as $table) {
    $imie = $table[0];
    $wiek = $table[1];
    echo "<li>$imie ma $wiek lat.</li>\n";
}
echo "</ol>";

?> 
</body>
</html>