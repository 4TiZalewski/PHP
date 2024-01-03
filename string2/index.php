<?php

$mode = 0;
$napis = "";

if (
    isset($_GET["napis"])
) {
    $mode = 1;
    $napis = $_GET["napis"];
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
        <label for="napis">
            napis:
            <input type="text" name="napis" id="napis">
        </label><br>
        <input type="submit" value="Wyślij">
    </form>

    <?php

    if ($mode === 1) {
        echo mb_strrev($napis)."<br>";

        $str_tab = explode(" ", $napis);
        echo implode(" ", array_reverse($str_tab))."<br>";

        foreach($str_tab as $wyraz) {
            echo mb_strrev($wyraz)." ";
        }

        echo "<br>";
    }

    ?>
   </div> 
</body>
</html>
<?php

function mb_strrev(string $text): string {
    $result = "";
    for ($i = mb_strlen($text) - 1; $i >= 0; $i--) {
        $result .= mb_substr($text, $i, 1);
    }

    return $result;
}

?>