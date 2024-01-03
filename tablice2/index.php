<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: black;
            color: white;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        fieldset {
            display: flex;
            flex-direction: column;
        }

        fieldset > div {
            text-align: center;
        }
    </style>
</head>
<body>
    <form action="" class="default-form">
        <!-- <?php
            for ($i = 1; $i <= 50; $i++) {
                echo "<input type=\"text\" name=\"a$i\" value=\"$i\"><br>\n";
            }
        ?> -->
        <input type="submit" value="Oblicz"><br>
    </form>

<?php

foreach($_GET as $key => $value) {
    echo $key." => ".$value."<br>";
}

?>
<script src="index.js"></script>
</body>
</html>