<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            <?php
                // $mode == -1 -> Pierwszy raz
                // $mode == 0 -> Poprawny trójkąt
                // $mode == 1 -> Niepoprawny trójkąt
                // $mode == 2 -> Złe dane
                $mode = -1;
                $a;
                $b;
                $c;

                if (isset($_GET['a']) &&
                    isset($_GET['b']) &&
                    isset($_GET['c'])
                ) {
                    $a = $_GET['a'];
                    $b = $_GET['b'];
                    $c = $_GET['c'];

                    if (
                        is_numeric($a) &&
                        is_numeric($b) &&
                        is_numeric($c) &&
                        $a > 0 &&
                        $b > 0 &&
                        $c > 0
                    ) {
                        if (
                            $a + $b > $c && 
                            $b + $c > $a && 
                            $a + $c > $b
                        ) {
                            $mode = 0;
                        } else {
                            $mode = 1;
                        }
                    } else {
                        $mode = 2;
                    }
                }

                if ($mode === 0) {
                    echo "background-color: green;";
                } else if ($mode === 1) {
                    echo "background-color: orange;";
                } else if ($mode === 2) {
                    echo "background-color: red;";
                } else {
                    echo "background-color: black;";
                }
            ?>
            color: white;
            margin: 0;
        }

        fieldset {
            display: flex;
            flex-direction: column;
        }

        fieldset > * {
            margin: 0.2rem;
        }
         
        fieldset > div {
            display: flex;
            justify-content: center;
        }

        .container {
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            if ($mode === 0) {
                $obwod = $a + $b + $c;
                $p = $obwod / 2;
                $pole = sqrt($p * ($p - $a) * ($p - $b) * ($p - $c));

                echo "<h3>Trójkąt</h3>";
                echo "Obwód = $obwod cm";
                echo "<br>";
                printf("Pole = %.2f cm\u{B2}", $pole);
            } else if ($mode === 1) {
                echo "To nie jest to trojkąt";
            } else if ($mode === 2) {
                echo "Złe dane!";
            } else {
        ?>
        <form>
            <fieldset>
                <label for="a">
                    a
                    <input type="text" name="a" id="a">
                    cm
                </label>
                <label for="b">
                    b
                    <input type="text" name="b" id="b">
                    cm
                </label>
                <label for="c">
                    c
                    <input type="text" name="c" id="c">
                    cm
                </label>
                <div>
                    <input type="submit" value="Oblicz">
                </div>
            </fieldset>
        </form>
        <?php
            }
        ?>
    </div>
</body>
</html>