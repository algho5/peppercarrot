<?php

session_start();

# Chemin absolu vers le dossier
if (!defined('ABSPATH')) define('ABSPATH', dirname(__FILE__).'/');

# tableau contenant les fontes disponibles
$fonts=array();
if ($dh = opendir(ABSPATH.'fonts')) {
	while (($file = readdir($dh)) !== false) {
		if(strtolower(strrchr($file,'.'))=='.ttf')
			$fonts[] = ABSPATH.'fonts/'.$file;
	}
	closedir($dh);
}

# tableau contenant les fonds d'images pour le capcha
$images=array();
if ($dh = opendir(ABSPATH.'images')) {
	while (($file = readdir($dh)) !== false) {
		if(strtolower(strrchr($file,'.'))=='.png')
			$images[] = ABSPATH.'images/'.$file;
	}
	closedir($dh);
}

# libs to convert rgb2hsl (source: https://stackoverflow.com/questions/1890409/change-hue-of-an-image-with-php-gd-library)
function rgb2hsl($r, $g, $b) {
   $var_R = ($r / 255);
   $var_G = ($g / 255);
   $var_B = ($b / 255);

   $var_Min = min($var_R, $var_G, $var_B);
   $var_Max = max($var_R, $var_G, $var_B);
   $del_Max = $var_Max - $var_Min;

   $v = $var_Max;

   if ($del_Max == 0) {
      $h = 0;
      $s = 0;
   } else {
      $s = $del_Max / $var_Max;

      $del_R = ( ( ( $var_Max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
      $del_G = ( ( ( $var_Max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
      $del_B = ( ( ( $var_Max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

      if      ($var_R == $var_Max) $h = $del_B - $del_G;
      else if ($var_G == $var_Max) $h = ( 1 / 3 ) + $del_R - $del_B;
      else if ($var_B == $var_Max) $h = ( 2 / 3 ) + $del_G - $del_R;

      if ($h < 0) $h++;
      if ($h > 1) $h--;
   }

   return array($h, $s, $v);
}

# libs to convert hsl2rgb (source: https://stackoverflow.com/questions/1890409/change-hue-of-an-image-with-php-gd-library)
function hsl2rgb($h, $s, $v) {
    if($s == 0) {
        $r = $g = $B = $v * 255;
    } else {
        $var_H = $h * 6;
        $var_i = floor( $var_H );
        $var_1 = $v * ( 1 - $s );
        $var_2 = $v * ( 1 - $s * ( $var_H - $var_i ) );
        $var_3 = $v * ( 1 - $s * (1 - ( $var_H - $var_i ) ) );

        if       ($var_i == 0) { $var_R = $v     ; $var_G = $var_3  ; $var_B = $var_1 ; }
        else if  ($var_i == 1) { $var_R = $var_2 ; $var_G = $v      ; $var_B = $var_1 ; }
        else if  ($var_i == 2) { $var_R = $var_1 ; $var_G = $v      ; $var_B = $var_3 ; }
        else if  ($var_i == 3) { $var_R = $var_1 ; $var_G = $var_2  ; $var_B = $v     ; }
        else if  ($var_i == 4) { $var_R = $var_3 ; $var_G = $var_1  ; $var_B = $v     ; }
        else                   { $var_R = $v     ; $var_G = $var_1  ; $var_B = $var_2 ; }

        $r = $var_R * 255;
        $g = $var_G * 255;
        $B = $var_B * 255;
    }    
    return array($r, $g, $B);
}

# libs to switch hue (source: https://stackoverflow.com/questions/1890409/change-hue-of-an-image-with-php-gd-library)
function imagehue(&$image, $angle) {
    if($angle % 360 == 0) return;
    $width = imagesx($image);
    $height = imagesy($image);

    for($x = 0; $x < $width; $x++) {
        for($y = 0; $y < $height; $y++) {
            $rgb = imagecolorat($image, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;            
            $alpha = ($rgb & 0x7F000000) >> 24;
            list($h, $s, $l) = rgb2hsl($r, $g, $b);
            $h += $angle / 360;
            if($h > 1) $h--;
            list($r, $g, $b) = hsl2rgb($h, $s, $l);            
            imagesetpixel($image, $x, $y, imagecolorallocatealpha($image, $r, $g, $b, $alpha));
        }
    }
}

# Création de l'image de fond du capcha
$image = imagecreatefrompng($images[array_rand($images)]);

# tableau des couleurs pour les lettres. imagecolorallocate() retourne un identifiant de couleur.
$colors=array(
	imagecolorallocate($image, 0,154,255), # cyan bright blue, water
	imagecolorallocate($image, 159,120,130), # greyish pink, red fishes
	imagecolorallocate($image, 0,153,172), # Teal, algua bright
	imagecolorallocate($image, 0,128,234), # primary blue, deep
	imagecolorallocate($image, 0,123,123) # dark green, algua dark
);

# Retourne de façon aléatoire une donnée d'un tableau
function random($tab) {
	return $tab[array_rand($tab)];
}

# récupération du code du capcha en variable de session
$theCode = $_SESSION['capcha'];

# imagettftext(image, taille police, angle inclinaison, coordonnée X, coordonnée Y, couleur, police, texte) écrit le texte sur l'image.
imagettftext($image, 28, rand(-5, 10),  5,  37, random($colors), random($fonts), substr($theCode,0,1));
imagettftext($image, 28, rand(-13, 8), 37,  37, random($colors), random($fonts), substr($theCode,1,1));
imagettftext($image, 28, rand(-8, 13), 60,  37, random($colors), random($fonts), substr($theCode,2,1));
imagettftext($image, 28, rand(-13, 8), 86, 37, random($colors), random($fonts), substr($theCode,3,1));
# last number is a fake
$fake = rand(1,9);
imagettftext($image, 28, rand(-6, 13), 115, 37, random($colors), random($fonts), $fake);

# Envoi de l'image
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
imagehue($image, rand(0, 20));

// Add some noise to the image (source: https://perials.com/tutorial-creating-image-captcha-php-using-gd-library/)
$width = 150;
$height = 50;
$noise_level = 30;
$noise_color = random($colors);
for ($i = 0; $i < $noise_level; $i++) {
	for ($j = 0; $j < $noise_level; $j++) {
		imagesetpixel(
			$image,
			rand(0, $width), 
			rand(0, $height),//make sure the pixels are random and don't overflow out of the image
			$noise_color
		);
	}
}

imagepng($image);
imagedestroy($image);
exit;
?>
