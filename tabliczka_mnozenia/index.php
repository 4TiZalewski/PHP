<?php

// 0 -> error
// 1 -> show table
$mode = 0;
$x_target = null;
$y_target = null;

if (
    isset($_GET["x"]) &&
    isset($_GET["y"]) &&
    is_numeric($_GET["x"]) &&
    is_numeric($_GET["y"]) &&
    $_GET["x"] > 0 &&
    $_GET["y"] > 0
) {
    $mode = 1;
    $x_target = $_GET["x"];
    $y_target = $_GET["y"];
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
                <label for="x">
                    x
                    <input type="number" name="x" id="x" min="1">
                </label>
                <label for="y">
                    y
                    <input type="number" name="y" id="y" min="1">
                </label>
                <div>
                    <input type="submit" value="Wygeneruj">
                </div>
            </fieldset>
        </form>

        <table>
            <?php
                if ($mode === 1) {
                    echo "<tr>";
                    echo "<th></th>";
                    for ($x = 1; $x <= $x_target; $x++) {
                        echo "<th>$x</th>";
                    }
                    echo "</tr>";

                    for ($y = 1; $y <= $y_target; $y++) {
                        echo "<tr>";
                        echo "<th>$y</th>";

                        for ($x = 1; $x <= $x_target; $x++) {
                            echo "<td>".($x * $y)."</td>";
                        }

                        echo "</tr>";
                    }
                }
            ?>
        </table>
    </div>
</body>
</html>