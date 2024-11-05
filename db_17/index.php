<?php

$conn = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_konta");

if (isset($_GET['client']) && trim($_GET['client']) != "" && is_numeric(trim($_GET['client'])) && isset($_GET['action']) && (trim($_GET['action']) === "+" || trim($_GET['action']) === "-")) {
    $action = trim($_GET['action']);
    $client = intval(trim($_GET['client']));

    $sql = "";
    if ($action === "+") {
        $sql = "UPDATE test SET test.srodki = test.srodki + 1 WHERE test.id = $client;";
    } else {
        $sql = "UPDATE test SET test.srodki = test.srodki - 1 WHERE test.id = $client;";
    }

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

        .money {
            display: flex;
            justify-content: space-between;
        }

        .money > * {
            margin-right: 0.1rem;
            margin-left: 0.1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <tr>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Środki</th>
            </tr>
        <?php

        $sql = "SELECT test.id, test.imie, test.nazwisko, test.srodki FROM test ";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row['imie']."</td>";
            echo "<td>".$row['nazwisko']."</td>";
            echo "<td><form class=\"money\"><input type=\"submit\" name=\"action\" value=\"-\"><input type=\"hidden\" name=\"client\" value=\"".$row['id']."\">".$row['srodki']."<input type=\"submit\" name=\"action\" value=\"+\"></form></td>";
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