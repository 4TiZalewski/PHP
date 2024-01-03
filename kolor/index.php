<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            <?php
                $bgcolor = $_GET['bgcolor'] ?? "black";
                $textcolor = $_GET['txcolor'] ?? "white";
                echo "background-color: $bgcolor;\n";
                echo "\t\t\tcolor: $textcolor;\n";
            ?>
        }

        form, h1 {
            margin: 1rem;
        }

        input {
            width: 4rem;
        }

        fieldset {
            display: inline;
        }
    </style>
</head>
<body>
    <?php
    if (isset($_GET['napis'])) {
        $text = $_GET['napis'];
        echo "<h1>$text</h1>";
    } else {
    ?>
        <form>
            <fieldset>
                <label for="napis">
                    Napis: 
                    <input type="text" name="napis" id="napis" size="12" required>
                </label>
                <br>
                <label for="bgcolor">
                    Kolor tła: 
                    <input type="color" name="bgcolor" id="bgcolor">
                </label>
                <br>
                <label for="txcolor">
                    Kolor tekstu: 
                    <input type="color" name="txcolor" id="txcolor" value="#ffffff">
                </label>
                <br>
                <input type="submit" value="Prześlij">
            </fieldset>
        </form> 
    <?php
    }
    ?>
</body>
</html>