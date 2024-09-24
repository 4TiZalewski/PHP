<?php
if (
    !isset($_GET['table_name']) || 
    trim($_GET['table_name']) == ""
) {
    header("Location: index.html");
    die();
}

$table_name = trim($_GET['table_name']);
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
        <?php
        $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (";
        $i = 0;
        while (isset($_GET["name_row_$i"]) && isset($_GET["type_row_$i"])) {
            $name = trim($_GET["name_row_$i"]);
            $type_id = intval(trim($_GET["type_row_$i"]));
            $type = "";
            switch ($type_id) {
                case 0:
                    $type = "INT";
                    break;
                case 1:
                    $type = "TEXT";
                    break;
                default:
                    header("Location: index.html");
                    die();
            }

            $sql .= "`$name` $type,";
            $i++;
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        $sql .= ");";
        echo $sql;
        ?>
    </div>
</body>
</html>