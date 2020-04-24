<?php include(dirname(__FILE__).'/header.php');
# add library to parse markdown files
include(dirname(__FILE__).'/lib-parsedown.php');

# lang strings
$lang = $plxShow->callHook('MyMultiLingueGetLang');
$ccbystring = $plxShow->getLang('UTIL_BY');
$episodestring = $plxShow->getLang('UTIL_EPISODE');
$addatranslationstring = $plxShow->getlang('ADD_TRANSLATION');

# get new variable 'folder'
$activefolder = htmlspecialchars($_GET["page"]);
# get new variable 'display'
$activeimage = htmlspecialchars($_GET["display"]);
# get new variable 'lang'
$requestedlang = htmlspecialchars($_GET["l"]);

# Security, remove all special characters except A-Z, a-z, 0-9, dots, hyphens, underscore before interpreting something.
$activefolder = preg_replace('/[^A-Za-z0-9\._-]/', '', $activefolder);
$activeimage = preg_replace('/[^A-Za-z0-9\._-]/', '', $activeimage);
$requestedlang = preg_replace('/[^A-Za-z0-9\._-]/', '', $requestedlang);
$pathcommunityfolder = '0_sources/0ther/community';


# Helper function for navigator
function localize_image($lang, $filepath) {
    # Split language from rest of image name
    preg_match('/^[a-z]{2}(_[A-Za-z-_]+_E\d+P01_[A-Za-z-]*.(jpg|gif))$/', basename($filepath), $matches);
    return $lang.$matches[1];
}


function show_navigator($firstEpisode, $previousEpisode, $nextEpisode, $lastEpisode, $buttonthemeActive, $buttonthemeInactive) {
    global $plxShow;
    # TODO more width
    # TODO add titles
    ?>
<div class="readernav col sml-12 med-12 lrg-12 sml-centered">
  <div class="grid">

  <div class="col sml-hide sml-12 med-3 lrg-3 med-show">
    <div class="<?php echo ''.$buttonthemeActive.''; ?>">
      <a class="readernavbutton" style="text-align:left;" href="<?php print($firstEpisode); ?>">
        &nbsp; « &nbsp; <?php $plxShow->lang('FIRST') ?>
      </a>
    </div>
  </div>

  <div class="col sml-6 med-3 lrg-3">
    <div class="<?php
        if ($previousEpisode === '#') {
            echo ''.$buttonthemeInactive.' off';
        } else {
            echo ''.$buttonthemeActive.'';
        }
    ?>">
      <a class="readernavbutton" style="text-align:left;" href="<?php print($previousEpisode); ?>">
        &nbsp; &lt; &nbsp; <?php $plxShow->lang('UTIL_PREVIOUS_EPISODE') ?>
      </a>
    </div>
  </div>

  <div class="col sml-6 med-3 lrg-3">
    <div class="<?php
        if ($nextEpisode === '#') {
            echo ''.$buttonthemeInactive.' off';
        } else {
            echo ''.$buttonthemeActive.'';
        }
    ?>">
      <a class="readernavbutton" style="text-align:right;" href="<?php print($nextEpisode); ?>">
        <?php $plxShow->lang('UTIL_NEXT_EPISODE') ?>&nbsp; &gt; &nbsp;
      </a>
    </div>
  </div>

  <div class="col sml-hide sml-12 med-3 lrg-3 med-show">
    <div class="<?php echo ''.$buttonthemeActive.''; ?>">
      <a class="readernavbutton" style="text-align:right;" href="<?php print($lastEpisode); ?>">
        <?php $plxShow->lang('LAST') ?>&nbsp; » &nbsp;
      </a>
    </div>
  </div>

  </div>
</div>
    <?php
}

?>
<div class="container">
	<main class="main grid" role="main">
    <section class="col sml-12" style="padding: 0 0;">
<?php
# [page] datas are in the URL
if(isset($_GET['page'])) {

    $pathartworks = $pathcommunityfolder .'/'.$activefolder;

    $baselink = "static11/communitywebcomics&page=$activefolder";

    # We can't count on contributions having a structured git repo, so we list the contribution links here.
    # Empty link means don't show any "add a translation" buttons for ths active folder.
    $contributionlinks = array(
        'Pepper-and-Carrot_by_Holger-Kraemer' => '',
        'Pepper-and-Carrot-Mini_by_Nartance' => 'https://framagit.org/peppercarrot/derivations/peppercarrot_mini/blob/master/CONTRIBUTING.md'
    );
    $contributionlink = $contributionlinks[$activefolder];


# Image viewer mode : display the artwork
# =======================================
# (a "page" variable passed)
# (a "display" variable passed)

    if (isset($_GET['display'])) {
        # Split language from rest of image name
        preg_match('/^([a-z]{2})((_[A-Za-z-_]+_E\d+)P01_[A-Za-z-]*.(jpg|gif))$/', $activeimage, $matches);

        # We get the wrong language from MyMultiLingueGetLang here, so setting it from this image
        $lang = $matches[1];
        $plxShow->callHook('MyMultiLingueSetLang', $lang);

        # Filename parts we'll need for the listing below
        $langimagewithoutlang = $matches[2];
        $episodeprefixwithoutlang = $matches[3];

        # Language menu
        echo '<div class="grid">';
          echo '<div class="col sml-12 sml-text-right">';
            echo '<nav class="nav" role="navigation">';
              echo '<div class="responsive-langmenu">';
                echo '<div class="button top">';
                  echo '<a href="'.$lang.'/'.$baselink.'/" class="lang option">← Back to index</a>';
                echo '</div>';
                eval($plxShow->callHook('MyMultiLingueLanguageMenu', array(
                        'pageurl' => '{LANG}/'.$baselink.'&display={LANG}'.$langimagewithoutlang,
                        'testdir' => $pathartworks,
                        'includewebsite' => false,
                        'contributionlink' => $contributionlink
                )));
              echo '</div>';
            echo '</nav>';
          echo '</div>';
        echo '</div>';
        echo '<div style="clear:both;"></div> ';


        # Episode path + filename for localized version
        $pages = glob($pathcommunityfolder.'/'.$activefolder.'/'.$lang.$episodeprefixwithoutlang.'*.???');

        if (empty($pages)) {
            # Fall back to English
            $pages = glob($pathcommunityfolder.'/'.$activefolder.'/en'.$episodeprefixwithoutlang.'*.???');
            echo '<br/>';
            echo '<div class="notice col sml-12 med-10 lrg-6 sml-centered lrg-centered med-centered sml-text-center">';
            echo '  <img src="themes/peppercarrot-theme_v2/ico/nfog.svg" alt="info:"/> English version <br/>(this episode is not yet available in your selected language.)';
            echo '</div><br>';
        }

        # Compute links for navigator
        $episodes = glob($pathartworks.'/en*P01*.jpg');
        $number_of_episodes = count($episodes);

        $current = 'en'.$langimagewithoutlang;

        $firstEpisode = "$lang/$baselink&display=".localize_image($lang, $episodes[0]);
        $previousEpisode = "#";
        $lastEpisode = "$lang/$baselink&display=".localize_image($lang, $episodes[count($episodes) - 1]);
        $nextEpisode = "#";

        for ($i = 0; $i < $number_of_episodes; $i++) {
            if (basename($episodes[$i]) === $current) {
                if ($i > 0) {
                    $previousEpisode = "$lang/$baselink&display=".localize_image($lang, $episodes[$i - 1]);
                }
                if ($i < $number_of_episodes - 1) {
                    $nextEpisode = "$lang/$baselink&display=".localize_image($lang, $episodes[$i + 1]);
                }
                break;
            }
        }

        # Show the navigator
        show_navigator($firstEpisode, $previousEpisode, $nextEpisode, $lastEpisode, '', '');

        # Write the viewer:
        echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
        echo '<br/><br/>';
        echo '</div>';
        echo '<section class="col sml-12 med-12 lrg-10 sml-centered sml-text-center" style="padding:0 0;">';

        foreach ($pages as $pagepath) {
            echo '<a href="'.$pagepath.'" ><img src="'.$pagepath.'" ></a><br/>';
        }

        show_navigator($firstEpisode, $previousEpisode, $nextEpisode, $lastEpisode, 'button', 'button moka');
        echo '<br/><br/>';

        echo '<div class="button col sml-centered lrg-3">';
        echo '    <a href="'.$lang.'/'.$baselink.'/" class="readernavbutton">← Back to index</a>';
        echo '</div>';

        echo '</section>';
        echo '<br/><br/><br/>';
    } else {

# Thumbnails mode
# ===============
# (a "page" variable passed)
# (no "display" variable passed)

        # Language menu
        echo '<div class="grid">';
          echo '<div class="col sml-12 sml-text-right">';
            echo '<nav class="nav" role="navigation">';
              echo '<div class="responsive-langmenu">';
                eval($plxShow->callHook('MyMultiLingueLanguageMenu', array(
                        'pageurl' => '{LANG}/'.$baselink,
                        'testdir' => $pathartworks,
                        'includewebsite' => false,
                        'statstemplate' => $pathartworks.'/{LANG}_[A-Za-z-]*_E[0-9][0-9]*[A-Za-z_-]*.jpg',
                        'contributionlink' => $contributionlink
                )));
              echo '</div>';
            echo '</nav>';
          echo '</div>';
        echo '</div>';
        echo '<div style="clear:both;"></div> ';

        # Display the title of the project and markdown:
        $foldernameclean = str_replace('_', ' ', $activefolder);
        $foldernameclean = str_replace('-', ' ', $foldernameclean);
        $foldernameclean = str_replace('by', '</h2><span class="font-size: 0.5rem;">'.$ccbystring.'', $foldernameclean);
        echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
        echo '<h2>'.$foldernameclean.'</span>';
        $hide = array('.', '..');
        $mainfolders = array_diff(scandir($pathartworks), $hide);
        if (file_exists($pathartworks.'/'.$lang.'_infos.md')) {
          $contents = file_get_contents($pathartworks.'/'.$lang.'_infos.md');
        } else {
          $contents = file_get_contents($pathartworks.'/en_infos.md');
        }
        $Parsedown = new Parsedown();
        echo '<div style="max-width: 910px; margin: 0 auto;">';
        echo $Parsedown->text($contents);
        echo '</div>';
        echo '<br/><br/>';
        echo '</div>';

        # Display episodes
        echo '<section class="col sml-12 med-12 lrg-10 sml-centered sml-text-center" style="padding:0 0;">';

        $thumbnailwidth = 370;
        $thumnailheight = 370;
        $wordwrapchars = 40;

        # Display thumbnails with links, using English as reference locale
        $search = glob($pathartworks.'/en*P01*.jpg');
        rsort($search);
        # we loop on found episodes
        if (!empty($search)){
          foreach ($search as $fallback_filepath) {
            # Extract 1. filename without locale and 2. the episode number
            preg_match('/^[a-z]{2}(_[A-Za-z-_]+_E(\d+)P01_[A-Za-z-]*.(jpg|gif))$/', basename($fallback_filepath), $matches);

            # episode path + filename for localized version
            $filename = $lang.$matches[1];
            $filepath = $pathartworks.'/'.$filename;

            # "Episode" + number for caption and title
            $episodetitle = $episodestring.' '.$matches[2];
            $tooltip = $episodetitle . ', click to read';
            $caption = wordwrap($episodetitle, $wordwrapchars, "<br />\n", true);

            # TODO adapted from vignette.php => vignetteArtList. Let's see what we can unify.
            if (file_exists($filepath)) {
                # We have a translated cover.
                $translationstatus = 'translated';
            } else {
                # English fallback.
                $filepath = $fallback_filepath;
                $translationstatus = 'notranslation';
                $tooltip .= ' '. $plxShow->getLang('TRANSLATION_FALLBACK');
                $caption .= '<br /><span class="detail">' . wordwrap($plxShow->getLang('TRANSLATION_FALLBACK'), $wordwrapchars, "<br />\n", true). '</span>';
            }

            $row = '
            <a href="{art_url}" title="{art_title}">
                <figure class="thumbnail {translationstatus} col sml-12 med-6 lrg-4" style="padding:0 1rem 0 0;">
                    <img class="{translationstatus}" src="plugins/vignette/plxthumbnailer.php?src={episode_vignette}&amp;w={width}&amp;h={height}&amp;s=1&amp;q=92" alt="{art_title}" title="{art_title}" />
                    <br/>
                    <figcaption class="text-center">{caption}</figcaption>
                    <br/><br/>
                </figure>
            </a>';

            # art url always goes to the translated version - we deal with English fallback over there.
            $row = str_replace('{art_url}', $lang.'/'.$baselink.'&display='.$lang.$matches[1], $row);
            $row = str_replace('{art_title}', $tooltip, $row);
            $row = str_replace('{episode_vignette}', $filepath, $row);
            $row = str_replace('{translationstatus}', $translationstatus, $row);
            $row = str_replace('{caption}', $caption, $row);
            $row = str_replace('{width}', $thumbnailwidth, $row);
            $row = str_replace('{height}', $thumnailheight, $row);
            echo $row;
          }
        }
        echo '</section>';
    }

} else {

# Main menu
# =========
# (no "page" variable passed)

  echo "<h2>";
  $plxShow->lang('WEBCOMICS');
  echo "</h2>";

  $hide = array('.', '..');
  $mainfolders = array_diff(scandir($pathcommunityfolder), $hide);
  sort($mainfolders);

  # we loop on found episodes
  foreach ($mainfolders as $folderpath) {
    # Name extraction
    $filename = basename($folderpath);
    $filenameclean = str_replace('_', ' ', $filename);
    $filenameclean = str_replace('-', ' ', $filenameclean);
    $filenameclean = str_replace('featured', '', $filenameclean);
    $filenameclean = str_replace('by', '</a><br/><span class="detail">'.$ccbystring.'', $filenameclean);
    $filenamezip = str_replace('jpg', 'zip', $filename);
    echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
    echo '<a href="'.$lang.'/static11/communitywebcomics&page='.$folderpath.'/" ><img src="plugins/vignette/plxthumbnailer.php?src='.$pathcommunityfolder .'/'.$folderpath.'/00_cover.jpg&amp;w=370&amp;h=370&amp;s=1&amp;q=92" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
    echo '<figcaption class="text-center" >
    <a href="0_sources/0ther/fan-art/'.$filename.'" >
    '.$filenameclean.'
    '.$dateextracted.'</span><br/>
    </figcaption>
    <br/><br/>';
    echo '</figure>';
  }
}

?>

    </section>
	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
