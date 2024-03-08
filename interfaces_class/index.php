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

    interface Plywajace {
        public function plyn(): void;
    }

    class Pojazd {
        public function jedz(): void {
            echo "Pojazd jedzie.<br>";
        }
    }

    class Amfibia extends Pojazd implements Plywajace {
        public function jedz(): void {
            echo "Amfibia jedzie.<br>";
        }

        public function plyn(): void {
            echo "Amfibia płynie.<br>";
        }
    }

    $a = new Amfibia;
    $a->jedz();
    $a->plyn();

    interface Latajace {
        public function lec():void ;
    }

    class Ptak {
        public function oddychaj(): void {
            echo "Ptak oddycha.<br>";
        }
    }

    class Pingwin extends Ptak implements Plywajace {
        public function oddychaj(): void {
            echo "Pingwin oddycha.<br>";
        }

        public function plyn(): void {
            echo "Pingwin plywa.<br>";
        }
    }

    class Wrobel extends Ptak implements Latajace {
        public function oddychaj(): void {
            echo "Wróbel oddycha.<br>";
        }

        public function lec(): void {
            echo "Wróbel lata.<br>";
        }
    }

    $p = new Pingwin;
    $p->oddychaj();
    $p->plyn();

    $w = new Wrobel;
    $w->oddychaj();
    $w->lec();

    class Hydroplan implements Plywajace, Latajace {
        public function plyn(): void {
            echo "Hydroplan plynie.<br>";
        }

        public function lec(): void {
            echo "Hydroplan lata.<br>";
        }
    }

    $h = new Hydroplan;
    $h->plyn();
    $h->lec();

    ?>
    </div> 
</body>
</html>
<?php



?>