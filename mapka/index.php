<?php

$mode = 0;
$coords = [311, 324];
$error_margin = 50;
$user_coords = null;

if (
    isset($_GET['x']) && 
    isset($_GET['y']) && 
    is_numeric($_GET['x']) &&
    is_numeric($_GET['y'])
) {
    $mode = 1;
    $user_coords = [$_GET['x'], $_GET['y']];
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
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="systemy 3tizadanie.jpg" alt="something" usemap="#my-map">
        <map name="my-map">
            <area shape="rect" coords="25,11,68,27" href="https://pl.wikipedia.org/wiki/Internet" alt="Internet" title="Internet">
            <area shape="circle" coords="86,74,35" href="https://pl.wikipedia.org/wiki/Router" alt="Ruter" title="Ruter">
            <area shape="rect" coords="173,233,247,114" href="https://pl.wikipedia.org/wiki/Serwer" alt="Serwer" title="Serwer">
            <area shape="rect" coords="335,151,411,106" href="https://pl.wikipedia.org/wiki/Prze%C5%82%C4%85cznik_sieciowy" alt="Switch" title="Switch">
            <area shape="rect" coords="470,107,570,240" href="https://pl.wikipedia.org/wiki/Komputer" alt="Switch" title="Komputer">
        </map>
        <form>
            <input type="image" src="applepear.png">
        </form>
    <?php

    if ($mode === 1) {
        if (is_correct($user_coords, $coords, $error_margin)) {
            echo "Witaj w jabłku";
        }
    }

    ?>
    </div> 
</body>
</html>
<?php

function is_correct(array $target, array $user_target, int $error_margin): bool {
    $x_diff = abs($user_target[0] - $target[0]);
    $y_diff = abs($user_target[1] - $target[1]);
    return $x_diff ** 2 + $y_diff ** 2 <= $error_margin ** 2;
}

?>