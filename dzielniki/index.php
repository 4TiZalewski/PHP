<?php

// 0 -> error
// 1 -> show table
$mode = 0;
$n_target = null;

if (
    isset($_GET["n"]) &&
    is_numeric($_GET["n"]) &&
    $_GET["n"] > 0
) {
    $mode = 1;
    $n_target = $_GET["n"];
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
            align-items: center;
        }

        fieldset {
            display: flex;
            flex-direction: column;
        }

        fieldset > div {
            text-align: center;
        }

        table {
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
                <label for="n">
                    n
                    <input type="number" name="n" id="n" min="2">
                </label>
                <div>
                    <input type="submit" value="Wygeneruj">
                </div>
            </fieldset>
        </form>

        <table>
            <?php
                if ($mode === 1) {
                    echo "<tr><th>n</th><th>Dzielniki</th><th>Czy pierwsza?</th><th>Czynniki pierwsze</th></tr>";

                    for ($n = 2; $n <= $n_target; $n++) {
                        echo "<tr><th>$n</th><td>";

                        $ilosc_dzielnikow = 0;
                        $result = "";
                        for ($d = 1; $d <= $n; $d++) {
                            if ($n % $d === 0) {
                                $ilosc_dzielnikow += 1;
                                $result .= "$d, ";
                            }
                        }
                        // Remove last 2 characters from result
                        $result = substr($result, 0, -2);

                        echo "$result</td><td>".($ilosc_dzielnikow === 2 ? "TAK" : "")."</td><td>";

                        $m = $n;
                        $d = 2;
                        $result = "";
                        while($d ** 2 <= $m) {
                            if ($m % $d === 0) {
                                $result .= "$d, ";
                                $m /= $d;
                            } else {
                                $d += 1;
                            }
                        }
                        $result .= $m;

                        echo "$result</td></tr>";
                    }
                }
            ?>
        </table>
    </div>
</body>
</html>