<?php
    $plec = "";
    if (isset($_GET['plec'])) {
        $plec = trim($_GET['plec']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form>
        <label for="wszyscy">
            <input type="radio" name="plec" id="wszyscy" value="wszyscy" checked>
            Wszyscy
        </label>
        <label for="kobiety">
            <input type="radio" name="plec" id="kobiety" value="kobiety">
            Kobiety
        </label>
        <label for="mezczyzni">
            <input type="radio" name="plec" id="mezczyzni" value="mezczyzni">
            Mężczyźni
        </label>
        <input type="submit" value="Pokaż">
    </form>
    <?php 
        $s = "localhost";
        $u = "root";
        $p = "";
        $db = "5ti_gr1_filmy";

        // $conn = new mysqli($s, $u, $p, $db);
        $conn = mysqli_connect($s, $u, $p, $db);

        // if ($conn->connect_error) {
        if (!$conn) {
            // die("Failed to connect to database: ".$conn->connect_error);
            die("Failed to connect to database: ".mysqli_connect_error());
        }

        $where = "";
        if ($plec == "kobiety") {
            $where = "WHERE klienci.Pesel REGEXP '.{9}[02468].'";
        } else if ($plec == "mezczyzni") {
            $where = "WHERE klienci.Pesel REGEXP '.{9}[13579].'";
        }

        $sql = "
            SELECT klienci.Imie, klienci.Nazwisko
            FROM klienci
            $where
            ORDER BY klienci.Nazwisko, klienci.Imie;
        ";

        // $result = $conn->query($sql);
        $result = mysqli_query($conn, $sql);
        // if ($result->num_rows > 0) {
        if (mysqli_num_rows($result) > 0) {
            echo "<ol>\n";
            // while ($row = $result->fetch_assoc()) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>".$row['Imie']." ".$row['Nazwisko']."</li>\n";
            }
            echo "</ol>\n";
        } else {
            echo "Nie ma klientów!";
        }

        // $conn->close();
        mysqli_close($conn);
    ?>
</body>
</html>