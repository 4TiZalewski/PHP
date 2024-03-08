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

    abstract class C { // -> Musi być rozszerzone (Nie można stworzyć instancję)
        protected int $x = 1;

        public function __construct(int $x) {
            $this->x = $x;
        }

        abstract public function test(); // -> Musi być override. Nie może mieć "ciała"
    }

    class D extends C {
        private $y = 1;

        public function __construct($x, $y) {
            parent::__construct($x);
            $this->y = $y;
        }

        public function test() {
            echo "Test z klasy D. x=$this->x, y=$this->y<br>";
        }
    }

    $c = new D(5, 7);
    $c->test();

    abstract class Figura {
        abstract public function pole();
        abstract public function obwod();
        protected function toString(array $data): string {
            $result = "{[";
            foreach ($data as $item) {
                $result .= $item.", ";
            }

            $result = substr_replace($result, "", -2, 2);

            $result .= "]p=".$this->pole().",ob=".$this->obwod()."}";
            return $result;
        }
    }

    class Prostokat extends Figura {
        protected int $a, $b;

        public function __construct(int $a, int $b) {
            $this->a = $a;
            $this->b = $b;
        }

        public function pole() {
            return $this->a * $this->b;
        }

        public function obwod() {
            return $this->a * 2 + $this->b * 2;
        }

        public function __toString() {
            return $this->toString([$this->a, $this->b]);
        }
    }

    class Kolo extends Figura {
        private $r;

        public function __construct(int $r) {
            $this->r = $r;
        }

        public function pole() {
            return pi() * $this->r ** 2;
        }

        public function obwod() {
            return 2 * pi() * $this->r;
        }

        public function __toString() {
            return $this->toString([$this->r]);
        }
    }

    class Kwadrat extends Prostokat {
        public function __construct(int $a) {
            parent::__construct($a, $a);
        }
        
        public function __toString() {
            return $this->toString([$this->a]);
        }
    }

    $p = new Prostokat(3, 4);
    echo $p."<br>";

    $k = new Kolo(10);
    echo $k."<br>";

    $kw = new Kwadrat(5);
    echo $kw."<br>";

    ?>
    </div> 
</body>
</html>
<?php



?>