<?php
// $mode == -1 -> first time
// $mode == 0 -> Access granted
// $mode == 1 -> Access denied
$mode = -1;

$password_hash = <<<PASS
\$argon2id\$v=19\$m=65536,t=4,p=1\$d2d4eGI5SmVIbHlaM2Vkbg\$T+4S6+i4bQ3cvypr/HsIX9ehJR5/uIdOd/upOq1ww50
PASS;

// Verification and logic
if (
    isset($_POST['login']) &&
    isset($_POST['password'])
) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (password_verify($login.$password, $password_hash)) {
        $mode = 0;
    } else {
        $mode = 1;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            color: white;
            background-color: black;
        }

        .container {
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        fieldset {
            display: flex;
            flex-direction: column;
        }

        label {
            display: flex;
            justify-content: space-between;
            margin: 0.2rem;
        }

        label > input {
            margin-left: 0.3rem;
        }

        input[type="text"],
        input[type="password"] {
            width: 8rem;
        }

        .button {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <?php

        if ($mode === 0) {
            // Access granted
            header("Location: strona.php?session=qwertyui");
        } else if ($mode === 1) {
            // Access denied
            header("Location: error.php?erc=1");
        } else {
            // First time
        ?>

        <form method="POST">
            <fieldset>
                <label for="login">
                    login
                    <input type="text" name="login" id="login" required>
                </label>
                <label for="password">
                    password
                    <input type="password" name="password" id="password" required>
                </label>
                <div class="button">
                    <input type="submit" value="Zaloguj">
                </div>
            </fieldset>
        </form>

        <?php
        }
        ?>
    </div>
</body>
</html>