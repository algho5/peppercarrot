<?php
// Get 'page' in URL and cleanup for prohibiting code injection or path
$page = htmlspecialchars($_GET["page"]);
$page = preg_replace('/[^A-Za-z0-9\'\/\._-]/', '', $page);

include(dirname(__FILE__).'/lib-parsedown.php');
include(dirname(__FILE__).'/header.php');

echo '<div class="container">';
echo '  <main class="main grid" role="main">';
echo '    <section class="col sml-12">';
echo '      <div class="grid">';

// Setup
$repositoryURL = "https://framagit.org/peppercarrot/scenarios";
$currentpage = "?static9/scenarios";
$datapath = "data/scenarios/";

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

    $contents = file_get_contents(''.$datapath.''. $page .'.md');
    $Parsedown = new Parsedown();
    echo $Parsedown->text($contents);
  echo '<br/><br/>';
  echo '</section>';
  
} else {

  // ==== MAIN MENU ====
  echo '<section class="page col sml-12 med-10 sml-centered">'."\n";
  echo '<h1>Fan-Fictions</h1>';
  echo '<p>Here you\'ll find a list of fan-fictions divided into categories. If you want to propose a fan-fiction, send your text to <a href="mailto:info@davidrevoy.com">info@davidrevoy.com</a> or propose it to <a href="'.$repositoryURL.'">the scenario source git repository</a>. For more information, check the <a href="';
  $plxShow->urlRewrite(''.$currentpage.'&page=README');
  echo '" title="">this README</a>.</p>';
  

  $hide = array('.', '..', '.git', '.gitignore', '.directory', 'README.md', 'offline');
  $folders = array_diff(scandir($datapath), $hide);
  sort($folders);
  
  # we loop on found episodes
  foreach ($folders as $folder) {
  
    $folderlabel = substr($folder, 3);
    $folderlabel = preg_replace('/\\.[^.\\s]{2,4}$/', '', $folderlabel);
    $folderlabel = str_replace('-', ' ', $folderlabel);
    $folderlabel = str_replace('_', ' ', $folderlabel);
    $folderlabel = ucfirst($folderlabel);
    echo '<h2>'.$folderlabel.'</h2>';
        
    $search = glob($datapath."/".$folder."/*.md");
    if (!empty($search)){ 
      foreach ($search as $file) {
        
        // cleaning
        $file = basename($file);
        $filelabel = str_replace('fr__', '<span class="notes">(In French)</span> ', $file);
        $filelabel = str_replace('--', ', ', $filelabel);
        $filelabel = str_replace('_by', '"<span class="notes">&nbsp by', $filelabel);
        $filelabel = str_replace('_', ' ', $filelabel);
        $filelabel = str_replace('-', ' ', $filelabel);
        $filelabel = preg_replace('/\\.[^.\\s]{2,4}$/', '', $filelabel);
        $filelabel = ucfirst($filelabel);

        if (substr($file, 0, 1) === '_') {
          // exclude system file starting with '_'.

        } else {
          
          // filter
          if ($file === 'README.md'){
              // in case of README
            
            
          } else if ($file === 'template.md'){
            // filter template, do nothing
          
          } else {
            // display markdown page
            $file = preg_replace('/\\.[^.\\s]{2,4}$/', '', $file);
            echo '<a class="scenariolist" href="';
            $plxShow->urlRewrite(''.$currentpage.'&page='.$folder.'/'.$file);
            echo '" title="">"'.$filelabel.'</span></a>';
          }
          
        }
      }
    }
  }
    
  echo '<br/><br/>';
  echo '</section>';

}

// footer
echo '<footer class="col sml-12 med-12 lrg-12 text-center">'; 
echo '<br/>';
echo '</footer>';
echo '</main>';
echo '</div>';
include(dirname(__FILE__).'/footer.php');
?> 
