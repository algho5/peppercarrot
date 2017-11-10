<?php
$scenariofile = htmlspecialchars($_GET["story"]);
$scenariofile = preg_replace('/[^A-Za-z0-9\._-]/', '', $scenariofile);

include(dirname(__FILE__).'/lib-parsedown.php');
include(dirname(__FILE__).'/header.php');

echo '<div class="container">';
echo '  <main class="grid" role="main">';

if(isset($_GET['story'])) {
  
  // display story found
  echo '<section class="col sml-12 med-9">';
  echo '<br/>';
    echo '<a href="';
    $plxShow->urlRewrite('?static9/scenarios');
    echo '" title=""><img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/home.svg" alt=""/>&nbsp;&nbsp; Back to all scenarios</a>';
    $contents = file_get_contents('0_sources/0ther/scenarios/'. $scenariofile .'.md');
    $Parsedown = new Parsedown();
    echo $Parsedown->text($contents);
  echo '</section>';
  
  // sidebar
  echo '<aside class="aside col sml-12 med-3" role="complementary"><br /><br />';
  echo '<div class="edit">';
    echo '<a href="https://github.com/Deevad/peppercarrot_scenarios/blob/master/'.$scenariofile.'.md" target="_blank" title="Edit this story with an external editor" ><img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/edit.svg" alt=""/>&nbsp;&nbsp; Edit this story</a>';        
    echo '<br/>';   
    echo '<br/>';
    echo '<a href="https://raw.githubusercontent.com/Deevad/peppercarrot_scenarios/master/'.$scenariofile.'.md" target="_blank" title="Edit this story with an external editor" ><img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/download.svg" alt=""/>&nbsp;&nbsp; Download</a>';
    echo '<br/>';
    echo '<a href="https://github.com/Deevad/peppercarrot_scenarios/commits/master/'.$scenariofile.'.md" target="_blank" title="External history link to see all changes made to this story" ><img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/history.svg" alt=""/>&nbsp;&nbsp; Revisions history</a>';
    echo '<br/>';
    echo '<a href="https://github.com/Deevad/peppercarrot_scenarios" target="_blank" title="Git repository main page" ><img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/git.svg" alt=""/>&nbsp;&nbsp; Repository</a>';
    echo '</div>';
  echo '</aside>';
  
} else {

  // fallback on menu
  echo '<div class="col sml-12 med-12 lrg-12 sml-text-center">';
  echo '<h2>Scenarios</h2>';
  echo '<img src="plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/misc/low-res/2016-27-05_scenarios-source_cover_by-David-Revoy.jpg&amp;w=210&amp;h=210&amp;s=1&amp;q=88&amp" alt="" title="" ><br/>';
  echo '<p>List of proposed/work-in-progress/collaborative scenarios.<br/>';
  $search = glob("0_sources/0ther/scenarios/*.md");
  if (!empty($search)){ 
    foreach ($search as $wikifile) {

      // cleaning
      $wikifile = basename($wikifile);
      $beautyname = str_replace('_', ' : ', $wikifile);
      $beautyname = str_replace('-', ' ', $beautyname);
      $beautyname = preg_replace('/\\.[^.\\s]{2,4}$/', '', $beautyname);
      $beautyname = ucfirst($beautyname);

      if (substr($wikifile, 0, 1) === '_') {
        // exclude system file starting with '_'.

      } else {
        
        // filter
        if ($wikifile === 'README.md'){
            // in case of README
          echo 'Send me your story or modifications at <a href="mailto:info@davidrevoy.com">info@davidrevoy.com</a> or <a href="https://github.com/Deevad/peppercarrot_scenarios/">on the repository</a>, and I\'ll republish them here.<br /><em>(check the <a href="';
          $plxShow->urlRewrite('?static9/scenarios&story=README');
          echo '" title="">Readme file</a> for more informations.)</em></p>';
          
        } else if ($wikifile === 'template.md'){
          // filter template, do nothing
        
        } else {
          // display markdown page
          $wikifile = preg_replace('/\\.[^.\\s]{2,4}$/', '', $wikifile);
          echo '<a class="scenarios" href="';
          $plxShow->urlRewrite('?static9/scenarios&story='.$wikifile);
          echo '" title=""><h3> '.$beautyname.' </h3></a>';
        }
        
      }
    }
    // menu footer
    echo '<br />...a <a href="https://raw.githubusercontent.com/Deevad/peppercarrot_scenarios/master/template.md" title="">template</a> also exist to help you with formating.<br /> For more informations about the universe of Pepper&amp;Carrot, visit the';
    echo '<a class="scenarios" href="';
    $plxShow->urlRewrite('?static8/wiki');
    echo '" title="Wiki of Pepper&amp;Carrot"> Wiki.</a>';
  }
  

  echo '</div>';

}

// footer
echo '<footer class="col sml-12 med-12 lrg-12 text-center">';
echo '<br/>';
include(dirname(__FILE__).'/share-static.php');   
echo '<br/>';
echo '</footer>';
echo '</main>';
echo '</div>';
include(dirname(__FILE__).'/footer.php');
?> 
