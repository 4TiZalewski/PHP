<?php

$mode = 0;
$login = "";
$password = "";

if (
    isset($_POST['login']) &&
    isset($_POST['password']) &&
    trim($_POST['login']) != "" &&
    trim($_POST['password']) != ""
) {
    $mode = 1;
    $login = $_POST['login'];
    $password = $_POST['password'];
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
        <form action="" method="POST">
            <label for="login">
                Login:
                <input type="text" name="login" id="login" required>
            </label><br>
            <label for="password">
                Hasło:
                <input type="password" name="password" id="password" required>
            </label><br>
            <input type="submit" value="Login">
        </form>

    <?php

    if ($mode === 1) {
        $file_path = "users\\$login.txt";
        if (file_exists($file_path)) {
            if (sha1($password) == file_get_contents($file_path)) {
                echo "OK. Witaj $login.";
            } else {
                echo "Access denied.";
            }
        } else {
            $file = fopen($file_path, "w");
            fputs($file, sha1($password));
            fclose($file);
            echo "Nowy użytkownik '$login' zarejestrowany";
        }
    }

    ?>
    </div> 
</body>
</html>
<?php



?>