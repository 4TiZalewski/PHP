<?php

// 0 -> Nic
// 1 -> Logowanie
// 2 -> Rejestracja
$mode = 0;
$login = "";
$password = "";
$users_path = "users";

if (
    isset($_POST['type']) &&
    isset($_POST['password']) &&
    $_POST['password'] != "" &&
    isset($_POST['login']) &&
    trim($_POST['login']) != ""
) {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    switch ($_POST['type']) {
        case "Loguj":
            $mode = 1;
            break;
        case "Rejestruj":
            $mode = 2;
            break;
        default:
    }
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
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST">
            <label for="login">
                Login: 
                <input type="text" id="login" name="login">
            </label>
            <label for="password">
                Password: 
                <input type="password" id="password" name="password">
            </label>
            <div>
                <input type="submit" name="type" value="Loguj">
                <input type="submit" name="type" value="Rejestruj">
            </div>
        </form>
    <?php

    if ($mode === 1) {
        if (file_exists("$users_path\\$login")) {
            $saved_password = file_get_contents("$users_path\\$login\\password.txt");
            if (password_verify($password, $saved_password)) {
                header("Location:galeria.php?login=$login");
            } else {
                echo "Błędne hasło";
            }
        } else {
            echo "Użytkownik $login nie istnieje";
        }
    } else if ($mode === 2) {
        if (!file_exists("$users_path\\$login")) {
            mkdir("$users_path\\$login");

            $password_file = fopen("$users_path\\$login\\password.txt", "w");
            fwrite($password_file, password_hash($password, PASSWORD_ARGON2ID));
            fclose($password_file);

            echo "Zarejestrowano użytkownika $login";
        } else {
            echo "Użytkownik $login już istnieje!\n";
        }
    }

    ?>
    </div> 
</body>
</html>
<?php


?>