<?php include(dirname(__FILE__).'/header.php'); ?>
<div class="container">
	<main class="main grid" role="main">

		<section class="col sml-12">

      <div class="grid">
        
        <div class="col sml-12 center" style="text-align:center; padding-top: 1rem;">
          <img src="0_sources/ep04_Stroke-of-genius/low-res/en_Pepper-and-Carrot_by-David-Revoy_E04P05.gif" />
          
          <div class="alert blue" style="margin: 0 auto; text-align:center; max-width: 910px; margin-bottom: 1.5rem;">
            <img src="themes/peppercarrot-theme_v2/ico/nfo.svg" alt=""/>
            <strong> Error : Page not found.</strong><br/>
            But!.. Carrot is diving into our database to show you alternatives:
          </div>
        </div>
        
        <div style="clear:both;"></div>
        
        <?php eval($plxShow->callHook("vignetteArtList", array('
        <!-- #art_title -->
        <figure class="thumbnail col sml-4 med-3 lrg-3">
          <a href="#art_url" title="#art_title">
            <img src="plugins/vignette/plxthumbnailer.php?src=#art_vignette&amp;w=370&amp;h=255&amp;s=1&amp;q=92" alt="#art_title" title="#art_title , click to read" >
          </a>
            <figcaption class="text-center"><a href="#art_url" title="#art_title"><strong>#category_list: </strong>#art_title<br/><span class="detail">#art_date #art_nbcoms</span></a></figcaption>
        </figure>
        ',96,'', "...", "rsort"))); ?>

        
      <section class="col sml-12 med-12 lrg-12 text-right">
        <br/>
          <div class="moreposts" style="margin-top: 0.3rem;">
            <a class="button blue" href="<?php $plxShow->pageBlog('#page_url') ?>" title="<?php $plxShow->lang('HOMEPAGE_MOREPOSTS_BUTTON') ?> (<?php $plxShow->lang('BLOG') ?>) "><?php $plxShow->lang('HOMEPAGE_MOREPOSTS_BUTTON') ?> (<?php $plxShow->lang('BLOG') ?>) &nbsp;<img class="svg" src="themes/peppercarrot-theme_v2/ico/go.svg" alt="→"/></a>
          </div>
      </section>
                  <div style="clear:both;"></div>
              <br/><br/><br/><br/>

          <!-- License / Share / Actions -->
          <footer class="grid text-center">
          </footer>

		</section>

	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
