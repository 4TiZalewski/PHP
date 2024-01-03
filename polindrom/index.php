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
        echo "Czy jest palindrom: ";
        echo is_palindrom(strtolower($napis)) ? "tak" : "nie";
    }

    ?>
   </div> 
</body>
</html>
<?php

// function is_palindrom(string $napis): bool {
//     $len = strlen($napis);

//     for ($i = 0; $i < $len / 2; $i++) {
//         if ($napis[$i] != $napis[-$i - 1]) {
//             return false;
//         }
//     }

//     return true;
// }

function is_palindrom(string $napis): bool {
    $len = mb_strlen($napis);

    for ($i = 0; $i < $len / 2; $i++) {
        if (mb_substr($napis, $i, 1) != mb_substr($napis, -$i - 1, 1)) {
            return false;
        }
    }

    return true;
}

?>