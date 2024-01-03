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
    <?php

    if ($mode === 1) {
        $dane = fopen("dane1.txt", "r");
        $parzyste = fopen("parzyste.txt", "w");
        $nieparzyste = fopen("nieparzyste.txt", "w");

        $number_parzyste = 0;
        $number_nieparzyste = 0;

        while (!feof($dane)) {
            $line = fgets($dane);
            if ($line) {
                $line = trim($line);
                $number = intval($line);
                if ($number % 2 == 0) {
                    $number_parzyste += 1;
                    fputs($parzyste, "$number\n");
                } else {
                    $number_nieparzyste += 1;
                    fputs($nieparzyste, "$number\n");
                }
            }
        }

        fclose($parzyste);
        fclose($nieparzyste);
        fclose($dane);

        echo "Parzystych było $number_parzyste, a nieparzystych $number_nieparzyste.<br>";
    }

    ?>
    </div> 
</body>
</html>
<?php



?>