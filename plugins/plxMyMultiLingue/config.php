<?php if(!defined('PLX_ROOT')) exit; ?>
<?php

# Control du token du formulaire
plxToken::validateFormToken($_POST);

if(!empty($_POST)) {
	$plxPlugin->setParam('lang_images_folder', $_POST['lang_images_folder'], 'numeric');
	$plxPlugin->setParam('lang_documents_folder', $_POST['lang_documents_folder'], 'numeric');
	$plxPlugin->setParam('display', $_POST['display'], 'string');
	$plxPlugin->setParam('redirect_ident', $_POST['redirect_ident'], 'numeric');

	$plxPlugin->mkDirs();
	$plxPlugin->saveParams();
	# réinitialisation des variables de sessions dépendantes de la langues
	unset($_SESSION['lang']);
	unset($_SESSION['medias']);
	unset($_SESSION['folder']);
	header('Location: parametres_plugin.php?p=plxMyMultiLingue');
	exit;
}

$display = $plxPlugin->getParam('display')!='' ? $plxPlugin->getParam('display') : 'flag';
$redirect_ident = $plxPlugin->getParam('redirect_ident') == '' ? 0 : $plxPlugin->getParam('redirect_ident');

$lang_images_folder = $plxPlugin->getParam('lang_images_folder')=='' ? 0 : $plxPlugin->getParam('lang_images_folder');
$lang_documents_folder = $plxPlugin->getParam('lang_documents_folder')=='' ? 0 : $plxPlugin->getParam('lang_documents_folder');
?>
<h2><?php echo $plxPlugin->getInfo('title') ?></h2>

<form action="parametres_plugin.php?p=plxMyMultiLingue" method="post" id="form_langs">
	<fieldset>
		<p class="field"><label for="id_lang_images_folder"><?php echo $plxPlugin->lang('L_LANG_IMAGES_FOLDER') ?>&nbsp;:</label></p>
		<?php plxUtils::printSelect('lang_images_folder',array('1'=>L_YES,'0'=>L_NO),$lang_images_folder) ?>
		<p class="field"><label for="id_lang_documents_folder"><?php echo $plxPlugin->lang('L_LANG_DOCUMENTS_FOLDER') ?>&nbsp;:</label></p>
		<?php plxUtils::printSelect('lang_documents_folder',array('1'=>L_YES,'0'=>L_NO),$lang_documents_folder) ?>
		<p class="field"><label for="id_display"><?php echo $plxPlugin->lang('L_DISPLAY') ?>&nbsp;:</label></p>
		<?php plxUtils::printSelect('display',array('flag'=>$plxPlugin->getLang('L_FLAG'),'label'=>$plxPlugin->getLang('L_LABEL')),$display) ?>
		<p class="field"><label for="id_redirect_ident"><?php echo $plxPlugin->lang('L_REDIRECT_IDENT') ?>&nbsp;:</label></p>
		<?php plxUtils::printSelect('redirect_ident',array('1'=>L_YES,'0'=>L_NO),$redirect_ident) ?>
	</fieldset>
	<fieldset>
		<p>
			<?php echo plxToken::getTokenPostMethod() ?>
			<input type="submit" name="submit" value="<?php $plxPlugin->lang('L_SAVE') ?>" />
		</p>
	</fieldset>
</form>
