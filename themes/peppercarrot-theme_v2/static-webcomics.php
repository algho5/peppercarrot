<?php include(dirname(__FILE__).'/header.php'); 
$lang = $plxShow->defaultLang($echo);
?>
<div class="container">
<main class="main grid" role="main">

		<section class="col sml-12">

      <div class="grid">

      <div class="translabar col sml-12 med-12 lrg-12 sml-centered sml-text-center">
        <ul class="menu" role="toolbar">
          <?php eval($plxShow->callHook('MyMultiLingueStaticLang')) ?>
          <li><a class="lang" href="index.php?article267/how-to-add-a-translation-or-a-correction"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> <?php $plxShow->lang('ADD_TRANSLATION') ?></a></li>
        </ul>
      </div>

      <section class="col sml-12 med-12 lrg-12">
        <div class="homebox">
          <h2><?php $plxShow->lang('WEBCOMIC_EPISODE') ?> :</h2>
          <div class="homecontent" style="margin-right: -1rem;">
          <?php eval($plxShow->callHook("vignetteArtList", array('
          <figure class="thumbnail col sml-12 med-4 lrg-4" style="padding:0 1rem 0 0;">
            <a href="#art_url" title="#art_title">
              <img src="plugins/vignette/plxthumbnailer.php?src=#episode_vignette&amp;w=400&amp;h=270&amp;s=1&amp;q=92" alt="#art_title" title="#art_title , click to read" >
            </a>
            <figcaption class="text-center"><a href="#art_url" title="#art_title"><span class="detail">#art_date #art_nbcoms</span></a></figcaption>
          </figure>
          ',99,'003', "...", "rsort"))); ?>
          
        <div style="clear:both;"></div>

        <h2>Older webcomic from same author :</h2>        
        <?php eval($plxShow->callHook("vignetteArtList", array('

        <figure class="thumbnail col sml-6 med-4 lrg-4" style="padding:0 1rem 0 0;">
          <a href="#art_url" title="#art_title">
            <img src="plugins/vignette/plxthumbnailer.php?src=#art_vignette&amp;w=400&amp;h=270&amp;s=1&amp;q=92" alt="#art_title" title="#art_title , click to read" >
          </a>
            <figcaption class="text-center"><a href="#art_url" title="#art_title"><span class="detail">#art_date #art_nbcoms</span></a></figcaption>
        </figure>
        ',2,'002', "...", "rsort"))); ?>
          
        <div style="clear:both;"></div>
          
          </div>
        </div>
      </section>
	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
