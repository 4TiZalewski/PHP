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
            align-items: center;
        }

        fieldset {
            display: flex;
            flex-direction: column;
        }

        fieldset > div {
            text-align: center;
        }

        ol {
            list-style-type: upper-roman;
        }

        li {
            margin: 0.4rem;
        }

        .cinema {
            margin-top: 1rem;
            border: white 1px solid;
            padding-right: 2rem;
            padding-left: 0.5rem;
        }

        button {
            width: 2rem;
            aspect-ratio: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="GET">
            <fieldset>
                <label for="miejsca-kino">
                    liczba miejsc w kinie
                    <input type="number" name="miejsca-kino" min="10" max="1000" value=<?php echo $_GET["miejsca-kino"] ?? "100" ?>>
                </label>
                <label for="miejsca-rzad-kino">
                    liczba miejsc w rzędzie
                    <input type="number" name="miejsca-rzad-kino" min="5" max="20" value=<?php echo $_GET["miejsca-rzad-kino"] ?? "10" ?>>
                </label>
                <div>
                    <input type="submit">
                </div>
            </fieldset>
        </form>
        
        <div class="cinema">
            <?php

            if (isset($_GET['miejsca-kino'])) {
                $miejsca = $_GET['miejsca-kino'];
                $miejsca_na_rzad = $_GET['miejsca-rzad-kino'];
                $rzedy = intval($miejsca / $miejsca_na_rzad);

                echo "<ol>";
                for ($rzad = 1; $rzad <= $rzedy; $rzad++) {
                    echo "<li>";
                    for ($miejsce = 1; $miejsce <= $miejsca_na_rzad; $miejsce++) {
                        echo "<button>$miejsce</button>";
                    }
                    echo "</li>";
                }

                if ($miejsca % $miejsca_na_rzad != 0) {
                    echo "<li>";
                    for ($miejsce = 1; $miejsce <= $miejsca % $miejsca_na_rzad; $miejsce++) {
                        echo "<button>$miejsce</button>";
                    }
                    echo "</li>";
                }

                echo "</ol>";
            }

            ?>
        </div>
    </div>

    <script src="index-kino.js"></script>
</body>
</html>