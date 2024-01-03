<?php

// 0 -> Nothing
// 1 -> Successful
$mode = 0;
$file = "";
$uploaded_files_path = "pliki";

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
            justify-content: center;
            align-items: center;
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
        $result = true;
        if ($file['size'] > 1000) {
            $result = false;
            echo "Plik nie został przesłany, ponieważ jest za duży: ".$file['size']."B > 1000B<br>";
        }

        if (pathinfo($file['name'], PATHINFO_EXTENSION) != "txt") {
            $result = false;
            echo "Plik nie został przesłany, ponieważ nie jest to plik tekstowy.<br>";
        }

        if ($result) {
            echo "Odebrano plik ".$file['name']." o rozmiarze ".$file['size']."B<br>";
            move_uploaded_file($file['tmp_name'], $uploaded_files_path."\\".$file['name']);
        }
    }

    ?>
    </div> 
</body>
</html>
<?php



?>