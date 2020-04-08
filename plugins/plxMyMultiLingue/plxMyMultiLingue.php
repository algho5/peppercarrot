<?php
/**
 * Plugin plxMyMultiLingue
 *
 * License: http://www.gnu.org/licenses/gpl.html GPL version 3 or higher
 */

/**
 * An Option Button to show below the main page navigator
 *
 * @author: GunChleoc
 */
class ComicToggleButton {
  private $title;
  private $status;
  private $varname;
  private $alttext;

  /**
   * Construct a button.
   *
   * @param string  $title       Button title to display to user
   *
   * @param string  $varname     Variable name to add to URL, format '&varname=1'
   *
   * @param string  $sessionvar  Name of the $_SESSION entry to remember the option
   *
   * @param string  $alton       Link tooltip for toggling on
   *
   * @param string  $altoff      Link tooltip for toggling off
   *
   * @return void
   */
  function __construct($title, $varname, $sessionvar, $alton, $altoff) {
    global $_GET, $_SESSION;

    $this->title = $title;
    $this->varname = $varname;

    # Have we got a new variable 'varname' in URL? Grab it as boolean.
    $this->status = isset($_GET[$varname]) && $_GET[$varname] === '1';

    # Remember in session if we switched it off explicitly just now
    if (!$this->status && isset($_GET[$varname])) {
      $_SESSION[$sessionvar] = 0;
    }

    # Have we got a preference in memory from previous page?
    if ($_SESSION[$sessionvar]) {
      $this->status = true;
    } else {
      if ($this->status) {
        # Record a token for the next page
        $_SESSION[$sessionvar] = 1;
      }
    }

    $this->alttext = $this->status ? $altoff : $alton;
  }

  /**
   * Print the button's HTML code.
   *
   * @param object  $plxShow  plxShow::getInstance() for accessing PluXML i18n
   *
   * @return void
   */
  function printHtml($is_available, $plxShow) {
    $link = $this->varname . '=' . ($this->status ? '0' : '1');
    $button_class = $this->status ? '' : 'moka';
    if (!$is_available) {
      $button_class = $button_class . ' off';
    }
    ?>
    <div class="button top <?php print($button_class); ?>">
      <a href="<?php $plxShow->artUrl(); print('&'.$link); ?>" title="<?php print($this->alttext); ?>" class="lang option"><?php echo ''.$this->title.''; ?></a>
    </div>
    <?php
  }

  /**
   * @return  boolean  the button's status as parsed in the constructor from $_GET[$varname]
   */
  function status() {
    return $this->status;
  }
}

/**
 * Metadata about the episode pages and transcripts to display
 *
 * @author: David Revoy, GunChleoc
 */
class Comic {
  /** The language to show the episode in.
   * We only set this if there are pages in the language available.
   */
  public $usedlang = "en";

  /** The collected image files to show */
  public $pagefiles = array();
  /** The collected transcript files to show. Can have gaps. */
  public $transcripts = array();

  /** The image folder, set depending on $hd_quality */
  private $resolutionfolder = "low-res";

  /** Number of the episode to show. Must be > 0 after initialization. */
  private $episode_number = 0;

  /** Button for turning transcript visibility on and off */
  public $transcript_button;

  /** Button for turning HD quality on and off */
  public $hd_button;

  /** Does nothing. Call initialize from a hook before using any created objects. */
  public function __construct() {
    # We can't do anyhing yet, because we can only get all the info while running in a hook
  }

  /**
   * Initialize the object. Must be called from a hook.
   *
   * @param string  $lang      The desired display language
   *
   * @param string  $vignette  Filepath template, e.g.
   *                           0_sources/ep01_Orange/low-res/en_Pepper-and-Carrot_by-David-Revoy_E01.jpg
   *
   * @param object  $plxShow   plxShow::getInstance() for accessing PluXML i18n
   *
   * @return void
   */
  public function initialize($lang, $vignette, $plxShow) {

    if ($this->episode_number > 0) {
      # We're already initialized
      return;
    }

    # Navigation toggle buttons
    $this->transcript_button = new ComicToggleButton(
      $plxShow->Getlang('NAVIGATION_TRANSCRIPT'),
      'transcript',
      'SessionTranscript',
      $plxShow->Getlang('NAVIGATION_TRANSCRIPT_ON'),
      $plxShow->Getlang('NAVIGATION_TRANSCRIPT_OFF')
    );

    $this->hd_button = new ComicToggleButton(
      $plxShow->Getlang('NAVIGATION_HD'),
      'hd',
      'SessionHD',
      $plxShow->Getlang('NAVIGATION_HD_ON'),
      $plxShow->Getlang('NAVIGATION_HD_OFF')
    );

    if ($this->hd_button->status()) {
      $this->resolutionfolder = "hi-res";
    } else {
      $this->resolutionfolder = "low-res";
    }

    # The listing of episode files is based on the information given by the 'thumbnail' of the article:
    # Start of the method is to breakdown the 'thumbnail' information to get the source directory of episode.
    # In full logic, source directory of an episode is one folder parent of the directory of the 'thumbnail'
    $vignette_parts = pathinfo($vignette);
    $path = $vignette_parts['dirname'];
    $parts = explode('/', $path);
    array_pop($parts);
    $episode_source_directory = implode('/', $parts);
    # Get the vignette filename without locale (e.g. en_) and detect the episode number (e.g. 01)
    # Example vignette filename: en_Pepper-and-Carrot_by-David-Revoy_E01
    preg_match('/^[a-z]+_([A-Za-z-_]+_E(\d+))$/', $vignette_parts['filename'], $matches);

    ## Vignette filename without locale tag
    # Example: Pepper-and-Carrot_by-David-Revoy_E01
    $vignette_name = $matches[1];
    ## Episode number
    $episode_number_with_zeroes = $matches[2];
    ## In case of leading leading 0, remove it to beautify (ep01 => ep1)
    $this->episode_number = ltrim($episode_number_with_zeroes, '0');
    ## debug: to test
    # echo "<b>&#36;episodenumber</b> [" . $this->episode_number . "] <br />";

    # Get all image files for episode and language (page title + pages)
    $this->pagefiles = glob(''.$episode_source_directory.'/'.$this->resolutionfolder.'/'.$lang.'_'.$vignette_name.'P[0-9][0-9]*.[A-Za-z]*');

    if (!empty($this->pagefiles)) {
      # If the files exist, we can use the desired language
      $this->usedlang = $lang;
    } else {
      # Fallback to English
      $this->pagefiles = glob(''.$episode_source_directory.'/'.$this->resolutionfolder.'/'.$this->usedlang.'_'.$vignette_name.'P[0-9][0-9]*.[A-Za-z]*');
    }

    # debug var_dump($this->pagefiles);

    # Look for transcript files. Make sure we allow for gaps.
    $transcript_filenames = glob($episode_source_directory.'/hi-res/html/'.$this->usedlang.'_E'.$episode_number_with_zeroes.'P[0-9][0-9]*.html');

    $keys = array_keys($transcript_filenames);

    foreach ($keys as $key) {
      if (file_exists($transcript_filenames[$key])) {
        $this->transcripts[$key] = $transcript_filenames[$key];
      }
    }
    # debug var_dump($this->transcripts);
  }

  /**
   * Print HTML code for a page or the header of the episode
   *
   * @param integer  $comicpage_number  The page to display
   *
   * @param string   $lang              The desired display language
   *
   * @param object   $plxShow           plxShow::getInstance() for accessing PluXML i18n
   *
   * @return void
   */
  public function displayPage($comicpage_number, $lang, $plxShow) {
    if ($this->episode_number < 1) {
      # Just in case we forgot to call initialize
      echo '<div>Something went wrong with collecting the episode data. This should not have happened.</div>';
      return;
    }

    $comicpage_link = $this->pagefiles[$comicpage_number];

    # Build a useful alternative link in case of a page not loading...
    $comicpage_alt = 'A webcomic page of Pepper&amp;Carrot, '.$plxShow->Getlang('UTIL_EPISODE').' '.$this->episode_number.' ['.$lang.'], '.$plxShow->Getlang('UTIL_PAGE').' '.$comicpage_number;
    # Define the anchor link
    $comicpage_anchorlink = ''.$plxShow->Getlang('UTIL_PAGE').''.$comicpage_number.'';
    # Get the geometry size of the comic page for correct display ratio on HTML
    $comicpage_size = getimagesize($this->pagefiles[$comicpage_number]);


    # Display (add a special rule to detect gif in HD mode and upscale them on webbrowser).
    if (strpos($comicpage_link, 'gif') !== false) {
      $max_width = $this->hd_button->status() ? '2276px' : '1176px';
      echo '<div class="panel" align="center">';
      echo '<img class="comicpage" style="max-width:'.$max_width.'" width="92%" src="'.$comicpage_link.'" '.$comicpage_size[3].' alt="'.$comicpage_alt.'">';
    } else {
      echo '<div class="panel" align="center">';
      echo '<img class="comicpage" src="'.$comicpage_link.'" '.$comicpage_size[3].' alt="'.$comicpage_alt.'">';
    }
    echo '</div>';
  }
}


/**
 * Plugin plxMyMultiLingue
 *
 * @author  Stephane F
 *
 **/

class plxMyMultiLingue extends plxPlugin {

  public $aLangs = array(); # tableau des langues
  public $lang = ''; # langue courante
  public $plxMotorConstruct = false;
  private $episode;

  /**
   * Constructeur de la classe
   *
   * @param  default_lang  langue par défaut
   * @return  stdio
   * @author  Stephane F
   **/
  public function __construct($default_lang) {

    # récupération de la langue si présente dans l'url
    $get = plxUtils::getGets();

    //if(isset($_COOKIE["plxMyMultiLingue"])) {
      //$this->lang = $_COOKIE["plxMyMultiLingue"];
    //} elseif(isset($_SESSION['lang'])) {
      //$this->lang = $_SESSION['lang'];
    //} elseif(preg_match('/^([a-zA-Z]{2})\/(.*)/', $get, $capture)) {
      //$this->lang = $capture[1];
    //} else {
      //$this->lang = $default_lang;
    //}
    if(preg_match('/^([a-zA-Z]{2})\/(.*)/', $get, $capture))
      $this->lang = $capture[1];
    elseif(isset($_SESSION['lang']))
      $this->lang = $_SESSION['lang'];
    elseif(isset($_COOKIE["plxMyMultiLingue"]))
      $this->lang = $_COOKIE["plxMyMultiLingue"];
    else
      $this->lang = $default_lang;

    //if(preg_match('/^([a-zA-Z]{2})\/(.*)/', $get, $capture))
    //  $this->lang = $capture[1];
    //elseif(isset($_SESSION['lang']))
    //  $this->lang = $_SESSION['lang'];
    //elseif(isset($_COOKIE["plxMyMultiLingue"]))
    //  $this->lang = $_COOKIE["plxMyMultiLingue"];
    //else
    //  $this->lang = $default_lang;

    # appel du constructeur de la classe plxPlugin (obligatoire)
    parent::__construct($this->lang);

    # Construct empty episode object. We have to wait for the hooks before we can initialize.
    $this->comic = new Comic();

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
    $this->addHook('MyMultiLingueGetLang', 'MyMultiLingueGetLang');
    $this->addHook('MyMultiLingueComicLang', 'MyMultiLingueComicLang');
    $this->addHook('MyMultiLingueStaticLang', 'MyMultiLingueStaticLang');
    $this->addHook('MyMultiLingueStaticAllLang', 'MyMultiLingueStaticAllLang');
    $this->addHook('MyMultiLingueComicToggleButtons', 'MyMultiLingueComicToggleButtons');
    $this->addHook('MyMultiLingueComicDisplay', 'MyMultiLingueComicDisplay');
    $this->addHook('MyMultiLingueComicHeader', 'MyMultiLingueComicHeader');
    $this->addHook('MyMultiLingueSourceLinkDisplay', 'MyMultiLingueSourceLinkDisplay');
    $this->addHook('MyMultiLingueBackgroundColor', 'MyMultiLingueBackgroundColor');
    $this->addHook('MyMultiLingueFramagitLinkDisplay', 'MyMultiLingueFramagitLinkDisplay');
    $this->addHook('MyMultiLingueCommentLinkDisplay', 'MyMultiLingueCommentLinkDisplay');

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
   * @author  Stephane F
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
   * @author  Stephane F
   **/
  public function mkDirs() {
  }

  /**
   * Méthode qui vérifie qu'une langue est bien gérer par le plugin
   *
   * param  lang    langue à tester
   * return  string    langue passée au paramètre si elle est gérée sinon la langue par défaut de PluXml
   * @author  Stephane F
   **/
  public function validLang($lang) {
    return (in_array($lang, $this->aLangs) ? $lang : $this->default_lang);
  }

  /**
   * Méthode qui renseigne la variable $this->lang avec la langue courante à utiliser lors de l'accès
   * au site ou dans l'administration (cf COOKIE/SESSION)
   *
   * @author  Stephane F
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

      setcookie("plxMyMultiLingue", $this->lang, time()+3600*24*30);  // expire after 30days
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
  /* core/lib/class.plx.motor.php  */
  /********************************/

  /**
   * Méthode qui fat la redirection lors du changement de langue coté visiteur
   *
   * @author  Stephane F
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
   * @author  Stephane F
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
   * @author  Stephane F
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
  /* core/lib/class.plx.show.php   */
  /********************************/

  /**
   * Méthode qui modifie l'url des pages statiques en rajoutant la langue courante dans le lien du menu de la page
   *
   * @author  Stephane F
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
  /* core/lib/class.plx.admin.php  */
  /********************************/

  /**
   * Méthode qui modifie les chemins de PluXml en supprimant la langue
   *
   * @author  Stephane F
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
   * @author  Stephane F
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
  /* core/admin/parametres_base.php   */
  /************************************/

  /**
   * Méthode qui remet la vraie langue par défaut de PluXml du fichier parametres.xml, sans tenir compte du multilangue
   *
   * @author  Stephane F
   **/
  public function AdminSettingsBaseTop() {

    echo '<?php
      $plxAdmin->aConf["default_lang"] = $_SESSION["plxMyMultiLingue"]["default_lang"];
    ?>';

  }

  /********************************/
  /* core/admin/top.php       */
  /********************************/

  /**
   * Méthode qui affiche dans l'administration un bouton pour revenir au français, et un raccourcis vers les settings
   *
   * return  stdio
   * @author  Deevad
   **/
  public function AdminTopMenus() {
        echo '<li class="menu custom"><a href="parametres_plugin.php?p=plxMyMultiLingue">★ plxMyMultiLingue</a></li>';
        echo '<div style="clear:both;"></div>';

  }

  /**
   * Méthode qui customise le theme de l'admin
   * @author  Deevad  , version post 5.3.1
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
  /* core/admin/article.php    */
  /********************************/

  /**
   * Méthode qui démarre la bufférisation de sortie
   *
   * @author  Stephane F
   **/
  public function AdminArticleTop() {

    echo '<?php ob_start(); ?>';
  }

  /**
   * Méthode qui rajoute la langue courante dans les liens des articles
   *
   * @author  Stephane F
   **/
  public function AdminArticleContent() {

    /* echo '<?php echo preg_replace("/(article[a-z0-9-]+\/)/", "'.$this->lang.'/$1", ob_get_clean()); ?>'; */

  }

  /********************************/
  /* index.php           */
  /********************************/

  /**
   * Méthode qui modifie les liens en tenant compte de la langue courante et de la réécriture d'urls
   *
   * @author  Stephane F
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
  /* feed.php           */
  /********************************/

  /**
   * Méthode qui modifie les liens en tenant compte de la langue courante et de la réécriture d'urls
   *
   * @author  Stephane F
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
  /* sitemap.php           */
  /********************************/

  /**
   * Méthode qui génère un sitemap en fonction d'une langue
   *
   * @author  Stephane F
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
   * return  stdio
   * @author  Stephane F
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

public function MyMultiLingueGetLang() {

  return $this->lang;

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
      # Lang registered in PLuxXML, we build the HTML for the language item
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
public function MyMultiLingueStaticAllLang($pageurl) {

  if(isset($pageurl)) {
    $pageurl = $pageurl;
  } else {
    $pageurl = "";
  }

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
    if (file_exists($LangAvailable) OR file_exists($episode01_tester)) {
      $websitetranslated = 0;
      if (file_exists($LangAvailable)){
      $websitetranslated = 10;
      }
      $totalepisodecount = 0;
      $translationcompletion = 0;
      $epfolders = glob("0_sources/ep[0-9][0-9]*");
      sort($epfolders);
      foreach($epfolders as $foldername) {
        $totalepisodecount = $totalepisodecount + 1;
        $testfolderpath = $foldername.'/lang/'.$lang;
        if(is_dir($testfolderpath)) {
          $translationcompletion = $translationcompletion + 1;
        }
      }

      $percent = ( $translationcompletion / $totalepisodecount ) * 90 + $websitetranslated;
      $percent = round($percent, 0);
      $LangString .= '<?php echo "<li class=\"'.$sel.'\"><a href=\"".$plxShow->plxMotor->urlRewrite("'.$lang.'/'.$pageurl.'")."\"';
      $LangString .= ' title=\"'.$translationcompletion.' on '.$totalepisodecount.' episodes translated, ';
      if ($websitetranslated == 10 ){
      $LangString .= 'website is translated.\">';
      } else {
      $LangString .= 'website is not translated.\">';
      }
      $LangString .= ''.$aLabels[$lang].' ';
      $LangString .= '<span class=\"percent\" >'.$percent.'%</span> ';
      if ($percent == 100 ){
        $LangString .= '<img src=\"themes/peppercarrot-theme_v2/ico/star.svg\" alt=\"star,\" title=\"Translation complete! Congratulation.\"/>';
      }
      $LangString .= '</a></li>"; ?>';
    }
  }
  # Display results
  echo $LangString;
}


  /*****************************************/
  /* Display the HD and transcript buttons */
  /*****************************************/
  /**
   * Method to display the "HD" and "Transcript" toggle buttons for the comic page in the target langage
   * Main input: the vignette of the article
   * @author: GunChleoc
   **/
  public function MyMultiLingueComicToggleButtons($params) {
    # Initialize episode object
    $plxShow = plxShow::getInstance();
    $this->comic->initialize($this->lang, plxMotor::getInstance()->plxRecord_arts->f('thumbnail'), $plxShow);

    # Show buttons
    $this->comic->transcript_button->printHtml(!empty($this->comic->transcripts), $plxShow);
    $this->comic->hd_button->printHtml(true, $plxShow);
  }


  /********************************/
  /* Display the comicpages       */
  /********************************/
  /**
   * Method to display the full comic page in the target langage ( without header )
   * Main input: the vignette of the article
   * @author: David Revoy
   **/
  public function MyMultiLingueComicDisplay() {

    # Initialize episode object
    $plxShow = plxShow::getInstance();
    $this->comic->initialize($this->lang, plxMotor::getInstance()->plxRecord_arts->f('thumbnail'), $plxShow);

    // Get the keys and skip the first one (that's the header we already displayed)
    $keys = array_keys($this->comic->pagefiles);
    array_shift($keys);

    # For every pages found in the actual language with this file pattern
    foreach ($keys as $comicpage_number) {
      $comicpage_link = $this->comic->pagefiles[$comicpage_number];

      $this->comic->displayPage($comicpage_number, $this->lang, $plxShow);

      # Include html file with transcript if available
      if (array_key_exists($comicpage_number, $this->comic->transcripts)) {
        if ($this->comic->transcript_button->status()) {
          # User requested transcript, so we show it
          readfile($this->comic->transcripts[$comicpage_number]);
        } else {
          # Show tiny text anyway so that screen readers can pick it up
          echo '<div class="hidden">';
          readfile($this->comic->transcripts[$comicpage_number]);
          echo '</div>';
        }
      }
    }
  }


  /********************************/
  /* Display the Header page 00   */
  /********************************/
  /**
   * Method to display the page 00 (header) separately
   * Main input: the vignette of the article
   *
   * @author: David Revoy
   **/
  public function MyMultiLingueComicHeader() {

    # Initialize episode object
    $plxShow = plxShow::getInstance();
    $this->comic->initialize($this->lang, plxMotor::getInstance()->plxRecord_arts->f('thumbnail'), $plxShow);

    # If the episode hasn't been translated yet, show info about English
    if ($this->lang != $this->comic->usedlang) {
      echo '<br/>';
      echo '<div class="notice col sml-12 med-10 lrg-6 sml-centered lrg-centered med-centered sml-text-center">';
      echo '  <img src="themes/peppercarrot-theme_v2/ico/nfog.svg" alt="info:"/> English version <br/>(this episode is not yet available in your selected language.)';
      echo '</div>';
    }

    $this->comic->displayPage(0, $this->lang, $plxShow);

    $transcript_exists = array_key_exists(0, $this->comic->transcripts);

    # Include html file with transcript if available and display info if it is not.
    # Also include a dictionary button.
    if ($this->comic->transcript_button->status()) {
      if (!empty($this->comic->transcripts)) {
        echo '<div class="panel" align="center">';
          if ($transcript_exists) {
            readfile($this->comic->transcripts[0]);
          }
          // Display a button for opening this page in http://multidict.net/wordlink/
          echo '<div class="button top moka">';
            echo '<a href="https://multidict.net/wordlink/?sl=en&url=';
              print($plxShow->artUrl().urlencode('&transcript=1'));
              echo '" title="'.$plxShow->Getlang('NAVIGATION_DICTIONARY_ALT').'">'.$plxShow->Getlang('NAVIGATION_DICTIONARY').'</a>';
            echo '</div>';
          echo '</div>';
      } else {
        echo '<div class="panel notice" align="center">';
          echo ''.$plxShow->Getlang('NAVIGATION_TRANSCRIPT_UNAVAILABLE').'';
        echo '</div>';
      }
    } else if ($transcript_exists) {
      # User didn't request a transcript, but we show it for screen readers anyway.
      echo '<div class="hidden">';
      readfile($this->comic->transcripts[0]);
      echo '</div>';
    }
  }

/********************************/
/* Display the link to Source   */
/********************************/
/**
 * Method to display a link to the source of the active webcomic
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
  $plxShow->urlRewrite('?static6/sources&page='.$sourcelink);
}

/**********************************************/
/* Return the background-color of an episode   */
/**********************************************/
/**
 * Method to return an hex color for the background of an episode, from a json file
 * @author: David Revoy
 **/
public function MyMultiLingueBackgroundColor() {
  $plxMotor = plxMotor::getInstance();
  $plxShow = plxShow::getInstance();
  $aLabels = unserialize($this->getParam('labels'));
  $vignette = $plxMotor->plxRecord_arts->f('thumbnail');
  $vignette_parts = pathinfo($vignette);
  $path = $vignette_parts['dirname'];
  $parts = explode('/', $path);
  array_pop($parts);
  $episode_source_directory = implode('/', $parts);
  $jsonpath = $episode_source_directory."/info.json";
  if (file_exists($jsonpath)) {
    $contents = file_get_contents($jsonpath);
    $get = json_decode($contents);
    echo 'style="background:'.$get->{'background-color'}.'"';
  } else {
    echo 'style="background: #FFFFFF"';
  }
}

/********************************/
/* Display a link to Framagit   */
/********************************/
/**
 * Method to display a link to the Framagit folder of the active webcomic
 * @author: David Revoy
 **/
public function MyMultiLingueFramagitLinkDisplay() {
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
  $activelang = $this->lang;
  echo 'https://framagit.org/peppercarrot/webcomics/tree/master/'.$sourcelink.'/lang/'.$activelang.'';
}

/**************************************************************/
/* Display the number of comments and url from DR website     */
/**************************************************************/
/**
 * Method to display comments url on davidrevoy.com or number
 * nb_com = comment number
 * url = raw url
 * @author: David Revoy
 **/
public function MyMultiLingueCommentLinkDisplay($params) {
  $plxMotor = plxMotor::getInstance();
  $plxShow = plxShow::getInstance();
  if(isset($params)) {
    if(is_array($params)) {
      $type = empty($params[0])?'':$params[0];
    }
  } else {
    $type = '';
  }

  $jsonpath = "0_sources/comments.json";
  $contents = file_get_contents($jsonpath);
  $get = json_decode($contents);

  $aLabels = unserialize($this->getParam('labels'));
  $vignette = $plxMotor->plxRecord_arts->f('thumbnail');
  $vignette_parts = pathinfo($vignette);
  ## Remove the lang tag in the vignette filename, three first char (eg. en_, fr_ )
  $vignette_name = substr($vignette_parts['filename'], 3);
  ## Keep only last two digit of vignette filename because they are the episode number
  $episode_number = substr($vignette_name, -2);
  $path = $vignette_parts['dirname'];
  $parts = explode('/', $path);
  array_pop($parts);
  $episode_source_directory = implode('/', $parts);
  # pattern : index.php?fr/static6/sources&page=ep02_Rainbow-potions
  $sourcelink = basename($episode_source_directory);
  $activelang = $this->lang;
  # retrieve epXX
  $episodeid = 'ep'.$episode_number;

  # Display depending what variable user pass:
  if($type == 'url') {
    $comurl = $get->{$episodeid}->{'url'};
    echo $comurl;
  } else if ($type == 'nb_com') {
    $comnb = $get->{$episodeid}->{'nb_com'};
    echo $comnb;
  } else {
    echo '';
  }
}

}
?>
