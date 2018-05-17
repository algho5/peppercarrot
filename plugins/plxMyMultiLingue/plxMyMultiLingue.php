<?php
/**
 * Plugin plxMyMultiLingue
 *
 * @author	Stephane F
 *
 **/

class plxMyMultiLingue extends plxPlugin {

	public $aLangs = array(); # tableau des langues
	public $lang = ''; # langue courante
	public $plxMotorConstruct = false;

	/**
	 * Constructeur de la classe
	 *
	 * @param	default_lang	langue par défaut
	 * @return	stdio
	 * @author	Stephane F
	 **/
	public function __construct($default_lang) {

		# récupération de la langue si présente dans l'url
		$get = plxUtils::getGets();
		if(preg_match('/^([a-zA-Z]{2})\/(.*)/', $get, $capture))
			$this->lang = $capture[1];
		elseif(isset($_SESSION['lang']))
			$this->lang = $_SESSION['lang'];
		elseif(isset($_COOKIE["plxMyMultiLingue"]))
			$this->lang = $_COOKIE["plxMyMultiLingue"];
		else
			$this->lang = $default_lang;

		# appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($this->lang);

		# droits pour accéder à la page config.php du plugin
		$this->setConfigProfil(PROFIL_ADMIN);

		# déclaration des hooks partie publique
		$this->addHook('IndexEnd', 'IndexEnd');
		$this->addHook('FeedEnd', 'FeedEnd');
		$this->addHook('SitemapBegin', 'SitemapBegin');

		# déclaration des hooks plxMotor
		$this->addHook('plxMotorConstruct', 'plxMotorConstruct');
		$this->addHook('plxMotorPreChauffageBegin', 'PreChauffageBegin');
		$this->addHook('plxMotorConstructLoadPlugins', 'ConstructLoadPlugins');

		# déclaration des hooks plxAdmin
		$this->addHook('plxAdminEditConfiguration', 'plxAdminEditConfiguration');

		# déclaration des hooks plxShow
		$this->addHook('plxShowStaticListEnd', 'plxShowStaticListEnd');
        $this->addHook('plxShowConstruct', 'plxShowConstruct');

		# déclaration des hooks plxFeed
		$this->addHook('plxFeedConstructLoadPlugins', 'ConstructLoadPlugins');
		$this->addHook('plxFeedPreChauffageBegin', 'PreChauffageBegin');

		# déclaration des hooks partie administration
		$this->addHook('AdminTopEndHead', 'AdminTopEndHead');
		$this->addHook('AdminTopMenus', 'AdminTopMenus');
		$this->addHook('AdminSettingsAdvancedTop', 'AdminSettingsAdvancedTop');
		$this->addHook('AdminSettingsBaseTop', 'AdminSettingsBaseTop');
		$this->addHook('AdminArticleTop', 'AdminArticleTop');
		$this->addHook('AdminArticleContent', 'AdminArticleContent');

		# déclaration hook utilisateur à mettre dans le thème
		$this->addHook('MyMultiLingue', 'MyMultiLingue');
        
    # Specific rules for Pepper&Carrot :
    $this->addHook('MyMultiLingueComicLang', 'MyMultiLingueComicLang');
    $this->addHook('MyMultiLingueStaticLang', 'MyMultiLingueStaticLang');
    $this->addHook('MyMultiLingueStaticAllLang', 'MyMultiLingueStaticAllLang');
    $this->addHook('MyMultiLingueComicDisplay', 'MyMultiLingueComicDisplay');
    $this->addHook('MyMultiLingueComicHeader', 'MyMultiLingueComicHeader');
    $this->addHook('MyMultiLingueSourceLinkDisplay', 'MyMultiLingueSourceLinkDisplay');
        
		# récupération des langues enregistrées dans le fichier de configuration du plugin
		if($this->getParam('flags')!='')
			$this->aLangs = explode(',', $this->getParam('flags'));

		$this->lang = $this->validLang($this->lang);

		# PLX_MYMULTILINGUE contient la liste des langues - pour être utilisé par d'autres plugins
		define('PLX_MYMULTILINGUE', $this->getParam('flags'));

	}

	/**
	 * Méthode executée à la désactivation du plugin
	 *
	 * @author	Stephane F
	 **/
	public function onDeactivate() {
		unset($_SESSION['lang']);
		unset($_SESSION['medias']);
		unset($_SESSION['folder']);
		unset($_SESSION['currentfolder']);
		unset($_COOKIE['plxMyMultiLingue']);
		setcookie('plxMyMultiLingue', '', time() - 3600);
	}

	/**
	 * Méthode qui créée les répertoires des langues (écran de config du plugin)
	 *
	 * @author	Stephane F
	 **/
	public function mkDirs() {
	}

	/**
	 * Méthode qui vérifie qu'une langue est bien gérer par le plugin
	 *
	 * param	lang		langue à tester
	 * return	string		langue passée au paramètre si elle est gérée sinon la langue par défaut de PluXml
	 * @author	Stephane F
	 **/
	public function validLang($lang) {
		return (in_array($lang, $this->aLangs) ? $lang : $this->default_lang);
	}

	/**
	 * Méthode qui renseigne la variable $this->lang avec la langue courante à utiliser lors de l'accès
	 * au site ou dans l'administration (cf COOKIE/SESSION)
	 *
	 * @author	Stephane F
	 **/
	public function getCurrentLang() {

		# sélection de la langue à partir dun drapeau
		if(isset($_GET["lang"]) AND !empty($_GET["lang"])) {

			$this->lang = $this->validLang(plxUtils::getValue($_GET["lang"]));

			if(defined("PLX_ADMIN")) {
				unset($_SESSION["medias"]);
				unset($_SESSION["folder"]);
				unset($_SESSION["currentfolder"]);
			}

			setcookie("plxMyMultiLingue", $this->lang, time()+3600*24*30);  // expire dans 30 jours
			$_SESSION["lang"] = $this->lang;

			# redirection avec un minimum de sécurité sur lurl
			if(defined("PLX_ADMIN")) {
				if(preg_match("@^".plxUtils::getRacine()."(.*)@", $_SERVER["HTTP_REFERER"]))
					header("Location: ".plxUtils::strCheck($_SERVER["HTTP_REFERER"]));
				else
					header("Location: ".plxUtils::getRacine());
				exit;
			} else {
				$this->plxMotorConstruct = true;
			}

		}

		# récupération de la langue si on accède au site à partir du sitemap
		if(preg_match("/sitemap\.php\??([a-zA-Z]+)?/", $_SERVER["REQUEST_URI"], $capture)) {
			$this->lang = $this->validLang(plxUtils::getValue($capture[1]));
			return;
		}

		setcookie("plxMyMultiLingue", $this->lang, time()+3600*24*30);  // expire dans 30 jours

	}

	/********************************/
	/* core/lib/class.plx.motor.php	*/
	/********************************/

	/**
	 * Méthode qui fat la redirection lors du changement de langue coté visiteur
	 *
	 * @author	Stephane F
	 **/
	public function plxMotorConstruct() {

		if($this->plxMotorConstruct) {

			if($this->getParam('redirect_ident')) {

				echo '<?php

				$url = $_SERVER["PHP_SELF"];
				if(preg_match("@^(".plxUtils::getRacine()."(index.php\?)?)([a-z]{2})\/(.*)@", $_SERVER["HTTP_REFERER"], $uri)) {

					if(preg_match("/^(article([0-9]+))\/(.*)/", $uri[4], $m)) {
						$file = $this->plxGlob_arts->query("/".str_pad($m[2],4,"0",STR_PAD_LEFT)."\.(.*)\.xml$/");
						$match = preg_match("/(.*)\.([a-z0-9-]+)\.xml$/", $file[0], $f);
						if($file AND $match) {
							$url = $uri[1]."'.$this->lang.'/".$m[1]."/".$f[2];
						} else {
							$url = $uri[1]."'.$this->lang.'/404";
						}
					}
					elseif(preg_match("/^(static([0-9]+))\/(.*)/", $uri[4], $m)) {
						if($sUrl = plxUtils::getValue($this->aStats[str_pad($m[2],3,"0",STR_PAD_LEFT)]["url"])) {
							$url =  $uri[1]."'.$this->lang.'/".$m[1]."/".$sUrl;
						} else {
							$url = $uri[1]."'.$this->lang.'/404";
						}
					}
					elseif(preg_match("/^(categorie([0-9]+))\/(.*)/", $uri[4], $m)) {
						if($sUrl = plxUtils::getValue($this->aCats[str_pad($m[2],3,"0",STR_PAD_LEFT)]["url"])) {
							$url =  $uri[1]."'.$this->lang.'/".$m[1]."/".$sUrl;
						} else {
							$url = $uri[1]."'.$this->lang.'/404";
						}
					} else {
							$url = $uri[1]."'.$this->lang.'/".$uri[4];
					}
				} else {
					$url = $_SERVER["HTTP_REFERER"];
					if ($url == "")
						$url = plxUtils::getRacine();
				}

				header("Location: ".plxUtils::strCheck($url));
				exit;

				?>';
			} else {
				header('Location: '.plxUtils::strCheck($_SERVER['PHP_SELF']));
				exit;
			}
		}
	}

	/**
	 * Méthode qui vérifie que la langue est bien présente dans l'url
	 *
	 * @author	Stephane F
	 **/
	public function PreChauffageBegin() {

		echo '<?php
			# utilisation de preg_replace pour être sur que la chaine commence bien par la langue
			$this->get = preg_replace("/^'.$this->lang.'\/(.*)/", "$1", $this->get);
		?>';

	}

	/**
	 * Méthode qui modifie les chemins de PluXml en tenant compte de la langue
	 *
	 * @author	Stephane F
	 **/
	public function ConstructLoadPlugins() {

		# sauvegarde de la langue stockée dans le fichier parametres.xml dans uen variable de session
		echo '<?php
			if(!isset($_SESSION["plxMyMultiLingue"]["default_lang"])) {
				$_SESSION["plxMyMultiLingue"]["default_lang"] = $this->aConf["default_lang"];
			}
		?>';

		# récupération de la langue à utiliser
		$this->getCurrentLang();

		# modification des chemins d'accès
		echo '<?php
            # $this->aConf["racine_statiques"] = $this->aConf["racine_statiques"]."'.$this->lang.'/";
            ?>';
			# $this->aConf["racine_articles"] = $this->aConf["racine_articles"]."'.$this->lang.'/";
			# path("XMLFILE_CATEGORIES", PLX_ROOT.PLX_CONFIG_PATH."'.$this->lang.'/categories.xml");
			# path("XMLFILE_STATICS", PLX_ROOT.PLX_CONFIG_PATH."'.$this->lang.'/statiques.xml");
			# path("XMLFILE_TAGS", PLX_ROOT.PLX_CONFIG_PATH."'.$this->lang.'/tags.xml");

		# modification des infos du site en fonction de la langue
        /*
		echo '<?php
			if(file_exists(PLX_ROOT.PLX_CONFIG_PATH."plugins/plxMyMultiLingue.xml")) {
				$this->aConf["title"] = "'.$this->getParam("title_".$this->lang).'";
				$this->aConf["description"] = "'.$this->getParam("description_".$this->lang).'";
				$this->aConf["meta_description"] = "'.$this->getParam("meta_description_".$this->lang).'";
				$this->aConf["meta_keywords"] = "'.$this->getParam("meta_keywords_".$this->lang).'";
			}
		?>';
        */

		# s'il faut un dossier images et documents différents pour chaque langue
		if($this->getParam('lang_images_folder')) {
			echo '<?php $this->aConf["images"] = $this->aConf["images"]."'.$this->lang.'/"; ?>';
		}
		if($this->getParam('lang_documents_folder')) {
			echo '<?php $this->aConf["documents"] = $this->aConf["documents"]."'.$this->lang.'/"; ?>';
		}

	}

	/********************************/
	/* core/lib/class.plx.show.php 	*/
	/********************************/

	/**
	 * Méthode qui modifie l'url des pages statiques en rajoutant la langue courante dans le lien du menu de la page
	 *
	 * @author	Stephane F
	 **/
	public function plxShowStaticListEnd() {

		echo '<?php
		foreach($menus as $idx => $menu) {
			if(strpos($menu[0], "static-home")===false) {
				if($this->plxMotor->aConf["urlrewriting"]) {
					$menus[$idx] = str_replace($this->plxMotor->racine, $this->plxMotor->racine."'.$this->lang.'/", $menu);
				}
			}
		}
		?>';
	}
    
	/**
	 * Méthode qui propose un fallback en anglais quand une page statique n'est pas traduite
	 **/
	public function plxShowConstruct() {

		echo '<?php
        
        $this->plxMotor = plxMotor::getInstance();
		# Chargement du fichier de lang du theme
		$langfile = PLX_ROOT.$this->plxMotor->aConf["racine_themes"].$this->plxMotor->style."/lang/'.$this->lang.'.php";
		if(is_file($langfile)) {
			include($langfile);
			$this->lang = $LANG;
		} else {
        $langfile = PLX_ROOT.$this->plxMotor->aConf["racine_themes"].$this->plxMotor->style."/lang/en.php";
            include($langfile);
			$this->lang = $LANG;
        }
		?>';
	}

	/********************************/
	/* core/lib/class.plx.admin.php	*/
	/********************************/

	/**
	 * Méthode qui modifie les chemins de PluXml en supprimant la langue
	 *
	 * @author	Stephane F
	 **/
	public function plxAdminEditConfiguration() {

		# Sauvegarde des parametres pris en compte en fonction de la langue
		/*
        echo '<?php
		if (preg_match("/parametres_base/",basename($_SERVER["SCRIPT_NAME"]))) {
			$lang = $this->aConf["default_lang"];
			$plugin = $this->plxPlugins->aPlugins["plxMyMultiLingue"];
			$plugin->setParam("title_".$lang, $_POST["title"], "cdata");
			$plugin->setParam("description_".$lang, $_POST["description"], "cdata");
			$plugin->setParam("meta_description_".$lang, $_POST["meta_description"], "cdata");
			$plugin->setParam("meta_keywords_".$lang, $_POST["meta_keywords"], "cdata");
			$plugin->saveParams();
		}
		?>';*/

		# pour ne pas écraser les chemins racine_articles, racine_statiques et racine_commentaires
		echo '<?php
			# $global["racine_statiques"] = str_replace("/'.$this->lang.'/", "/", $global["racine_statiques"]);
		?>';
        # $global["racine_articles"] = str_replace("/'.$this->lang.'/", "/", $global["racine_articles"]);
        # $global["racine_commentaires"] =  str_replace("/'.$this->lang.'/", "/", $global["racine_commentaires"]);



		# pour ne pas écraser le chemin du dossier des images et des documents
		if($this->getParam('lang_images_folder')) {
			echo '<?php $global["images"] = str_replace("/'.$this->lang.'/", "/", $global["images"]); ?>';
		}
		if($this->getParam('lang_documents_folder')) {
			echo '<?php $global["documents"] = str_replace("/'.$this->lang.'/", "/", $global["documents"]); ?>';
		}

		# pour tenir compte des changements de paramètrage de la langue par défaut du site
        /*
		echo '<?php
			$_SESSION["plxMyMultiLingue"]["default_lang"] = $_POST["default_lang"];
		?>'; */

	}

	/*************************************/
	/* core/admin/parametres_avances.php */
	/*************************************/

	/**
	 * Méthode qui modifie les chemins de PluXml en supprimant la langue
	 *
	 * @author	Stephane F
	 **/
	public function AdminSettingsAdvancedTop() {

		# pour ne pas écraser les chemins racine_articles, racine_statiques et racine_commentaires
		echo '<?php
			# $plxAdmin->aConf["racine_statiques"] = str_replace("/'.$this->lang.'/", "/", $plxAdmin->aConf["racine_statiques"]);
		?>';
			# $plxAdmin->aConf["racine_articles"] = str_replace("/'.$this->lang.'/", "/", $plxAdmin->aConf["racine_articles"]);
			# $plxAdmin->aConf["racine_commentaires"] =  str_replace("/'.$this->lang.'/", "/", $plxAdmin->aConf["racine_commentaires"]);

		# pour ne pas écraser le chemin du dossier des images et des documents
		if($this->getParam('lang_images_folder')) {
			echo '<?php $plxAdmin->aConf["images"] =  str_replace("/'.$this->lang.'/", "/", $plxAdmin->aConf["images"]); ?>';
		}
		if($this->getParam('lang_documents_folder')) {
			echo '<?php $plxAdmin->aConf["documents"] =  str_replace("/'.$this->lang.'/", "/", $plxAdmin->aConf["documents"]); ?>';
		}

	}

	/************************************/
	/* core/admin/parametres_base.php 	*/
	/************************************/

	/**
	 * Méthode qui remet la vraie langue par défaut de PluXml du fichier parametres.xml, sans tenir compte du multilangue
	 *
	 * @author	Stephane F
	 **/
	public function AdminSettingsBaseTop() {

		echo '<?php
			$plxAdmin->aConf["default_lang"] = $_SESSION["plxMyMultiLingue"]["default_lang"];
		?>';

	}

	/********************************/
	/* core/admin/top.php 			*/
	/********************************/

	/**
	 * Méthode qui affiche dans l'administration un bouton pour revenir au français, et un raccourcis vers les settings
	 *
	 * return	stdio
	 * @author	Deevad
	 **/
	public function AdminTopMenus() {
        echo '<li class="menu custom"><a href="parametres_plugin.php?p=plxMyMultiLingue">★ plxMyMultiLingue</a></li>';
        echo '<div style="clear:both;"></div>';
        
	}
    
	/**
	 * Méthode qui customise le theme de l'admin
	 * @author	Deevad  , version post 5.3.1
	**/
    
	public function AdminTopEndHead() {
        /** echo '
        <style>
        html {color: #333;font-family: arial, sans-serif;font-size: 14px;}
        .aside {background: #304A39 }
        button.red, input.red[type="button"], input.red[type="reset"], input.red[type="submit"] {
        background-color: #888888;
        }
        .aside .profil {
        background-color: #4A4A4A;
        border-top: 1px solid #bbb;
        border-bottom: 1px solid #bbb;
        }
        .menu .custom {
        background-color: #4A4A4A;

        padding: 0 0 4px 0;
        float: left;
        font-size: 12px;
        text-align: left;
        border-radius: 5px;
        margin: 5px;
        }
        td, th {
        border: 0px solid #BBB;
        }
        .scrollable-table .full-width td, .scrollable-table .full-width th {
        padding-top: 0;
        padding-bottom: 0;
        }
        </style>
        ';**/
	}
    

	/********************************/
	/* core/admin/article.php		*/
	/********************************/

	/**
	 * Méthode qui démarre la bufférisation de sortie
	 *
	 * @author	Stephane F
	 **/
	public function AdminArticleTop() {

		echo '<?php ob_start(); ?>';
	}

	/**
	 * Méthode qui rajoute la langue courante dans les liens des articles
	 *
	 * @author	Stephane F
	 **/
	public function AdminArticleContent() {

		/* echo '<?php echo preg_replace("/(article[a-z0-9-]+\/)/", "'.$this->lang.'/$1", ob_get_clean()); ?>'; */

	}

	/********************************/
	/* index.php 					*/
	/********************************/

	/**
	 * Méthode qui modifie les liens en tenant compte de la langue courante et de la réécriture d'urls
	 *
	 * @author	Stephane F
	 **/
	public function IndexEnd() {

		echo '<?php
		if($plxMotor->aConf["urlrewriting"]) {
			$output = str_replace($plxMotor->racine."article", $plxMotor->racine."'.$this->lang.'/article", $output);
			$output = str_replace($plxMotor->racine."static", $plxMotor->racine."'.$this->lang.'/static", $output);
			$output = str_replace($plxMotor->racine."categorie", $plxMotor->racine."'.$this->lang.'/categorie", $output);
			$output = str_replace($plxMotor->racine."tag", $plxMotor->racine."'.$this->lang.'/tag", $output);
			$output = str_replace($plxMotor->racine."archives", $plxMotor->racine."'.$this->lang.'/archives", $output);
			$output = str_replace($plxMotor->racine."feed", $plxMotor->racine."feed/'.$this->lang.'", $output);
			$output = str_replace($plxMotor->racine."page", $plxMotor->racine."'.$this->lang.'/page", $output);
			$output = str_replace($plxMotor->racine."blog", $plxMotor->racine."'.$this->lang.'/blog", $output);
		} else {
			$output = str_replace("?article", "?'.$this->lang.'/article", $output);
			$output = str_replace("?static", "?'.$this->lang.'/static", $output);
			$output = str_replace("?categorie", "?'.$this->lang.'/categorie", $output);
			$output = str_replace("?tag", "?'.$this->lang.'/tag", $output);
			$output = str_replace("?archives", "?'.$this->lang.'/archives", $output);
			$output = str_replace("?rss", "?'.$this->lang.'/rss", $output);
			$output = str_replace("?page", "?'.$this->lang.'/page", $output);
			$output = str_replace("?blog", "?'.$this->lang.'/blog", $output);
		}
		?>';

	}

	/********************************/
	/* feed.php 					*/
	/********************************/

	/**
	 * Méthode qui modifie les liens en tenant compte de la langue courante et de la réécriture d'urls
	 *
	 * @author	Stephane F
	 **/
	public function FeedEnd() {

		echo '<?php
		if($plxFeed->aConf["urlrewriting"]) {
			$output = str_replace($plxFeed->racine."article", $plxFeed->racine."'.$this->lang.'/article", $output);
			$output = str_replace($plxFeed->racine."static", $plxFeed->racine."'.$this->lang.'/static", $output);
			$output = str_replace($plxFeed->racine."categorie", $plxFeed->racine."'.$this->lang.'/categorie", $output);
			$output = str_replace($plxFeed->racine."tag", $plxFeed->racine."'.$this->lang.'/tag", $output);
			$output = str_replace($plxFeed->racine."archives", $plxFeed->racine."'.$this->lang.'/archives", $output);
			$output = str_replace($plxFeed->racine."feed", $plxFeed->racine."feed/'.$this->lang.'", $output);
			$output = str_replace($plxFeed->racine."page", $plxFeed->racine."'.$this->lang.'/page", $output);
			$output = str_replace($plxFeed->racine."blog", $plxFeed->racine."'.$this->lang.'/blog", $output);
		} else {
			$output = str_replace("?article", "?'.$this->lang.'/article", $output);
			$output = str_replace("?static", "?'.$this->lang.'/static", $output);
			$output = str_replace("?categorie", "?'.$this->lang.'/categorie", $output);
			$output = str_replace("?tag", "?'.$this->lang.'/tag", $output);
			$output = str_replace("?archives", "?'.$this->lang.'/archives", $output);
			$output = str_replace("?rss", "?'.$this->lang.'/rss", $output);
			$output = str_replace("?page", "?'.$this->lang.'/page", $output);
			$output = str_replace("?blog", "?'.$this->lang.'/blog", $output);
		}
		?>';

	}

	/********************************/
	/* sitemap.php 					*/
	/********************************/

	/**
	 * Méthode qui génère un sitemap en fonction d'une langue
	 *
	 * @author	Stephane F
	 **/
	public function SitemapBegin() {

		# affichage du sitemapindex ou du sitemap de la langue
		if(empty($_SERVER['QUERY_STRING'])) {
			# création d'un sitemapindex
			echo '<?php echo "<?xml version=\"1.0\" encoding=\"".strtolower(PLX_CHARSET)."\"?>\n<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">" ?>';
			foreach($this->aLangs as $lang) {
				echo '<?php echo "\n\t<sitemap>"; ?>';
				echo '<?php echo "\n\t\t<loc>".$plxMotor->racine."sitemap.php?'.$lang.'</loc>"; ?>';
				echo '<?php echo "\n\t</sitemap>"; ?>';
			}
			echo '<?php echo "\n</sitemapindex>"; ?>';
			echo '<?php return true; ?>';
		}
	}

	public function SitemapEnd() {

		$this->IndexEnd();

	}

	/********************************/
	/* theme: affichage du drapeaux */
	/********************************/

	/**
	 * Méthode qui affiche les drapeaux ou le nom des langues pour la partie visiteur du site
	 *
	 * return	stdio
	 * @author	Stephane F
	 **/
	public function MyMultiLingue() {

		$aLabels = unserialize($this->getParam('labels'));

		if($this->aLangs) {
			echo '<div id="langs">';
			echo '<ul>';
			foreach($this->aLangs as $idx=>$lang) {
				$sel = $this->lang==$lang ? ' active':'';
				if($this->getParam('display')=='flag') {
					$img = '<img class=\"lang'.$sel.'\" src=\"'.PLX_PLUGINS.'plxMyMultiLingue/img/'.$lang.'.png\" alt=\"'.$lang.'\" />';
					echo '<li><?php echo "<a href=\"".$plxShow->plxMotor->urlRewrite("?lang='.$lang.'")."\">'.$img.'</a></li>"; ?>';
				} else {
					echo '<li><?php echo "<a class=\"lang'.$sel.'\" href=\"".$plxShow->plxMotor->urlRewrite("?lang='.$lang.'")."\">'. $aLabels[$lang].'</a></li>"; ?>';
				}
				
			}
			echo '</ul>';
			echo '</div>';
		}
	}
  
/**********************************************************/
/* Display the pills of available lang (article-webcomic) */
/**********************************************************/
/**
 * Method to display a list of the available langage for active comic
 * @author: David Revoy
 **/
public function MyMultiLingueComicLang() {
  $plxMotor = plxMotor::getInstance();
  $aLabels = unserialize($this->getParam('labels'));
	$vignette = $plxMotor->plxRecord_arts->f('thumbnail');
  $vignette_parts = pathinfo($vignette);
  foreach($this->aLangs as $idx=>$lang) {
    # If the label display active lang, let CSS know for highlight via class 'active'
		$sel = $this->lang==$lang ? ' active':'';
    # Method: Get the episode number from vignette filename
    ## Remove the lang tag in the vignette filename, three first char (eg. en_, fr_ )
    $vignette_name = substr($vignette_parts['filename'], 3);
    $episode_source_directory = $vignette_parts['dirname'].'';
    # Method to display only buttons with real translations existing
    # Build a pattern to find a hypothetic page 1 in the scanned lang target
    $comicpage_tester = $episode_source_directory.'/'.$lang.'_'.$vignette_name.'P01.jpg';
    #Debug $comicpage_tester
    #echo '<li><img src="'.$comicpage_tester.'" width="30px"></li>';
    # then we detect if hypothical page exist to display the button
	  if (file_exists($comicpage_tester)) {
      # Lang exist, we build the HTML for the language item
      $LangString .= '<?php echo "<li class=\"'.$sel.'\"><a href=\"".$plxShow->plxMotor->urlRewrite("?lang='.$lang.'")."\">'. $aLabels[$lang].'</a></li>"; ?>';
    }
  }
  # Display the resulting full list
  echo $LangString;

}

/************************************************/
/* Display the pills of available lang (static) */
/************************************************/
/**
 * Method to display a list of the available langage for static pages
 * @author: David Revoy
 **/  
public function MyMultiLingueStaticLang() {
  $plxMotor = plxMotor::getInstance();
  $aLabels = unserialize($this->getParam('labels'));
  # loop on all the lang pluxml know
  foreach($this->aLangs as $idx=>$lang) {
    # Build a pattern to find a hypothetic translation (eg. en.php, jp.php) in theme/lang/ folder 
    $LangAvailable = PLX_ROOT.$plxMotor->aConf['racine_themes'].$plxMotor->style.'/lang/'.$lang.'.php';
    # If the label display active lang, let CSS know for highlight via class 'active'
    $sel = $this->lang==$lang ? ' active':'';
    # if we detect page 01 exist in a active language
    if (file_exists($LangAvailable)) {
      # Lang exist, we build the HTML for the language item
      $LangString .= '<?php echo "<li class=\"'.$sel.'\"><a href=\"".$plxShow->plxMotor->urlRewrite("?lang='.$lang.'")."\">'. $aLabels[$lang].'</a></li>"; ?>';
     }
  }   
  # Display the resulting full list
  echo $LangString;
}


/********************************************************************************************/
/* Display the pills of all available lang, even webcomic (static: for frontpage/webcomics) */
/********************************************************************************************/
/**
 * Method to display a list of the available all langage for static pages
 * @author: David Revoy
 **/  
public function MyMultiLingueStaticAllLang() {
  $plxMotor = plxMotor::getInstance();
  $aLabels = unserialize($this->getParam('labels'));
  # loop on all the lang pluxml know
  foreach($this->aLangs as $idx=>$lang) {
    # Build a pattern to find a hypothetic translation (eg. en.php, jp.php) in theme/lang/ folder 
    $LangAvailable = PLX_ROOT.$plxMotor->aConf['racine_themes'].$plxMotor->style.'/lang/'.$lang.'.php';
    # If the label display active lang, let CSS know for highlight via class 'active'
    $sel = $this->lang==$lang ? ' active':'';
    # if we detect cover of episode 01 exists in a active language:
    $episode01_tester = '0_sources/ep01_Potion-of-Flight/low-res/'.$lang.'_Pepper-and-Carrot_by-David-Revoy_E01.jpg';
    if (file_exists($LangAvailable)) {
      # Lang exist, we build the HTML for the language item
      $LangString .= '<?php echo "<li class=\"'.$sel.'\"><a href=\"".$plxShow->plxMotor->urlRewrite("?lang='.$lang.'")."\" title=\"'.$aLabels[$lang].'\" >'.$aLabels[$lang].'</a></li>"; ?>';
     } else if (file_exists($episode01_tester)) {
      # Lang exist but only for webcomic. 
      $sel = 'notfull';
      $LangString .= '<?php echo "<li class=\"'.$sel.'\"><a href=\"".$plxShow->plxMotor->urlRewrite("index.php?'.$lang.'/static3/webcomics")."\" title=\"'.$aLabels[$lang].' - Note: Translation of webcomic only \">'.$aLabels[$lang].'</a></li>"; ?>';
    }
  }   
  # Display the resulting full list
  echo $LangString;
}

/********************************/
/* Display the comicpages				*/
/********************************/
/**
 * Method to display the full comic page in the target langage ( without header )
 * Main input: the vignette of the article
 * @author: David Revoy
 **/ 
public function MyMultiLingueComicDisplay($params) {
  
  if(isset($params)) {
    if(is_array($params)) {
      $definition = empty($params[0])?'low':$params[0];
    }
  } else {
    $definition = 'low';
  }
  
  # Have we got a preference in memory from previous page?
  if ($_SESSION['SessionMemory'] == "KeepHD") {
    $definition = 'hd';
  }
  
  if ($definition == "hd") {
    $resolutionfolder = "hi-res";
    # Record a token for the next page
    $_SESSION['SessionMemory'] = "KeepHD";
    
  } else {
    $resolutionfolder = "low-res";
  }
  # debug
  # echo "<b>Url variable + &#36;resolution</b> : ".$definition."  [" . $resolutionfolder . "] <br />";

  $plxMotor = plxMotor::getInstance();
  $plxShow = plxShow::getInstance();
  $aLabels = unserialize($this->getParam('labels'));
  $vignette = $plxMotor->plxRecord_arts->f('thumbnail');
  $vignette_parts = pathinfo($vignette);

  # The listing of episode files is based on the information given by the 'thumbnail' of the article:
  # Start of the method is to breakdown the 'thumbnail' information to get the source directory of episode.
  # In full logic, source directory of an episode is one folder parent of the directory of the 'thumbnail'
  $path = $vignette_parts['dirname'];
  $parts = explode('/', $path);
  array_pop($parts);
  $episode_source_directory = implode('/', $parts);
  ## debug: to test
  #echo $episode_source_directory.'<br/>';

  # Method: Get the episode number from vignette filename
  ## Remove the lang tag in the vignette filename, three first char (eg. en_, fr_ )
  $vignette_name = substr($vignette_parts['filename'], 3);
  ## Keep only last two digit of vignette filename because they are the episode number
  $episode_number = substr($vignette_name, -2);
  ## In case of leading leading 0, remove it to beautify (ep01 => ep1)
  $episode_number = ltrim($episode_number, '0');
  ## debug: to test
  #echo "<b>&#36;episodenumber</b> [" . $episode_number . "] <br />";

  # Method to force english in case comicpage are not translated
  # Build a pattern to find a hypothetic page 1 in the current language
  $comicpage_tester = $episode_source_directory.'/'.$resolutionfolder.'/'.$this->lang.'_'.$vignette_name.'P01.jpg';
  ## debug: to test $comicpage_tester
  #echo '<img src="'.$comicpage_tester.'"><br/>';
  
  # Test if the hypothetical don't file exist
  if (! file_exists($comicpage_tester)) {
  # Force comicpages in english";
  # $this->lang = "en";
  $usedlang = "en";
  } else {
  $usedlang = $this->lang;
  }

  # For every pages found in the actual language with this file pattern
  foreach (glob(''.$episode_source_directory.'/'.$resolutionfolder.'/'.$usedlang.'_*P[0-9]*[0-9]*.*') as $comicpage_link) {	
    
    # debug: display link  
    #echo "<b>&#36;comicpage</b> [" . $comicpage_link . "] <br />";

    # Method: Get the page number [0-9][0-9]
    ## Regular expression: keep only digit of the string
    $comicpage_number = preg_replace("/[^0-9\s]/", "", $comicpage_link);
    ## definition: keep only the last two char of the string
    $comicpage_number = substr($comicpage_number, -2);
    ## debug: to test
    #echo "<b>&#36;pagenumber</b> [" . $comicpage_number . "] <br />";

    # Managing conditional alt text for <img> html tag
    ## only in case of a normal page
    if ( $comicpage_number != "00" ) {
      # Remove the 0 in front of double digit page number
      $comicpage_number = ltrim($comicpage_number, '0');
      # Build a usefull alternative link in case of a page do not load...    
      $comicpage_alt = 'A webcomic page of Pepper&amp;Carrot, '.$plxShow->Getlang('UTIL_EPISODE').' '.$comicpage_number.' , '.$plxShow->Getlang('UTIL_PAGE').' '.$comicpage_number.'';
    

    # Define the anchor link
    $comicpage_anchorlink = ''.$plxShow->Getlang('UTIL_PAGE').''.$comicpage_number.'';
    # Get the geometry size of the comic page for correct display ratio on HTML  
    $comicpage_size = getimagesize($comicpage_link);

    # Display of the resulting HTML code
    #   <a href="#'.$comicpage_anchorlink.'" id="'.$comicpage_anchorlink.'" >
    #     <img class="comicpage" src="'.$comicpage_link.'" '.$comicpage_size[3].' alt="'.$comicpage_alt.'">
    #   </a>
    echo '
    <div class="panel" align="center">
        <img class="comicpage" src="'.$comicpage_link.'" '.$comicpage_size[3].' alt="'.$comicpage_alt.'">
    </div>
    ';
    }
  }
}

/********************************/
/* Display the Header page 00 	*/
/********************************/
/**
 * Method to display the page 00 (header) separately
 * Main input: the vignette of the article
 * @author: David Revoy
 **/ 
public function MyMultiLingueComicHeader() {

  $plxMotor = plxMotor::getInstance();
  $plxShow = plxShow::getInstance();
  $aLabels = unserialize($this->getParam('labels'));
  $vignette = $plxMotor->plxRecord_arts->f('thumbnail');
  $vignette_parts = pathinfo($vignette);
  $path = $vignette_parts['dirname'];
  $parts = explode('/', $path);
  array_pop($parts);
  $episode_source_directory = implode('/', $parts);
  # Method: Get the episode number from vignette filename
  ## Remove the lang tag in the vignette filename, three first char (eg. en_, fr_ )
  $vignette_name = substr($vignette_parts['filename'], 3);
  ## Keep only last two digit of vignette filename because they are the episode number
  $episode_number = substr($vignette_name, -2);
  ## In case of leading leading 0, remove it to beautify (ep01 => ep1)
  $episode_number = ltrim($episode_number, '0');
  ## debug: to test
  #echo "<b>&#36;episodenumber</b> [" . $episode_number . "] <br />";

  # Method to force english in case comicpage are not translated
  # Build a pattern to find a hypothetic Header page 00 in the current language
  $comicpage_header = $episode_source_directory.'/low-res/'.$this->lang.'_'.$vignette_name.'P00.jpg';
  ## debug: to test $comicpage_tester
  #echo '<img src="'.$comicpage_tester.'"><br/>';
  
    # Test if the hypothetical don't file exist
    if (! file_exists($comicpage_header)) {
    # Force comicpages in english";
    # $this->lang = "en";
    $comicpage_header = $episode_source_directory.'/low-res/en_'.$vignette_name.'P00.jpg';
    echo '<br/>';
    echo '<div class="col sml-12 med-10 lrg-6 sml-centered lrg-centered med-centered sml-text-center alert blue">';
    echo '  <img src="themes/peppercarrot-theme_v2/ico/nfo.svg" alt="info:"/> Content not available in the selected language. Falling back to English.';
    echo '</div>';
    }

    # Remove the 0 in front of double digit page number
    $comicpage_number = '0';
    # Build a usefull alternative link in case of a page do not load...    
    $comicpage_alt = 'A webcomic page of Pepper&amp;Carrot, '.$plxShow->Getlang('UTIL_EPISODE').' '.$comicpage_number.' , '.$plxShow->Getlang('UTIL_PAGE').' '.$comicpage_number.'';
    # Define the anchor link
    $comicpage_anchorlink = ''.$plxShow->Getlang('UTIL_PAGE').''.$comicpage_number.'';
    # Get the geometry size of the comic page for correct display ratio on HTML  
    $comicpage_size = getimagesize($comicpage_header);
    
    # Display of the resulting HTML code of the header
    echo '
    <div class="panel" align="center">
        <img class="comicpage" src="'.$comicpage_header.'" '.$comicpage_size[3].' alt="'.$comicpage_alt.'">
    </div>
    ';
}

/********************************/
/* Display the link to Source 	*/
/********************************/
/**
 * Method to display a button to link to the source of the active webcomic
 * Main input: the vignette of the article
 * @author: David Revoy
 **/ 
public function MyMultiLingueSourceLinkDisplay() {
  $plxMotor = plxMotor::getInstance();
  $plxShow = plxShow::getInstance();
  $aLabels = unserialize($this->getParam('labels'));
  $vignette = $plxMotor->plxRecord_arts->f('thumbnail');
  $vignette_parts = pathinfo($vignette);
  $path = $vignette_parts['dirname'];
  $parts = explode('/', $path);
  array_pop($parts);
  $episode_source_directory = implode('/', $parts);
  # pattern : index.php?fr/static6/sources&page=ep02_Rainbow-potions
  $sourcelink = basename($episode_source_directory);
  echo '<a class="sourcebutton" href="';
  $plxShow->urlRewrite('?static6/sources&page='.$sourcelink);
  echo '">'; 
  echo ''.$plxShow->Getlang('SOURCES_TITLE').': '.$sourcelink.''; 
  echo '</a>';
}

}
?>
