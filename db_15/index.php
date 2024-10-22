<?php

$conn = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_konta");

$client = NULL;
$kwota = NULL;
if (isset($_GET['klient']) && trim($_GET['klient']) != "" && is_numeric(trim($_GET['klient']))) {
    $client = intval(trim($_GET['klient']));
    $type = trim($_GET['type']);

    if ($type != "Wyświetl" && $type != "Dodaj" && $type != "USUŃ!") {
        header("Location: index.php");
        die();
    }

    if ($type === "Wyświetl" && isset($_GET['kwota'])) {
        header("Location: index.php?klient=$client&type=Wyświetl");
        die();
    }

    if ($type === "Dodaj" && isset($_GET['kwota']) && trim($_GET['kwota']) != "" && is_numeric(trim($_GET['kwota']))) {
        $kwota = intval(trim($_GET['kwota']));

        $sql = "UPDATE test SET test.srodki = test.srodki + $kwota WHERE test.id = $client;";
        mysqli_query($conn, $sql);

        header("Location: index.php?klient=$client&type=Wyświetl");
        die();
    }

    if ($type === "USUŃ!") {
        $sql = "DELETE FROM test WHERE test.id = $client;";
        mysqli_query($conn, $sql);

        header("Location: index.php");
        die();
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
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
        }

        table, th, td {
            border: 1px solid white;
        }

        table {
            margin: 1rem;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.3rem;
        }

        input[type="number"] {
            width: 3rem;
            margin-right: 0.2rem;
        }

        input[type="submit"] {
            cursor: pointer;
        }

        input[value="USUŃ!"] {
            border: 0.3rem solid red;
            padding: 0.2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <form>
            <label for="klient">
                <select name="klient" id="klient">
                <?php
                    $sql = "SELECT test.id, test.imie, test.nazwisko FROM test ORDER BY test.nazwisko, test.imie;";
                    
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = intval($row['id']);
                        $selected = "";
                        if (intval($id) === $client) {
                            $selected = "selected";
                        }

                        echo "<option value=\"$id\" $selected >".$row['imie']." ".$row['nazwisko']."</option>";
                    }
                ?>
                </select>
                <input type="submit" name="type" value="Wyświetl">
                <input type="submit" name="type" value="Dodaj">
                <input type="number" name="kwota" value="">
                <input type="submit" name="type" value="USUŃ!">
            </label>
        </form>
        <?php

        if ($client) {
            $sql = "SELECT test.imie, test.nazwisko, test.srodki FROM test WHERE test.id = ?;";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $client);
            mysqli_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                echo "<h4>".$row['imie']." ".$row['nazwisko']." ma ".$row['srodki']." PLN</h4>";
            }
        }

        ?>
    </div> 
</body>
</html>
<?php

mysqli_close($conn);

?>