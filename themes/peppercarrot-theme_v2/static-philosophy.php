<?php include(dirname(__FILE__).'/header.php'); ?>
<div class="container">
<main class="main grid" role="main">

		<section class="col sml-12 med-12 lrg-10 sml-centered med-centered lrg-centered">

      <div class="grid">

      <div class="translabar col sml-12 med-12 lrg-12 sml-centered sml-text-center">
        <ul class="menu" role="toolbar">
          <?php eval($plxShow->callHook('MyMultiLingueStaticLang')) ?>
          <li><a class="lang" href="<?php $plxShow->urlRewrite('?static14/documentation&page=010_Translate_the_comic') ?>"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> <?php $plxShow->lang('ADD_TRANSLATION') ?></a></li>
        </ul>
      </div>   
       
       <article class="philosophy col sml-12 med-12 lrg-12 text-center" role="article">
         <?php $plxShow->lang('PHILOSOPHY_TOP') ?>
         <?php include(dirname(__FILE__).'/supportme.php'); ?>
         <?php $plxShow->lang('PHILOSOPHY_BOTTOM') ?>
         <?php include(dirname(__FILE__).'/supportme.php'); ?>
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
