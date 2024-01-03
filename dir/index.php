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
            justify-content: flex-start;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        img {
            aspect-radio: 1;
            width: 10rem;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php

    if ($mode === 1) {
        $files = scandir("images");
        for($i = 2; $i < count($files); $i++) {
            echo "<img src=\"images\\".$files[$i]."\" alt=\"Język programowania\">\n";
        }
    }

    ?>
    </div> 
</body>
</html>
<?php



?>