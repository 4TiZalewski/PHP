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
    <form action="osoby.php" class="default-form">
        <table>
        <tr><th>Imię</th><th>Wiek</th></tr>
        <?php

        $imiona = ["Franek", "Basia", "Grzegorz", "Dawid", "AmongUs"];
        for ($i=0; $i < 10; $i++) { 
            $imie = $imiona[rand(0, count($imiona) - 1)];
            echo "<tr><td><input type=\"text\" name=\"imie$i\" value=\"$imie\"></td><td><input type=\"text\" name=\"wiek$i\" value=\"".rand(18,80)."\"</td></tr>\n";
        }

        ?>
        </table>
        <fieldset>
            <legend>Sortowanie</legend>
            <label for="ir">
                <input type="radio" name="sort" id="ir" value="ksort" checked>
                imiona rosnąco
            </label><br>
            <label for="im">
                <input type="radio" name="sort" id="im" value="krsort">
                imiona malejąco
            </label><br>
            <label for="wr">
                <input type="radio" name="sort" id="wr" value="asort">
                wiek rosnąco
            </label><br>
            <label for="wm">
                <input type="radio" name="sort" id="wm" value="arsort">
                wiek malejąco
            </label>
        </fieldset>
        <input type="submit" value="Wyślij">
    </form>
</body>
</html>