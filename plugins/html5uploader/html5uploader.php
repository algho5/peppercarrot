<?php

if (!defined('PLX_ROOT')) exit;

class html5uploader extends plxPlugin {

	private $scriptname = '';

	public function __construct($default_lang) {
		# appel du constructeur de la classe plxPlugin (obligatoire)
		
		parent::__construct($default_lang);

		# droits pour accéder à la page config.php du plugin
		$this->setConfigProfil(PROFIL_ADMIN);

		$this->addHook('AdminTopEndHead', 'AdminTopEndHead');
		$this->addHook('AdminMediasFoot', 'AdminMediasFoot');
	}

	private function pluginRoot() {
		// toujours utilisé dans le back-office
		global $plxAdmin;
		if (isset($plxAdmin)) {
			return $plxAdmin->racine.$plxAdmin->aConf['racine_plugins'].__CLASS__.'/';
		} else {
			return false;
		}
	}

	public function AdminTopEndHead($params) {
		global $plxMedias;
		
		if (isset($plxMedias)) {
			global $plxAdmin, $folderMedias;

			// We have $_SESSION['folder'] and we have to add this $_SESSION
			if($plxAdmin->aConf['userfolders'] AND $_SESSION['profil']==PROFIL_WRITER)
				$folderMedias = $_SESSION['user'].'/'.$_SESSION['folder'];
			else
				$folderMedias = $_SESSION['folder'];			
			$_SESSION['uploader_root'] = PLX_ROOT;
			$_SESSION['uploader_racine'] = $plxAdmin->racine;
			$_SESSION['uploader_lang'] = $plxAdmin->aConf['default_lang'];
			$_SESSION['uploader_folderMedias'] = $folderMedias;
?>
	<script type="text/javascript" src="<?php echo $this->pluginRoot().__CLASS__; ?>.js"></script>
<?php	}
	}

	private function getNumber($aString) {
		$aString = trim($aString);
		$value = intval($aString);
		$unit = strtoupper(substr($aString, -1));
		switch ($unit) {
			case 'G' :
				$value *= 1024;
			case 'M' :
				$value *= 1024;
			case 'K' :
				$value *= 1024;
		}
		return $value;
	}

	public function AdminMediasFoot($params) {
		$max_file_uploads = ini_get('max_file_uploads');
		$upload_max_filesize = ini_get('upload_max_filesize');
		$post_max_size = ini_get('post_max_size'); ?>
		<p id="progressBar">&nbsp;</p>
		<script type="text/javascript">
			var dropZone = addDepositFiles('medias-table');
			if (dropZone) {
				var	max_file_uploads = '<?php echo $max_file_uploads; ?>',
					upload_max_filesize = '<?php echo $this->getNumber($upload_max_filesize); ?>',
					post_max_size = '<?php echo $this->getNumber($post_max_size); ?>',
					// some messages for the WorldWide ...
					max_file_uploadsWarn = '<?php $this->lang('L_DND_DROP_MAX_FILE_UPLOADS_WARN'); ?>',
					upload_max_filesizeWarn = '<?php $this->lang('L_DND_DROP_UPLOAD_MAX_FILESIZE_WARN'); ?>',
					post_max_sizeWarn = '<?php $this->lang('L_DND_DROP_POST_MAX_SIZE_WARN'); ?>',
					Kbytes = '<?php $this->lang('L_DND_DROP_KBYTES'); ?>',
					post_is_doneMsg = '<?php $this->lang('L_DND_DROP_POST_IS_DONE_MSG'); ?>';
				uploader(dropZone, '<?php echo $this->pluginRoot(); ?>uploader.php', 'form_uploader', 'uploaderInfo'); // register.php | uploader.php
				var isJSON = <?php echo (function_exists('json_encode')) ? 'true' : 'false'; // requires php version >= 5.2 ?>;
			}
			else
				console.log('DropZone is missing.');
		</script>
<?php	
	}

}
?>
