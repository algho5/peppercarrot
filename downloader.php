<?php
// get new variable 'folder'
$activefolder = htmlspecialchars($_GET["page"]);
// get new variable 'lang'
$requestedlang = htmlspecialchars($_GET["l"]);

// Security, remove all special characters except A-Z, a-z, 0-9, dots, hyphens, underscore before interpreting something. 
$activefolder = preg_replace('/[^A-Za-z0-9\._-]/', '', $activefolder);
$requestedlang = preg_replace('/[^A-Za-z0-9\._-]/', '', $requestedlang);

    $path = '0_sources/';
    $projectpath = $path.$activefolder;
    $foldername = $activefolder;
    $hide = array('.', '..', '0_archives','0_Storyboard', '0ther', '.thumbs', 'New');
    $zip = new ZipArchive;
    $isodate = date("Y-m-d");
    $lang = $requestedlang;
    $download = 'tmp/'.$isodate.'_'.$lang.'_peppercarrot-all-pages.zip';
    
    # cleaning! Important. 
    #define the directory
    $dir = "tmp/";
    #cycle through all files in the directory
    foreach (glob($dir."*.zip") as $file) {
    #if file is 5 hours (18000 seconds) old then delete it
    if (filemtime($file) < time() - 18000) {
    unlink($file);
    }
    }
    
    if(is_file($download)) {
        header('Content-Type: application/zip');
        header("Content-Disposition: attachment; filename = $download");
        header('Content-Length: ' . filesize($download));
        header("Location: $download");
    } else {
      $zip->open($download, ZipArchive::CREATE);
      $mainfolders = array_diff(scandir($path), $hide);
      sort($mainfolders);
      # Loop on the folders
      foreach($mainfolders as $foldername) {
        $projectpath = $path.$foldername;
        if(is_dir($projectpath)) {
          # we scan all the valid pattern pages inside episode folder
          $searchtxt = glob($projectpath."/hi-res/txt-only/".$lang."_Pepper-and-Carrot_by-David-Revoy_E[0-9][0-9]P[0-9][0-9].*");
          $searchgfx = glob($projectpath."/hi-res/gfx-only/gfx_Pepper-and-Carrot_by-David-Revoy_E[0-9][0-9]P[0-9][0-9].*");
          $search = array_merge($searchtxt, $searchgfx);
          # request last page of array
          if (!empty($search)) { 
            foreach ($search as $key => $filepath) {
              # extracting from the path the filename and path itself
              $filename = basename($filepath);
              $fullpath = dirname($filepath);
              if (file_exists($filepath)) {
                # Our page is existing, it exclude the renamed P00.jpg, start the tag
                # echo '+ '.$filepath.'<br/>';
                $zip->addFile($filepath, $filename);
              }
            }
          }
        } 
      }
      $zip->addFile("0_sources/README-GENERAL-LICENSE.md", "README-GENERAL-LICENSE.md");
      $zip->close();
      header('Content-Type: application/zip');
      header("Content-Disposition: attachment; filename = $download");
      header('Content-Length: ' . filesize($download));
      header("Location: $download");
    }
    
    
    
    # top button
    echo '</section>';
?>
