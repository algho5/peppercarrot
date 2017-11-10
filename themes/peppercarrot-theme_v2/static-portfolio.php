<?php include(dirname(__FILE__).'/header.php'); ?>
<div class="container">
	<main class="main grid" role="main">

		<section class="col sml-12 med-8">

			<article class="article static" role="article" id="static-page-<?php echo $plxShow->staticId(); ?>">

				<header>
					<h1>
						<?php $plxShow->staticTitle(); ?>
					</h1>
				</header>

				<section>
					<?php $plxShow->staticContent(); ?>
          
          
 <?php eval($plxShow->callHook("vignetteArtList", array('
 
<!-- #art_title -->
<div class="thumbnail">
  <a href="#art_url" title="#art_title">
    <img src="#art_vignette" alt="#art_title" title="#art_title , click to read">
  </a>
  <a href="#art_url" title="#art_title">
    #art_title
  </a>
  <div class="captionscomments">
    #art_nbcoms
  </div>
</div>
                    ',99,'001', "...", "rsort"))); ?>
          
          
          
				</section>

			</article>

		</section>

		<?php include(dirname(__FILE__).'/sidebar.php'); ?>

	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
