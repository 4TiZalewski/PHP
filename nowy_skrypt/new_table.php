<?php
if (
    !isset($_GET['name']) || 
    trim($_GET['name']) == "" ||
    !isset($_GET['number_of_column']) ||
    !is_numeric($_GET['number_of_column'])
) {
    header("Location: index.html");
    die();
}

$name = trim($_GET['name']);
$number_of_column = intval($_GET['number_of_column']);

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form action="execute.php">
            <?php
            for ($i = 0; $i < $number_of_column; $i++) {
                echo "<div>";
                echo "<label for=\"name_row_$i\">";
                echo "Nazwa";
                echo "<input type=\"text\" name=\"name_row_$i\" id=\"name_row_$i\" required>";
                echo "</label>";
                echo "<label for=\"type_row_$i\">";
                echo "Typ";
                echo "<select name=\"type_row_$i\" id=\"type_row_$i\">";
                echo "<option value=\"0\">INT</option>";
                echo "<option value=\"1\">TEXT</option>";
                echo "</select>";
                echo "</label>";
                echo "</div>";
            }
            echo "<input type=\"text\" value=\"$name\" name=\"table_name\" hidden>";
            ?>
            <input type="submit" value="Wykonaj">
        </form>
    </div>
</body>
</html>