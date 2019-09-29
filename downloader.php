<?php

# downloader.php:
# ===============
# Generate ZIP objects with pages for print and display the list of zip after that.

# Get new variable from URL; 'lang'
$requestedlang = htmlspecialchars($_GET["l"]);

# Security filter: remove all special characters except a-z.
$requestedlang = preg_replace('/[^a-z]/', '', $requestedlang);

# Block empty requests.
if($requestedlang != '') {

  # Block anything more than three letters.
  if (strlen($requestedlang)<3) {

    # Our lang is now ready to be used
    $lang = $requestedlang;

    # Removing 24 hours old generated zip stored in target folder.
    $dir = "tmp/";
    foreach (glob($dir."*.zip") as $file) {
      if (filemtime($file) < time() - 86400) {
        unlink($file);
      }
    }
    
    # Get ISO date YYYY-MM-DD.
    $isodate = date("Y-m-d");
    
    # Init our zip object.
    $zip = new ZipArchive;
    
    # Be sure this one is empty on start of loop.
    $notification = "";
    
    # Build a list of the episodes folders from 0_sources.
    $sourcespath = '0_sources/';
    $hidefromsourcespath = array('.', '..', '0_archives', '0ther', 'fonts');
    $mainfolders = array_diff(scandir($sourcespath), $hidefromsourcespath);
    sort($mainfolders);

    # Define the path for outputs.
    $download = 'tmp/'.$isodate.'_'.$lang.'_peppercarrot-all-pages.zip';
    
    # If a zip exist and was already generated (in less than 24h), don't redo it.
    if(!is_file($download)) {
    
      # Define our future zip object.
      $zip->open($download, ZipArchive::CREATE);

      # Loop on the episodes folders.
      foreach($mainfolders as $foldername) {
        
        # Build absolute path from root of website.
        $projectpath = $sourcespath.$foldername;
        
        # Security: check if the folder exists.
        if(is_dir($projectpath)) {
        
          # Check if the translation folder exist for the lang selected.
          if (is_dir($projectpath."/lang/".$lang."/")) {
          
            # Search for a pattern of txt-only pages (transparent PNG with text).
            $searchtxt = glob($projectpath."/hi-res/txt-only/".$lang."_Pepper-and-Carrot_by-David-Revoy_E[0-9][0-9]P[0-9][0-9].*");
            
            # Search for a pattern of gfx-only page (hi-resolution PNGs artworks, no text).
            $searchgfx = glob($projectpath."/hi-res/gfx-only/gfx_Pepper-and-Carrot_by-David-Revoy_E[0-9][0-9]P[0-9][0-9].*");
            
            # Merge the two previously search results.
            $search = array_merge($searchtxt, $searchgfx);
            
            # Generate the Zip
            # ----------------
            # Security: Block empty search result of pages.
            if (!empty($search)) {
            
              # Loop on result of the search.
              foreach ($search as $key => $filepath) {
              
                # Cleanup path of search results.
                $filename = basename($filepath);
                $fullpath = dirname($filepath);
                
                # Security: Block path not pointing to real files.
                if (file_exists($filepath)) {
                
                  # Store the file in the zip
                  $zip->addFile($filepath, $filename);
                }
              }
            }
          }
        }
      } 

      # Store also this files in every ZIP automated.
      $zip->addFile("0_sources/AUTHORS.md", "AUTHORS.md");
      $zip->addFile("0_sources/README.md", "README.md");
      $zip->addFile("0_sources/CONTRIBUTING.md", "CONTRIBUTING.md");
      
      # Close our generated ZIP object.
      $zip->close();
    }

    # User interface
    # ---------------
    # Search if the zip file is successfully created.
    if(is_file($download)) {
    
      # Switch message in memory for a success.
      $notification = "Success: Archive was generated or was already in cache. Find the download link within this list:";
      
    } else {
    
      # Switch message in memory for a failure.
      $notification = "Error: couldn't generate the archive. Displaying the list cached:";
      
    }

    # Display an HTML page for the end user
    # -------------------------------------
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
    
    # List all the zip founds on the folder.
    foreach (glob($dir."*.zip") as $file) {
    
      # Cleanup path to display only filename.
      $filenamelabel = basename($file);
      
      # Print the result as a list element.
      echo '<li><a href="'.$file.'" download>'.$filenamelabel.'</a></li>';
    }
    echo '</ul>';
    echo '</body>';
    
  } else {
  
    # Display a error message if the query is a malformated lang.
    echo 'Invalid lang.';
    
  }
  
} else {

  # Display a error message if the query is empty.
  echo 'Error: empty request.';
  
}

?>
