<?php

$mode = 0;
$napis = [];

if (
    isset($_GET["napis1"]) &&
    isset($_GET["napis2"])
) {
    $mode = 1;
    $napis[0] = $_GET["napis1"];
    $napis[1] = $_GET["napis2"];
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
        <label for="napis1">
            napis nr 1:
            <input type="text" name="napis1" id="napis1">
        </label><br>
        <label for="napis2">
            napis nr 2:
            <input type="text" name="napis2" id="napis2">
        </label><br>
        <input type="submit" value="Wyślij">
    </form>

    <?php

    if ($mode === 1) {
        echo "Czy \"".$napis[0]."\" i \"".$napis[1]."\" to anagramy? -> ";
        echo are_anagrams2($napis[0], $napis[1]) ? "tak" : "nie";
    }

    ?>
   </div> 
</body>
</html>
<?php

function are_anagrams2(string $text1, string $text2): bool {
    $tab1 = str_split($text1);
    $tab2 = str_split($text2);
    sort($tab1);
    sort($tab2);
    return $tab1 == $tab2;
}

function are_anagrams(string $text1, string $text2): bool {
    $tab1 = count_characters($text1);
    $tab2 = count_characters($text2);

    return $tab1 == $tab2;
}

function count_characters(string $text_raw): array {
    $text = strtolower($text_raw);
    $tab = [];
    for ($i = 0; $i < strlen($text); $i++) {
        $z = $text[$i];
        if (isset($tab[$z])) {
            $tab[$z]++;
        } else {
            $tab[$z] = 1;
        }
    }

    return $tab;
}

?>