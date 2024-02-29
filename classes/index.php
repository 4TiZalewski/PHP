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
    <?php

    class Dog {
        public $imie;
        public $rasa;

        public function woof(Dog &$other) {
            echo "Jestem $this->imie rasy $this->rasa i szczekam: Hau! Hau! na $other->imie<br>";
        }

        public function __construct(string $imie, string $rasa) {
            $this->imie = $imie;
            $this->rasa = $rasa;
        }

        public function __destruct() {
            echo "Usuwam obiekt Dog o imieniu: $this->imie<br>";
        }

        public function __toString() {
            return "{ $this->imie razy $this->rasa }<br>";
        }
    }

    $p = new Dog("Azor", "Pudel");
    $p2 = new Dog("Monika", "now");
    
    $p->woof($p2);
    $p2->woof($p);

    $p3 = clone $p;
    $p3->imie = "Reksio";

    $p->woof($p2);

    var_dump($p);
    echo $p;

    unset($p);

    class Car {
        public string $marka;
        public string $model;
        public int $przebieg;

        public function drive(int $ile) {
            $this->przebieg += $ile;
            echo "Wroom, wroom<br>";
        }

        public function __construct(string $marka, string $model) {
            $this->marka = $marka;
            $this->model = $model;
            $this->przebieg = 0;
        }

        public function __destruct() {
            echo "Usuwanie samochodu marki $this->marka model $this->model<br>";
        }

        public function __toString() {
            return "{ Samochód marki $this->marka modelu $this->model }<br>";
        }
    };

    $car = new Car("Mercedes", "56V");
    $car->drive(5);

    $car2 = clone $car;
    $car2->model = "60V";
    $car2->drive(10);

    echo $car;
    echo $car2;

    ?>
</body>
</html>