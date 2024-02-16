<?php
session_start();

$mode = 0;

if (
    file_exists("zdjecia/".session_id())
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
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        img {
            aspect-radio: 1;
            width: 10rem;
            margin: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Galeria</h1>
        <div class="galery">
        <?php
            $folders = scandir("zdjecia");
            foreach ($folders as $dir) {
                if ($dir == "." || $dir == "..") {
                    continue;
                }

                if ($dir == session_id()) {
                    continue;
                }

                foreach(scandir("zdjecia/".$dir) as $img_file) {
                    $path = "zdjecia/$dir/$img_file";
                    if (is_file($path)) {
                        unlink($path);
                    }
                }

                rmdir("zdjecia/".$dir);
            }

            if ($mode === 1) {
                load_images("zdjecia/".session_id());
            }
        ?>
        </div>
        <a href="index.php">Powrót</a>
    </div> 
</body>
</html>
<?php

function load_images($dir_path) {
    $dir = opendir($dir_path);

    while (($file_path = readdir($dir))) {
        if ($file_path == "." || $file_path == "..") {
            continue;
        }

        $image = <<<IMG
            <img src="$dir_path/$file_path">
        IMG;

        echo $image;
    }

    closedir($dir);
}

?>