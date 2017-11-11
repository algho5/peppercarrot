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
          <li><a class="lang" href="index.php?fr/article267/translation-tutorial"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> <?php $plxShow->lang('ADD_TRANSLATION') ?></a></li>
        </ul>
      </div>
      
      <section class="col sml-12 med-12 lrg-12" >
        <div class="cover">
          <div class="covertextoverlay">
            <h1><?php $plxShow->lang('HOMEPAGE_BIG_TEXT') ?></h1>
            <div id="coverpatreonbox">
              <?php $plxShow->lang('HOMEPAGE_PATREON_BOX') ?>
              <br/>
              <a href="<?php $plxShow->lang('HOMEPAGE_MAINSERVICE_LINK') ?>" title="<?php $plxShow->lang('HOMEPAGE_PATREON_BUTTON') ?>">
                <img src="<?php $plxShow->template(); ?>/img/patreon-logo.png" alt="Patreon"/>
              </a>
              <br/>
              <div id="alternatives">
                <?php $plxShow->lang('HOMEPAGE_ALTERNATIVES') ?>
                <a href="https://liberapay.com/davidrevoy/" class="link">Liberapay</a>,
                <a href="https://www.tipeee.com/pepper-carrot" class="link">Tipeee</a>,
                <a href="https://paypal.me/davidrevoy" class="link">Paypal</a><?php $plxShow->lang('UTIL_DOT') ?>
              </div>
            </div>
          </div>
        </div>
      </section>  

      <section class="col sml-12 med-4 lrg-4">
        <div class="homebox">
          <h2><?php $plxShow->lang('HOMEPAGE_LAST_EPISODE') ?></h2>
          <div class="homecontent" style="margin-right: -1rem;">
          <?php eval($plxShow->callHook("vignetteArtList", array('
          <div class="col sml-12 med-12 lrg-12" style="padding:0 1rem 0 0;">
            <div class="lastep">
              <figure>
                <a href="#art_url" title="#art_title">
                  <img src="plugins/vignette/plxthumbnailer.php?src=#episode_vignette&amp;w=630&amp;h=550&amp;s=1&amp;q=65" alt="#art_title" title="#art_title , click to read" >
                </a>
                <figcaption><a href="#art_url" title="#art_title"><span class="detail">#art_date #art_nbcoms</span></a></figcaption>
              </figure>
            </div>
          </div>
          ',1,'003', "...", "rsort"))); ?>
          </div>
            <div style="clear:both;"></div>
          <div class="moreposts" style="margin-bottom: 1rem;">
            <a class="button blue" href="<?php $plxShow->urlRewrite('?static3/webcomics') ?>" title="<?php $plxShow->lang('WEBCOMIC_EPISODE') ?>"><?php $plxShow->lang('WEBCOMIC_EPISODE') ?>  &nbsp;<img class="svg" src="themes/peppercarrot-theme_v2/ico/go.svg" alt="→"/></a>
          </div>
        </div>
      </section>
      
      <section class="col sml-12 med-8 lrg-8">
        <div class="homebox news">
          <h2><?php $plxShow->lang('HOMEPAGE_NEWS_UPDATE') ?></h2>
          <div class="homecontent" style="margin-right: -1rem;">
            <?php 
            eval($plxShow->callHook("vignetteArtList", array('
              <div class="col sml-6 med-4 lrg-4" style="padding:0 1rem 0 0; margin: 0 0 1rem 0;">
                <div class="homethumbnail">
                <figure>
                  <a href="#art_url" title="#art_title">
                    <img src="plugins/vignette/plxthumbnailer.php?src=#art_vignette&amp;w=270&amp;h=160&amp;s=1&amp;q=60&amp;a=t" alt="#art_title" title="#art_title , click to read" >
                  </a>
                  <figcaption><a href="#art_url" title="#art_title">#art_supertitle #art_date#art_nbcoms</span></a></figcaption>
                </figure>
                </div>
              </div>
              ',6,'001|004|005|006|007|008|009|010|011|012|013', "...", "rsort"))); 
            ?>
          </div>
            <div style="clear:both;"></div>
          <div class="moreposts" style="margin-top: 0.3rem;">
            <a class="button blue" href="<?php $plxShow->pageBlog('#page_url') ?>" title="<?php $plxShow->lang('HOMEPAGE_MOREPOSTS_BUTTON') ?> (<?php $plxShow->lang('BLOG') ?>) "><?php $plxShow->lang('HOMEPAGE_MOREPOSTS_BUTTON') ?> (<?php $plxShow->lang('BLOG') ?>) &nbsp;<img class="svg" src="themes/peppercarrot-theme_v2/ico/go.svg" alt="→"/></a>
          </div>
        </div>
      </section>

	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
