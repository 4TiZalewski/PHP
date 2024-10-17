<?php

$conn = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_konta");

if (
    isset($_POST['count']) && 
    trim($_POST['count']) != "" && 
    is_numeric($_POST['count']) &&
    isset($_POST['client']) && 
    trim($_POST['client']) != ""
) {
    $count = intval(trim($_POST['count']));
    $client = trim($_POST['client']);
    
    $sql = "UPDATE test SET test.srodki = test.srodki + $count WHERE CONCAT(test.imie, \"_\", test.nazwisko) = '$client'";

    mysqli_query($conn, $sql);

    header("Location: index.php");
    die();
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

        form {
            margin: 1rem;
        }

        table {
            margin: 1rem;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.3rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST">
            <label for="client">
                Klient
                <select name="client" id="client">
                    <?php
                        $sql = "SELECT test.imie, test.nazwisko FROM test ORDER BY test.nazwisko, test.imie;";

                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)) {
                            $imie = $row['imie'];
                            $nazwisko = $row['nazwisko'];
                            echo "<option value=\"$imie"."_"."$nazwisko\">$imie $nazwisko</option>";
                        }
                    ?>
                </select>
            </label>
            <input type="number" value="0" name="count">zł
            <input type="submit" value="Dodaj">
        </form>
        <table>
            <tr>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Środki</th>
            </tr>
            <?php
                $sql = "SELECT test.imie, test.nazwisko, test.srodki FROM test;";
                
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".($row['imie'])."</td>";
                    echo "<td>".($row['nazwisko'])."</td>";
                    echo "<td>".($row['srodki'])."</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div> 
</body>
</html>
<?php

mysqli_close($conn);

?>