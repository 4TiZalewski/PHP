<?php
session_start();

$VISITED = 'visited';
$LAST_VISIT = 'last-visit';
$SESSION_VISITS = 'session-visits';
$SESSION_START = 'session-start-time';
$ALREADY_VISITED = 'not-first-time';

$last_visit = $_COOKIE[$LAST_VISIT] ?? time();
$times_visited = null;

if (!isset($_COOKIE[$VISITED])) {
    setcookie($VISITED, 1, time() + 60 * 60 * 24 * 356);
    $times_visited = 1;
    $_SESSION[$SESSION_VISITS] = 0;
    $_SESSION[$SESSION_START] = time();
} else if (!isset($_SESSION[$ALREADY_VISITED])) {
    setcookie($VISITED, intval($_COOKIE[$VISITED]) + 1, time() + 60 * 60 * 24 * 356);
    $times_visited = intval($_COOKIE[$VISITED]) + 1;
    $_SESSION[$SESSION_VISITS] = 0;
    $_SESSION[$SESSION_START] = time();
} else {
    $_SESSION[$SESSION_VISITS] += 1;
    $times_visited = intval($_COOKIE[$VISITED]);
}

$_SESSION[$ALREADY_VISITED] = 1;
$session_start_time = $_SESSION[$SESSION_START];
$session_visits = intval($_SESSION[$SESSION_VISITS]);

$LOGGED = 'logged';
$LOGIN = 'login';
$PASSWORD = 'pass';
$LOGOUT = 'logout';
$COLOR = 'color';

$color = '#000000';

// 0 -> login screen
// 1 -> successful login/user screen
// 2 -> failed login
$mode = 0;

if (
    isset($_POST[$LOGIN]) &&
    isset($_POST[$PASSWORD]) &&
    trim($_POST[$LOGIN]) == "admin" &&
    trim($_POST[$PASSWORD]) == "1234"
) {
    $_SESSION[$LOGGED] = "1";
    header("Location: index.php");
} else if (
    isset($_SESSION[$LOGGED]) && 
    trim($_SESSION[$LOGGED] == "1")
) {
    $mode = 1;
} else if (isset($_POST['logining'] )) {
    $_SESSION[$LOGGED] = "0";
    header("Location: index.php");
} else if (isset($_SESSION[$LOGGED]) && trim($_SESSION[$LOGGED]) == "0") {
    $mode = 2;
}

if (isset($_POST[$LOGOUT])) {
    session_destroy();
    header("Location: index.php");
}

if (isset($_POST[$COLOR])) {
    setcookie($COLOR, $_POST[$COLOR], time() + 60 * 60 * 24 * 356);
    $color = $_POST[$COLOR];
} else if (isset($_COOKIE[$COLOR])) {
    $color = $_COOKIE[$COLOR];
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
            background-color: <?php echo $color; ?>;
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
        <div>
            <p>Jesteś tu <?php echo $times_visited; ?> raz, a byłeś tu ostatnio <?php echo date("Y-m-d H:i:s", $last_visit); ?></p>
            <p>W tej sesji odświeżyłeś stronę <?php echo $session_visits; ?> razy, a sesja trwa <?php echo time() - $session_start_time; ?>s</p>
        </div>
        <div>
            <?php if ($mode === 0 || $mode === 2) { ?>
            <form method="POST" action="index.php">
                <fieldset>
                    <label for="login">
                        Login:
                        <input type="text" name="login" id="login" required>
                    </label><br>
                    <label for="pass">
                        Password:
                        <input type="password" name="pass" id="pass" required>
                    </label><br>
                    <input type="hidden" name="logining">
                    <input type="submit" value="Zaloguj">
                </fieldset>
            </form>
            <?php
                if ($mode === 2) {
                    echo "Błędny login lub hasło!";
                }
            ?>
            <?php } else if ($mode === 1 || $mode === 3) { ?>
                <form method="POST" action="index.php">
                    <input type="submit" name="logout" id="logout" value="Logout">
                </form>

                <form method="POST" action="index.php">
                    <input type="color" name="color" id="color" value="<?php echo $color; ?>">
                    <input type="submit" value="Ustaw kolor">
                </form>
            <?php } ?>
        </div>
    <?php
    setcookie($LAST_VISIT, time(), time() + 60 * 60 * 24 * 356);
    ?>
    </div> 
</body>
</html>