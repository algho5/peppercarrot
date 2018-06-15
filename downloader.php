<?php
// get new variable 'folder'
$activefolder = htmlspecialchars($_GET["page"]);
// get new variable 'lang'
$requestedlang = htmlspecialchars($_GET["l"]);

// Security, remove all special characters except A-Z, a-z, 0-9, dots, hyphens, underscore before interpreting something. 
$activefolder = preg_replace('/[^A-Za-z0-9\._-]/', '', $activefolder);
$requestedlang = preg_replace('/[^A-Za-z0-9\._-]/', '', $requestedlang);

if($requestedlang != '') {
  # TODO: Maybe a better filter than this to check if $requestedlang contain only two small case letters?
  if (strlen($requestedlang)<3) {


    $notification = "";
    $path = '0_sources/';
    $hide = array('.', '..', '0_archives', '0ther', 'fonts');
    $zip = new ZipArchive;
    $isodate = date("Y-m-d");
    $lang = $requestedlang;
    $dir = "tmp/";
    $download = 'tmp/'.$isodate.'_'.$lang.'_peppercarrot-all-pages.zip';

    # Cleaning older zip: keep older 24 hours
    foreach (glob($dir."*.zip") as $file) {
      if (filemtime($file) < time() - 86400) {
        unlink($file);
      }
    }
        
    # If file exist in cache, don't redo it
    if(!is_file($download)) {
      $zip->open($download, ZipArchive::CREATE);
      $mainfolders = array_diff(scandir($path), $hide);
      sort($mainfolders);
      # Loop on the episodes folders
      foreach($mainfolders as $foldername) {
        $projectpath = $path.$foldername;
        if(is_dir($projectpath)) {
          # Check if translation exist
          if (is_dir($projectpath."/lang/".$lang."/")) {
          # We select wanted pages
          $searchtxt = glob($projectpath."/hi-res/txt-only/".$lang."_Pepper-and-Carrot_by-David-Revoy_E[0-9][0-9]P[0-9][0-9].*");
          $searchgfx = glob($projectpath."/hi-res/gfx-only/gfx_Pepper-and-Carrot_by-David-Revoy_E[0-9][0-9]P[0-9][0-9].*");
          $search = array_merge($searchtxt, $searchgfx);
          # Generate (if selection is not empty)
            if (!empty($search)) { 
              # Loop on the selection
              foreach ($search as $key => $filepath) {
                $filename = basename($filepath);
                $fullpath = dirname($filepath);
                if (file_exists($filepath)) {
                  $zip->addFile($filepath, $filename);
                }
              }
            }
          }
        }
      }
      # Add credits
      $zip->addFile("0_sources/AUTHORS.md", "AUTHORS.md");
      $zip->addFile("0_sources/README.md", "README.md");
      $zip->addFile("0_sources/CONTRIBUTING.md", "CONTRIBUTING.md");
      $zip->close();
    }

    # Validate after possible generation
    if(is_file($download)) {
      $notification = "Success: Archive was generated or was already in cache. Find the download link within this list:";
    } else {
      $notification = "Error: couldn't generate the archive. Displaying the list cached:";
    }

    # display html listing
    echo '<!doctype html>';
    echo '<html>';
    echo '<head>';
    echo ' <meta http-equiv="content-type" content="text/html; charset=UTF-8">';
    echo ' <title>Download repository</title>';
    echo '</head>';
    echo '<body>';
    echo '<h1>Download repository</h1>';
    echo '<p>Files here are cached for 24h.</p>';
    echo '<p>'.$notification.'</p>';
    echo '<ul>';
    foreach (glob($dir."*.zip") as $file) {
      $filenamelabel = basename($file);
      echo '<li><a href="'.$file.'" download>'.$filenamelabel.'</a></li>';
    }
    echo '</ul>';
    echo '</body>';
    
  } else {
    echo 'Invalid lang.';
  }
} else {
  echo 'Error: empty request.';
}

?>
