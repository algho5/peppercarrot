<?php
/**
 * Plugin linkMyComments
 *
 * Based on code of FluxBB
 * Copyright (C) 2008-2012 FluxBB
 * based on code by Rickard Andersson copyright (C) 2002-2008 PunBB
 * License: http://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 *
 *
 * @package	PLX
 * @version	1.0
 * @date	14/01/2014
 * @author	Cyril MAGUIRE
 **/
include 'functions.php';
class linkMyComments extends plxPlugin {

	/**
	 * Constructeur de la classe inMyPluxml
	 *
	 * @param	default_lang	langue par défaut utilisée par PluXml
	 * @return	null
	 * @author	Stephane F
	 **/
	public function __construct($default_lang) {

		# Appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);

		# Déclarations des hooks		
		$this->addHook('plxMotorParseCommentaire', 'plxMotorParseCommentaire');
	}
	public function __do_clickable($text) {
		return do_clickable($text);
	}
	public function plxMotorParseCommentaire() {
		$string = '
		$com[\'content\'] = $this->plxPlugins->aPlugins[\'linkMyComments\']->__do_clickable($com[\'content\']);
		';
		echo "<?php ".$string."?>";
	}
}
?>