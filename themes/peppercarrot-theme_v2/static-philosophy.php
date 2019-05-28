<?php include(dirname(__FILE__).'/header.php'); ?>
<div class="container">
  <main class="main grid" role="main">
		<section class="col sml-12 med-12 lrg-10 sml-centered med-centered lrg-centered">

        <div class="grid">
        
          <div class="col sml-12 sml-text-right">
            <nav class="nav" role="navigation">
              <div class="responsive-langmenu">
                <label for="langmenu"><span class="translabutton"><img src="themes/peppercarrot-theme_v2/ico/language.svg" alt=""/> <?php echo $langlabel;?><img src="themes/peppercarrot-theme_v2/ico/dropdown.svg" alt=""/></span></label>
                <input type="checkbox" id="langmenu">
                <ul class="langmenu expanded">
                <?php eval($plxShow->callHook('MyMultiLingueStaticLang')) ?>
                <li class="button"><a class="lang" href="<?php $plxShow->urlRewrite('?static14/documentation&page=010_Translate_the_comic') ?>"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> <?php $plxShow->lang('ADD_TRANSLATION') ?></a></li>
                </ul>
              </div>
            </nav>
          </div>
          
        <article class="philosophy col sml-12 med-12 lrg-12 text-center" role="article">
          <?php $plxShow->lang('PHILOSOPHY_TOP') ?>
          <?php echo '<a href="TODO-DONATEPAGE">'.$plxShow->Getlang(PATRONAGE_BUTTON).'</a>.'; ?>
          <?php $plxShow->lang('PHILOSOPHY_BOTTOM') ?>
        </article>
        
        <div style="clear:both;"></div>

	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
