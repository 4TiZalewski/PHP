<?php

$mode = 0;
$db = "texts.txt";
$name = "";
$text = "";

if (
    isset($_GET["name"]) &&
    isset($_GET["text"]) &&
    trim($_GET["name"]) != "" &&
    trim($_GET["text"]) != ""
) {
    $mode = 1;
    $name = trim($_GET["name"]);
    $text = trim($_GET["text"]);
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

        fieldset {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <div class="container">

    <form>
        <fieldset>
            <label for="name">
                Imię:
                <input type="text" name="name" id="name">
            </label>
            <label for="text">
                Tekst:
                <input type="text" name="text" id="text">
            </label>
            <input type="submit" value="Wyślij">
        </fieldset>
    </form>
    <hr>

    <?php

    if ($mode === 1) {
        // $file = fopen("dane.txt", "aw");
        // $file = fopen("dane.txt", "w");
        // for ($i = 0; $i < 2; $i++) {
        //     fputs($file, rand(100, 999)."\n");
        // }
        // fclose($file);

        if (!file_exists($db)) {
            $file = fopen($db, "w");
            fclose($file);
        }

        $file = fopen($db, "aw");
        $date = date("j-m-Y H:i:s");
        fputs($file, "$date &lt;$name&gt;: $text\n");
        fclose($file);
    }

    if (file_exists($db)) {
        $file = fopen($db, "r");
        while (!feof($file)) {
            $line = fgets($file);
            if ($line) {
                $line = trim($line);
                echo "$line<br>";
            }
        }
    }

    ?>
    </div> 
</body>
</html>
<?php



?>