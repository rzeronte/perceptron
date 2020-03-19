<?php
error_reporting(E_ERROR | E_PARSE);

require "Perceptron.php";
require "tools.php";

$width = $height = 20;
$fonts = getFonts();
$p = new Perceptron($width*$height);

$i = 0; $times = 50000;

while ($i < $times) {
    if (rand(1, 100) < 25) {
        $num = 1;
    } else {
        $num = rand(2, 9);
    }

    echo "Iteracción $i de $max para sample '$num' -> result: ". (($num == 1) ? "TRUE":"FALSE") . " Error: ".$p->getIterationError(). PHP_EOL;

    $img = createSampleRandomFront($num, $fonts, $width, $height);

    if ($img !== false) {
        $input = processPixelImage($img, $width, $height);
        if ($input !== false) {
            $output = ($num == 1) ? 1 : 0;
            $p->train($input, $output);
        }
    }
    $i++;
}


echo PHP_EOL."Entrenado para $i casos.".PHP_EOL;

$tests = 100; $ok = $ko = 0;

echo "Resultado para $tests pruebas";
for ($i = 0; $i <= $tests; $i++) {
    if (rand(1, 100) < 25) {
        $test = 1;
    } else {
        $test = rand(2, 9);
    }

    $img = createSampleRandomFront($test, $fonts, $width, $height);
    $dataImg = processPixelImage($img, $width, $height);
    $result = $p->test($dataImg);

    if ($test == 1 && $result) {
        $ok++;
    } else {
        $ko++;
    }
    echo PHP_EOL."Prueba sample '$test' -> " . ( $result ? "TRUE":"FALSE" );
    //viewMatrixSample($width, $height, $img);
}

echo PHP_EOL. " " . $ko . " aciertos de " . $tests . " pruebas";