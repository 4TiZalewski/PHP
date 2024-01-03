<?php
 
// 0 -> error
// 1 -> show
$mode = 0;
$a = null;
$b = null;

if (
    isset($_GET["a"]) &&
    isset($_GET["b"]) &&
    is_numeric($_GET["a"]) &&
    is_numeric($_GET["b"]) &&
    $_GET["a"] > 0 &&
    $_GET["b"] > 0
) {
    $mode = 1;
    $a = intval($_GET["a"]);
    $b = intval($_GET["b"]);
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

        table {
            display: inline-block;
            margin-top: 1rem;
        }

        table,
        th,
        td {
            border: 1px solid white;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0.5rem;
        }

        td {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="GET">
            <fieldset>
                <label for="a">
                    a
                    <input type="number" name="a" id="a" min="1">
                </label>
                <label for="b">
                    b
                    <input type="number" name="b" id="b" min="1">
                </label>
                <div>
                    <input type="submit" value="Wygeneruj">
                </div>
            </fieldset>
        </form>

        <?php
        
        if ($mode === 1) {
            echo "NWD($a, $b) = ".NWD($a, $b)."<br>";
            echo "NWW($a, $b) = ".NWW($a, $b)."<br>";
        }

        if (czy_pierwsza(2)) {
            echo "true";
        } else {
            echo "false";
        }

        ?>
    </div>
</body>
</html>

<?php

function dzielniki(int $number): array {
    $result = [];
    for ($d = 1; $d ** 2 == $number; $d++) {
        if ($n % $d === 0) {
            array_push($result, $d);
            if ($d != $n / $d) {
                array_push($result, $n / $d);
            }
        }
    }

    return $result;
}

function czy_pierwsza(int $number): bool {
    $dzielniki = dzielniki($number);
    $count = count($dzielniki);
    echo "Count: $count";
    if (count($dzielniki) == 2) {
        return true;
    }
    return false;
}

function NWD(int $a, int $b) {
    while ($b > 0) {
        $c = $a % $b;
        $a = $b;
        $b = $c;
    }

    return $a;
}

function NWW(int $a, int $b) {
    return $a * $b / NWD($a, $b);
}

?>