<?php

// 0 -> Pierwszy raz
// 1 -> Kolejny raz
// 2 -> Kolejny raz i zmiana koloru
$mode = 0;
$ktory_raz = 0;
$time = null;
$text_color = "#ffffff";
$color = "#000000";
$year = time() + 365 * 24 * 3600;

if (
    isset($_COOKIE['ktory-raz'])
) {
    $mode = 1;
    $ktory_raz = $_COOKIE['ktory-raz'];
    if (!isset($_COOKIE['cooldown'])) {
        $ktory_raz += 1;
        $time = date("Y-m-d H:i:s", time());
    } else {
        $time = $_COOKIE['last-time'];
    }
} else {
    $ktory_raz = 1;
}

setcookie('ktory-raz', "$ktory_raz", $year);
setcookie('last-time', "$time", $year);
setcookie('cooldown', "1", time() + 10);

if (
    isset($_GET['color']) &&
    isset($_GET['text-color'])
) {
    $mode = 2;
    $color = $_GET['color'];
    $text_color = $_GET['text-color'];
    setcookie('color', "$color|$text_color", $year);
} else if (isset($_COOKIE['color'])) {
    $color_merged = explode("|", $_COOKIE['color']);;
    $color = $color_merged[0];
    $text_color = $color_merged[1];
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
            background-color: <?php echo $color; ?>;
            color: <?php echo $text_color; ?>;
        }

        .container {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            right: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <form>
            <label for="color">
                Background color:
                <input type="color" name="color" value="<?php echo $color ?>">
            </label>
            <label for="text-color">
                Text color:
                <input type="color" name="text-color" value="<?php echo $text_color ?>">
            </label>
            <input type="submit" value="Prześlij">
        </form>

    <?php

    echo "Witaj! ";
    echo "<br>";
    echo "Jesteś tu po raz $ktory_raz.";
    if ($mode === 1 | 2) {
        echo "<br>Ostatnio byłeś u nas w: $time";
    } else if ($mode === 0) {
        echo "<br><br>Ta strona używa ciasteczek!";
    }

    ?>
    </div> 
</body>
</html>
<?php



?>