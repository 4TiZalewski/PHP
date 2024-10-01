<?php

$conn = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_domy");

$table = NULL;
if (
    isset($_POST['imie']) && 
    isset($_POST['nazwisko']) && 
    trim($_POST['imie']) != "" && 
    trim($_POST['nazwisko']) != "" &&
    isset($_POST['type']) &&
    trim($_POST['type']) != ""
) {
    $imie = trim($_POST['imie']);
    $nazwisko = trim($_POST['nazwisko']);

    $type = $_POST['type'];
    echo "$type";
    if ($_POST['type'] === "agent") {
        $table = "agenci";
    } else if ($_POST['type'] === "klient") {
        $table = "klienci";
    }

    if ($table != NULL) {
        $sql = "INSERT INTO $table (`Imie`, `Nazwisko`) VALUES (?, ?);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $imie, $nazwisko);
        mysqli_execute($stmt);
        header("Location: index.php");
    }
}

if ($table == NULL) {
    $table = "klienci";
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
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
        }

        form {
            margin: 1rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
    </style>
</head>
<body>
    <div class="container">
    <form method="POST">
        <label for="imie">
            Imię
            <input type="text" name="imie" id="imie" required>
        </label>
        <label for="Nazwisko">
            Nazwisko
            <input type="text" name="nazwisko" id="nazwisko" required>
        </label>
        <label for="agent">
            <input type="radio" name="type" id="agent" value="agent">
            Agent
        </label>
        <label for="klient">
            <input type="radio" name="type" id="klient" value="klient" checked>
            Klient
        </label>
        <input type="submit" value="Dodaj">
    </form>
    <?php

    $sql = "SELECT Imie, Nazwisko FROM `$table` ORDER BY Nazwisko";

    $result = mysqli_query($conn, $sql);

    echo "<ol>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>".($row['Imie'])." ".($row['Nazwisko'])."</li>";
    }
    echo "</ol>";

    mysqli_close($conn);

    ?>
    </div> 
</body>
</html>
<?php



?>