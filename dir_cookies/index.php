<?php

$files_path = "plki";
$sortowanie = 0;

if (
    isset($_GET['sortowanie'])
) {
    $sortowanie = intval($_GET['sortowanie']);
    setcookie("sortowanie", $sortowanie);
} else if (
    isset($_COOKIE['sortowanie'])
) {
    $sortowanie = intval($_COOKIE['sortowanie']);
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
            margin: 0;
            background-color: black;
            color: white;
        }

        .container {
            margin: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        th, td {
            padding: 0.5rem;
        }

        table, tr, th, td {
            border: 1px solid white;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="container">
        <form>
            <select name="sortowanie">
                <option value="0" <?php if ($sortowanie == 0) { echo "selected"; } ?>>Rosnąco wg nazwy</option>
                <option value="1" <?php if ($sortowanie == 1) { echo "selected"; } ?>>Malejąco wg nazwy</option>
                <option value="2" <?php if ($sortowanie == 2) { echo "selected"; } ?>>Rosnąco wg rozmiaru</option>
                <option value="3" <?php if ($sortowanie == 3) { echo "selected"; } ?>>Malejąco wg rozmiaru</option>
            </select>
            <input type="submit" value="Sortuj">
        </form>
        <table>
            <tr>
                <th>Nazwa pliku</th>
                <th>Rozmiar</th>
            </tr>
        <?php

        $sorting_algorythms = [
            function(array &$arg): bool { return ksort($arg); },
            function(array &$arg): bool { return krsort($arg); },
            function(array &$arg): bool { return asort($arg); },
            function(array &$arg): bool { return arsort($arg); },
        ];

        $files = scandir($files_path);
        $tab = [];
        foreach($files as $file_path) {
            if ($file_path == "." || $file_path == "..") {
                continue;
            }

            $tab[$file_path] = filesize("$files_path/$file_path");
        }

        $sorting_algorythms[$sortowanie]($tab);

        foreach($tab as $plik => $rozmiar) {
            echo "<tr>";
            echo "<td>$plik</td>";
            echo "<td>$rozmiar B</td>";
            echo "</tr>\n";
        }

        ?>
        </table>
    </div> 
</body>
</html>
<?php



?>