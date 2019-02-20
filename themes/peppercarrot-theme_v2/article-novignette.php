<?php $plxShow->artBlogRedirect(); ?>
<?php include(dirname(__FILE__) . '/header.php'); ?>

  <div class="container">
  
	<main class="main grid" role="main">
    
    <section class="col sml-12 med-9">
			<article class="article" role="article" id="post-<?php echo $plxShow->artId(); ?>">

					<h1><?php $plxShow->artTitle(); ?></h1>
					<small><time datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>"><?php $plxShow->artDate('#num_day #month #num_year(4)'); ?></time></small>

          <!-- Content -->
          <section class="col sml-12 med-12 lrg-12">
              <div class="content">
              <?php $plxShow->artContent(); ?>
              </div>
          </section>

          <!-- License / Share / Actions -->
          <div style="clear:both;"></div>
          <?php include(dirname(__FILE__).'/share.php'); ?>        

      </article>
      
      <?php include(dirname(__FILE__).'/commentaires.php'); ?>

		</section>

		<?php include(dirname(__FILE__).'/sidebar.php'); ?>

	</main>
  </div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
