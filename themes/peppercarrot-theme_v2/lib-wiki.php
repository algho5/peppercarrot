<?php if (!defined('PLX_ROOT')) exit; 

// Get 'page' in URL and cleanup for prohibiting code injection or path
$page = htmlspecialchars($_GET["page"]);
$page = preg_replace('/[^A-Za-z0-9\._-]/', '', $page);

// Variable
$status = "";
$statushome = "";

// Redirection
if(!isset($_GET['page'])) {
  // no page found
  $page = "README";
  $statushome="active";
}

// Initiate page
echo '<div class="'.$wikitheme.'">'."\n";
echo '  <div class="container">'."\n";
echo '    <main class="main grid" role="main">'."\n";

// Start sidebar
echo '      <aside class="wikivertimenu col sml-12 med-12 lrg-3" role="complementary">'."\n";
echo '        <section class="wikibuttonmenu col sml-12 med-12 lrg-12" style="padding:0 0;">'."\n";

// Create array database
$allpages = array();
// Menu generation
// Scan for markdowns
$search = glob("".$datapath."*.md");
if (!empty($search)){ 
  foreach ($search as $file) {
    // Clean full path to filename only
    $file = basename($file);
    
    // Exclude _Footer, _Sidebar, and all page starting with '_'
    if (substr($file, 0, 1) === '_') {
    } else {
      // We have a markdown page
      // Make filename without extension
      $file = preg_replace('/\\.[^.\\s]{2,4}$/', '', $file);
      // Feed the array database
      array_push($allpages, $file);
    }
  }

  // Construct the array
  // Clean README.md from our Database
  $allpages = array_diff($allpages, array("README"));
  // Insert Home in first position
  array_unshift($allpages,"Home");
  // Process Next/Prev:
  $current= array_search($page, $allpages);
  $prevID = $allpages[$current-1];
  $nextID = $allpages[$current+1];
  
  // Display the menu
  foreach ($allpages as $file) {
    $menulabel = str_replace('_', ' ', $file);
    $menulabel = preg_replace('/[0-9.]+/', '', $menulabel);
    // Special filter to replace Home by link README
    if ($file === "Home") {
        $file = "README";
    }
    // Create menu item
    if ($file === $page) {
      $status="active";
    } else {
      $status="";
    }
    echo '        <a class="wikibutton '.$status.'" href="'; $plxShow->urlRewrite(''.$currentpage.'&page='.$file); echo '" title="">'."\n";
    echo '          '.$menulabel.''."\n";
    echo '        </a>'."\n";
  }
}
echo '      </section>'."\n";
echo '     <div style="clear:both"></div>'."\n";
echo '    </aside>'."\n";

echo '	  <section class="page col sml-12 med-12 lrg-9">'."\n";

// Display edit buttons
function _Displayeditbuttons() {
  global $repositoryURL, $page, $wikiicons;
  echo '     <div class="edit" >'."\n";
  echo '       <div class="button moka" >'."\n";
  echo '        <a href="'.$repositoryURL.'/commits/master/'.$page.'.md" target="_blank" title="External history link to see all changes made to this page" >'."\n";
  echo '          <img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/history'.$wikiicons.'.svg" alt=""/>'."\n";
  echo '            View history'."\n";
  echo '        </a>'."\n";
  echo '       </div>'."\n";

  echo '       <div class="button moka" >'."\n";
  echo '        <a href="'.$repositoryURL.'/edit/master/'.$page.'.md" target="_blank" title="Edit this page with an external editor" >'."\n";
  echo '          <img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/edit'.$wikiicons.'.svg" alt=""/>'."\n";
  echo '            Edit'."\n";
  echo '        </a>'."\n";
  echo '       </div>'."\n";
  echo '     </div>'."\n";
}

_Displayeditbuttons();

// Debug
//echo "<pre>";
//print_r ($allpages);
//echo "- current ID: [".$current."]<br/>";
//echo "</pre>";

// Display content
$contents = file_get_contents(''.$datapath.''. $page .'.md');
$Parsedown = new Parsedown();
echo $Parsedown->text($contents);
echo '	    <br/><br/>'."\n";

// Display previous and next
$prevlabel = str_replace('_', ' ', $prevID);
$prevlabel = preg_replace('/[0-9.]+/', '', $prevlabel);
if ($prevID != "") {
  echo '<div class="button" style="float:left;">'."\n";
  echo '<a href="'; $plxShow->urlRewrite(''.$currentpage.'&page='.$prevID); echo '" title="">&nbsp; < &nbsp;'.$prevlabel.'</a>'."\n";
  echo '</div>'."\n";
}
$nextlabel = str_replace('_', ' ', $nextID);
$nextlabel = preg_replace('/[0-9.]+/', '', $nextlabel);
if ($nextID != "") {
  echo '<div class="button" style="float:right;">'."\n";
  echo '<a href="'; $plxShow->urlRewrite(''.$currentpage.'&page='.$nextID); echo '" title="">'.$nextlabel.'&nbsp; > &nbsp;</a>'."\n";
  echo '</div>'."\n";
}
echo '	    <br/><br/>'."\n";

// Footer
echo '	    <footer class="credits col sml-12 med-12 lrg-12">'."\n";
$contents = file_get_contents(''.$datapath.'_Footer.md');
$Parsedown = new Parsedown();
echo $Parsedown->text($contents);
echo '	    </footer>'."\n";

_Displayeditbuttons();
      
echo '	    <div style="clear:both"></div>'."\n";
echo '	    <br/><br/>'."\n";

echo '	    </section>'."\n";
echo '	  </main>'."\n";
echo '  </div>'."\n";
echo '</div>'."\n";
echo ''."\n";
?>
