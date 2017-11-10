<?php

if (empty($_POST)) exit;

session_start();

define('PLX_ROOT', $_SESSION['uploader_root']);
include(PLX_ROOT.'config.php'); // défini PLX_CONFIG_PATH

$lang = $_SESSION['uploader_lang'];
if (defined('PLX_LIB')) {
	include(PLX_LIB.'config.php');
	include_once(PLX_LIB.'class.plx.date.php');
	include_once(PLX_LIB.'class.plx.utils.php');
	include_once(PLX_LIB.'class.plx.msg.php'); // request by plxMedias for displaying error
	include_once(PLX_LIB.'class.plx.medias.php');
	loadLang(PLX_LIB.'lang/'.$lang.'/admin.php');
} else {
	define('PLX_CORE', PLX_ROOT.'core/');
	include(PLX_CORE.'lib/config.php'); //
	include_once(PLX_CORE.'lib/class.plx.date.php');
	include_once(PLX_CORE.'lib/class.plx.utils.php');
	include_once(PLX_CORE.'lib/class.plx.msg.php'); // request by plxMedias for displaying error
	include_once(PLX_CORE.'lib/class.plx.medias.php');
	loadLang(PLX_CORE.'lang/'.$lang.'/admin.php'); // maybe core.php
}

class plxMediasMulti extends plxMedias {

	// It's the same function as _getDirFiles but this last one is a private function. Shit !!
	protected function getDirFiles($dir) {

		# Initialisation
		$files = array();
		# Ouverture et lecture du dossier demandé
		if ($handle = opendir($this->path.$dir)) {
			while (FALSE !== ($file = readdir($handle))) {
				if (($file[0] != '.') AND !preg_match('/index\.htm/i', $file) AND !preg_match('/\.tb\.[a-z]+$/D', $file)) {
                    $absName = $this->path.$dir.$file;
					if (is_file($absName)) {
                        $thumName = plxUtils::thumbName($file);
						$ext = strtolower(strrchr($file,'.'));
						$thumb_name = '.thumbs/'.$dir.$file;
						if (! file_exists($this->path.$thumb_name))
							$_thumb1 = plxUtils::makeThumb($absName, $this->path.$thumb_name, $this->thumbWidth, $this->thumbHeight, $this->thumbQuality);
						else
							$_thumb1 = true;
						$absThumbName = $this->path.$dir.$thumName;
						if (is_file($absThumbName))
							$_thumb2 = array(
								'infos' => getimagesize($absThumbName),
								'filesize'	=> filesize($absThumbName)
							);
                        else
                            $_thumb2 = false;
						$files[$file] = array(
							'.thumb'	=> $_thumb1 ? $thumb_name : 'theme/images/file.png',
							'name' 		=> $file,
							'path' 		=> $dir.$file,
							'date' 		=> filemtime($absName),
							'filesize' 	=> filesize($absName),
							'extension'	=> $ext,
							'infos' 	=> getimagesize($absName),
							'thumb' 	=> $_thumb2
						);
					}
				}
			}
			closedir($handle);
		}
		# On tri le contenu
		ksort($files);
		# On retourne le tableau
		return $files;
    }

	// It's the same function as _uploadFile but this last one is a private function. Shit !!
	protected function uploadFile($file, $resize, $thumb) {

		if($file['name'] == '')
			return L_PLXMEDIAS_WRONG_FILENAME;

		if($file['size'] > $this->maxUpload['value'])
			return L_PLXMEDIAS_WRONG_FILESIZE;

		if(!preg_match($this->img_exts, $file['name']) AND !preg_match($this->doc_exts, $file['name']))
			return L_PLXMEDIAS_WRONG_FILEFORMAT;

		# On teste l'existence du fichier et on formate le nom du fichier pour éviter les doublons
		$i = 1;
		$upFile = $this->path.$this->dir.plxUtils::title2filename($file['name']);
		$name = substr($upFile, 0, strrpos($upFile,'.'));
		$ext = strrchr($upFile, '.');
		while(file_exists($upFile)) {
			$upFile = $this->path.$this->dir.$name.'.'.$i++.$ext;
		}

		if(!move_uploaded_file($file['tmp_name'],$upFile)) { # Erreur de copie
			return L_PLXMEDIAS_UPLOAD_ERR;
		} else { # Ok
			if(preg_match($this->img_exts, $file['name'])) {
				plxUtils::makeThumb($upFile, $this->path.'.thumbs/'.$this->dir.basename($upFile), $this->thumbWidth, $this->thumbHeight, $this->thumbQuality);
				if($resize)
					plxUtils::makeThumb($upFile, $upFile, $resize['width'], $resize['height'], 80);
				if($thumb)
					plxUtils::makeThumb($upFile, plxUtils::thumbName($upFile), $thumb['width'], $thumb['height'], 80);
			}
		}
		return L_PLXMEDIAS_UPLOAD_SUCCESSFUL;
	}

	public function uploadFilesMulti() {
		$params = array();
		foreach (array('resize', 'thumb') as $k) {
			if (!empty($_POST[$k])) {
				if ($_POST[$k] == 'user')	{
					$width = $_POST[$k.'_w']; $height = $_POST[$k.'_h'];
				}
				else {
					list($width, $height) = explode('x', $_POST[$k]);
				}
				$params[$k] = array('width'=>$width, 'height'=>$height);
			}
			else
				$params[$k] = false;
		}
		$count1 = 0;
		foreach ($_FILES as $input) {
			for ($i=0; $i<count($input['name']); $i++) {
				$file1 = array();
				foreach (array('name', 'type', 'tmp_name', 'error', 'size') as $m)
					$file1[$m] = $input[$m][$i];
				if ($file1['error'] == 0) {
					$res = $this->uploadFile($file1, $params['resize'], $params['thumb']);
					if ($res ==  L_PLXMEDIAS_UPLOAD_SUCCESSFUL)
						$count1++;
					else {
						return plxMsg::Error($res.': '.$file['name'].' - '.$file['size']);
						break;
					}
				}
				else {
					return plxMsg::Error(L_PLXMEDIAS_UPLOADS_ERR.$file['name'].' - '.$file['size']);
					break;
				}
			}
		}
		// update $this->aFiles
		unset($this->aFiles);
		$this->aFiles = $this->getDirFiles($this->dir);
		return plxMsg::Info($count1.' '.L_PLXMEDIAS_UPLOADS_SUCCESSFUL);
	}
}

// plxToken::validateFormToken($_POST);

// part of medias.php
// Nouvel objet de type plxMedias
$folderMedias = $_SESSION['uploader_folderMedias'];
$plxMedias = new plxMediasMulti(PLX_ROOT.$_SESSION['medias'], $folderMedias);

if ($plxMedias->uploadFilesMulti($_FILES, $_POST)) {
	if ($plxMedias->aFiles) {
		$rootMedias = $_SESSION['uploader_racine'].$_SESSION['medias'];
		$body = '';
		foreach ($plxMedias->aFiles as $v) { # Pour chaque fichier
			$filesize = plxUtils::formatFilesize($v['filesize']);
			$isImage = in_array(strtolower($v['extension']), array('.png', '.gif', '.jpg'));
			if ($isImage) {
				if (isset($v['infos']) AND isset($v['infos'][0]) AND isset($v['infos'][1]))
					$dimensions = $v['infos'][0].' x '.$v['infos'][1];
				else
					$dimensions = '&nbsp;';
				$thumbOk = (isset($v['thumb']) and ($v['thumb']['filesize'] > 0));
				$thumbSize = ($thumbOk) ? plxUtils::formatFilesize($v['thumb']['filesize']) : '&nbsp;';
				$thumbDim = ($thumbOk) ? $v['thumb']['infos'][0].' x '.$v['thumb']['infos'][1] : '&nbsp;';
			} else {
				$thumbSize = '';
				$dimensions = '&nbsp;';
				$thumbDim = '';
			}
			$name = $v['name'];
			$href = $rootMedias.$v['path'];
			$title = basename($v['path']);
			$label_file = plxUtils::strCheck($v['name']);
			$vignette = $rootMedias.$v['.thumb'];
			$extension = strtolower($v['extension']);
			$cell3_thumb = '';
			$filedate = plxDate::formatDate(plxDate::timestamp2Date($v['date']));
			if ($isImage) {
				$cell2 =  <<< CELL2
<a href="$href" title="$title" rel="lightbox-1"><img src="$vignette" /></a></td>
CELL2;
				if ($thumbOk) {
					$href_thumb = $rootMedias.plxUtils::thumbName($v['path']);
					$label_thumb = L_MEDIAS_THUMB;
					$cell3_thumb = <<< CELL3_THUMB
<a href="$href_thumb" rel="lightbox-3">$label_thumb</a>
CELL3_THUMB;
				}
			} else {
				$cell2 = '&nbsp;';
			}
			$body .= <<< TR
			<tr>
				<td><input type="checkbox" name="idFile[]" value="$name" /></td>
				<td>$cell2</td>
				<td>
					<a href="$href" rel="lightbox-2" title="$title">$label_file</a><br />
					$cell3_thumb
				</td>
				<td>$extension</td>
				<td>
					$filesize
					$thumbSize
				</td>
				<td>
					$dimensions<br />
					$thumbDim
				</td>
				<td>$filedate</td>
			</tr>
TR;
		}
	}
	else {
		$label1 = L_MEDIAS_NO_FILE;
		$body = <<< NO_MEDIA
				<tr>
					<td colspan="7" class="center">$label1</td>
				</tr>
NO_MEDIA;
	}
	$response = array('msg'=>$_SESSION['info'], 'inner'=>$body);
	$_SESSION['info'] = '';
}
else
	$response = array('msg'=>$_SESSION['error']);

header("Content-type: text/plain");
if (function_exists('json_encode'))
	// json_encode requires PHP version >= 5.2
	echo json_encode($response);
else
	echo implode('aZErTy', $response);
?>
