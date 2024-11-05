<?php

require 'lib.php';

$connection = get_connection();

$druzyna = NULL;
if (isset($_GET['druzyna']) && is_numeric(trim($_GET['druzyna']))) {
    $druzyna = intval(trim($_GET['druzyna']));
} else {
    header("Location: index.php");
}

if (isset($_GET['date']) && trim($_GET['date']) != "") {
    $date = trim($_GET['date']);
    $type = trim($_GET['type']);
    $where = trim($_GET['where']);
    $sedzia = trim($_GET['sedzia']);
    $w = intval(trim($_GET['W']));
    $l = intval(trim($_GET['L']));

    $sql = "INSERT INTO wyniki (Data_meczu, Rodzaj_meczu, Gdzie, Id_druzyny, Nr_licencji, Bramki_zdobyte, Bramki_stracone) VALUES (DATE('$date'), '$type', '$where', $druzyna, '$sedzia', $w, $l);";
    mysqli_query($connection, $sql);

    header("Location: mecze.php?druzyna=$druzyna");
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

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="number"] {
            width: 3rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dodaj mecz</h1>
        <?php
            echo "<a href=\"mecze.php?druzyna=$druzyna\">Powrót</a>";
        ?>
        <form>
            <label for="date">
                Data meczu:
                <input type="date" name="date" require>
            </label>
            <div>
            <label for="type">
                Rodzaj meczu:
                <select name="type" id="type" require>
                    <?php
                        $sql = "SELECT DISTINCT wyniki.Rodzaj_meczu FROM wyniki;";
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value=\"".$row['Rodzaj_meczu']."\">".$row['Rodzaj_meczu']."</option>";
                        }
                    ?>
                </select>
            </label>
            <label for="where">
                Gdzie:
                <select name="where" id="where" require>
                    <?php
                        $sql = "SELECT DISTINCT wyniki.Gdzie FROM wyniki;";
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value=\"".$row['Gdzie']."\">".$row['Gdzie']."</option>";
                        }
                    ?>
                </select>
            </label>
            </div>
            <label for="sedzia">
                Sędzia:
                <select name="sedzia" id="sedzia" require>
                    <?php
                        $sql = "SELECT sedziowie.Nr_licencji, CONCAT(sedziowie.Imie, \" \", sedziowie.Nazwisko) AS sedzia FROM sedziowie;";
                        $result = mysqli_query($connection, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value=\"".$row['Nr_licencji']."\">".$row['sedzia']."</option>";
                        }
                    ?>
                </select>
            </label>
            <div>
            <label for="W">
                Bramki zdobyte:
                <input type="number" min="0" name="W" id="W" value="0" require>
            </label>
            <label for="L">
                Bramki stracone:
                <input type="number" min="0" name="L" id="L" value="0" require>
            </label>
            </div>
            <input type="hidden" name="druzyna" value="<?php echo "$druzyna"; ?>">
            <input type="submit" value="Dodaj mecz">
        </form>
    </div>
</body>
</html>
<?php

mysqli_close($connection);

?>