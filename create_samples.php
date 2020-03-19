<?php

$Directory = new RecursiveDirectoryIterator('.');
$Iterator = new RecursiveIteratorIterator($Directory);
$Regex = new RegexIterator($Iterator, '/^.+(.ttf)$/i', RecursiveRegexIterator::GET_MATCH);

$max = 99999999;
$i = 0;

foreach($Regex as $font => $Regex) {
    // Creamos samples por carpetas con el número
    for ( $j = 0; $j<= 9; $j++ ) {
        try {
            createSamplePNG($j, $font);
        } catch(Exception $e) {
            echo "Error con $font".PHP_EOL;
        }
    }
    $i++;
}
