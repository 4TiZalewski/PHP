<?php

$conn = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_konta");

if (
    isset($_POST['count']) && 
    trim($_POST['count']) != "" &&
    is_numeric(trim($_POST['count'])) &&
    isset($_POST['client']) && 
    trim($_POST['client']) != ""
) {
    $client = trim($_POST['client']);
    $kwota = intval(trim($_POST['count']));
    
    $sql = "UPDATE test SET test.srodki = test.srodki + $kwota WHERE CONCAT(test.imie, \"_\", test.nazwisko) = '$client'";

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
    </style>
</head>
<body>
    <div class="container">
        <table>
            <tr>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Środki</th>
                <th></th>
            </tr>
            <?php
                $sql = "SELECT test.imie, test.nazwisko, test.srodki FROM test;";
                
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".($row['imie'])."</td>";
                    echo "<td>".($row['nazwisko'])."</td>";
                    echo "<td>".($row['srodki'])."</td>";
                    echo "<td>";
                    echo "<form method=\"POST\">";
                    echo "<input type=\"hidden\" name=\"client\" value=\"".$row['imie']."_".$row['nazwisko']."\">";
                    echo "<input type=\"number\" name=\"count\" value=\"10\">";
                    echo "<input type=\"submit\" value=\"+\">";
                    echo "</form>";
                    echo "</td>";
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