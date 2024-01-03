<?php
// $mode == -1 -> Access denied!
// $mode == 0 -> Access granted!
// $mode == 1 -> Show results
// $mode == 2 -> Wrong data
$mode = -1;
$login_session = "";

// Verification and logic
if (
    // Checking if user is authenticated
    isset($_GET['session']) && 
    $_GET['session'] === 'qwertyui'
) {
    $mode = 0;
    $login_session = $_GET['session'];

    // Checking if user send right input
    if (
        isset($_GET['a']) &&
        isset($_GET['b'])
    ) {
        $a = $_GET['a'];
        $b = $_GET['b'];

        if (
            is_numeric($a) &&
            is_numeric($b) &&
            $a > 0 &&
            $b > 0
        ) {
            $mode = 1;
        } else {
            $mode = 2;
        }
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
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
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
            // First time, authenticated
        ?>
    
        <form>
            <fieldset>
                <legend>Prostokąt</legend>
                <input type="checkbox" name="session" id="session" checked value="<?php echo "$login_session"; ?>" hidden>
                <label for="a">
                    a
                    <input type="text" name="a" id="a" required="required">
                </label>
                <label for="b">
                    b
                    <input type="text" name="b" id="b" required="required">
                </label>
                <input type="submit" value="Oblicz">
            </fieldset>
        </form>

        <?php
        } else if ($mode === 1) {
            // Correct data
            header("Location: result.php?session=$login_session&a=$a&b=$b");
        } else if ($mode === 2) {
            // Wrong data
            header("Location: error.php?erc=2");
        } else {
            // Unathorized
            header("Location: error.php?erc=1");
        }
        ?>
    </div>
</body>
</html>