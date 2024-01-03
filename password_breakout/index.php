<?php

$mode = 0;

if (
    true
) {
    $mode = 1;
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
    <?php

    if ($mode === 1) {
        $characters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'q', 'w', 'v', 'x', 'y', 'z'];
        $result = false;
        $password = "";
        $file = "michal.txt";
        $hash = file_get_contents($file);

        for ($x = 0; $x < count($characters); $x++) {
            for ($y = 0; $y < count($characters); $y++) {
                $password = $characters[$x].$characters[$y];
                if (sha1($password) == $hash) {
                    $result = true;
                    break;
                }
            }

            if ($result) {
                break;
            }
        }

        if ($result) {
            echo "Password is: '$password'";
        }
    }

    ?>
    </div> 
</body>
</html>
<?php



?>