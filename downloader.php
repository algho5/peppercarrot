<?php

# downloader.php:
# ===============
# Generate ZIP objects with pages for print and display the list of zip after that.

# Regenerate the lock status (0=off, 1=regenerate).
$lockstatus = 0;

# Storage path of the ZIPs.
$dir = "tmp/";

# Get new variable from URL; 'lang'.
$requestedlang = htmlspecialchars($_GET["l"]);

# Security filter: remove all special characters except a-z.
$requestedlang = preg_replace('/[^a-z]/', '', $requestedlang);

# Get new variable from URL; 'season'.
$season = htmlspecialchars($_GET["s"]);

# Security filter: remove seasons superior to 4.
$season = preg_replace('/[^1-4]/', '', $season);



# Block empty lang requests.
if($requestedlang != '') {

  # Block empty season requests.
  if($season != '') {

    # Block anything more than three letters.
    if (strlen($requestedlang)<3) {
    
      # Block invalid lang (test if they exist on episode 1).
      $testfolder = '0_sources/ep01_Potion-of-Flight/lang/'.$requestedlang.'';
      if(is_dir($testfolder)) {

        # Block any season with more numbers.
        if (strlen($season)<2) {
          
          # Removing anti-flood protection if older than 3min (180s).
          foreach (glob($dir."cachelock.txt") as $file) {
            if (filemtime($file) < time() - 180) {
              unlink($file);
              $lockstatus = 1;
            }
          }
          
          # Our lang is now ready to be used.
          $lang = $requestedlang;

          # Removing 24 hours (86400s) old generated zip stored in target folder.
          $zipcounter = 0;
          foreach (glob($dir."*.zip") as $file) {
            $zipcounter = $zipcounter + 1;
            if (filemtime($file) < time() - 86400) {
              unlink($file);
              $zipcounter = $zipcounter - 1;
            }
          }
            
          # Block generation of zip for 24h after more than 8 done.
          if($zipcounter < 8 ) {
          
            # Block request faster than 3min reload.
            if(!is_file(''.$dir.'/cachelock.txt')) {
            
              # Get ISO date YYYY-MM-DD.
              $isodate = date("Y-m-d");
              
              # Init our zip object.
              $zip = new ZipArchive;
              
              # Be sure this one is empty on start of loop.
              $notification = "";
              
              # Build a list of the episodes folders from 0_sources.
              $mainfolders = glob("0_sources/ep[0-9][0-9]*");
              
              # Sort episodes alphabetically starting by ep01.
              sort($mainfolders);
              
              # Validate our episodes.
              # ----------------------
              # Create a table to store validated episodes folders.
              $validatedfolders = array();
              # Loop inside all the episodes found on 0_sources and check foders.
              foreach($mainfolders as $folder) {
                # Validate if the episode with the target lang folder is found on disk
                $validationpattern = ''.$folder.'/lang/'.$lang.'';
                if(is_dir($validationpattern)) {
                  # Redirect seasons
                  switch ($season) {
                    case 1:
                      # Allow Season 1 episodes only.
                      if(preg_match('/(01|02|03|04|05|06|07|08|09|10|11)/iu', $folder)) {
                        # Push the validated episodes inside the table.
                        array_push($validatedfolders, $folder);
                      }
                      break;
                      
                    case 2:
                      # Allow Season 2 episodes only.
                      if(preg_match('/(12|13|14|15|16|17|18|19|20|21)/iu', $folder)) {
                        # Push the validated episodes inside the table.
                        array_push($validatedfolders, $folder);
                      }
                      break;
                      
                    case 3:
                      # Allow Season 3 episodes only.
                      if(preg_match('/(22|23|24|25|26|27|28|29)/iu', $folder)) {
                        # Push the validated episodes inside the table.
                        array_push($validatedfolders, $folder);
                      }
                      break;
                      
                    case 4:
                      # Allow Season 4 episodes only.
                      if(preg_match('/(30|31|32|33|34|35|36|37|38|39)/iu', $folder)) {
                        # Push the validated episodes inside the table.
                        array_push($validatedfolders, $folder);
                      }
                      break;
                  }
                }
              }
              
              # Block if the table is empty: no episodes translated, canceling empty zip generation.
              if (count($validatedfolders) != 0) {

                # Create a filename zip output depending of the, date, lang and active season.
                $download = 'tmp/'.$isodate.'_'.$lang.'_S0'.$season.'_peppercarrot-all-pages.zip';

                # If a zip already exists and was generated in less than 24h, don't redo it...
                if(!is_file($download)) {
                
                  # Define our future zip object.
                  $zip->open($download, ZipArchive::CREATE);

                  # Loop on the episodes folders.
                  foreach($validatedfolders as $foldername) {
                    
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
                            
                              # Store the file in the zip.
                              $zip->addFile($filepath, $filename);
                            }
                          }
                        }
                      }
                    }
                  } 

                  # Store also this file in every ZIP automated to remind about license and usages.
                  $zip->addFile("downloader-notice.md", "README.md");
                  
                  # Close our generated ZIP object.
                  $zip->close();
                }

                  # User interface
                  # ---------------
                  # Search if the zip file is successfully created.
                  if(is_file($download)) {
                  
                    # Switch message in memory for a success.
                    $notification = '<p class="notifok">&#128154; Success: your zip archive is ready.<p><br/><p>Find the download link within this list:</p>';
                    
                    # Log the ZIP generation
                    # ----------------------
                    # Get an IP to track abuse.
                    $ip = $_SERVER['REMOTE_ADDR'];
                    # Get ISO date YYYY-MM-DD_HHhMM.
                    $logexactdate = date("Y-m-d_H\hi");
                    $logfileweight = (filesize($download) / 1024) / 1024;
                    $logverboseline = '['.$logexactdate.'] ['.$ip.'] '.$download.' ('.round($logfileweight, 2).'MB)'.PHP_EOL;
                    $log = ''.$dir.'/log.txt';
                    $logfile = fopen($log, 'a');
                    fwrite($logfile, $logverboseline);
                    fclose($logfile);

                    
                  } else {
                    # Switch message in memory for a failure.
                    $notification = '<p class="notifno">Error: couldn\'t generate the archive.<p><p>Ready for download:</p>';
                  }

              } else {
                # Display a error the season has no translations.
                $notification = '<p class="notifmeh">&#128533; <b>Nothing to do</b><br/><small>Season '.$season.' has no translated pages for ['.$lang.'] language.</small></p><p>Ready for download:</p>';
              }
              
            } else {
              # Display a error message if the lang query is empty.
              $notification = '<p class="notifinfo">&#128336; <b>Server CPU protection:</b><br/><small>&#128472; Too many requests. Please reload this page in 3 min.</small></p><p>Ready for download:</p>';
            }
            
          } else {
            # Display a error message if the lang query is empty.
            $notification = '<p class="notifinfo">&#128274; <b>Server disk space protection:</b><br/><small> Too many zip have been generated in the last 24h. Come back tomorrow</p><p>Ready for download:</p>';

          }

        } else {
          # Display a error message if the query is a malformated season.
          $notification = '<p class="notifno">&#128027; [Error] Invalid season:<br/><small>Use only a single digit.</small></p><p>Displaying this list in cache:</p>';
        }
          
      } else {
        # Display a error message if the query is a unkown lang.
        $notification = '<p class="notifno">&#128027; [Error] Invalid lang:<br/><small>This lang has no translation on episode 1.</small></p><p>Ready for download:</p>';
      }
        
    } else {
      # Display a error message if the query is a malformated lang.
      $notification = '<p class="notifno">&#128027; [Error] Invalid lang:<br/><small>Use a valid iso lang with small letters.</small></p><p>Ready for download:</p>';
    }
  
  } else {
    # Display a error message if the season query is empty.
    $notification = '<p class="notifno">&#128027; [Error]<br/><small>Empty season or malformed URL request.</small></p><p>Ready for download:</p>';
  }

} else {
  # Display a error message if the lang query is empty.
  $notification = '<p class="notifno">&#128027; [Error]<br/><small>Empty lang or malformed URL request.</small></p><p>Ready for download:</p>';
}


# Display an HTML page for the end user
# -------------------------------------
echo '<!doctype html>';
echo '<html>';
echo '<head>';
echo ' <meta http-equiv="content-type" content="text/html; charset=UTF-8">';
echo ' <title>Download repository</title>';
echo '</head>';
echo '
<style type="text/css" media="screen">
  body { font-family: Ubuntu, Arial, sans; margin: 2em; padding: 0; background: #F0F0F0; color: #666; font-size: 1rem; text-align: left; }
  #wrapper { text-align: left; background: #fff; max-width: 480px; padding: 2rem; margin: 0 auto; border: 1px #dedede solid; }
  p { line-height: 160%; }
  .notifok { padding: 1rem; background: #D5FF75; }
  .notifno { padding: 1rem; background: #FFA075; }
  .notifinfo { padding: 1rem; background: #C8EBFF; }
  .notifmeh { padding: 1rem; background: #FADF94; }
  .filesize { color: #ABABAB; font-size: 0.8rem; }
  .button { display:block; box-shadow:inset 0px 1px 0px 0px #ffffff;	background:linear-gradient(to bottom, #f9f9f9 5%, #e9e9e9 100%); background-color:#f9f9f9; border-radius:6px;	border:1px solid #dcdcdc;	color:#666666; padding:6px 24px; text-decoration:none; text-shadow:0px 1px 0px #ffffff;}
  .button:hover { background:linear-gradient(to bottom, #e9e9e9 5%, #f9f9f9 100%); background-color:#e9e9e9; }
  h1 { color: #555; font-size: 1.8rem; font-family: Ubuntu, Arial, sans; font-weight: bold; margin: 0 0 0.3rem 0; text-align: center; }
  ul { margin-top: 20px; padding: 0 0;}
  li { list-style-type:none; margin: 6px 0 0 0; }
  a { color: #666; text-decoration: none;}
  a:hover {    color: #222;}
@media (max-width: 700px) {
  body { background: #FFF; }
  #wrapper { max-width: 100%; padding: 0; margin: 0 auto; border: none; }
  h1 { font-size: 1.6rem;}
} 
</style>';
echo '<body>';
echo '<div id="wrapper">';
echo '<h1>Pepper&Carrot downloader</h1>';
echo '<center><img src="https://www.peppercarrot.com/plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/misc/low-res/2016-04-13_carrot-updating-or-repairing_by-David-Revoy.jpg&w=200&h=180&zc=2&s=0&q=92&a=t"></center>';

echo '<p>'.$notification.'</p>';
echo '<ul>';

# Counter for number of files in cache.
$count = 0;

# List all the zip founds on the folder.
foreach (glob($dir."*.zip") as $file) {

  # Cleanup path to display only filename.
  $filenamelabel = basename($file);
  
  # Get the weight of the zip.
  $fileweight = (filesize($file) / 1024) / 1024;
  
  # Print the result as a list element.
  echo '<li> <a class="button" href="'.$file.'" download>&#128229; '.$filenamelabel.' <em class="filesize">('.round($fileweight, 2).'MB)</em></a></li>';
  
  # Upgrade the counter.
  $count = $count + 1;
}

# Display a special item if list is empty.
if ($count == 0) {
  echo '<li><span style="color: #FFA075;">No zip files ready on disk.</span></li>';
}

echo '</ul>';
echo '<br/><div align="right"><a style="color:#7373D7; text-decoration: underline; font-size: 0.8rem;" href="static6/sources&page=download">Go back to the selector</a></div>';
echo '<br/><p><small style="color:#aaa;"><b>Server friendly rules:</b><br/>- Files are stored here for 24h after their creation. <br/>- 8 zip generated per day maximum. <br/>- 3min wait between zip generations.</small></p>';
echo '<!-- Debug: ';
print_r($validatedfolders);
echo '-->';
echo '</div>';
echo '</body>';

# Regenerate a the cache lock
# ---------------------------
# Do it if necessary.
if($lockstatus == 1) {
  # Regenerate if doesn't exists.
  if(!is_file(''.$dir.'/cachelock.txt')) {
    # Get ISO date YYYY-MM-DD_HHhMM.
    $tokkendate = date("Y-m-d_H\hi");
    $tokken = fopen(''.$dir.'/cachelock.txt', "w");
    fwrite($tokken, $tokkendate);
    fclose($tokken);
  }
}

?>
