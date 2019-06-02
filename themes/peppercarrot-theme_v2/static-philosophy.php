<?php include(dirname(__FILE__).'/header.php'); ?>
<div class="container">
  <main class="main grid" role="main">
		<section class="col sml-12">
      <div class="grid">
        
        <?php include(dirname(__FILE__).'/lib-transla-static.php'); ?>
          
          <article class="philosophy col sml-12 med-12 lrg-12 text-center" role="article">
            <?php $plxShow->lang('PHILOSOPHY_TOP') ?>
              <div class="button moka">
                <a href="<?php $plxShow->urlRewrite('?static12/donate'); ?>">
                  <?php $plxShow->lang(PATRONAGE_BUTTON);?>
                </a>
              </div>
            <?php $plxShow->lang('PHILOSOPHY_BOTTOM') ?>
            <br/>
            <br/>
          </article>
        
        <div style="clear:both;"></div>

      </div>
    </section>
	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
