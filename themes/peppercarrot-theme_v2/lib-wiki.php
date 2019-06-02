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
echo '<div class="container wikibg">'."\n";
echo '  <main class="main grid" role="main">'."\n";

// Start sidebar
echo '    <aside class="wikivertimenu col sml-12 med-12 lrg-3" role="complementary">'."\n";
echo '      <section class="wikibuttonmenu col sml-12 med-12 lrg-12" style="padding:0 0;">'."\n";
echo '        <a class="wikibutton '.$statushome.'" href="'; $plxShow->urlRewrite(''.$currentpage.''); echo '" title="">'."\n";
echo '          Home'."\n";
echo '        </a>'."\n";

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
      // Hardcode Home.md or README to the top
      if ($file === 'Home.md' OR $file === 'README.md') {
      } else {
        // Make filename without extension
        $file = preg_replace('/\\.[^.\\s]{2,4}$/', '', $file);
        $status="";
        // Create menu item
        if ($file === $page) {
          $status="active";
        }
        $menulabel = str_replace('_', ' ', $file);
        $menulabel = preg_replace('/[0-9.]+/', '', $menulabel);
        echo '        <a class="wikibutton '.$status.'" href="'; $plxShow->urlRewrite(''.$currentpage.'&page='.$file); echo '" title="">'."\n";
        echo '          '.$menulabel.''."\n";
        echo '        </a>'."\n";
      }
    }
  }
}
echo '      </section>'."\n";
echo '     <div style="clear:both"></div>'."\n";
echo '    </aside>'."\n";

echo '	  <section class="page col sml-12 med-12 lrg-9">'."\n";

// Start edit buttons
echo '     <div class="edit" >'."\n";
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

// display content
$contents = file_get_contents(''.$datapath.''. $page .'.md');
$Parsedown = new Parsedown();
echo $Parsedown->text($contents);

echo '	    <br/><br/>'."\n";
      
// Footer
echo '	    <footer class="credits col sml-12 med-12 lrg-12">'."\n";
$contents = file_get_contents(''.$datapath.'_Footer.md');
$Parsedown = new Parsedown();
echo $Parsedown->text($contents);
echo '	    </footer>'."\n";
      
echo '	    <div style="clear:both"></div>'."\n";
echo '	    <br/><br/>'."\n";

echo '	  </section>'."\n";
echo '	</main>'."\n";
echo '</div>'."\n";
echo ''."\n";
?>
