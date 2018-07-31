<?php
$lang = $plxShow->defaultLang($echo);

// get new variable 'page'
$docpage = htmlspecialchars($_GET["page"]);

// Security, remove all special characters except A-Z, a-z, 0-9, dots, hyphens, underscore before interpreting something. 
$docpage = preg_replace('/[^A-Za-z0-9\._-]/', '', $docpage);

// reset status for active pages
$status="";
$statushome="";

  if(isset($_GET['page']))
  {
    // page found
  }else{
    // no page found, we propose homepage by default and active status
    // new homepage is README.md
    $docpage = "README";
    $statushome="active";
  }

// add library to parse markdown files
include(dirname(__FILE__).'/lib-parsedown.php');

// add header
include(dirname(__FILE__).'/header.php'); 
?>

<div class="container">
	<main class="grid" role="main">

      <section class="col sml-12 med-9">
        
        <div class="limit col sml-12 med-10 lrg-9 sml-centered lrg-centered med-centered sml-text-center">
          <?php 
          if ($lang !== 'en') {
            echo '&nbsp;<img class="svg" src="themes/peppercarrot-theme_v2/ico/nfog.svg" alt=" "/>';
            $plxShow->lang('LIMITATIONS');
          } else {
            # nothing
          }
          ?>
        </div>           
      <?php
      // echo '<h1>'.$docpage.'</h1>';
      // display content main page
      $contents = file_get_contents('data/documentation/'. $docpage .'.md');
      $Parsedown = new Parsedown();
      echo $Parsedown->text($contents);
      ?>
      <br/>
      <br/>
      
      <!-- Footer infos -->
      <footer class="col sml-12 med-12 lrg-12 text-center">
        <?php
        $contents = file_get_contents('data/documentation/_footer.md');
        $Parsedown = new Parsedown();
        echo $Parsedown->text($contents);
        ?>
      </footer>
      
      <div style="clear:both"></div><br/><br/>
      
      </section>
    
      <aside class="aside col sml-12 med-3" role="complementary">
      
<div class="homebox">
        <section class="catbuttonmenu col sml-12 med-12 lrg-12" style="padding:0 0;">
          <a class="catbutton <?php echo $statushome; ?>" href="<?php $plxShow->urlRewrite('?static14/documentation'); ?> " title=""><img src="themes/peppercarrot-theme_v2/ico/home.svg" alt="Home"/> Home</a>
          <?php
            // dynamic menu generation for sidebar
    
              # we scan all markdown in folder
              $search = glob("data/documentation/*.md");

              # we loop on found files
              if (!empty($search)){ 
                foreach ($search as $docfile) {
                  
                  // clean path to filename only
                  $docfile = basename($docfile);
                  
                  // _Footer and _Sidebar are special page, they start with '_' exclude them
                  if (substr($docfile, 0, 1) === '_') {
                    // page starting with '_' found, do nothing.
                  } else {
                    // Check if the page is Home, we don't display it here to keep it hardcoded on the top
                    if ($docfile === 'Home.md' OR $docfile === 'README.md') {
                    // Home.md found, do nothing
                    } else {
                      // We have a valid markdown page
                      // Clean filename to get only name without extension :
                      $docfile = preg_replace('/\\.[^.\\s]{2,4}$/', '', $docfile);
                      // reset the status of active page.
                      $status="";
                      // Is there a chance we display the page of this button now? time to set status actif!
                      if ($docfile === $docpage) {
                        $status="active";
                      }
                      // Ok, we have all, diplay this button now :
                      // Better name
                      $docfilehuman = str_replace('_', ' ', $docfile);
                      $docfilehuman = preg_replace('/[0-9.]+/', '', $docfilehuman);
                      echo '<a class="catbutton '.$status.'" href="';
                      $plxShow->urlRewrite('?static14/documentation&page='.$docfile);
                      echo '" title="">'.$docfilehuman.'</a>';
                    }
                  }
                }
              }
          ?>
          </section>
        </div>
      
      <div style="clear:both"></div>
    <br/>
      <div class="edit" >
          <a href="https://framagit.org/peppercarrot/documentation/edit/master/<?php echo $docpage; ?>.md" target="_blank" title="Edit this page with an external editor" ><img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/edit.svg" alt=""/>&nbsp;&nbsp; Edit this page</a>
          <br/><br/>
          <?php
          echo '<a href="https://framagit.org/peppercarrot/documentation/commits/master/'.$docpage.'.md" target="_blank" title="External history link to see all changes made to this page" ><img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/history.svg" alt=""/>&nbsp;&nbsp;Page history</a>';
          echo '<br/>';
          echo '<a href="https://framagit.org/peppercarrot/documentation" target="_blank" title="External repository link" ><img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/git.svg" alt=""/>&nbsp;&nbsp;Repository</a>';
          echo '<br/>';
          echo '<a href="https://framagit.org/peppercarrot/documentation/commits/master" target="_blank" title="External history link to see all changes made to the documentation" ><img width="16px" height="16px" src="themes/peppercarrot-theme_v2/ico/log.svg" alt=""/>&nbsp;&nbsp;full log</a>';
          ?>      
      </div>
      
    </section>

  </aside>

	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
