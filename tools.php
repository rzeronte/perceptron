<?php



function processPixelImage($im, $width, $height)
{
    $image_linear = [];

    for($x=0;$x<$width;$x++) {
        for($y=0;$y<$height;$y++) {
            $rgb = imagecolorat($im, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            //echo "R: $r, G:, $g, B: $b".PHP_EOL;
            if ($r == 255 && $g == 255 && $b == 255) {
                $image_linear[] = 0;
            } else {
                $image_linear[] = 1;
            }
        }
    }

    return $image_linear;
}

function processPixelImageFile($src)
{
    $im     = imagecreatefrompng($src);
    $size   = getimagesize($src);
    $width  = $size[0];
    $height = $size[1];
    $image_linear = [];

    for($x=0;$x<$width;$x++) {
        for($y=0;$y<$height;$y++) {
            $rgb = imagecolorat($im, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            //echo "R: $r, G:, $g, B: $b".PHP_EOL;
            if ($r == 255 && $g == 255 && $b == 255) {
                $image_linear[] = 0;
            } else {
                $image_linear[] = 1;
            }
        }
    }

    return $image_linear;
}

function createSamplePNG($character, $fontName, $width, $height)
{
    // Crear la imagen
    $im = imagecreatetruecolor($width, $height);

    // Crear algunos colores
    $blanco = imagecolorallocate($im, 255, 255, 255);
    $gris = imagecolorallocate($im, 128, 128, 128);
    $negro = imagecolorallocate($im, 0, 0, 0);
    imagefilledrectangle($im, 0, 0, $height, $height, $blanco);

    // El texto a dibujar
    $texto = $character;
    // Reemplace la ruta por la de su propia fuente
    $fuente = $fontName;

    // Añadir el texto
    imagettftext($im, 20, 0, 0, $height, $negro, $fuente, $texto);

    return $im;
}

function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function createSampleRandomFront($character, $fonts, $width, $height)
{
    $randomFont = rand(0, count($fonts)-1);
    $font = $fonts[$randomFont];

    $image = createSamplePNG($character, $font, $width, $height);
    if ($image == false) {
        echo "Error en la imagen";
    }
    return $image;
}

function viewMatrixSample($w, $h, $im)
{
    echo PHP_EOL."Matrix sample:".PHP_EOL;
    $dataTest = processPixelImage($im, $w, $h);

    $cont = 0;
    for ($i = 0; $i<= count($dataTest)-1; $i++) {
        echo  ($dataTest[$i] == 1) ? "1": "0";
        $cont++;
        if ($cont == $w) {
            echo PHP_EOL;
            $cont = 0;
        }
    }

    echo PHP_EOL."end matrix".PHP_EOL;
}

function getFonts()
{
    $Directory = new RecursiveDirectoryIterator('.');
    $Iterator = new RecursiveIteratorIterator($Directory);
    $Regex = new RegexIterator($Iterator, '/^.+(.ttf)$/i', RecursiveRegexIterator::GET_MATCH);

    $fonts = [];
    foreach($Regex as $font => $Regex) {
        $fonts[] = $font;
    }

    return $fonts;
}