<?php 
include(dirname(__FILE__).'/lib-parsedown.php');
include(dirname(__FILE__).'/header.php');

$lang = $plxShow->getLang('LANGUAGE_ISO_CODE_2_LETTER');
// get new variable 'folder'
$activefolder = htmlspecialchars($_GET["page"]);
// get new variable 'lang'
$requestedlang = htmlspecialchars($_GET["l"]);
// get new variable 'episode'
$requestedepisode = htmlspecialchars($_GET["e"]);

// Security, remove all special characters except A-Z, a-z, 0-9, dots, hyphens, underscore before interpreting something. 
$activefolder = preg_replace('/[^A-Za-z0-9\._-]/', '', $activefolder);
$requestedlang = preg_replace('/[^A-Za-z0-9\._-]/', '', $requestedlang);
$requestedepisode = preg_replace('/[^A-Za-z0-9\._-]/', '', $requestedepisode);

# debug
#echo $activefolder;

if(isset($_GET['page'])) {

# main HTML container:
echo '<div class="container">';
echo '<main class="main grid" role="main">';
echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
echo '<div class="grid">';

# List Folder Content

  $path = '0_sources/';
  $projectpath = $path.$activefolder;
  $foldername = $activefolder;
  #Ensure a folder exist
  if(is_dir($projectpath)) {
    echo '<article class="source col sml-12 med-12 lrg-10 sml-centered" role="article" style="font-size: 93%">';
    echo '<div class="grid">';
    # beautify name
    $rawfoldername = $foldername;
    $foldername = str_replace('_', ' : ', $foldername);
    $foldername = str_replace('-', ' ', $foldername);
    if (strpos($rawfoldername, 'new-') !== false) {
      echo '<div class="col sml-12 med-12 lrg-12">';
      echo '<h3>BETA VERSION:  ('.$foldername.')</h3>';
      echo '<p><b>Spoiler alert! Please, do not reshare this page</b>: This episode is still in development and is not meant to be ready for public. It\'s published here only to help proofreader and contributors of Pepper&Carrot ( <a href="static6/sources&page=XYZ">XYZ is here</a> ). If you want to help and give a feedback, <a href="https://framagit.org/peppercarrot/webcomics/issues?scope=all&utf8=%E2%9C%93&state=all&label_name[]=future%20episode">join our latest thread on Framagit here.</a></p>';
      echo '</div>';
    } else {
      echo '<div class="col sml-12 med-12 lrg-12">';
      echo '<h3>'.$foldername.'</h3>';
      echo '</div>';
    }
    
    
    echo '<div class="col sml-12 med-4 lrg-4">';
    
    # we scan the vignette
    # we scan all en vignette to define all episodes , it's a constant
    $search = glob($projectpath."/low-res/en_*E??.jpg");
    # we loop on found episodes
    if (!empty($search)){ 
    foreach ($search as $filepath) {
    # filename extraction
    $fileweight = (filesize($filepath) / 1024) / 1024;
    $filename = basename($filepath);
    $fullpath = dirname($filepath);
    # guess from pattern name of hypothetic translation
    $filenamewithoutenprefix = substr($filename, 2);
    $filepathtranslated = ''.$fullpath.'/'.$lang.''.$filenamewithoutenprefix.'';
    # if our hypothetic translation exist, display. Else, fallback to english :
    if (file_exists($filepathtranslated)) {
    echo '<img src="plugins/vignette/plxthumbnailer.php?src='.$filepathtranslated.'&amp;w=290&amp;h=230&amp;s=1&amp;q=88" alt="'.$foldername.'" title="'.$foldername.'" ><br/>';
    } else {
    echo '<img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=290&amp;h=230&amp;s=1&amp;q=88" alt="'.$foldername.'" title="'.$foldername.'" ><br/>';
    }
    }
    }else{ 
    # no vignette, take any jpg at the root
    $search = glob($projectpath."/*.jpg");
    if (!empty($search)){ 
    foreach ($search as $filepath) {
    $filename = basename($filepath);
    $fileweight = (filesize($filepath) / 1024) / 1024;
    echo '<img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=290&amp;h=230&amp;s=1&amp;q=90" alt="'.$foldername.'" title="'.$foldername.'" ><br/>';
    }
    }
    }

        
    # === COVER ===
    $search = glob($projectpath."/low-res/*E??.jpg");
    if (!empty($search)){ 
      echo '<br/>';
      echo ''.$plxShow->Getlang('SOURCE_COVER').'<br/>';
      foreach ($search as $filepath) {
        $filename = basename($filepath);
        $filename = str_replace('_by-David-Revoy', '', $filename);
        $fileweight = (filesize($filepath) / 1024) / 1024;
        echo '<a href="'.$filepath.'" target="_blank" >
        '.$filename.' <em class="filesize">'.round($fileweight, 2).'MB
        </em></a><br />';
      }
    }
    # + cover gfx-only
    $search = glob($projectpath."/low-res/gfx-only/*E??.jpg");
    if (!empty($search)){ 
    foreach ($search as $filepath) {
    $filename = basename($filepath);
    $filename = str_replace('_by-David-Revoy', '', $filename);
    $fileweight = (filesize($filepath) / 1024) / 1024;
    echo '<a href="'.$filepath.'" target="_blank" >
    '.$filename.' <em class="filesize">'.round($fileweight, 2).'MB 
    </em></a><br />';
    }
    } 
    # single-pages
    $search = glob($projectpath."/low-res/single-page/*.jpg");
    if (!empty($search)){ 
    echo '<br/> ';
    $plxShow->lang('SOURCE_MONTAGE');
    echo '<br/>';
    foreach ($search as $filepath) {
    $filename = basename($filepath);
    $filename = str_replace('_by-David-Revoy', '', $filename);
    $fileweight = (filesize($filepath) / 1024) / 1024;
    echo '<a href="'.$filepath.'" target="_blank" >
    '.$filename.' <em class="filesize">'.round($fileweight, 2).'MB </em></a><br />';
    } 
    }
    echo '</div>';
    
    # ***************************************** RIGHT COLUMN *******************************************
    
    # ##### TOP BIG BUTTONS ########

    echo '<div class="col sml-12 med-8 lrg-8">';
    
    # KRITA SOURCE PACK (Self hosted)
    #
    $search = glob($projectpath."/zip/*_art-pack.zip");
    if (!empty($search)){ 
      echo '<div class="buttonkrazip">'; 
      echo '<img style="float:left; margin-right:10px;" src="themes/peppercarrot-theme_v2/ico/paint.svg" alt=""/> ';
      $plxShow->lang('SOURCE_KRITA');
      echo'<br/>';
      foreach ($search as $filepath) {
        $filename = basename($filepath);
        $fileweight = (filesize($filepath) / 1024) / 1024;
        echo '<a href="'.$filepath.'" target="_blank" >
        '.$filename.' <em class="filesize">'.round($fileweight, 2).'MB </em></a><br />';
      }
      echo '</div>';
    } 
    
    # LANG PACK (Self hosted)
    #
    $search = glob($projectpath."/zip/*_lang-pack.zip");
    if (!empty($search)){ 
      echo '<div class="buttonlangzip">';  
      echo '<img style="float:left; margin-right:10px;" src="themes/peppercarrot-theme_v2/ico/lang.svg" alt=""/>  ';
      $plxShow->lang('SOURCE_TRANSLATOR');
      echo ' <span style="font-size:0.8em">(<a href="';
      $plxShow->urlRewrite('?static14/documentation&page=010_Translate_the_comic');
      echo'">?</a>)</span><br/>';
      foreach ($search as $filepath) {
        $filename = basename($filepath);
        $fileweight = (filesize($filepath) / 1024) / 1024;
        echo '<a href="'.$filepath.'" target="_blank" >
        '.$filename.' <em class="filesize">'.round($fileweight, 2).'MB </em></a><br />';
      }
      echo '</div>';
    } 
    
    echo '<div class="grid">';
    
    # ***************************************** UNDER BUTTONS *******************************************

    # DISPLAY PAGES THUMBNAILS
    #
    echo '<div class="col sml-12">';
    # we scan all the valid pattern pages inside episode folder
    $search = glob($projectpath."/low-res/gfx-only/*P[0-9][0-9].*");
    # request last page of array
    $last_page = end(array_keys($search));
    if (!empty($search)){ 
      foreach ($search as $key => $filepath) {
        # weak workaround for excluding page 00 header
        $filepath = str_replace('P00.jpg', 'Pnon-exist.jpg', $filepath);
        # extracting from the path the filename and path itself
        $filename = basename($filepath);
        $fullpath = dirname($filepath);
        if (file_exists($filepath)) {
          # Our page is existing, it exclude the renamed P00.jpg, start the tag
          echo '<figure class="thumbnail col sml-4 med-3 lrg-3"><a href="'.$projectpath.'/hi-res/gfx-only/'.$filename.'" title="'.$humanfoldername.'" >';
          if( $key == $last_page) {
            # in case of last page, close the tag
            echo '</a></figure>';
          } else {
            # it's a real page, display it
            echo '<img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=210&amp;h=270&amp;s=1&amp;q=88" alt="'.$humanfoldername.'" title="'.$humanfoldername.'" ></a>';
            echo '</figure>';
          }
        }
      }
    }
    echo '</div>';
    
    # ************************************ TWO COLUMN LIST FILES : LEFT **************************************
    echo '<div class="col sml-6" style="margin-top:30px">';
    
    # LOW RES
    #
    $search = glob($projectpath."/low-res/*P??.*");
    if (!empty($search)){ 
      echo '<img src="themes/peppercarrot-theme_v2/ico/web.svg" alt=""/> ';
      $plxShow->lang('SOURCE_WEB');
      echo '<br/>';
      foreach ($search as $filepath) {
        $filename = basename($filepath);
        $filename = str_replace('_by-David-Revoy', '', $filename);
        $fileweight = (filesize($filepath) / 1024) / 1024;
        echo '<a href="'.$filepath.'" target="_blank" >
        '.$filename.' <em class="filesize">'.round($fileweight, 2).'MB </em></a><br />';
        }
    }
    echo '</div>';
    
    # ************************************ TWO COLUMN LIST FILES : RIGHT **************************************

    echo '<div class="col sml-6" style="margin-top:30px">';
    
    # HI-RES
    #
    $search = glob($projectpath."/hi-res/*P??.*");
    if (!empty($search)){ 
      echo '<img src="themes/peppercarrot-theme_v2/ico/ink.svg" alt=""/> ';
      $plxShow->lang('SOURCE_PRINT');
      echo '<br/>';
      foreach ($search as $filepath) {
        $filename = basename($filepath);
        $filename = str_replace('_by-David-Revoy', '', $filename);
        $fileweight = (filesize($filepath) / 1024) / 1024;
        echo '<a href="'.$filepath.'" target="_blank" >
        '.$filename.' <em class="filesize">'.round($fileweight, 2).'MB </em></a><br />';
      }
    }
    
    echo '<br/><br/>';
      
    # TXT-ONLY
    #
    $search = glob($projectpath."/hi-res/txt-only/*P??.*");
    if (!empty($search)){ 
      echo '<img src="themes/peppercarrot-theme_v2/ico/ink.svg" alt=""/> ';
      echo 'Text-only layer, PNG:';
      echo '<br/>';
      foreach ($search as $filepath) {
        $filename = basename($filepath);
        $filename = str_replace('_by-David-Revoy', '', $filename);
        $fileweight = (filesize($filepath) / 1024) / 1024;
        echo '<a href="'.$filepath.'" target="_blank" >
        '.$filename.' <em class="filesize">'.round($fileweight, 2).'MB </em></a><br />';
      }
    }
    
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</article>';
    
  } elseif ($activefolder == "episodes") {
  # ===========  Episodes ================
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    echo '<h2>'.$plxShow->getLang('WEBCOMIC_EPISODE').'</h2>';
    echo '</div>';
    echo '<section class="col sml-12 med-12 lrg-10 sml-centered sml-text-center" style="padding:0 0;">';

    $path = '0_sources/';
    $hide = array('.', '..', '0_archives','0_Storyboard', '0ther', '.thumbs', 'New', '.git', '.ci');
    $mainfolders = array_diff(scandir($path), $hide);
    sort($mainfolders);
    # Loop on the folders
    foreach($mainfolders as $foldername) {   
      $projectpath = $path.$foldername;
      if(is_dir($projectpath)) {
        # we are in comic source folder
        # beautify name
        $humanfoldername = str_replace('_', ' : ', $foldername);
        $humanfoldername = str_replace('-', ' ', $humanfoldername);
        echo '<figure class="thumbnail col sml-6 med-3 lrg-3"><a href="';
        $plxShow->urlRewrite('?static6/sources&page='.$foldername);
        echo '" title="'.$humanfoldername.'" >';
        # we scan all en vignette to define all episodes , it's a constant
        $search = glob($projectpath."/low-res/en_*E??.jpg");
        # we loop on found episodes
        if (!empty($search)){ 
          foreach ($search as $filepath) {
            # filename extraction
            $fileweight = (filesize($filepath) / 1024) / 1024;
            $filename = basename($filepath);
            $fullpath = dirname($filepath);
            # guess from pattern name of hypothetic translation
            $filenamewithoutenprefix = substr($filename, 2);
            $filepathtranslated = ''.$fullpath.'/'.$lang.''.$filenamewithoutenprefix.'';
            # if our hypothetic translation exist, display. Else, fallback to english :
            if (file_exists($filepathtranslated)) {
              echo '<img src="plugins/vignette/plxthumbnailer.php?src='.$filepathtranslated.'&amp;w=260&amp;h=190&amp;s=1&amp;q=88" alt="'.$humanfoldername.'" title="'.$humanfoldername.'" ><br/>';
            } else {
              echo '<img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=260&amp;h=190&amp;s=1&amp;q=88" alt="'.$humanfoldername.'" title="'.$humanfoldername.'" ><br/>';
            }
          }
        }
        echo '</a><figcaption class="sourcescaptions text-center" ><a href="';
        $plxShow->urlRewrite('?static6/sources&page='.$foldername);
        echo '" >'.$humanfoldername.'</a></figcaption>';
        echo '</figure>';
      } 
    }	
    # top button
    echo '</section>';

} elseif ($activefolder == "allthumb") {

  # =========== ALL THUMBNAIL OVERVIEW ================
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    echo '<h2>All thumbnail overview</h2>';
    echo '<p>An overview of all pages published so far to explore available graphics in the webcomic</p>';
    echo '</div>';
    echo '<section class="col sml-12 med-12 lrg-10 sml-centered" style="padding:0 0;">';

    $overviewpagecount = 0;
    $path = '0_sources/';
    $hide = array('.', '..', '0_archives','0_Storyboard', '0ther', '.thumbs', 'New', '.git', '.ci');
    $mainfolders = array_diff(scandir($path), $hide);
    sort($mainfolders);
    # Loop on the folders
    foreach($mainfolders as $foldername) {
      $projectpath = $path.$foldername;
      if(is_dir($projectpath)) {
        echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
        # beautify name
        $humanfoldername = str_replace('_', ' : ', $foldername);
        $humanfoldername = str_replace('-', ' ', $humanfoldername);
        echo '<h3>'.$humanfoldername.'</h3>';
        echo '</div>';
        echo '<section class="col sml-12 med-12 lrg-10 sml-centered sml-text-center">';
        
        # we scan all the valid pattern pages inside episode folder
        $search = glob($projectpath."/low-res/gfx-only/gfx_Pepper-and-Carrot_by-David-Revoy_E[0-9][0-9]P[0-9][0-9].*");
        # request last page of array
        $last_page = end(array_keys($search));
        if (!empty($search)) { 
          foreach ($search as $key => $filepath) {
            # weak workaround for excluding page 00 header
            $filepath = str_replace('P00.jpg', 'Pnon-exist.jpg', $filepath);
            # extracting from the path the filename and path itself
            $filename = basename($filepath);
            $fullpath = dirname($filepath);
            if (file_exists($filepath)) {
              # Our page is existing, it exclude the renamed P00.jpg, start the tag
              echo '<figure class="thumbnail col sml-6 med-3 lrg-3"><a href="'.$projectpath.'/hi-res/gfx-only/'.$filename.'" title="'.$humanfoldername.'" >';
              if( $key == $last_page) {
                # in case of last page, close the tag
                echo '</a></figure>';
              } else {
                # it's a real page:
                $overviewpagecount = $overviewpagecount + 1;
                # display a thumbnail
                echo '<img class="srcoverview" src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=210&amp;h=270&amp;s=1&amp;q=88" alt="'.$humanfoldername.'" title="'.$humanfoldername.'" ></a>';
                # Add a page count caption
                echo '<figcaption class="text-center" style="color:#ABABAB">'.$overviewpagecount.'</figcaption>';
                echo '</figure>';
              }
            }
          }
        }
      } 
      echo '</section>';
    }	
    # top button
    echo '</section>';
    
} elseif ($activefolder == "XYZ") {

  # =========== XYZ Preview page ================
    # main HTML container:
    echo '<div class="containercomic">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    echo '<p><b>Spoiler alert! Please, do not reshare this page</b>: This episode is still in development and is not meant to be ready for public. It\s published here only to help proofreader and contributors of Pepper&Carrot. If you want to help and give a feedback, <a href="https://framagit.org/peppercarrot/webcomics/issues?scope=all&utf8=%E2%9C%93&state=all&label_name[]=future%20episode">join our latest thread on Framagit here.</a></p>';
    echo '</div>';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered" style="padding:0 0;">';

    $path = '0_sources/';
    $hide = array('.', '..', '0_archives','0_Storyboard', '0ther', '.thumbs', 'New', '.git', '.ci');
    $mainfolders = array_diff(scandir($path), $hide);
    sort($mainfolders);
    # Loop on the folders
    foreach($mainfolders as $foldername) {
      $projectpath = $path.$foldername;
      if(is_dir($projectpath)) {
        if (strpos($foldername, 'new-') !== false) {
        
          echo '<section class="col sml-12 med-12 lrg-12 sml-centered sml-text-center">';
          # we scan all the valid pattern pages inside episode folder
          $search = glob($projectpath."/low-res/en_Pepper-and-Carrot_by-David-Revoy_E[0-9][0-9]P[0-9][0-9].*");
          if (!empty($search)) { 
            foreach ($search as $key => $filepath) {
              # extracting from the path the filename and path itself
              $filename = basename($filepath);
              $fullpath = dirname($filepath);
              if (file_exists($filepath)) {
                # Our page is existing, it exclude the renamed P00.jpg, start the tag
                  # display page
                  echo '<img src="'.$filepath.'" alt="'.$humanfoldername.'" title="'.$humanfoldername.'" ></a>';
                  # Add a page count caption
                  echo '<figcaption class="text-center" style="color:#ABABAB">'.$overviewpagecount.'</figcaption>';
                  echo '</figure>';
              }
            }
          }
        }
      } 
      echo '</section>';
    }	
    # top button
    echo '</section>';

} elseif ($activefolder == "download") {
  # ===========  DOWNLOADER ================
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    # Create a frame for the header.
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    
      # Add a Title
      echo '<h2>Downloader</h2>';
      
      # Decorate with an illustration:
      echo '<img src="plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/sys/low-res/2016-05-27_download_cover_by-David-Revoy.jpg&amp;w=210&amp;h=210&amp;s=1&amp;q=88" alt="" title="" ><br/>';
    
      # Add a description.
      echo '<p>A tool for publishers, book creators and printers.<br/> It will pack for you all pages in a ZIP file. You\'ll get:<br/>Artworks as PNG without quality loss + speechbubble on another PNG for each page.</p>';
    
    # Close header.  
    echo '</div>';
    
    # Create a frame for the body.
    echo '<section class="col sml-12 med-10 lrg-8 sml-centered">';
    
      # Create a table.
      $langfolders = array();
      
      # Browse langs.json and feed the table with the iso
      foreach ($get as $iso => $value ) {
         array_push($langfolders, $iso);
      }
      
      # Sort the table alphabetically. 
      sort($langfolders);
      
      # Debug: Display the table
      # print_r($langfolders);
      
      # Start the HTML formular interface.
      echo '<form action="';
      $plxShow->urlRewrite('downloader.php');      
      echo '">';
      
      # 1. Language selector.
      # ---------------------
      echo '<label for="page">1. Select a langage: </label>';
      echo '<select name="l">';
      
      # Loop on all lang available.
      foreach($langfolders as $langfolder) {
      
        # Create better names for each ISO.
        $localname = $get->{$langfolder}->{'local_name'};
        $name = $get->{$langfolder}->{'name'};
        
        # Print the item.
        echo '<option value="'.$langfolder.'">';
        echo '['.$langfolder.'] '.$name.' / '.$localname.'';
        echo '</option>';
      }

      echo '</select>';
      
      # Line break and distance.
      echo '<br><br>';
      
      # 2. Season selector
      # ------------------
      echo '<label for="season">2. Select a season: </label>';
      echo '<select name="s">';
      
      # Manually enter the cut here for the seasons.
      echo '<option value="1">[Season 1] from Episode 01 → Episode 11.</option>';
      echo '<option value="2">[Season 2]: from Episode 12 → Episode 21.</option>';
      echo '<option value="3">[Season 3]: from Episode 22 → Episode 29.</option>';
      echo '<option value="4">[Season 4]: from Episode 30 → (Work in Progress).</option>';
      echo '</select>';
      
      # Line break and distance.
      echo '<br><br>';
      
      # Submit button.
      echo '<input type="submit" value="Generate the pack">';
      
      # End of the formular.
      echo '</form>';
      
      # Push the footer far from the form.
      echo'<br/><br/><br/><br/><br/><br/><br/><br/>';
      
    # Close the body.
    echo '</section>';
    
} elseif ($activefolder == "3D") {
  # ===========  3D ================
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    echo '<h2>3D Blender files</h2>';
    echo '<p>Quick 3D draft scenes made with Blender 3D for prototyping and painting over the rendered pictures.<br/> </p>';
    echo '<br/><br/>';
    echo '</div>';
    echo '<section class="col sml-12 med-12 lrg-10 sml-centered sml-text-center" style="padding:0 0;">';
    #variables:
    $pathartworks = '0_sources/0ther/3Dmodels';
    $hide = array('.', '..');
    $mainfolders = array_diff(scandir($pathartworks), $hide);
    rsort($mainfolders);
    $search = glob($pathartworks."/low-res/*.jpg");
      # we loop on found episodes
    if (!empty($search)){ 
    foreach ($search as $filepath) {
    # filename extraction
    $filename = basename($filepath);
    $fullpath = dirname($filepath);
    $filenamezip = str_replace('.jpg', '_peppercarrot.zip', $filename);
    $zippath = $fullpath.'/../zip/'.$filenamezip.'';
    $fileweight = (filesize($zippath) / 1024) / 1024;
    
    echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
    echo '<a href="0_sources/0ther/3Dmodels/hi-res/'.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=260&amp;h=190&amp;s=1&amp;q=88&amp;a=t" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
    $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
    $filenameclean = str_replace('_by-David-Revoy', '', $filenameclean);
    $filenameclean = str_replace('_', ' ', $filenameclean);
    $filenameclean = str_replace('-', ' ', $filenameclean);
    
    echo '<figcaption class="sourcescaptions text-center" >
    <b>'.$filenameclean.'</b><br/>
    [ 
    <a href="0_sources/0ther/3Dmodels/low-res/'.$filename.'" >low</a> |
    <a href="0_sources/0ther/3Dmodels/hi-res/'.$filename.'" >hi</a> |
    <a href="0_sources/0ther/3Dmodels/zip/'.$filenamezip.'" >src <em class="filesize">('.round($fileweight, 2).'MB)</em></a> ]
    </figcaption>';
    echo '</figure>';
    }
    }
    echo '</section>';
    echo '</div>';


  } elseif ($activefolder == "artworks") {
  # =======  ARTWORKS ===========
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    echo '<h2>Artworks</h2>';
    echo '<p>All the artworks are available as: <b>low</b>-resolution, <b>hi</b>-resolution, or with the layered <b>src</b>/sources krita files.</p>';
    echo '<br/><br/>';
    echo '</div>';
    echo '<section class="col sml-12 med-12 lrg-11 sml-centered sml-text-center" style="padding:0 0;">';
    #variables:
    $pathartworks = '0_sources/0ther/artworks';
    $hide = array('.', '..');
    $mainfolders = array_diff(scandir($pathartworks), $hide);
    rsort($mainfolders);
    $search = glob($pathartworks."/low-res/*.jpg");
    # newer on top
    rsort($search);
    # we loop on found episodes
    if (!empty($search)){ 
    foreach ($search as $filepath) {
    # filename extraction
    $filename = basename($filepath);
    $fullpath = dirname($filepath);
    $filenamezip = str_replace('.jpg', '.zip', $filename);
    $zippath = $fullpath.'/../zip/'.$filenamezip.'';
    $fileweight = (filesize($zippath) / 1024) / 1024;
    echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
    echo '<a href="0_sources/0ther/artworks/hi-res/'.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=260&amp;h=190&amp;s=1&amp;zc=2&amp;q=88&amp;a=t" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
    $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
    $filenameclean = substr($filenameclean, 11);
    $filenameclean = str_replace('_by-David-Revoy', '', $filenameclean);
    $filenameclean = str_replace('_', ' ', $filenameclean);
    $filenameclean = str_replace('-', ' ', $filenameclean);
    $filenamezip = str_replace('jpg', 'zip', $filename);
    echo '<figcaption class="sourcescaptions text-center" >
    <b>'.$filenameclean.'</b><br/>
    [ 
    <a href="0_sources/0ther/artworks/low-res/'.$filename.'" >low</a> |
    <a href="0_sources/0ther/artworks/hi-res/'.$filename.'" >hi</a> |
    <a href="0_sources/0ther/artworks/zip/'.$filenamezip.'" >src <em class="filesize">('.round($fileweight, 2).'MB)</em></a> ]
    </figcaption>';
    echo '</figure>';
    }
    }
    echo '</section>';
    echo '</div>';

  } elseif ($activefolder == "eshop") {
  # =======  E-SHOP ===========
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    echo '<h2>E-Shop Sources</h2>';
    echo '<p>All the sources of the eshop for the <a href="https://www.redbubble.com/people/davidrevoy/portfolio?asc=u">official Pepper&amp;Carrot E-Shop on Redbubble</a> are available here under <a href="https://creativecommons.org/licenses/by/4.0/">CC-By license</a>.</p>';
    echo '<br/><br/>';
    echo '</div>';
    echo '<section class="col sml-12 med-12 lrg-11 sml-centered sml-text-center" style="padding:0 0;">';
    #variables:
    $patheshop = '0_sources/0ther/eshop';
    $hide = array('.', '..');
    $mainfolders = array_diff(scandir($patheshop), $hide);
    rsort($mainfolders);
    $search = glob($patheshop."/low-res/*.jpg");
    # newer on top
    rsort($search);
    # we loop on found episodes
    if (!empty($search)){ 
    foreach ($search as $filepath) {
    # filename extraction
    $filename = basename($filepath);
    $fullpath = dirname($filepath);
    $filenamezip = str_replace('.jpg', '.zip', $filename);
    $zippath = $fullpath.'/../zip/'.$filenamezip.'';
    $fileweight = (filesize($zippath) / 1024) / 1024;
    echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
    $filenamepng = str_replace('jpg', 'png', $filename);
    echo '<a href="0_sources/0ther/eshop/hi-res/'.$filenamepng.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=260&amp;h=190&amp;s=1&amp;zc=2&amp;q=88&amp;a=t" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
    $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
    $filenameclean = substr($filenameclean, 11);
    $filenameclean = str_replace('_by-David-Revoy', '', $filenameclean);
    $filenameclean = str_replace('_', ' ', $filenameclean);
    $filenameclean = str_replace('-', ' ', $filenameclean);
    $filenamezip = str_replace('jpg', 'zip', $filename);
    echo '<figcaption class="sourcescaptions text-center" >
    <b>'.$filenameclean.'</b><br/>
    [ 
    <a href="0_sources/0ther/eshop/low-res/'.$filename.'" >low</a> |
    <a href="0_sources/0ther/eshop/hi-res/'.$filenamepng.'" >hi</a> |
    <a href="0_sources/0ther/eshop/zip/'.$filenamezip.'" >src <em class="filesize">('.round($fileweight, 2).'MB)</em></a> ]
    </figcaption>';
    echo '</figure>';
    }
    }
    echo '</section>';
    echo '</div>';


  } elseif ($activefolder == "wallpapers") {
  # =======  WALLPAPERS ===========
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    echo '<h2>Wallpapers</h2>';
    echo '<p></p>';
    echo '<br/><br/>';
    echo '</div>';
    echo '<section class="col sml-12 med-12 lrg-10 sml-centered sml-text-center" style="padding:0 0;">';
    #variables:
    $pathartworks = '0_sources/0ther/wallpapers';
    $hide = array('.', '..');
    $mainfolders = array_diff(scandir($pathartworks), $hide);
    rsort($mainfolders);
    $search = glob($pathartworks."/1920x1080/*.jpg");
    # newer on top
    rsort($search);
    # we loop on found episodes
    if (!empty($search)){ 
    foreach ($search as $filepath) {
    # filename extraction
    $filename = basename($filepath);
    $fullpath = dirname($filepath);
    $filenamezip = str_replace('_peppercarrot-wallpaper_by-David-Revoy.jpg', '_source-files_by-David-Revoy.zip', $filename);
    $zippath = $fullpath.'/../zip/'.$filenamezip.'';
    $fileweight = (filesize($zippath) / 1024) / 1024;
    echo '<figure class="thumbnail col sml-12 med-6 lrg-6">';
    echo '<a href="0_sources/0ther/wallpapers/1920x1080/'.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=390&amp;h=220&amp;s=1&amp;q=88&amp;a=t" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
    $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
    $filenameclean = str_replace('_by-David-Revoy', '', $filenameclean);
    $filenameclean = str_replace('_peppercarrot-wallpaper', '', $filenameclean);
    $filenameclean = str_replace('_', ' ', $filenameclean);
    $filenameclean = str_replace('-', ' ', $filenameclean);
    echo '<figcaption class="sourcescaptions text-center" style="height:6rem;">
    <b>'.$filenameclean.'</b><br/>
    <a href="0_sources/0ther/wallpapers/zip/'.$filenamezip.'" >Source <em class="filesize">('.round($fileweight, 2).'MB)</em></a> &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="0_sources/0ther/wallpapers/1080x1920/'.$filename.'" >Mobile <em class="filesize">(1080x1920)</em></a> &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="0_sources/0ther/wallpapers/1280x1024/'.$filename.'" >4:3 <em class="filesize">(1280x1024)</em></a> <br/>
    <a href="0_sources/0ther/wallpapers/1920x1080/'.$filename.'" >16:9 <em class="filesize">(1920x1080)</em></a> &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="0_sources/0ther/wallpapers/1920x1200/'.$filename.'" >16:10 <em class="filesize">(1920x1200)</em></a> &nbsp;&nbsp;|&nbsp;&nbsp;
    <a href="0_sources/0ther/wallpapers/2560x1600/'.$filename.'" >16:10 <em class="filesize">(2560x1600)</em></a> <br/>

    </figcaption>';
    echo '</figure>';
    }
    }
    echo '</section>';
    echo '</div>';

} elseif ($activefolder == "press") {
  # =======  PRESS ===========
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    echo '<h2>Press</h2>';
    echo '<p>Logo, title, banner for press or community projects.</p>';
    echo '<br/><br/>';
    echo '</div>';
    echo '<section class="col sml-12 med-12 lrg-11 sml-centered sml-text-center" style="padding:0 0;">';
    #variables:
    $pathartworks = '0_sources/0ther/press';
    $hide = array('.', '..');
    $mainfolders = array_diff(scandir($pathartworks), $hide);
    rsort($mainfolders);
    $search = glob($pathartworks."/low-res/*.jpg");
    # newer on top
    rsort($search);
    # we loop on found episodes
    if (!empty($search)){ 
    foreach ($search as $filepath) {
    # filename extraction
    $filename = basename($filepath);
    $fullpath = dirname($filepath);
    $filenamezip = str_replace('.jpg', '.zip', $filename);
    $zippath = $fullpath.'/../zip/'.$filenamezip.'';
    $fileweight = (filesize($zippath) / 1024) / 1024;
    echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
    echo '<a href="0_sources/0ther/press/hi-res/'.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=210&amp;zc=2&amp;h=210&amp;s=1&amp;q=88&amp;a=t" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
    $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
    $filenameclean = substr($filenameclean, 11);
    $filenameclean = str_replace('_by-David-Revoy', '', $filenameclean);
    $filenameclean = str_replace('_', ' ', $filenameclean);
    $filenameclean = str_replace('-', ' ', $filenameclean);
    $filenamezip = str_replace('jpg', 'zip', $filename);
    echo '<figcaption class="sourcescaptions text-center" >
    <b>'.$filenameclean.'</b><br/>
    [ 
    <a href="0_sources/0ther/press/low-res/'.$filename.'" >low</a> |
    <a href="0_sources/0ther/press/hi-res/'.$filename.'" >hi</a> |
    <a href="0_sources/0ther/press/zip/'.$filenamezip.'" >src <em class="filesize">('.round($fileweight, 2).'MB)</em></a> ]
    </figcaption>';
    echo '</figure>';
    }
    }
    echo '</section>';
    echo '</div>';
    
} elseif ($activefolder == "other") {
  # =======  MISC ===========
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    echo '<h2>Misc / Other</h2>';
    echo '<p>Archive of artworks.</p>';
    echo '<br/><br/>';
    echo '</div>';
    echo '<section class="col sml-12 med-12 lrg-11 sml-centered sml-text-center" style="padding:0 0;">';
    #variables:
    $pathartworks = '0_sources/0ther/misc';
    $hide = array('.', '..');
    $mainfolders = array_diff(scandir($pathartworks), $hide);
    sort($mainfolders);
    $search = glob($pathartworks."/low-res/*.jpg");
    # newer on top
    sort($search);
    # we loop on found episodes
    if (!empty($search)){ 
    foreach ($search as $filepath) {
    # filename extraction
    $filename = basename($filepath);
    $fullpath = dirname($filepath);
    $filenamezip = str_replace('.jpg', '.zip', $filename);
    $zippath = $fullpath.'/../zip/'.$filenamezip.'';
    $fileweight = (filesize($zippath) / 1024) / 1024;
    echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
    echo '<a href="0_sources/0ther/misc/hi-res/'.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=260&amp;h=190&amp;zc=2&amp;s=1&amp;q=88&amp;a=t" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
    $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
    $filenameclean = substr($filenameclean, 11);
    $filenameclean = str_replace('_by-David-Revoy', '', $filenameclean);
    $filenameclean = str_replace('_', ' ', $filenameclean);
    $filenameclean = str_replace('-', ' ', $filenameclean);
    $filenamezip = str_replace('jpg', 'zip', $filename);
    echo '<figcaption class="sourcescaptions text-center" >
    <b>'.$filenameclean.'</b><br/>
    [ 
    <a href="0_sources/0ther/misc/low-res/'.$filename.'" >low</a> |
    <a href="0_sources/0ther/misc/hi-res/'.$filename.'" >hi</a> |
    <a href="0_sources/0ther/misc/zip/'.$filenamezip.'" >src <em class="filesize">('.round($fileweight, 2).'MB)</em></a> ]
    </figcaption>';
    echo '</figure>';
    }
    }
    echo '</section>';
    echo '</div>';
    
    
  } elseif ($activefolder == "translation") {
  # =======  Translation Status ===========
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    #closing page formating
    echo '</div>';
    echo '</section>';
    echo '</main>';
    echo '</div>'; #main container
    
    
    echo '<div style="text-align:left; margin: 1rem;">';
    echo '<div style="width: 1500px;">';
    echo '<h2>Translation Project Overview</h2>';
    $totalepisodecount = 0;
    $translacounter = 0;
    $fulltranslacounter = 0;
    $languagecounter = 0;
    $singlelangcount = 0;
    $langfull = 0;
    $validlangdir = 'core/lang/';
    $hide = array('.', '..');
    $langfolders = array_diff(scandir($validlangdir), $hide);
    sort($langfolders);
    echo '<table class="tabletransla">';
    echo '<caption><small>Info: The date written in the block is when the translation received an update for the last time ( format: in YYYY.MM.DD, 2016.04.01 = 2014 april 1st, 2015.09.20 = 2015 September 20, etc... ) </small></caption>';
    echo "<tr>";
    echo "<th></th>";
    # Loop on the folders for headers
    $path = '0_sources/';
    $hide = array('.', '..', '0ther', '0_archives', '.thumbs', 'New', '2010-10-10_Older-comics', '2010-10-09_Press-kit', '.git', '.ci', 'fonts');
    $mainfolders = array_diff(scandir($path), $hide);
    sort($mainfolders);
    foreach($mainfolders as $foldername) {   
      $projectpath = $path.$foldername;
      #Ensure a folder exist
      if(is_dir($projectpath)) {
        $episodenumber = substr($foldername, 1);
        $episodenumber = preg_replace('/[^0-9.]+/', '', $foldername);
        echo '<th><a href="';
        $plxShow->urlRewrite('?static6/sources&page='.$foldername);
        echo'" title="'.$projectpath.'"> ep'.$episodenumber.'';
        echo'<img src="plugins/vignette/plxthumbnailer.php?src='.$projectpath.'/low-res/gfx-only/gfx_Pepper-and-Carrot_by-David-Revoy_E'.$episodenumber.'.jpg&amp;h=40&amp;w=75&amp;s=1&amp;q=84&amp"></a></th>';
        $totalepisodecount = $totalepisodecount + 1;
        }
    }
    echo "</tr>";

    # Guess total number of episode at first
    foreach($langfolders as $langfolder) {
      $projectpath = $validlangdir.$langfolder;
      if(is_dir($projectpath)) {
        $languagecounter = $languagecounter + 1;
      }
    }
         
    # Display : Loop on the folders
    foreach($langfolders as $langfolder) {
      $projectpath = $validlangdir.$langfolder;
      #Ensure a folder exist
      if(is_dir($projectpath)) {
        echo '<td>';
          echo ''.$langfolder.' <br/><strong>';
          # Get local name from langs.json, imported at the end of header.php 
          $localname = $get->{$langfolder}->{'local_name'};
          echo $localname;
        echo' </strong></td>';
        $path = '0_sources/';
        $hide = array('.', '..', '0_archives', '0ther', '.thumbs', 'New', 'fonts');
        $mainfolders = array_diff(scandir($path), $hide);
        sort($mainfolders);
        
        foreach($mainfolders as $foldername) {
          $projectpath = $path.$foldername;
          #Ensure a folder exist
          if(is_dir($projectpath)) {
            $search = glob($projectpath."/low-res/en_*E??.jpg");
            if (!empty($search)){ 
              foreach ($search as $filepath) {
                # filename extraction
                $fileweight = (filesize($filepath) / 1024) / 1024;
                $filename = basename($filepath);
                $fullpath = dirname($filepath);
                # guess cover filename and path
                $filenamewithoutenprefix = substr($filename, 2);
                $filepathtranslated = ''.$fullpath.'/'.$langfolder.''.$filenamewithoutenprefix.'';
                # if cover exist; translation exist: we display
                if (file_exists($filepathtranslated)) {
                $singlelangcount = $singlelangcount + 1;
                }
              }
            }
          }
        }
        
        foreach($mainfolders as $foldername) {
          $projectpath = $path.$foldername;
          #Ensure a folder exist
          if(is_dir($projectpath)) {
            # we are in comic source folder
            # beautify name
            $foldername = str_replace('ep', ' Episode ', $foldername);
            $foldername = substr($foldername, 19);
            $foldername = str_replace('_', ' : ', $foldername);
            $foldername = str_replace('-', ' ', $foldername);
            # we scan all en vignette to define all episodes , it's a constant
            $search = glob($projectpath."/low-res/en_*E??.jpg");
            # we loop on found episodes
            if (!empty($search)){ 
              foreach ($search as $filepath) {
                # filename extraction
                $fileweight = (filesize($filepath) / 1024) / 1024;
                $filename = basename($filepath);
                $fullpath = dirname($filepath);
                # guess cover filename and path
                $filenamewithoutenprefix = substr($filename, 2);
                $filepathtranslated = ''.$fullpath.'/'.$langfolder.''.$filenamewithoutenprefix.'';
                # if cover exist; translation exist: we display
                if (file_exists($filepathtranslated)) {
                  if ( $singlelangcount == $totalepisodecount ) {
                  # all is translated!
                  echo '<td align="center" style="background-color:#D5F1B3;color:#6FA62C">';
                  $fulltranslacounter = $fulltranslacounter + 1;
                  } else {
                  # partial
                  echo '<td align="center" style="background-color:#FFFD9E;color:#C3922A">';
                  }
                  # for all
                  echo '<small>'.date ("Y.m.d", filemtime($filepathtranslated)).'</small>';
                  echo ' </td>';
                  $translacounter = $translacounter + 1;
                } else {
                  echo ' <td align="center" style="color:#dedede;"><small>TO-DO</small></td>';
                }
              }
            }
            }
          }
        $singlelangcount = 0;
      }
      echo "</tr>";
    }            
    echo "</table>";
    echo '</div>';
    echo '</div>';
    
    echo "<br/>";
    echo '<div style="text-align:left; margin: 1rem;">';
    
    echo '<div style="max-width:960px; border: 1px solid #bdbdbd; padding: 2rem;">';
    echo "<strong>";
    echo $totalepisodecount.' episodes published. <br/>';
    echo $languagecounter.' languages available.<br/> ';
    $fulltranslacounter = $fulltranslacounter / $totalepisodecount;
    echo 'Pepper&amp;Carrot is fully translated into '.$fulltranslacounter.' languages !<br/>';
    echo "</strong>";
    echo '</div>';
    echo "<br/>";
    $contributorfilepath = 'http://www.peppercarrot.com/0_sources/AUTHORS.md';
    $contents = file_get_contents($contributorfilepath);
    $Parsedown = new Parsedown();
    echo '<div style="max-width:960px; border: 1px solid #bdbdbd; padding: 2rem;">';
    echo '<p>Credits as written in <a href="https://framagit.org/peppercarrot/webcomics/blob/master/AUTHORS.md">AUTHOR.md</a> :</p>';
    echo $Parsedown->text($contents);
    echo '</div>';
    echo "</div>";



  } elseif ($activefolder == "original") {
  # ===========  Original ================
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    echo '<h2>Original artworks scanned</h2>';
    echo '<p>Original drawings: pencil on paper , Raw Scan at 300ppi with Xsane.<br/> </p>';
    echo '<br/><br/>';
    echo '</div>';
    echo '<section class="col sml-12 med-12 lrg-10 sml-centered sml-text-center" style="padding:0 0;">';
    #variables:
    $pathartworks = '0_sources/0ther/original';
    $hide = array('.', '..');
    $mainfolders = array_diff(scandir($pathartworks), $hide);
    rsort($mainfolders);
    $search = glob($pathartworks."/*.jpg");
    # we loop on found episodes
    if (!empty($search)){ 
    foreach ($search as $filepath) {
    # filename extraction
    $fileweight = (filesize($filepath) / 1024) / 1024;
    $filename = basename($filepath);
    $fullpath = dirname($filepath);
    $notavailable="Not-available";
    if (strlen(strstr($filename,$notavailable))>0) {
      echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
      echo '<a href="0_sources/0ther/original/'.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;h=210&amp;w=210&amp;s=1&amp;zc=2&amp;q=84&amp" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
      $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
      $filenameclean = str_replace('_by-David-Revoy', '', $filenameclean);
      $filenameclean = str_replace('Not-available', '', $filenameclean);
      $filenameclean = str_replace('_', ' ', $filenameclean);
      $filenameclean = str_replace('-', ' ', $filenameclean);
      $filenamezip = str_replace('jpg', 'zip', $filename);
      echo '<figcaption class="sourcescaptions text-center" >
      <a href="0_sources/0ther/original/'.$filename.'" >'.$filenameclean.'</a><br/>
      </figcaption>';
      echo '</figure>';
    } else {
      echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
      echo '<a href="0_sources/0ther/original/'.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;h=210&amp;w=210&amp;zc=2&amp;s=1&amp;q=84&amp" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
      $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
      $filenameclean = str_replace('_by-David-Revoy', '', $filenameclean);
      $filenameclean = str_replace('Not-available', '', $filenameclean);
      $filenameclean = str_replace('_', ' ', $filenameclean);
      $filenameclean = str_replace('-', ' ', $filenameclean);
      $filenamezip = str_replace('jpg', 'zip', $filename);
      echo '<figcaption class="sourcescaptions text-center" >
      <a href="0_sources/0ther/original/'.$filename.'" >'.$filenameclean.'</a><br/>
      </figcaption>';
      echo '</figure>';
    }
    }
    }
    echo '</section>';
    echo '</div>';
    
  } elseif ($activefolder == "inks") {
  # ===========  Inks ================
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    echo '<h2>Inks</h2>';
    echo '<p>Drawings made with inks, daily made during <a href="http://mrjakeparker.com/inktober">Inktober</a>.<br/>This drawings are licensed under <a href="https://creativecommons.org/licenses/by/4.0/" title="For more information, read the Creative Commons Attribution 4.0">CC-By license</a> to <a href="http://www.davidrevoy.com">David Revoy</a>. </p>';
    echo '<br/><br/>';
    echo '</div>';
    echo '<section class="col sml-12 med-12 lrg-10 sml-centered" style="padding:0 0;">';
    #variables:
    $pathartworks = '0_sources/0ther/inks';
    $hide = array('.', '..');
    $mainfolders = array_diff(scandir($pathartworks), $hide);
    rsort($mainfolders);
    $search = glob($pathartworks."/*.jpg");
    # we loop on found episodes
    if (!empty($search)){ 
    foreach ($search as $filepath) {
    # filename extraction
    $fileweight = (filesize($filepath) / 1024) / 1024;
    $filename = basename($filepath);
    $fullpath = dirname($filepath);
    $largepicture="_00";
    if (strlen(strstr($filename,$largepicture))>0) {
      # header
      $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
      $filenameclean = preg_replace('/\d+/u', '', $filenameclean);
      $filenameclean = str_replace('_by-David-Revoy', '', $filenameclean);
      $filenameclean = str_replace('_', ' ', $filenameclean);
      $filenameclean = str_replace('-', ' ', $filenameclean);
      $anchornameclean = str_replace(' ', '', $filenameclean);
      echo '<div style="clear:both;"></div>';
      echo '<br/><br/><h2 style="text-transform: capitalize;margin-left: 14px; color: 000;">
      <a href="#'.$anchornameclean.'" name="'.$anchornameclean.'"><img class="svg" src="themes/peppercarrot-theme_v2/ico/link.svg" alt="link"/></a>
      '.$filenameclean.'
      </h2>';
      echo '<figure class="thumbnail col sml-12">';
      echo '<a href="0_sources/0ther/inks/'.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;h=600&amp;q=90&amp" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
      echo '</figure>';
      echo '<div style="clear:both;"></div><br/>';
    } else {
      echo '<figure class="thumbnail col sml-6 med-2 lrg-2">';
      echo '<a href="0_sources/0ther/inks/'.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;h=136&amp;w=136&amp;s=1&amp;q=84&amp" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
      $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
      $filenameclean = str_replace('_by-David-Revoy', '', $filenameclean);
      $filenameclean = str_replace('_', ' ', $filenameclean);
      $filenameclean = str_replace('-', ' ', $filenameclean);
      $filenamezip = str_replace('jpg', 'zip', $filename);
      echo '</figure>';
    }
    }
    }
    echo '</section>';
    echo '</div>';

  } else {
  # =========== Error Page ================
    # main HTML container:
    echo '<div class="container">';
    echo '<main class="main grid" role="main">';
    echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
    echo '<div class="grid">';
    
    echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
    echo '<h2>Error: Page not found</h2>';
    echo '</div>';
  }

}else{

# Nothing found: we display main Intro

  # main HTML container:
  echo '<div class="container">';
  echo '<main class="main grid" role="main">';
  echo '<section class="col sml-12 med-12 lrg-12 sml-centered">';
  echo '<div class="grid">';
  
  echo '<!-- Intro -->';
    include(dirname(__FILE__).'/lib-transla-static.php');
    echo '<article class="page col sml-12 med-12 lrg-10 sml-centered" role="article" >';
      echo '<h1>Sources center</h1>';
      $plxShow->lang('SOURCES_TOP');
      $plxShow->lang('SOURCES_BOTTOM');
      echo '<center>';
      echo '<div class="button mandarine big">';
      echo '<a href="https://framagit.org/peppercarrot">Framagit repositories</a>';
      echo '</div>';
      echo '&nbsp;&nbsp;&nbsp;&nbsp;';
      echo '<div class="button">';
      echo '<a href="';
      $plxShow->urlRewrite('?static14/documentation');
      echo '">Read the documentation</a>';
      echo '</div>';
      echo '</center>';
      echo '<br/><br/>';
      echo '</article>';
      echo '<br/><br/>';
      
        echo '<section class="col sml-12 med-12 lrg-10 sml-centered sml-text-center">';
        
          
          # SOURCES EPISODES
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static6/sources&page=episodes');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-webcomics.jpg" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Webcomic</b><br/>';
          echo 'sources of all langs & episodes';
          echo '</a></figcaption>';
          echo '</figure>';
          
          # OVERVIEW
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static6/sources&page=allthumb');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-overview.jpg" alt="" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Overview/Flatplan</b><br/>';
          echo 'all pages without speechbubbles';
          echo '</a></figcaption>';
          echo '</figure>';

          # ARTWORKS
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static6/sources&page=artworks');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-artworks.jpg" alt="" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Artworks</b><br/>';
          echo 'Illustrations for print';
          echo '</a></figcaption>';
          echo '</figure>';
          
          # WALLPAPERS
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static6/sources&page=wallpapers');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-wallpapers.jpg" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Wallpapers</b><br/>';
          echo 'screen-sized illustrations';
          echo '</a></figcaption>';
          echo '</figure>';
          
          # INKS
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static6/sources&page=inks');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-inks.jpg" alt="" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Inks</b><br/>';
          echo 'Inked artworks';
          echo '</a></figcaption>';
          echo '</figure>';

          # ORIGINALS
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static6/sources&page=original');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-originals.jpg" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Originals</b><br/>';
          echo 'raw scan of drawings';
          echo '</a></figcaption>';
          echo '</figure>';
          
          # 3D
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static6/sources&page=3D');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-3d.jpg" alt="" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>3D</b><br/>';
          echo '3D Blender files';
          echo '</a></figcaption>';
          echo '</figure>';
          
          # PRESSKIT
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static6/sources&page=press');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-presskit.jpg" alt="" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Press kit</b><br/>';
          echo 'banners and logos';
          echo '</a></figcaption>';
          echo '</figure>';
          
          # MISC
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static6/sources&page=other');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-misc.jpg" alt="" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Misc</b><br/>';
          echo 'speedpaintings, lineart and misc';
          echo '</a></figcaption>';
          echo '</figure>';
          
          # ESHOP
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static6/sources&page=eshop');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-eshop.jpg" alt="" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Eshop</b><br/>';
          echo 'Sources of the official eshop';
          echo '</a></figcaption>';
          echo '</figure>';
          
          # FAN−ART
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static10/fanart-gallery');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-fanart.jpg" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Fan-arts</b><br/>';
          echo 'artworks from the fans';
          echo '</a></figcaption>';
          echo '</figure>';
          
          # DOWNLOAD
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static6/sources&page=download');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-download.jpg" alt="" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Downloader</b><br/>';
          echo 'zip available for publishers';
          echo '</a></figcaption>';
          echo '</figure>';
          
          # TRANSLATION STATUS
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static6/sources&page=translation');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-translations.jpg" alt="" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Translation status</b><br/>';
          echo 'tools and credit for translators';
          echo '</a></figcaption>';
          echo '</figure>';
          
          # SCENARIOS
          echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
          echo '<a href="';
          $plxShow->urlRewrite('?static9/scenarios');
          echo '" >';
          echo '<img src="data/images/static/sourcesthumb-scenarios.jpg" alt="" title="" ><br/>';
          echo '<figcaption class="sourcescaptions text-center" >';
          echo '<b>Scenarios</b><br/>';
          echo 'collaborative stories';
          echo '</a></figcaption>';
          echo '</figure>';
      
        echo '</section>';
    
    echo '</article>';
  echo '</div>';
  echo '<div class="grid">';
  
}


?>
<div style="clear:both;"><br/><br/></div>
</section>
</section>
</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
