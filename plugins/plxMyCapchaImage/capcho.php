<?php

session_start();

# Chemin absolu vers le dossier
if (!defined('ABSPATH')) define('ABSPATH', dirname(__FILE__).'/');

# tableau contenant les fontes disponibles
$fonts=array();
if ($dh = opendir(ABSPATH.'lib')) {
	while (($file = readdir($dh)) !== false) {
		if(strtolower(strrchr($file,'.'))=='.ttf')
			$fonts[] = ABSPATH.'lib/'.$file;
	}
	closedir($dh);
}

# tableau contenant les fonds d'images pour le capcha
$images=array();
if ($dh = opendir(ABSPATH.'lib')) {
	while (($file = readdir($dh)) !== false) {
		if(strtolower(strrchr($file,'.'))=='.png')
			$images[] = ABSPATH.'lib/'.$file;
	}
	closedir($dh);
}

# Création de l'image de fond du capcha
$image = imagecreatefrompng($images[array_rand($images)]);

# tableau des couleurs pour les lettres. imagecolorallocate() retourne un identifiant de couleur.
$colors=array(
	imagecolorallocate($image, 255,255,255)
);

# Retourne de façon aléatoire une donnée d'un tableau
function random($tab) {
	return $tab[array_rand($tab)];
}

# récupération du code du capcha en variable de session
$theCode = $_SESSION['capcha'];

# imagettftext(image, taille police, angle inclinaison, coordonnée X, coordonnée Y, couleur, police, texte) écrit le texte sur l'image.
imagettftext($image, 28, rand(-5, 10),  5,  37, random($colors), random($fonts), substr($theCode,0,1));
imagettftext($image, 28, rand(-10, 5), 37,  37, random($colors), random($fonts), substr($theCode,1,1));
imagettftext($image, 28, rand(-5, 10), 60,  37, random($colors), random($fonts), substr($theCode,2,1));
imagettftext($image, 28, rand(-10, 5), 86, 37, random($colors), random($fonts), substr($theCode,3,1));
# last number is a fake
$fake = rand(1,9);
imagettftext($image, 28, rand(-6, 13), 115, 37, random($colors), random($fonts), $fake);

# Envoi de l'image
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
exit;
?>
