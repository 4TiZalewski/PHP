<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
            // 1 -> arytmetyczny
            // 2 -> geometryczny
            $ciag_type = 0;
            $a1 = null;
            $r = null;
            $n = null;

            if (
                isset($_GET["ciag_type"]) &&
                (
                    $_GET["ciag_type"] === "1" ||
                    $_GET["ciag_type"] === "2"
                ) &&
                isset($_GET["a1"]) &&
                is_numeric($_GET["a1"]) &&
                isset($_GET["r"]) &&
                is_numeric($_GET["r"]) &&
                isset($_GET["n"]) &&
                is_numeric($_GET["n"]) &&
                $_GET["n"] > 0
            ) {
                $ciag_type = intval($_GET["ciag_type"]);
                $a1 = doubleval($_GET["a1"]);
                $r = doubleval($_GET["r"]);
                $n = intval($_GET["n"]);
            } else {
        ?>
        <form method="GET">
            <fieldset>
                <legend>Ciag</legend>
                <label for="ciag_type">
                    Typ
                    <select name="ciag_type" id="ciag_type">
                        <option value="0" hidden selected></option>
                        <option value="1">arytmentyczny</option>
                        <option value="2">geometryczny</option>
                    </select>
                </label>
                <label for="a1">
                    <div>a<sub>1</sub></div>
                    <input type="text" name="a1" id="a1" required>
                </label>
                <label for="r">
                    r/q
                    <input type="text" name="r" id="r" required>
                </label>
                <label for="n">
                    n
                    <input type="number" min="1" name="n" id="n" required>
                </label>
                <input type="submit" value="Generuj">
            </fieldset>
        </form>
        <?php
                if (
                    isset($_GET["ciag_type"]) &&
                    $_GET["ciag_type"] === "0"
                ) {
                    echo "Proszę wybrać typ ciągu";
                }
                die();
            }

            echo "<table>\n";
            echo "<tr>\n<th>n</th>\n<th>a<sub>n</sub></th>\n</tr>\n";
            $last = $a1;
            if ($ciag_type === 1) {
                for ($i = 1; $i <= $n; $i++) {
                    echo "<tr>\n";
                    echo "<td>$i</td>\n";
                    echo "<td>$last</td>\n";
                    echo "</tr>\n";
                    $last += $r;
                }
            } else {
                for ($i = 1; $i <= $n; $i++) {
                    echo "<tr>\n";
                    echo "<td>$i</td>\n";
                    echo "<td>$last</td>\n";
                    echo "</tr>\n";
                    $last *= $r;
                }
            }
            echo "</table>\n";
        ?>
    </div>
</body>
</html>