<?php
// Get 'page' in URL and cleanup for prohibiting code injection or path
$page = htmlspecialchars($_GET["page"]);
$page = preg_replace('/[^A-Za-z0-9\/\._-]/', '', $page);

include(dirname(__FILE__).'/lib-parsedown.php');
include(dirname(__FILE__).'/header.php');

echo '<div class="container">';
echo '  <main class="main grid" role="main">';
echo '    <section class="col sml-12">';
echo '      <div class="grid">';

// Setup
$repositoryURL = "https://framagit.org/peppercarrot/scenarios";
$currentpage = "?static9/scenarios";
$datapath = "0_sources/0ther/scenarios/";

if(isset($_GET['page'])) {
  
  // ==== DISPLAY PAGE ====
  echo '<section class="page scenario col sml-12 med-10 sml-centered">'."\n";
  
    // Start edit buttons
    echo '     <div class="edit" >'."\n";
    
    echo '       <div class="button moka" >'."\n";
    echo '        <a href="'; $plxShow->urlRewrite(''.$currentpage.''); echo '" title=""><img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/home.svg" alt=""/>'."\n";
    echo '          Back to all scenarios'."\n";
    echo '         </a>'."\n";
    echo '       </div>'."\n";

    echo '       <div class="button moka" >'."\n";
    echo '        <a href="'.$repositoryURL.'/commits/master/'.$page.'.md" target="_blank" title="External history link to see all changes made to this page" >'."\n";
    echo '          <img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/history.svg" alt=""/>'."\n";
    echo '            View history'."\n";
    echo '        </a>'."\n";
    echo '       </div>'."\n";

    echo '       <div class="button moka" >'."\n";
    echo '        <a href="'.$repositoryURL.'/edit/master/'.$page.'.md" target="_blank" title="Edit this page with an external editor" >'."\n";
    echo '          <img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/edit.svg" alt=""/>'."\n";
    echo '            Edit'."\n";
    echo '        </a>'."\n";
    echo '       </div>'."\n";

    echo '     </div>'."\n";

    $contents = file_get_contents('0_sources/0ther/scenarios/'. $page .'.md');
    $Parsedown = new Parsedown();
    echo $Parsedown->text($contents);
  echo '</section>';
  
} else {

  // ==== MAIN MENU ====
  echo '<div class="page col sml-12 med-12 lrg-9 sml-centered sml-text-center">';
  echo '<h1>Scenarios</h1>';
  echo '<p>';
  echo 'Send me your page or modifications at <a href="mailto:info@davidrevoy.com">info@davidrevoy.com</a> or <a href="https://github.com/Deevad/peppercarrot_scenarios/">on the repository</a>, and I\'ll republish them here. <em>(check the <a href="';
  $plxShow->urlRewrite(''.$currentpage.'&page=README');
  echo '" title="">Readme file</a> for more informations.)</em></p>';
  

  $hide = array('.', '..', '.directory');
  $folders = array_diff(scandir($datapath), $hide);
  sort($folders);
  
  # we loop on found episodes
  foreach ($folders as $folder) {
  
    $beautyfoldername = substr($folder, 3);
    $beautyfoldername = preg_replace('/\\.[^.\\s]{2,4}$/', '', $beautyfoldername);
    $beautyfoldername = str_replace('_', ' ', $beautyfoldername);
    $beautyfoldername = ucfirst($beautyfoldername);
    echo '<h2>'.$beautyfoldername.'</h2>';
        
    $search = glob($datapath."/".$folder."/*.md");
    if (!empty($search)){ 
      foreach ($search as $wikifile) {
        
        // cleaning
        $wikifile = basename($wikifile);
        $beautyname = str_replace('_', ' ', $wikifile);
        $beautyname = str_replace('-', ' ', $beautyname);
        $beautyname = preg_replace('/\\.[^.\\s]{2,4}$/', '', $beautyname);
        $beautyname = ucfirst($beautyname);

        if (substr($wikifile, 0, 1) === '_') {
          // exclude system file starting with '_'.

        } else {
          
          // filter
          if ($wikifile === 'README.md'){
              // in case of README
            
            
          } else if ($wikifile === 'template.md'){
            // filter template, do nothing
          
          } else {
            // display markdown page
            $wikifile = preg_replace('/\\.[^.\\s]{2,4}$/', '', $wikifile);
            echo '<a class="scenarios" href="';
            $plxShow->urlRewrite(''.$currentpage.'&page='.$folder.'/'.$wikifile);
            echo '" title="">'.$beautyname.'</a><br/>';
          }
          
        }
      }
    }
  }
    

  echo '</div>';

}

// footer
echo '<footer class="col sml-12 med-12 lrg-12 text-center">'; 
echo '<br/>';
echo '</footer>';
echo '</main>';
echo '</div>';
include(dirname(__FILE__).'/footer.php');
?> 
