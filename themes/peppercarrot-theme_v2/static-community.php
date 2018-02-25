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
	<main class="grid" role="main">
    <section class="col sml-12" style="padding: 0 0;">
<?php 
# [page] datas are in the URL
if(isset($_GET['page'])) {

    $foldername = $activefolder;
    $pathartworks = $pathcommunityfolder .'/'.$activefolder;
    $detectedlangs=array();
    
    # Prepare the lang detection
    $searchfiles = glob($pathartworks."/????-??-??_*.jpg");
    foreach ($searchfiles as $file) {
      $filename = basename($file);
      $filenameclean = substr($filename, 11); // rm iso date
      $filenameclean =  substr($filenameclean, 0, 2); // keep two letter ep number
      array_push($detectedlangs,$filenameclean);
    }
    $detectedlangscleaned = array_unique($detectedlangs);
    
    $matchinglang = 0;
    foreach ($detectedlangscleaned as $proposedlang) {
      if ($lang == $proposedlang){
        $matchinglang = 1;
      }
    }
    if ($matchinglang !== 1){
      echo '<div class="grid">';
      echo '<br/><div class="col sml-12 med-10 lrg-6 sml-centered lrg-centered med-centered sml-text-center alert blue">';
      echo '  <img src="themes/peppercarrot-theme_v2/ico/nfo.svg" alt="info:"/>';
      echo $plxShow->Getlang(LIMITATIONS);
      echo '</div>';
      echo '</div>';
      
    }
    
    $langISOurl = "0_sources/lang-ISO.json";
    $contents = file_get_contents($langISOurl);
    $contents = utf8_encode($contents);
    $langprettyname = json_decode($contents); 

    # + [display] datas are in the URL
    # Viewer mode : display the comic
    if(isset($_GET['display'])) {
        $imagename = $activeimage;
        
        # lang pills
        echo '<div class="grid">';
          echo '<div class="translabar col sml-12 med-12 lrg-12 sml-centered sml-text-center">';
            echo '<ul class="menu" role="toolbar">';
              foreach ($detectedlangscleaned as $langavailable) {
              
                $langimagenamepart1 = substr($imagename, 0, 11); // rm iso date
                $langimagenamepart2 = substr($imagename, 13); // rm iso date
                $langimagename = $langimagenamepart1.''.$langavailable.''.$langimagenamepart2;
                echo '<li><a href="?'.$langavailable.'/static11/community-webcomics&page='.$activefolder.'&display='.$langimagename.'">';
                echo $langprettyname->$langavailable;
                echo '</a></li>';
              }
            echo '<li><a class="lang option" href="'.$pathartworks.'"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> '.$addatranslationstring.'</a></li>';
            echo '</ul>';
          echo '</div>';
        echo '</div>';
        
        echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
        echo '<br/><br/>';
        echo '</div>';
        echo '<section class="col sml-12 med-12 lrg-10 sml-centered sml-text-center" style="padding:0 0;">';
        # display picture
        if ($matchinglang !== 1){
          $lang = "en";
        }
        $imagename = $langimagenamepart1.''.$lang.''.$langimagenamepart2;
        echo '<a href="'.$pathcommunityfolder.'/'.$activefolder.'/'.$imagename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$pathcommunityfolder.'/'.$activefolder.'/'.$imagename.'&amp;w=970&amp&amp;s=1&amp;q=92" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
        #link source
        echo '<div class="col sml-12 med-12 lrg-12">';
        echo '<a class="sourcebutton" href="';
        echo ''.$pathcommunityfolder.'/'.$activefolder.'/'.$imagename.'';
        echo '">'; 
        echo ''.$plxShow->Getlang('SOURCES_TITLE').': '; 
        echo ''.$imagename.'';
        echo '</a>';
        echo '</div><br/>';
    
        echo '</section>';
        echo '<br/><br/><br/><br/><br/></div>';
    
    } else {
    
        # === Thumbnails of episodes ===
        
        # lang pills
        echo '<div class="grid">';
          echo '<div class="translabar col sml-12 med-12 lrg-12 sml-centered sml-text-center">';
            echo '<ul class="menu" role="toolbar">';
              foreach ($detectedlangscleaned as $langavailable) {
                echo '<li><a href="?'.$langavailable.'/static11/community-webcomics&page='.$activefolder.'">';
                echo $langprettyname->$langavailable;
                echo '</a></li>';
              }
            echo '<li><a class="lang option" href="'.$pathartworks.'"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> '.$addatranslationstring.'</a></li>';
            echo '</ul>';
          echo '</div>';
        echo '</div>';
    
        $foldernameclean = str_replace('_', ' ', $foldername);
        $foldernameclean = str_replace('-', ' ', $foldernameclean);

        $foldernameclean = str_replace('by', '</h2><span class="font-size: 0.5rem;">'.$ccbystring.'', $foldernameclean);
        echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
        echo '<h2>'.$foldernameclean.'</span>';
        
        $hide = array('.', '..');
        $mainfolders = array_diff(scandir($pathartworks), $hide);
                
        if (!file_exists($pathartworks.'/'.$lang.'_infos.md')) {
          if ($matchinglang !== 1){
            $lang = "en";
          }
        }
        $contents = file_get_contents($pathartworks.'/'.$lang.'_infos.md');
        if ($matchinglang !== 1){
          $lang = "en";
        }
        $search = glob($pathartworks.'/????-??-??_'.$lang.'*.jpg');

        $Parsedown = new Parsedown();
        echo $Parsedown->text($contents);

        echo '<br/><br/>';
        echo '</div>';
        echo '<section class="col sml-12 med-12 lrg-10 sml-centered sml-text-center" style="padding:0 0;">';

        rsort($search);
        # we loop on found episodes
        if (!empty($search)){ 
          foreach ($search as $filepath) {
            # filename extraction
            $fileweight = (filesize($filepath) / 1024) / 1024;
            $filename = basename($filepath);
            $fullpath = dirname($filepath);
            $dateextracted = substr($filename,0,10).'';
            $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
            $filenameclean = substr($filenameclean, 13); // rm iso date
            $filenameclean =  substr($filenameclean, 0, 3); // keep two letter ep number
            $filenameclean = str_replace('_', ' ', $filenameclean);
            $filenameclean = str_replace('-', ' ', $filenameclean);

            echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
            echo '<a href="?static11/community-webcomics&page='.$activefolder.'&display='.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=370&amp;h=370&amp;s=1&amp;q=92" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
            echo '<figcaption class="text-center" >
            <a href="0_sources/0ther/fan-art/'.$filename.'" >
            '.$episodestring.' '.$filenameclean.'
            <br/><span class="detail">'.$dateextracted.'</span><br/>
            </figcaption>
            <br/><br/>';
            echo '</figure>';
          }
        }
        echo '</section>';
        echo '</div>';
    }
    
} else {
# === Main menu, listing folders ===
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
    echo '<a href="?static11/community-webcomics&page='.$folderpath.'/" ><img src="plugins/vignette/plxthumbnailer.php?src='.$pathcommunityfolder .'/'.$folderpath.'/00_cover.jpg&amp;w=370&amp;h=370&amp;s=1&amp;q=92" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
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
