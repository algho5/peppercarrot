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
      
      <?php
      $contents = file_get_contents('data/documentation/_sidebar.md');
      $contents = str_replace("](", "](index.php?static14/documentation&page=", $contents);
      $contents = str_replace(".md", "", $contents);
      $Parsedown = new Parsedown();
      echo $Parsedown->text($contents);
      ?>
      
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
