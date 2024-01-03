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
        <!-- <label for="napis">
            Imię:
            <input type="text" name="napis" id="napis">
        </label><br> -->
        <label for="napis">
            napis:
            <input type="text" name="napis" id="napis">
        </label><br>
        <input type="submit" value="Wyślij">
    </form>

    <?php

    if ($mode === 1) {
        // $last_digit = strtolower(last_character($napis));

        // if ($last_digit === 'a') {
        //     echo "$imie jest kobietą!";
        // } else {
        //     echo "$imie jest mężczyzną!";
        // }

        $napis = strtolower($napis);
        $result = "";
        for($i = 0; $i < strlen($napis); $i++) {
            $result = $napis[$i].$result;
        }

        echo $result == $napis ? "Palindrom" : "Nie palindrom";

        // $tab = explode("", $napis);
        // foreach($tab as $znak) {
        //     echo $znak;
        // }
    }

    ?>
   </div> 
</body>
</html>
<?php

function last_character(string $text): string {
    return $text[strlen($text) - 1];
}

?>