<?php
 
$reference_example = false;
$closure_example = false;
$closure_return_example = false;
$nww_arrow_example = false;
$recurrency_example = true;

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
    </style>
</head>
<body>
    <div class="container">
        <?php
            if ($reference_example) {
                $x = 5;
                $y = 7; 
                echo "x = $x, y = $y<br>";

                function swap(int &$x, int &$y): void {
                    $temp = $y;
                    $y = $x;
                    $x = $temp;
                }

                swap($x, $y);
                echo "x = $x, y = $y<br>";
            }

            if ($closure_example) {
                $normal_function = false;
                $arrow_function = true;

                function test(int $n, Closure $f): int {
                    return $f($n);
                }

                if ($normal_function) {
                    $kwadrat = function (int $n): int {
                        return $n ** 2;
                    };

                    echo test(5, $kwadrat);
                }

                if ($arrow_function) {
                    echo test(5, fn(int $n): int => $n ** 2);
                }
            }

            if ($closure_return_example) {
                function test(int $a): Closure {
                    return fn($b) => $a * $b;
                }

                echo test(5)(5);
            }

            if ($nww_arrow_example) {
                function nwd(int $a, int $b): int {
                    while ($b > 0) {
                        $c = $a % $b;
                        $a = $b;
                        $b = $c;
                    }
                    
                    return $a;
                }

                $nww = fn(int $a, int $b): int => $a * $b / nwd($a, $b);

                echo $nww(13, 6);
            }

            if ($recurrency_example) {
                function silnia(int $n): int {
                    return $n ? silnia($n - 1) * $n : 1;
                }

                echo silnia(7);
                echo "<br>";

                function nwd(int $a, int $b): int {
                    return $b ? nwd($b, $a % $b) : $a;
                }

                echo nwd(16, 20);
                echo "<br>";

                function f(int $n): int {
                    return $n < 3 ? 1 : f($n - 1) + f($n - 2);
                }

                echo f(10);
                echo "<br>";

                function fibo(int $n): float {
                    $a = 1;
                    $b = 1;
                    for ($i = 3; $i <= $n; $i++) {
                        $c = $a + $b;
                        $a = $b;
                        $b = $c;
                    }

                    return $b;
                }

                echo fibo(420);

                // function hanoi(int $n, string $from,): void {
                //     if ($n == 0) return;

                //     hanoi(n - 1)
                // }
            }
        ?>
    </div>
</body>
</html>