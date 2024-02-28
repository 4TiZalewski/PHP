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

    class Dog {
        public $imie;
        public $rasa;

        public function woof(Dog &$other) {
            echo "Jestem $this->imie rasy $this->rasa i szczekam: Hau! Hau! na $other->imie\n";
        }

        public function __construct(string $imie, string $rasa) {
            $this->imie = $imie;
            $this->rasa = $rasa;
        }
    }

    $p = new Dog("Azor", "Pudel");
    $p2 = new Dog("Monika", "now");
    
    $p->woof($p2);
    $p2->woof($p);

    var_dump($p);

    class Car {
        public string $name;
        public int $przebieg = 0;

        public function drive(int $ile) {
            $this->$przebieg += $ile;
            echo "Wroom, wroom";
        }

        public function __construct(string $name) {
            $this->name = $name;
        }

        public function who_are_you() {
            echo "Jestem samochód $this->name i mam przebieg $this->przebieg";
        }
    };

    $car = new Car("Samochod");

    $car->drive(5);

    ?>
    </div> 
</body>
</html>
<?php

?>