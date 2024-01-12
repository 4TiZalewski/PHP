<?php

// 0 -> show files
// 1 -> save uploaded file
// 2 -> delete file
// 3 -> create and save new text file
$mode = 0;
$file_dir = "pliki";

$file = "";
$delete_file_path = "";

$new_file_name = "";
$new_file_contents = "";

if (
    isset($_FILES['file']) &&
    is_uploaded_file($_FILES['file']['tmp_name'])
) {
    $mode = 1;
    $file = $_FILES['file'];
} else if (
    isset($_GET['delete-file-path']) &&
    trim($_GET['delete-file-path']) != ""
) {
    $mode = 2;
    $delete_file_path = $_GET['delete-file-path'];
} else if (
    isset($_GET['file-contents']) &&
    isset($_GET['file-name']) &&
    trim($_GET['file-name']) != ""
) {
    $mode = 3;
    $new_file_name = trim($_GET['file-name']);
    $new_file_contents = trim($_GET['file-contents']);
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

        .file-item {
            display: flex;
        }

        form {
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }

        h2 {
            padding: 1rem;
        }
        
        hr {
            width: 80%;
        }
    </style>
</head>
<body>
    <div class="container">
    <form method="GET">
        <textarea name="file-contents" placeholder="wpisz tekst"></textarea>
        <label for="file-name">
            <input type="text" name="file-name" id="file-name" placeholder="nazwa pliku"/>.txt
            <input type="submit" value="Zapisz plik na serwerze">
        </label>
    </form>
    <hr>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit">
    </form>
    <hr>

    <h2>Pliki tekstowe:</h2>
    <ol>
        <?php

        if ($mode === 1) {
            move_uploaded_file($file['tmp_name'], $file_dir."/".$file['name']);
            header("Location:index.php");
        } else if ($mode === 2) {
            unlink("$file_dir/$delete_file_path");
            header("Location:index.php");
        } else if ($mode === 3) {
            $new_file_handle = fopen("$file_dir/$new_file_name.txt", "w");
            fwrite($new_file_handle, $new_file_contents);
            fclose($new_file_handle);
            header("Location:index.php");
        }

        $dir = opendir($file_dir);
        while($file_path = readdir($dir)) {
            if ($file_path == "." || $file_path == "..") {
                continue;
            }

            $info = pathinfo($file_path);

            if ($info['extension'] != "txt") {
                continue;
            }

            $file_name = $info['basename'];

            $file_handle = fopen("$file_dir/$file_path", "r");
            $file_contents = fread($file_handle, 50);
            fclose($file_handle);

            $file_list = <<<FILE
                <li>
                    <div class="file-item">
                        <form>
                            <input type="submit" name="delete-file" value="X" />
                            <input type="hidden" name="delete-file-path" value="$file_path" />
                        </form>
                        <a href="$file_dir/$file_path" alt="file">$file_name</a>
                        <br>
                        <p>
                            "$file_contents"
                        </p>
                    </div>
                </li>
            FILE;
            echo $file_list;
        }

        closedir($dir);

        ?>
    </ol>
    </div> 
</body>
</html>
<?php



?>