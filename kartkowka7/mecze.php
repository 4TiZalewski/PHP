<?php

require 'lib.php';

$connection = get_connection();

$druzyna = NULL;
if (isset($_GET['druzyna']) && is_numeric(trim($_GET['druzyna']))) {
    $druzyna = intval(trim($_GET['druzyna']));
} else {
    header("Location: index.php");
}

if (isset($_GET['delete']) && is_numeric(trim($_GET['delete']))) {
    $id = trim($_GET['delete']);
    $sql = "DELETE FROM wyniki WHERE wyniki.Id_meczu = $id;";
    mysqli_query($connection, $sql);

    header("mecze.php?druzyna=$druzyna");
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
            padding: 0.4rem;
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
        }

        .buttons {
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
            echo "<h1>Mecze drużyny ".$row['Nazwa']."</h1>";
            echo "<div class=\"buttons\"><a href=\"dodaj-mecz.php?druzyna=$druzyna\">Dodaj mecz</a>";
        ?>
        <a href="index.php">Powrót</a></div>
        <table>
            <tr>
                <th>Data</th>
                <th>Wynik</th>
                <th>Sędzia</th>
                <th>Gdzie | Rodzaj</th>
                <th></th>
            </tr>
            <?php
                $sql = "SELECT wyniki.Id_meczu, wyniki.Data_meczu, CONCAT(wyniki.Bramki_zdobyte, \"-\", wyniki.Bramki_stracone) AS wynik, CONCAT(sedziowie.Imie, \" \", sedziowie.Nazwisko) AS sedzia, CONCAT(wyniki.Gdzie, wyniki.Rodzaj_meczu) AS info FROM wyniki JOIN sedziowie USING(Nr_licencji) WHERE Id_druzyny = $druzyna ORDER BY wyniki.Data_meczu DESC;";
                $result = mysqli_query($connection, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row['Data_meczu']."</td>";
                    echo "<td>".$row['wynik']."</td>";
                    echo "<td>".$row['sedzia']."</td>";
                    echo "<td>".$row['info']."</td>";
                    echo "<td><form><input type=\"hidden\" name=\"delete\" value=\"".$row['Id_meczu']."\"><input type=\"hidden\" name=\"druzyna\" value=\"".$druzyna."\"><input type=\"submit\" value=\"Usuń\"></form></td>";
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