<?php

// 0 -> Show images
// 1 -> Upload and show images
$mode = 0;
$file = "";
$dir_path = "images";
$uploaded_files_path = $dir_path;

if (
    isset($_FILES['file']) &&
    is_uploaded_file($_FILES['file']['tmp_name'])
) {
    $mode = 1;
    $file = $_FILES['file'];
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
        }

        img {
            aspect-radio: 1;
            width: 10rem;
            display: inline;
        }

        p {
            display: inline;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="file">
            <input type="submit">
        </form>
    <?php

    if ($mode === 1) {
        move_uploaded_file($file['tmp_name'], $uploaded_files_path."\\".$file['name']);
    }

    if ($mode === 1 || $mode === 0) {
        $dir = opendir($dir_path);
        while (($file_path = readdir($dir))) {
            if ($file_path == "." || $file_path == "..") {
                continue;
            }

            $extension = pathinfo($file_path, PATHINFO_EXTENSION);
            if ($extension != "txt") {
                $text = "";
                $text_file_path = pathinfo($file_path, PATHINFO_FILENAME).".txt";
                if (file_exists("$dir_path\\$text_file_path")) {
                    $text_array = file("$dir_path\\$text_file_path");
                    for ($i = 0; $i < count($text_array); $i++) {
                        $text .= $text_array[$i]." ";
                    }
                }
                echo "<div class=\"row\">\n<img src=\"$dir_path\\$file_path\">\n<p>$text</p>\n</div>\n";
            }
        }
    }

    ?>
    </div> 
</body>
</html>
<?php



?>