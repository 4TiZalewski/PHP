<?php
session_start();

$conn = mysqli_connect("127.0.0.1", "root", "", "5ti_gr1_domy");

// 0 -> Login page
// 1 -> Domy
$mode = 0;
$user = NULL;

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header("Location: index.php");
    die;
}

if (isset($_POST['login']) && trim($_POST['login']) != "" && isset($_POST['password']) && trim($_POST['password']) != "" && is_numeric($_POST['password'])) {
    $pass = intval(trim($_POST['password']));
    $login = trim($_POST['login']);
    $sql = "SELECT klienci.Id_klienta, klienci.Nazwisko, klienci.Imie FROM klienci WHERE klienci.Id_klienta = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $pass);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) < 1) {
        failed_login();
        die;
    }

    $row = mysqli_fetch_assoc($result);
    $id = intval($row['Id_klienta']);
    $nazwisko = $row['Nazwisko'];
    $imie = $row['Imie'];

    if ($login !== $imie.$nazwisko) {
        failed_login();
        die;
    }

    $_SESSION['user'] = $id;
    header("Location: index.php");
}

if (isset($_SESSION['user']) && trim($_SESSION['user']) && is_numeric($_SESSION['user'])) {
    $mode = 1;
    $user = intval(trim($_SESSION['user']));
}

if (isset($_GET['id']) && isset($_GET['zainteresowany'])) {
    $id_oferty = trim($_GET['id']);
    $zainteresowany_oferta = intval(trim($_GET['zainteresowany']));

    $sql = NULL;
    if ($zainteresowany_oferta === 1) {
        $sql = "DELETE FROM zainteresowanie WHERE zainteresowanie.Id_oferty = '$id_oferty' AND zainteresowanie.Id_klienta = $user;";
    } else {
        $sql = "INSERT INTO zainteresowanie (Id_oferty, Id_klienta) VALUES ('$id_oferty', $user);";
    }

    mysqli_query($conn, $sql);
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieruchomości</title>
    <style>
        body {
            background-color: black;
            color: white;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        table, td, th {
            border: 1px solid white;
        }

        table {
            margin-top: 1rem;
            border-collapse: collapse;
        }

        td, th {
            padding: 0.3rem;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php
        if ($mode === 0) {
    ?>
        <form method="POST">
            <label for="login">
                Login
                <input type="text" name="login" id="login" require>
            </label>
            <label for="password">
                Hasło
                <input type="password" name="password" id="password" require>
            </label>
            <input type="submit" value="Zaloguj">
        </form>
    <?php
        } else if ($mode === 1) {
    ?>
        <h1>Oferta</h1>
        <form method="GET">
            <input type="submit" name="logout" value="Wyloguj">
        </form>
        <table>
            <tr>
                <th>Województwo</th>
                <th>Status</th>
                <th>Powierzchnia</th>
                <th>Liczba pokoi</th>
                <th>Liczba łazienek</th>
                <th>Cena</th>
                <th>Data zgłoszenia</th>
                <th></th>
            </tr>
        <?php
            $sql = "SELECT
                    oferty.Id_oferty,
                    oferty.Woj,
                    oferty.Status,
                    oferty.Pow,
                    oferty.L_pokoi,
                    oferty.L_laz,
                    oferty.Cena,
                    oferty.Data_zglosz,
                    zainteresowany
                FROM
                    (
                        (
                        SELECT
                            oferty.Id_oferty,
                            0 AS zainteresowany
                        FROM
                            oferty
                        WHERE
                            oferty.Id_oferty NOT IN(
                            SELECT
                                oferty.Id_oferty
                            FROM
                                oferty
                            JOIN zainteresowanie USING(Id_oferty)
                            JOIN klienci USING(Id_klienta)
                            WHERE
                                klienci.Id_klienta = ?
                        )
                    )
                UNION
                    (
                    SELECT
                        oferty.Id_oferty,
                        1 AS zainteresowany
                    FROM
                        oferty
                    JOIN zainteresowanie USING(Id_oferty)
                    JOIN klienci USING(Id_klienta)
                    WHERE
                        klienci.Id_klienta = ?
                )
                    ) AS d
                JOIN oferty USING(Id_oferty)
                ORDER BY
                    zainteresowany
                DESC;";
            
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $user, $user);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            while ($row = mysqli_fetch_assoc($result)) {
                $zainteresowany = NULL;
                if ($row['zainteresowany'] === 1) {
                    $zainteresowany = "Zainteresowany";
                } else {
                    $zainteresowany = "Nie zainteresowany";
                }

                echo "<tr>";
                echo "<td>".$row['Woj']."</td>";
                echo "<td>".$row['Status']."</td>";
                echo "<td>".$row['Pow']."</td>";
                echo "<td>".$row['L_pokoi']."</td>";
                echo "<td>".$row['L_laz']."</td>";
                echo "<td>".$row['Cena']."</td>";
                echo "<td>".$row['Data_zglosz']."</td>";
                echo "<td>
                    <form method=\"GET\">
                        <input type=\"hidden\" name=\"id\" value=\"".$row['Id_oferty']."\">
                        <input type=\"hidden\" name=\"zainteresowany\" value=\"".$row['zainteresowany']."\">
                        <input type=\"submit\" value=\"".$zainteresowany."\">
                    </form>
                </td>";
                echo "</tr>";
            }
        ?>
        </table>
    <?php
        }
    ?>
    </div>
</body>
</html>
<?php
mysqli_close($conn);

function failed_login() {
    // Failed to log in
    header("Location: index.php");
}
?>