<?php

$conn = mysqli_connect("localhost","root","","5ti_gr1_mecze");

$selected_sedzia = NULL;
if (isset($_GET['sedzia']) && is_numeric(trim($_GET['sedzia']))) {
    $selected_sedzia = intval(trim($_GET['sedzia']));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,td,th {border: 1px solid black}
        .bokiem {
            writing-mode: vertical-lr;
            text-align: left;
            transform: rotate(-180deg);
        }

        tr:first-child {
            height:8em;
        }

        tr:hover {
            background-color: pink;
        }

        td:hover::after,th:hover::after {
            background-color: pink;
        }

        td {
            text-align: center;
        }

        .container {
            display: flex;
            align-items: flex-start;
        }

        .Mecze {
            display: flex;
            margin-left: 10rem;
            flex-direction: column;
            align-items: center;
        }

        .Mecze td {
            text-align: center;
            padding: 0.2rem;
        }

        .razem {
            padding: 0.4rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        $sql_s = "SELECT * from sedziowie";
        $result_s = mysqli_query($conn, $sql_s);
        echo "<table>\n";
        echo "<tr><td>Sędzia</td>";
        $sql_k = "SELECT nazwa FROM kluby ORDER BY nazwa";
        $result_k = mysqli_query($conn,$sql_k);
        while ($klub = mysqli_fetch_assoc($result_k)) {
            echo "<td class=\"bokiem\">".$klub['nazwa']."</td>";
        }
        echo "<td class=\"razem\">Razem</td>";
        echo "</tr>";
        while ($sedzia = mysqli_fetch_assoc($result_s)) {
            $id_sedziego = $sedzia['Id_sedziego'];
            echo "<tr><td><form><input type=\"hidden\" name=\"sedzia\" value=\"$id_sedziego\"><input type=\"submit\" value=\"".$sedzia['Imie']." ".$sedzia['Nazwisko']."\"></form></td>";
            $sql_k = "select id_klubu, count(id_sedziego) as ile\n"
            . "from kluby left join\n"
            . "(SELECT * from mecze where id_sedziego = $id_sedziego) as pom\n"
            . "using (id_klubu)\n"
            . "GROUP by Id_klubu ORDER BY nazwa;";
            $result_k = mysqli_query($conn,$sql_k);
            $ile = 0;
            while ($klub = mysqli_fetch_assoc($result_k)) {
                echo "<td>".$klub['ile']."</td>";
                $ile += intval($klub['ile']);
            }
            echo "<td>$ile</td>";
            echo "</tr>\n";
        }
        echo "</table>\n";
        ?>
        <?php
        if ($selected_sedzia) {
        ?>
        <div class="Mecze">
            <h1>Mecze sędziego</h1>
            <?php
                $sql = "SELECT CONCAT(sedziowie.Imie, \" \", sedziowie.Nazwisko) AS FULL_NAME FROM sedziowie WHERE sedziowie.Id_sedziego = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $selected_sedzia);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                echo "<h2>".$row['FULL_NAME']."</h2>";
            ?>
            <table>
                <tr>
                    <th>Klub</th>
                    <th>Termin</th>
                    <th>Wynik</th>
                </tr>
                <?php
                $sql = "SELECT mecze.Data, kluby.Nazwa, CONCAT(mecze.Sety_wygrane, \":\" , mecze.Sety_przegrane) AS wynik FROM mecze JOIN kluby USING(Id_klubu) WHERE mecze.Id_sedziego = ? ORDER BY mecze.Data DESC";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $selected_sedzia);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row['Nazwa']."</td>";
                    echo "<td>".$row['Data']."</td>";
                    echo "<td>".$row['wynik']."</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <?php
        }
        ?>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>