<?php include(dirname(__FILE__).'/header.php'); 
$lang = $plxShow->defaultLang($echo);

echo "<!-- LANG DEBUG:".$lang." -->";

?>
<div class="container">
<main class="main grid" role="main">

		<section class="col sml-12">

      <div class="grid">

      <div class="translabar col sml-12 med-12 lrg-12 sml-centered sml-text-center">
        <ul class="menu" role="toolbar">
          <?php eval($plxShow->callHook('MyMultiLingueStaticAllLang')) ?>
          <li><a class="lang" href="<?php $plxShow->urlRewrite('?static14/documentation&page=010_Translate_the_comic') ?>"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> <?php $plxShow->lang('ADD_TRANSLATION') ?></a></li>
        </ul>
      </div>
      
      <section class="col sml-12 med-12 lrg-12" >
        <div class="cover">
          <div class="covertextoverlay">
            <h1 style="margin-bottom: 1.4rem;"><?php $plxShow->lang('HOMEPAGE_BIG_TEXT') ?></h1>
              <a class="moreinfobutton" href="<?php $plxShow->urlRewrite('?static2/philosophy') ?>" title="<?php $plxShow->lang('HOMEPAGE_MOREINFO_BUTTON') ?>"><?php $plxShow->lang('HOMEPAGE_MOREINFO_BUTTON') ?></a>
          </div>
        </div>
      </section>

      <section class="col sml-12 med-12 lrg-12">
        <div class="homebox">
          <h2 style="margin-top: 0.8rem;"><?php $plxShow->lang('WEBCOMIC_EPISODE') ?></h2>
          <div class="homecontent" style="margin-right: -1rem;">
          <?php eval($plxShow->callHook("vignetteArtList", array('
          <figure class="thumbnail #translationstatus col sml-12 med-4 lrg-4" style="padding:0 1rem 0 0;">
            <a href="#art_url" title="#art_title">
              <img class="#translationstatus" src="plugins/vignette/plxthumbnailer.php?src=#episode_vignette&amp;w=400&amp;h=270&amp;s=1&amp;q=92" alt="#art_title" title="#art_title, click to read #translationmessage" >
            </a>
            <figcaption class="#translationstatus text-center"><a href="#art_url" title="#art_title"><span class="detail">#overlay#art_date</span></a></figcaption>
          </figure>
          ',99,'003', "...", "rsort"))); ?>
          
          <div style="clear:both;"></div>
          </div>
        <?php include(dirname(__FILE__).'/share-static.php'); ?>  
          </div>
          </section>
        </div>
      </section>
	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
