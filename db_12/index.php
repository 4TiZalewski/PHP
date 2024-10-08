<?php

$selected_client = NULL;
$connection = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_konta");

if (isset($_GET['client']) && trim($_GET['client']) != "") {
    $client = trim($_GET['client']);
    if ($client !== "%" && is_numeric($client)) {
        $selected_client = intval($client);
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table, th, td {
            border: 1px solid white;
        }

        table {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.3rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <form>
            <label for="client">
                <select name="client" id="client">
                    <option value="%" <?php if (!$selected_client) { echo "selected"; } ?>>Wszyscy</option>
                    <?php
                        $sql = "SELECT osoby.id_osoby, osoby.imie, osoby.nazwisko FROM osoby;";

                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id_osoby = intval($row['id_osoby']);
                            echo "<option value=\"".($id_osoby)."\" ".($selected_client === $id_osoby ? "selected" : "").">".($row['imie'])." ".($row['nazwisko'])."</option>\n";
                        }
                    ?>
                </select>
            </label>
            <input type="submit" value="Wybierz">
        </form>
        <form action="add_client.php">
            <input type="submit" value="Dodaj konto">
        </form>
        <table>
            <tr>
                <th>Bank</th>
                <th>Nr konta</th>
                <th>Właściciel</th>
                <th>Stan konta</th>
            </tr>
            <?php

            if (!$selected_client) {
                $client = "%";
            } else {
                $client = $selected_client;
            }

            $sql = "SELECT konta.bank, konta.nr_konta, osoby.imie, osoby.nazwisko, konta.dostepne_srodki FROM konta JOIN osoby USING(id_osoby) WHERE id_osoby LIKE ?";

            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "s", $client);
            mysqli_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".($row['bank'])."</td>";
                echo "<td>".($row['nr_konta'])."</td>";
                echo "<td>".($row['imie'])." ".($row['nazwisko'])."</td>";
                echo "<td>".($row['dostepne_srodki'])."</td>";
                echo "</tr>";
            }

            ?>
        </table>
    </div> 
</body>
</html>
<?php

mysqli_close($connection);

?>