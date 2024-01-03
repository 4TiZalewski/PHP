<?php

$mode = 0;

if (
    true
) {
    $mode = 1;
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
    </style>
</head>
<body>
    <div class="container">
        <form>
            <select name="owoc" id="owoc">
<?php
    $owoce = file("owoce.txt");
    foreach($owoce as $numer => $owoc) {
        echo "\t\t\t\t<option value=\"$numer\">".trim($owoc)."</option>\n";
    }
?>
            </select>
            <input type="submit" value="Submit">
        </form>
    <?php

    if ($mode === 1) {
        // echo readfile("dane.txt")."<br>";
        // echo filesize("dane.txt")."<br>";
        // var_dump(file("dane.txt"))."<br>";

        // $file = fopen("owoce.txt", "r");
        // echo fread($file, 5)."<br>";
        // echo fread($file, filesize("owoce.txt"))."<br>";
        // echo fgets($file)."<br>";
        // while (!feof($file)) {
        //     $line = fgets($file);
        //     if ($line) {
        //         echo "> ".trim($line)."<br>";
        //     }
        // }
        // fclose($file);

        $file = fopen("dane1.txt", "r");
        $result = 0;
        while (!feof($file)) {
            if(fgets($file)) {
                $result += 1;
            }
        }
        echo $result."<br>";
        fclose($file);

        $file = fopen("dane1.txt", "r");
        $result = 0;
        while (!feof($file)) {
            $line = fgets($file);
            if ($line) {
                $line = trim($line);
                if ($line[0] == $line[-1]) {
                    $result += 1;
                }
            }
        }
        echo $result."<br>";
        fclose($file);

        $file = fopen("dane1.txt", "r");
        $result = 0;
        $tab_result = [];
        while (!feof($file)) {
            $line = fgets($file);
            if ($line) {
                $line = trim($line);
                $tab = str_split($line);
                $last = $tab[0];
                $local_result = true;
                $max = 0;
                $min = 7;
                for ($i = 0; $i < count($tab); $i++) {
                    $max = max($tab[$i], $max);
                    $min = min($tab[$i], $min);

                    if ($last > $tab[$i]) {
                        $local_result = false;
                    }

                    $last = $tab[$i];
                }

                if ($local_result) {
                    $local_tab = [$max, $min];
                    array_push($tab_result, $local_tab);
                    $result += 1;
                }
            }
        }
        var_dump($tab_result);
        echo $result."<br>";
        fclose($file);
    }

    ?>
    </div> 
</body>
</html>
<?php



?>