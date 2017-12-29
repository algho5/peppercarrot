<?php include(dirname(__FILE__) . '/header.php'); ?>
<?php include(dirname(__FILE__).'/lib-parsedown.php'); ?>

  <div class="container">
	<main class="main grid" role="main">
    
		<section class="col sml-12" >
			<article style="max-width: 850px; margin: 0 auto; " class="article" role="article" id="post-<?php echo $plxShow->artId(); ?>">
        
              <?php
              # Dynamic: can be edited here: 
              # https://framagit.org/peppercarrot/webcomics/blob/master/CONTRIBUTING.md
              $contributorfilepath = '0_sources/CONTRIBUTING.md';
              $contents = file_get_contents($contributorfilepath);
              $Parsedown = new Parsedown();
              echo '<div style="text-align:left;">';
              echo $Parsedown->text($contents);
              echo '</div>';
              ?>
              
      </article>
    </section>
</div>
      
	</main>
  </div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
