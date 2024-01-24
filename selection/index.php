<?php

$selected = null;

if (
    isset($_GET['image'])
) {
    $selected = $_GET['image'];
    setcookie("selected_image", $selected, time() + 3600 * 24 * 365);
} else if (
    isset($_COOKIE['selected_image'])
) {
    $selected = $_COOKIE['selected_image'];
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

        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        label {
            cursor: pointer;
        }

        img {
            padding: 1rem;
            width: 5rem;
        }

        .selected {
            background-color: red;
        }

        label:focus {
            border: 1px solid white;
        }
    </style>
</head>
<body>
    <div class="container">
        <form>
            <div>
                <?php echo load_images("pliki", $selected); ?>
            </div>
            <input type="submit" value="Prześlij">
        </form>
    </div> 
</body>
</html>
<?php

function load_images(string $image_dir, string|null $selected) {
    $dir = scandir($image_dir);
    $id = 0;
    foreach($dir as $file_path) {
        if ($file_path == "." || $file_path == "..") {
            continue;
        }

        $path_info = pathinfo($file_path);

        $class = "";
        if ($selected == $file_path) {
            $class = "class=\"selected\"";
        }

        $img = <<<IMG
            <label for="image$id">
                <img src="$image_dir/$file_path" $class alt="">
                <input type="radio" name="image" id="image$id" value="$file_path">
            </label>
        IMG;

        echo "$img\n";
        $id += 1;
    }
}

?>