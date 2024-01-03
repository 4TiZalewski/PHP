<?php
$n = null;
$dzielniki = false;
$w_ile = null;

if (
    isset($_GET['n']) &&
    is_numeric($_GET['n']) &&
    $_GET['n'] > 0
) {
    $n = intval($_GET['n']);

    if (
        isset($_GET['dzielniki']) &&
        $_GET['dzielniki'] === "on"
    ) {
        $dzielniki = true;
    }

    if (
        isset($_GET['wielokrotnosci']) &&
        $_GET['wielokrotnosci'] === "on" &&
        isset($_GET['ile-w']) &&
        is_numeric($_GET['ile-w']) &&
        $_GET['ile-w'] > 0
    ) {
        $w_ile = intval($_GET['ile-w']);
    }
}

$ile = null;
// 0 -> not set
// 1 -> fibonacci
// 2 -> 2 powers
// 3 -> liczby pierwsze
$mode = 0;

if (
    isset($_GET['ile']) && 
    is_numeric($_GET['ile']) &&
    $_GET['ile'] > 0
) {
    $ile = $_GET['ile'];
    
    if (
        isset($_GET['type']) &&
        is_numeric($_GET['type']) &&
        $_GET['type'] > 0
    ) {
        $mode = intval($_GET['type']);
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
            background-color: black;
            color: white;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form {
            margin: 1rem;
        }

        fieldset {
            display: flex;
            flex-direction: column;
        }

        fieldset > div {
            text-align: center;
        }

        input[type="number"] {
            width: 5rem;
        }

        .answer {
            display: flex;
            flex-direction: column;
            margin: 1rem;
            border: 1px solid white;
            padding: 0.5rem;
        }

        h4 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="GET">
            <fieldset>
                <div>
                    <label for="n">
                        n
                        <input type="number" name="n" id="n" min="1" required>
                    </label>
                </div>
                <label for="dzielniki">
                    <input type="checkbox" name="dzielniki" id="dzielniki">
                    Dzielniki
                </label>
                <label for="wielokrotnosci">
                    <input type="checkbox" name="wielokrotnosci" id="wielokrotnosci">
                    Wielokrotnosci
                    <input type="number" name="ile-w" id="ile-w" min="1">
                </label>
                <div>
                    <input type="submit" value="Wypisz">
                </div>
            </fieldset>
        </form>

        <form method="GET">
            <fieldset>
                <div>
                    <label for="ile">
                        ile
                        <input type="number" name="ile" id="ile" min="1">
                    </label>
                </div>
                <label for="fib">
                    <input type="radio" name="type" id="fib" value="1">
                    Ciąg Fibonacciego
                </label>
                <label for="powers">
                    <input type="radio" name="type" id="powers" value="2">
                    Potęgi 2
                </label>
                <label for="firsts">
                    <input type="radio" name="type" id="firsts" value="3">
                    Liczby pierwsze
                </label>
                <div>
                    <input type="submit" value="Generuj">
                </div>
            </fieldset>
        </form>

        <?php
        if ($n != null) {
            echo "<div class=\"answer\">";
            if ($dzielniki) {
                echo "<h4>Dzielniki</h4>";
                $i = false;
                for ($d = 1; $d ** 2 <= $n; $d++) {
                    if ($n % $d == 0) {
                        if ($i) {
                            echo ", ";
                        }

                        echo "$d";
                        if ($d != $n / $d) {
                            echo ", ".($n / $d);
                        }
                    }

                    if (!$i) {
                        $i = true;
                    }
                }
            }

            if ($w_ile != null) {
                echo "<h4>Wielokrotności</h4>";
                $i = false;
                for ($w = 1; $w <= $w_ile; $w++) {
                    if ($i) {
                        echo ", ";
                    } else {
                        $i = true;
                    }

                    echo ($n * $w);
                }
            }
            echo "</div>";
        }
        ?>

        <?php
        if (
            $ile != null && 
            (
                $mode === 1 ||
                $mode === 2 ||
                $mode === 3
            )
        ) {
            echo "<div class=\"answer\">";
            if ($mode === 1) {
                echo "<h4>Ciag fibonacciego</h4>";
                $steps = 0;
                $secondary = 1;
                $first = 0;
                $i = false;
                while($steps < $ile) {
                    $result = $first + $secondary;

                    if ($i) {
                        echo ", ";
                    } else {
                        $i = true;
                    }

                    echo "$result";
                    if ($steps % 2 != 0) {
                        $first = $result;
                    } else {
                        $secondary = $result;
                    }
                    $steps++;
                }
            } else if ($mode === 2) {
                echo "<h4>Potęgi 2</h4>";
                $i2 = false;
                for ($i = 0; $i < $ile; $i++) {
                    if ($i2) {
                        echo ", ";
                    } else {
                        $i2 = true;
                    }

                    echo (2 ** $i);
                }
            } else if ($mode === 3) {
                echo "<h4>Liczby pierwsze</h4>";
                $numbers = 0;
                $number = 2;
                $i = false;

                while($numbers < $ile) {
                    $ilosc_dzielnikow = 0;

                    for ($d = 1; $d ** 2 <= $number; $d++) {
                        if ($number % $d == 0) {
                            $ilosc_dzielnikow++;
                            if ($d != $number / $d) {
                                $ilosc_dzielnikow++;
                            }
                        }
                        
                        if ($ilosc_dzielnikow > 2) {
                            break;
                        }
                    }

                    if ($ilosc_dzielnikow == 2) {
                        if ($i) {
                            echo ", ";
                        } else {
                            $i = true;
                        }

                        echo "$number";
                        $numbers++;
                    }

                    $number++;
                }
            }
            echo "</div>";
        }
        ?>

    </div>
</body>
</html>