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

    /* final */ class A { // -> brak mozliwosci extend
        protected int $x;

        public function __construct(int $x) {
            $this->x = $x;
        }

        public function __toString() {
            return "[$this->x]<br>";
        }

        public /* final */ function test() { // -> brak mozliwosci override
            echo "Test z klasy A <br>";
        }
    }

    class B extends A {
        private int $y;

        public function __construct($x, $y) {
            parent::__construct($x);
            $this->y = $y;
        }

        public function __toString() {
            return "[$this->x, $this->y]<br>";
        }

        public function test() {
            echo "Test z klasy B <br>";
        }
    }

    $b = new B(5, 6);
    echo $b;
    $b->test();

    ?>
    </div> 
</body>
</html>
<?php



?>