<?php include(dirname(__FILE__).'/header.php'); ?>
<div class="container">
<main class="main grid" role="main">

		<section class="col sml-12 med-12 lrg-11 sml-centered med-centered lrg-centered">

      <div class="grid">

      <div class="translabar col sml-12 med-12 lrg-12 sml-centered sml-text-center">
        <ul class="menu" role="toolbar">
          <?php eval($plxShow->callHook('MyMultiLingueStaticLang')) ?>
          <li><a class="lang" href="index.php?article267/how-to-add-a-translation-or-a-correction"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> <?php $plxShow->lang('ADD_TRANSLATION') ?></a></li>
        </ul>
      </div>   
       
       <article class="philosophy col sml-12 med-12 lrg-12 text-center" role="article">
         <?php $plxShow->lang('PHILOSOPHY_TOP') ?>
         <b>
           <?php $plxShow->lang('HOMEPAGE_PATREON_BOX') ?>
           <a href="<?php $plxShow->lang('HOMEPAGE_MAINSERVICE_LINK') ?>" class="link">Patreon</a>
         </b>
         <br/>
         <?php $plxShow->lang('HOMEPAGE_ALTERNATIVES') ?>
            <a href="https://liberapay.com/davidrevoy/" class="link">Liberapay</a>,
            <a href="https://www.tipeee.com/pepper-carrot" class="link">Tipeee</a>,
            <a href="https://paypal.me/davidrevoy" class="link">Paypal</a><?php $plxShow->lang('UTIL_DOT') ?>
         <?php $plxShow->lang('PHILOSOPHY_BOTTOM') ?>
       </article> 

<!-- Footer infos -->
<div style="clear:both;"></div>
<footer class="col sml-12 med-12 lrg-12 text-center">
  <?php include(dirname(__FILE__).'/share-static.php'); ?>          
  <div class="col sml-12 text-center">
    <br/><?php $plxShow->lang('TRANSLATED_BY') ?>
  </div>
</footer>

	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
