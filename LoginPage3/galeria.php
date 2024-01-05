<?php

// 0 -> Nothing
// 1 -> File transfer
// 2 -> Deletion
$mode = 0;
$file = "";
$delete_file_path = "";
$users_path = "users";
$login = "";
$preview_choise = false;

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
} else if (
    isset($_GET['delete_file_path']) &&
    trim($_GET['delete_file_path']) != ""
) {
    $mode = 2;
    $delete_file_path = $_GET['delete_file_path'];
}

if (
    isset($_GET['preview'])
) {
    $preview_choise = true;
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

        .image {
            display: flex;
        }

        table, tr, td, th {
            border: 0.1rem solid white;
            border-collapse: collapse;
        }

        td, th {
            padding: 0.3rem;
        }

        .hidden-preview {
            display: none;
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

        <form>
            <label for="preview">
                <input type="checkbox" name="preview" id="preview" <?php echo $preview_choise ? "checked" : "" ?>>
                Podgląd
            </label>
            <input type="hidden" name="login" value="<?php echo $login; ?>">
            <input type="submit" value="Aplikuj">
        </form>

    <?php
    echo "<table>";
    load_images("$users_path\\$login", $login, $preview_choise);
    echo "</table>";

    if ($mode === 1) {
        move_uploaded_file($file['tmp_name'], $uploaded_files_path."\\".$file['name']);
        header("Location:galeria.php?login=$login");
    } else if ($mode === 2) {
        unlink("$users_path\\$login\\$delete_file_path");
        header("Location:galeria.php?login=$login");
    }

    ?>
    </div> 
</body>
</html>
<?php

function load_images($dir_path, $login, $preview) {
    $dir = opendir($dir_path);

    echo "<table>";
    $preview_view = $preview ? "<th>Podgląd</th>" : "";
    echo "<tr><th>Nazwa</th><th>Rozmiar</th>$preview_view<th>Usuń</th></tr>";
    while (($file_path = readdir($dir))) {
        if ($file_path == "." || $file_path == ".." || $file_path == "password.txt") {
            continue;
        }

        $image_size = filesize("$dir_path\\$file_path");
        $class;

        if ($preview) {
            $class = "preview";
        } else {
            $class = "hidden-preview";
        }

        $image = <<<IMG
        <tr>
            <td>
                $file_path
            </td>
            <td>
                $image_size B
            </td>
            <td class="$class">
                <img src="$dir_path\\$file_path">
            </td>
            <td>
                <form>
                    <input type="submit" name="delete_file" value="X">
                    <input type="hidden" name="delete_file_path" value="$file_path">
                    <input type="hidden" name="login" value="$login">
                </form>
            </td>
        </tr>
        IMG;

        echo $image;
    }
    echo "</table>";

    closedir($dir);
}

?>