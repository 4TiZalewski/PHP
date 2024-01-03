<?php

$characters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'W', 'Q', 'V', 'X', 'Y', 'Z'];
$mode = 0;
$text = "";
$n = 0;
$L = '';

if (
    isset($_GET['text']) &&
    isset($_GET['n']) &&
    isset($_GET['L']) &&
    is_numeric($_GET['n']) &&
    $_GET['n'] > 0 &&
    $_GET['text'] != ""
) {
    $mode = 1;
    $text = $_GET['text'];
    $n = intval($_GET['n']);
    $L = $_GET['L'];
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
    <form action="#">
        <fieldset>
            <input type="textarea" name="text" id="text">
            <label for="n">
                n
                <input type="number" name="n" id="n" min="1" value="1">
            </label>
            <label for="L">
                L
                <select name="L" id="L">
                    <?php
                        for ($i = 0; $i < count($characters); $i++) {
                            $char = $characters[$i];
                            echo "<option value=\"$char\">$char</option>";
                        }
                    ?>
                </select>
            </label>
            <input type="submit" value="Statystyka">
        </fieldset>
    </form>

    <?php

    if ($mode === 1) {
        $l = $L;
        $L = strtolower($L);
        echo "Liczba wyrazów: ".str_word_count($text)."<br>";

        $liczba_wyrazow = 0;
        $wyrazy = explode(' ', $text);
        for($i = 0; $i < count($wyrazy); $i++) {
            if (strlen($wyrazy[$i]) == $n) {
                $liczba_wyrazow += 1;
            }
        }
        echo "Liczba wyrazów o długości $n: $liczba_wyrazow<br>";

        $liczba_na_L = preg_match_all("/\w*$L\b/", $text);
        echo "Liczba wyrazów kończących się na \"$l\": $liczba_na_L<br>";

        $liczba_L = preg_match_all("/$L/", $text);
        echo "Liczba wystąpień \"$l\": $liczba_L<br>";

        $big_text = "";
        for($i = 0; $i < count($wyrazy); $i++) {
            $word = $wyrazy[$i];
            if (strlen($word) > 0) {
                $word[0] = strtoupper($word[0]);
                $big_text .= $word." ";
            }
        }
        echo "Każdy wyraz zaczyna się wielką literą: $big_text<br>";

        $liczba_palindromow = 0;
        for($i = 0; $i < count($wyrazy); $i++) {
            if (is_palindrom(strtolower($wyrazy[$i]))) {
                $liczba_palindromow += 1;
            }
        }
        echo "Liczba palindromów: $liczba_palindromow<br>";
    }

    ?>
    </div> 
</body>
</html>
<?php

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