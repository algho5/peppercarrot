<?php include(dirname(__FILE__).'/header.php'); 
# add library to parse markdown files
include(dirname(__FILE__).'/lib-parsedown.php');

# lang strings
$lang = $plxShow->getLang('LANGUAGE_ISO_CODE_2_LETTER');
$ccbystring = $plxShow->getLang('UTIL_BY');
$episodestring = $plxShow->getLang('UTIL_EPISODE');

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
    
    # + [display] datas are in the URL
    # Viewer mode : display the comic
    if(isset($_GET['display'])) {
        $imagename = $activeimage;
        echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
        echo '<br/><br/>';
        echo '</div>';
        echo '<section class="col sml-12 med-12 lrg-10 sml-centered sml-text-center" style="padding:0 0;">';
        # display picture
        echo '<a href="'.$pathcommunityfolder.'/'.$activefolder.'/'.$imagename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$pathcommunityfolder.'/'.$activefolder.'/'.$imagename.'&amp;w=970&amp&amp;s=1&amp;q=92" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
        #link source
        echo '<div class="col sml-12 med-12 lrg-12">';
        echo '<a class="sourcebutton" href="';
        echo ''.$pathcommunityfolder.'/'.$activefolder.'/'.$imagename.'';
        echo '"><br/>'; 
        echo '<b>'.$plxShow->Getlang('SOURCES_TITLE').':</b> '; 
        echo ''.$imagename.'';
        echo '<br/><br/></a>';
        echo '</div><br/>';
    
        echo '</section>';
        echo '<br/><br/><br/><br/><br/></div>';
    
    } else {
    
        # === Thumbnails of episodes ===
        $pathartworks = $pathcommunityfolder .'/'.$activefolder;
        $foldernameclean = str_replace('_', ' ', $foldername);
        $foldernameclean = str_replace('-', ' ', $foldernameclean);

        $foldernameclean = str_replace('by', '</h2><span class="font-size: 0.5rem;">'.$ccbystring.'', $foldernameclean);
        echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
        echo '<h2>'.$foldernameclean.'</span>';

        $hide = array('.', '..');
        $mainfolders = array_diff(scandir($pathartworks), $hide);
        
        # TODO: Real lang selector. 
        # $search = glob($pathartworks."/????-??-??_".$lang."*.jpg");
        if ($lang == "fr" ){ 
            $search = glob($pathartworks."/????-??-??_fr*.jpg");
            $contents = file_get_contents($pathartworks."/fr_infos.md");

        } else {
            $search = glob($pathartworks."/????-??-??_en*.jpg");
            $contents = file_get_contents($pathartworks."/en_infos.md");
        }
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
