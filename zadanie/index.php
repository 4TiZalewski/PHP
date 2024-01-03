<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <?php
        if (
            isset($_GET['a']) &&
            isset($_GET['b'])
        ) {
            $a = $_GET['a'];
            $b = $_GET['b'];

            echo "$a + $b = ".($a + $b);
            echo "<br>";
            echo "$a - $b = ".($a - $b);
            echo "<br>";
            echo "$a \u{D7} $b = ".($a * $b);
            echo "<br>";

            // Can't divide by zero
            $division = $b != 0 ? $a / $b : "Error";

            echo "$a \u{F7} $b = $division";
            echo "<br>";
            echo "$a<sup>$b</sup> = ".($a ** $b);
        } else {
    ?>
        <form>
            <fieldset>
                <label for="a">
                    a
                    <input type="number" name="a" id="a">
                </label>
                <br>
                <label for="b">
                    b
                    <input type="number" name="b" id="b">
                </label>
                <br>
                <input type="submit" value="Oblicz">
            </fieldset> 
        </form>
    <?php
        }
    ?>
</body>
</html>