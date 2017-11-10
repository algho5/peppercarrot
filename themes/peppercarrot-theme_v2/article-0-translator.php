<?php include(dirname(__FILE__) . '/header.php'); ?>
  <div class="container">
	<main class="main grid" role="main">
    
		<section class="col sml-12" >
			<article class="article" role="article" id="post-<?php echo $plxShow->artId(); ?>">
            

				<header class="col sml-12 med-12 lrg-12 text-center">
            
					<h1>
						<?php $plxShow->artTitle(); ?>
					</h1>
					<small>
						<time datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>"><?php $plxShow->artDate('#num_day #month #num_year(4)'); ?></time> 
					</small>
				</header>
        
                  <!-- vignette -->
                  <figure class="col sml-12 med-12 lrg-12 text-center">
                    <a href="<?php eval($plxShow->callHook('showVignette', 'true')); ?>"><?php eval($plxShow->callHook('showVignette')); ?></a>
                  </figure>
                  
                  <!-- Content -->
                  <section class="col sml-12 med-12 lrg-12">
                      <div class="content">
                      <?php $plxShow->artContent(); ?>
                      </div>
                  </section>
          
              </article>
        </section>
        
  <div style="clear:both"></div>
  <br/><br/>
  
  <div class="col sml-12 med-12 lrg-12 text-center">
    <h2>Check the translation
      <a  class="button blue" href="<?php $plxShow->urlRewrite('index.php?fr/static6/sources&page=translation') ?>" id="status">
        translation status table here
      </a>
    &nbsp;&nbsp;for an overview.</h2>
      <br/><br/>  <br/><br/>

</div>

  <?php include(dirname(__FILE__).'/commentaires.php'); ?>
      
	</main>
  </div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
