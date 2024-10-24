<?php

$conn = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_konta");

if (isset($_GET['client']) && trim($_GET['client']) != "" && is_numeric(trim($_GET['client']))) {
    $client = intval(trim($_GET['client']));
    $sql = "DELETE FROM test WHERE test.id = $client;";
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

        input[value="USUŃ!"] {
            border: 0.3rem solid red;
            padding: 0.2rem;
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
            echo "<td>".$row['srodki']."</td>";
            echo "<td><form><input type=\"hidden\" name=\"client\" value=\"".$row['id']."\"><input type=\"submit\" value=\"X\"></form></td>";
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