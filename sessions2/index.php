<?php
session_start();

$mode = 0;
$zyciorys = "";

if (
    isset($_FILES['file']) &&
    is_uploaded_file($_FILES['file']['tmp_name'])
) {
    $dir = "zdjecia/".session_id();
    if (!file_exists($dir)) {
        mkdir($dir);
    }

    $file = $_FILES['file'];
    move_uploaded_file($file['tmp_name'], $dir."/".$file['name']);
}

if (
    isset($_SESSION['zyciorys'])
) {
    $zyciorys = trim($_SESSION['zyciorys']);
}

if (
    isset($_POST['zyciorys'])
) {
    $zyciorys = trim($_POST['zyciorys']);
    $_SESSION['zyciorys'] = $zyciorys;
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

        fieldset {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <div class="container">
        <fieldset>
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="zyciorys">
                    Życiorys
                    <br>
                    <textarea name="zyciorys" id="zyciorys" cols="30" rows="10"><?php echo $zyciorys; ?></textarea>
                </label>
                <div>
                    <input type="file" name="file">
                    <input type="submit" value="Prześlij">
                </div>
            </form>
        </fieldset>
        <a href="galeria.php">Galeria</a>
    <?php

    if ($mode === 1) {
        
    }

    ?>
    </div> 
</body>
</html>
<?php



?>