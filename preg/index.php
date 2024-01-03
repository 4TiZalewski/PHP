<?php

$mode = 0;
$text = "";

if (
    isset($_GET['text'])
) {
    $mode = 1;
    $text = $_GET['text'];
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
        <form action="#">
            <label for="text">
                Text:
                <input type="textarea" name="text" id="text">
            </label>
            <input type="submit" value="Wyślij">
        </form>
        <?php

        if ($mode === 1) {
            $text = mb_strtolower($text);
            $result = [];
            // echo preg_match_all("/\w*a\w*/", $text);
            echo preg_match_all("/(\w*a){2}\w*/", $text);
        }

        ?>
    </div> 
</body>
</html>
<?php



?>