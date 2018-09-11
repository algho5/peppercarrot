<?php
# ------------------ BEGIN LICENSE BLOCK ------------------
#
# This file is part of PluXml : http://www.pluxml.org
#
# Copyright (c) 2010-2013 Stephane Ferrari and contributors
# Copyright (c) 2008-2009 Florent MONTHEL and contributors
# Copyright (c) 2006-2008 Anthony GUERIN
# Licensed under the GPL license.
# See http://www.gnu.org/licenses/gpl.html
#
# ------------------- END LICENSE BLOCK -------------------

define('PLX_ROOT', './');
define('PLX_CORE', PLX_ROOT.'core/');
include(PLX_ROOT.'config.php');
include(PLX_CORE.'lib/config.php');
include(PLX_ROOT.'plugins/cache.php');

session_start();
# Start cache if not on localhost
if (strpos($_SERVER['SERVER_NAME'], "localhost") === false){
  cache_starthook();
}


# On verifie que PluXml est installé
if(!file_exists(path('XMLFILE_PARAMETERS'))) {
	header('Location: '.PLX_ROOT.'install.php');
	exit;
}

# On inclut les librairies nécessaires
include(PLX_CORE.'lib/class.plx.date.php');
include(PLX_CORE.'lib/class.plx.glob.php');
include(PLX_CORE.'lib/class.plx.utils.php');
include(PLX_CORE.'lib/class.plx.capcha.php');
include(PLX_CORE.'lib/class.plx.erreur.php');
include(PLX_CORE.'lib/class.plx.record.php');
include(PLX_CORE.'lib/class.plx.motor.php');
include(PLX_CORE.'lib/class.plx.feed.php');
include(PLX_CORE.'lib/class.plx.show.php');
include(PLX_CORE.'lib/class.plx.encrypt.php');
include(PLX_CORE.'lib/class.plx.plugins.php');

# Creation de l'objet principal et lancement du traitement
$plxMotor = plxMotor::getInstance();

# Hook Plugins
eval($plxMotor->plxPlugins->callHook('Index'));

$plxMotor->prechauffage();
$plxMotor->demarrage();

# Creation de l'objet d'affichage
$plxShow = plxShow::getInstance();

eval($plxMotor->plxPlugins->callHook('IndexBegin'));

# On démarre la bufferisation
ob_start();
ob_implicit_flush(0);

# Traitements du thème
if($plxMotor->style == '' or !is_dir(PLX_ROOT.$plxMotor->aConf['racine_themes'].$plxMotor->style)) {
	header('Content-Type: text/plain');
	echo L_ERR_THEME_NOTFOUND.' ('.PLX_ROOT.$plxMotor->aConf['racine_themes'].$plxMotor->style.') !';
} elseif(file_exists(PLX_ROOT.$plxMotor->aConf['racine_themes'].$plxMotor->style.'/'.$plxMotor->template)) {
	# On impose le charset
	header('Content-Type: text/html; charset='.PLX_CHARSET);
	# Insertion du template
	include(PLX_ROOT.$plxMotor->aConf['racine_themes'].$plxMotor->style.'/'.$plxMotor->template);
} else {
	header('Content-Type: text/plain');
	echo L_ERR_FILE_NOTFOUND.' ('.PLX_ROOT.$plxMotor->aConf['racine_themes'].$plxMotor->style.'/'.$plxMotor->template.') !';
}

# Récuperation de la bufférisation
$output = ob_get_clean();

# Hooks spécifiques au thème
ob_start();
eval($plxMotor->plxPlugins->callHook('ThemeEndHead'));
$output = str_replace('</head>', ob_get_clean().'</head>', $output);
ob_start();
eval($plxMotor->plxPlugins->callHook('ThemeEndBody'));
$output = str_replace('</body>', ob_get_clean().'</body>', $output);

# Hook Plugins
eval($plxMotor->plxPlugins->callHook('IndexEnd'));

# On applique la réécriture d'url si nécessaire
if($plxMotor->aConf['urlrewriting']) {
	$output = plxUtils::rel2abs($plxMotor->aConf['racine'], $output);
}

if (strpos($_SERVER['SERVER_NAME'], "localhost") === false){
  cache_endhook($output);
}

# Restitution écran
echo $output;
exit;
?>
