<?php

$mode = 0;

if (
    true
) {
    $mode = 1;
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
    </style>
</head>
<body>
    <div class="container">
    <?php

    class A {
        private readonly int $id;
        public int $x = 0;
        static public int $y = 0;
        static public int $instances = 0;
        static private int $s_last_used_id = 0;

        public function __construct(int $x, int $y) {
            $this->id = self::$s_last_used_id += 1;

            $this->x = $x;
            self::$y = $y;
            self::$instances += 1;
        }

        public function __destruct() {
            self::$instances -= 1;
        }

        public function __toString() {
            $y = self::$y;
            $instances = self::$instances;
            return "#$this->id{ x = $this->x, y = $y, [liczba instancji: $instances ] }<br>";
        }

        static public function fun() {
            echo "#$this->id{ y = $y }<br>";
        }
    }

    $a = new A(3, 4);
    echo $a; // x = 3, y = 4

    // echo $a->y;
    // echo A::$y;

    $b = new A(5, 6);
    echo $b; // x = 5, y = 6

    unset($b);

    echo $a; // x = 3, y = 6

    $c = new A(7, 9);

    echo $c;

    ?>
    </div> 
</body>
</html>
<?php



?>