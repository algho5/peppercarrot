<?php include(dirname(__FILE__).'/header.php'); ?>
<div class="container">
  <main class="main grid" role="main">
		<section class="col sml-12">
      <div class="grid">
        
        <?php include(dirname(__FILE__).'/lib-transla-static.php'); ?>
          
          <article class="page philo col sml-12 med-12 lrg-10 sml-centered text-center" role="article">
            <h1>
              <?php $plxShow->lang('PHILOSOPHY') ?>
            </h1>
            <?php $plxShow->lang('PHILOSOPHY_TOP') ?>
              <div class="button">
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
