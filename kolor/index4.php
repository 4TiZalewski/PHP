<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }
        
        h1 {
            margin: 1rem;
        }

        body {
            height: 100svh;
            display: flex;
            justify-content: center;
            align-items: center;
            <?php
            $color = $_GET['color'];
            echo "background-color: $color;";
            ?>
        }
    </style>
</head>
<body>
    <h1>
    <?php
        $napis = $_GET['napis'] ?? NULL;

        if (
            !is_null($napis)
        ) {
            echo $napis;
        }
    ?>
    </h1> 
</body>
</html>