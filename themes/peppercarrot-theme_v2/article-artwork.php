<?php include(dirname(__FILE__) . '/header.php'); ?>
  <div class="container">
  
	<main class="main grid" role="main">
    
    <section class="col sml-12 med-9">
			<article class="article" role="article" id="post-<?php echo $plxShow->artId(); ?>">
      
        <section class="col sml-12 med-12 lrg-12" style="padding:0 0;">
                
          <!-- Display rich auto-formated artworks (link to hires, sources, license) -->
          <figure class="col sml-12 med-12 lrg-12 text-center" style="padding:0 0;">
              <?php eval($plxShow->callHook('showVignettePlus')); ?>
          </figure>

          <!-- Description (blog post content) -->
          <div class="content" style="max-width:650px; text-align: justify;">
            <?php $plxShow->artContent(); ?>
            <br/>
          </div>
          
        </section>
<div style="clear:both;"></div>
        <section class="share col sml-12 med-12 lrg-12 sml-centered sml-text-center" style="color:#888; font-size:0.85rem;">
          <time datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>"><?php $plxShow->artDate('#num_day #month #num_year(4)'); ?></time>
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
