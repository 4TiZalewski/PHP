<?php

// 0 -> Nothing
// 1 -> Successful
$mode = 0;
$file = "";
$users_path = "users";
$login = "";

if (
    isset($_GET['login']) &&
    trim($_GET['login']) != ""
) {
    $login = $_GET['login'];
} else {
    header("Location:index.php");
}

if (
    isset($_FILES['file']) &&
    is_uploaded_file($_FILES['file']['tmp_name'])
) {
    $mode = 1;
    $file = $_FILES['file'];
}

$uploaded_files_path = "$users_path\\$login";

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

        img {
            aspect-radio: 1;
            width: 5rem;
            margin: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php
        echo "Zalogowano na użytkownika $login";
    ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="file">
            <input type="submit">
        </form>

    <?php
    load_images("$users_path\\$login");

    if ($mode === 1) {
        move_uploaded_file($file['tmp_name'], $uploaded_files_path."\\".$file['name']);
        header("Location:galeria.php?login=$login");
    }

    ?>
    </div> 
</body>
</html>
<?php

function load_images($dir_path) {
    $dir = opendir($dir_path);

    while (($file_path = readdir($dir))) {
        if ($file_path == "." || $file_path == ".." || $file_path == "password.txt") {
            continue;
        }

        echo "<img src=\"$dir_path\\$file_path\">\n";
    }

    closedir($dir);
}

?>