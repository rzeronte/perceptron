<?php

require "tools.php";

$dataTest = processPixelImage("3.png");

$cont = 0;
for ($i = 0; $i<= count($dataTest); $i++) {
    echo  ($dataTest[$i] == 1) ? ".": " ";
    $cont++;
    if ($cont == 24) {
        echo PHP_EOL;
        $cont = 0;
    }

}