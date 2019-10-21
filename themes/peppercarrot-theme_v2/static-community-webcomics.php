<?php include(dirname(__FILE__).'/header.php'); 
# add library to parse markdown files
include(dirname(__FILE__).'/lib-parsedown.php');

# lang strings
$lang = $plxShow->getLang('LANGUAGE_ISO_CODE_2_LETTER');
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
?>
<div class="container">
	<main class="main grid" role="main">
    <section class="col sml-12" style="padding: 0 0;">
<?php 
# [page] datas are in the URL
if(isset($_GET['page'])) {

    $foldername = $activefolder;
    $pathartworks = $pathcommunityfolder .'/'.$activefolder;
    $detectedlangs=array();
    
# Check available languages
# =========================
    
    # Detect the amount of language to display by scanning threw available files
    $searchfiles = glob($pathartworks."/??_*by-*.jpg");
    foreach ($searchfiles as $file) {
      $filename = basename($file);
      $filenameclean =  substr($filename, 0, 2); // keeps only two letter ISO lang
      array_push($detectedlangs,$filenameclean);
    }
    $detectedlangscleaned = array_unique($detectedlangs);
    
    $matchinglang = 0;
    # We check if content exist for user with active lang selected
    foreach ($detectedlangscleaned as $proposedlang) {
      if ($lang == $proposedlang){
        $matchinglang = 1;
      }
    }

    # When no lang available, display a message:
    if ($matchinglang !== 1){
      echo '<div class="grid">';
      echo '<br/><div class="col sml-12 med-10 lrg-6 sml-centered lrg-centered med-centered sml-text-center alert blue">';
      echo '  <img src="themes/peppercarrot-theme_v2/ico/nfo.svg" alt="info:"/>';
      echo $plxShow->Getlang(LIMITATIONS);
      echo '</div>';
      echo '</div>';
      
    }
    
# Image viewer mode : display the artwork
# =======================================
# (a "page" variable passed)
# (a "display" variable passed)

    if(isset($_GET['display'])) {
        $imagename = $activeimage;
        
        # Write lang pills for the viewer
        # Challenge: the pills must translate the image displayed.
        echo '<div class="grid">';
          echo '<div class="col sml-12 sml-text-right">';
            echo '<nav class="nav" role="navigation">';
              echo '<div class="responsive-langmenu">';
              echo '<div class="button top">';
                echo '<a href="static11/communitywebcomics&page=Pepper-and-Carrot-Mini_by_Nartance/" class="lang option">← Back to index</a>';
              echo '</div>';
                echo '<label for="langmenu"><span class="translabutton"><img src="themes/peppercarrot-theme_v2/ico/language.svg" alt=""/>'.$langlabel.'<img src="themes/peppercarrot-theme_v2/ico/dropdown.svg" alt=""/></span></label>';
                  echo '<input type="checkbox" id="langmenu">';
                    echo '<ul class="langmenu expanded">';
                      foreach ($detectedlangscleaned as $langavailable) {
                        $langimagewithoutlang = substr($imagename, 2); // rm old lang
                        $langimagename = $langavailable.''.$langimagewithoutlang;
                        if (file_exists($pathartworks.'/'.$langimagename.'')) {
                          echo '<li class="button"><a class="lang" href="?'.$langavailable.'/static11/communitywebcomics&page='.$activefolder.'&display='.$langimagename.'">';
                          $langprettyname = $get->{$langavailable}->{'name'};
                          echo $langprettyname;
                          echo '</a></li>';
                        }
                      }
                      echo '<li class="button" ><a class="lang option" href="https://framagit.org/peppercarrot/derivations/peppercarrot_mini/blob/master/CONTRIBUTING.md"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> '.$addatranslationstring.'</a></li>';
                echo '</ul>';
            echo '</nav>';
          echo '</div>';
        echo '</div>';
        echo '<div style="clear:both;"></div> ';
        
        # Write the viewer:
        echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
        echo '<br/><br/>';
        echo '</div>';
        echo '<section class="col sml-12 med-12 lrg-10 sml-centered sml-text-center" style="padding:0 0;">';

        $imagename = $activeimage;
        echo '<a href="'.$pathcommunityfolder.'/'.$activefolder.'/'.$imagename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$pathcommunityfolder.'/'.$activefolder.'/'.$imagename.'&amp;w=970&amp&amp;s=1&amp;q=92" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
        
        echo '<div class="button top">';
          echo '<a href="static11/communitywebcomics&page=Pepper-and-Carrot-Mini_by_Nartance/" class="lang option">← Back to index</a>';
        echo '</div>';
              
        echo '</section>';
        echo '<br/><br/><br/><br/><br/></div>';
    
    } else {
    
# Thumbnails mode
# ===============
# (a "page" variable passed)
# (no "display" variable passed)
        
        # lang pills
        echo '<div class="grid">';
          echo '<div class="col sml-12 sml-text-right">';
            echo '<nav class="nav" role="navigation">';
              echo '<div class="responsive-langmenu">';
                echo '<label for="langmenu"><span class="translabutton"><img src="themes/peppercarrot-theme_v2/ico/language.svg" alt=""/> Translations<img src="themes/peppercarrot-theme_v2/ico/dropdown.svg" alt=""/></span></label>';
                  echo '<input type="checkbox" id="langmenu">';
                    echo '<ul class="langmenu expanded">';
                      foreach ($detectedlangscleaned as $langavailable) {
                        echo '<li><a href="?'.$langavailable.'/static11/communitywebcomics&page='.$activefolder.'">';
                        echo $langprettyname->$langavailable;
                        echo '</a></li>';
                      }
                      echo '<li><a class="lang option" href="https://framagit.org/peppercarrot/derivations/peppercarrot_mini/blob/master/CONTRIBUTING.md"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> '.$addatranslationstring.'</a></li>';
                echo '</ul>';
            echo '</nav>';
          echo '</div>';
        echo '</div>';
        echo '<div style="clear:both;"></div> ';
        
        # Display the title of the project and markdown:   
        $foldernameclean = str_replace('_', ' ', $foldername);
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
        $search = glob($pathartworks.'/'.$lang.'*.jpg');
        rsort($search);
        # we loop on found episodes
        if (!empty($search)){ 
          foreach ($search as $filepath) {
            # episode number extraction
            $filename = basename($filepath);
            $fullpath = dirname($filepath);
            $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
            $filenameclean = substr($filenameclean, 11); // remove 11 first characters
            $filenameclean =  substr($filenameclean, 0, 2); // keeps two numbers
            $filenameclean = str_replace('_', ' ', $filenameclean);
            $filenameclean = str_replace('-', ' ', $filenameclean);

            echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
            echo '<a href="?static11/communitywebcomics&page='.$activefolder.'&display='.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=370&amp;h=370&amp;s=1&amp;q=92" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
            echo '<figcaption class="text-center" >
            <a href="?static11/communitywebcomics&page='.$activefolder.'&display='.$filename.'" >
            '.$episodestring.' '.$filenameclean.'
            </figcaption>
            <br/><br/>';
            echo '</figure>';
          }
        }
        echo '</section>';
        echo '</div>';
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
    echo '<a href="?static11/communitywebcomics&page='.$folderpath.'/" ><img src="plugins/vignette/plxthumbnailer.php?src='.$pathcommunityfolder .'/'.$folderpath.'/00_cover.jpg&amp;w=370&amp;h=370&amp;s=1&amp;q=92" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
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
