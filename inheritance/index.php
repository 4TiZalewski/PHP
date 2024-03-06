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

    class Zwierze {
        private $masa = 10;
        public function daj_glos() {
            echo "Jestem zwierzęciem o masie $this->masa kg i daje głos.<br>";
        }

        public function get_masa() {
            return $this->masa;
        }

        public function __construct($masa) {
            $this->masa = $masa;
        }
    }

    class Pies extends Zwierze {
        private $rasa = "kundel";

        public function daj_glos() {
            echo "Jestem psem rasy $this->rasa, o masie".$this->get_masa()."kg i szczekam Hau! Hau!<br>";
        }

        public function __construct($masa, $rasa) {
            parent::__construct($masa);
            $this->rasa = $rasa;
        }
    }

    class Kot extends Zwierze {
        private $rasa = "dachowiec";
        private $wiek = 0;

        public function daj_glos() {
            echo "Jestem kotem rasy $this->masa o masie ".$this->get_masa()."kg, który ma $this->wiek lat i miauczę miau! miau!<br>";
        }

        public function __construct($masa, $rasa, $wiek) {
            parent::__construct($masa);
            $this->rasa = $rasa;
            $this->wiek = $wiek;
        }
    }

    $a = [];
    $a[] = new Zwierze(15);

    ?>
</body>
</html>
<?php



?>