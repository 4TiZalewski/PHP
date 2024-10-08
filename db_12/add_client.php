<?php

$connection = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_konta");

if (
    isset($_POST['bank']) && 
    trim($_POST['bank']) != "" &&
    isset($_POST['client']) &&
    trim($_POST['client']) != "" &&
    is_numeric($_POST['client'])
) {
    $bank = trim($_POST['bank']);
    $client = intval(trim($_POST['client']));
    $nr_konta = "";
    for ($i = 0; $i < 26; $i++) {
        $random_number = rand(0, 9);
        $nr_konta .= $random_number;
    }

    $sql = "INSERT INTO konta (id_osoby, bank, nr_konta, dostepne_srodki) VALUES ($client, \"$bank\", $nr_konta, 0);";

    mysqli_query($connection, $sql);

    header("Location: index.php?client=$client");
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
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form > label {
            padding: 0.3rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST">
            <label for="bank">
                Bank:
                <select name="bank" id="bank">
                    <?php
                        $sql = "SELECT DISTINCT konta.bank FROM konta;";

                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value=\"".($row['bank'])."\">".($row['bank'])."</option>\n";
                        }
                    ?>
                </select>
            </label>
            <label for="client">
                Client:
                <select name="client" id="client">
                    <?php
                        $sql = "SELECT osoby.id_osoby, osoby.imie, osoby.nazwisko FROM osoby;";

                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id_osoby = intval($row['id_osoby']);
                            echo "<option value=\"".($id_osoby)."\">".($row['imie'])." ".($row['nazwisko'])."</option>\n";
                        }
                    ?>
                </select>
            </label>
            <input type="submit" value="Załóż konto">
        </form>
        <?php

        

        ?>
    </div> 
</body>
</html>
<?php

mysqli_close($connection);

?>