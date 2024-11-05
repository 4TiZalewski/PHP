<?php

require 'lib.php';

$connection = get_connection();

$druzyna = NULL;
if (isset($_GET['druzyna']) && is_numeric(trim($_GET['druzyna']))) {
    $druzyna = intval(trim($_GET['druzyna']));
} else {
    header("Location: index.php");
}

if (isset($_GET['name']) && trim($_GET['name']) != "") {
    $name = trim($_GET['name']);
    $sql = "UPDATE druzyny SET druzyny.Nazwa = \"$name\" WHERE druzyny.Id_druzyny = $druzyna;";
    mysqli_query($connection, $sql);

    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mecze</title>
    <style>
        body {
            margin: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background-color: black;
            color: white;
        }

        table, th, td {
            border: 1px solid white;
        }

        th, td {
            padding: 0.3rem;
        }

        table {
            border-collapse: collapse;
        }

        a {
            padding: 0.3rem;
            background-color: wheat;
            color: black;
            text-decoration: none;
            border-radius: 0.2rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            $sql = "SELECT druzyny.Nazwa FROM druzyny WHERE druzyny.Id_druzyny = $druzyna;";
            $result = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($result);
            echo "<h1>Modyfikuj drużynę ".$row['Nazwa']."</h1>";
        ?>
        <a href="index.php">Powrót</a>
        <form>
            <label for="name">
                Nazwa drużyny:
                <?php
                    echo "<input type=\"text\" name=\"name\" value=\"".$row['Nazwa']."\" require>";
                ?>
            </label>
            <input type="hidden" name="druzyna" value="<?php echo "$druzyna"; ?>">
            <input type="submit" value="Modyfikuj">
        </form>
    </div>
</body>
</html>
<?php

mysqli_close($connection);

?>