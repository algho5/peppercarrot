<?php
function showBottomArticleLinks() {
  global $plxShow;
  ?>
<div class="content">
  <div style="clear:both;"></div>
  <div class="grid">

    <section class="col sml-12 med-12 lrg-11 text-center sml-centered">

      <div class="cardsocket mini col sml-4 med-4 lrg-4">
        <div class="cardblock mini">
          <figure class="thumbnail">
            <a href="<?php eval($plxShow->callHook('MyMultiLingueSourceLinkDisplay')) ?>">
              <img src="<?php $plxShow->racine() ?>/plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/misc/low-res/2019-06_sources-webcomic_by-David-Revoy.jpg&amp;w=275&amp;h=275&amp;s=1&amp;q=92" alt="Pepper doing shopping,">
            </a>
          </figure>
          <div class="button milk">
            <a href="<?php eval($plxShow->callHook('MyMultiLingueSourceLinkDisplay')) ?>">
              <b>Artworks files</b><br/> Krita files, svg and jpg.
            </a>
          </div>
        </div>
      </div>


      <div class="cardsocket mini col sml-4 med-4 lrg-4">
        <div class="cardblock mini">
          <figure class="thumbnail">
            <a href="<?php eval($plxShow->callHook('MyMultiLingueCommentLinkDisplay', array('url'))) ?>#comments">
              <img src="<?php $plxShow->racine() ?>/plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/misc/low-res/2019-06_comment-webcomic_by-David-Revoy.jpg&amp;w=275&amp;h=275&amp;s=1&amp;q=92" alt="Pepper doing shopping," />
            </a>
          </figure>
          <div class="button milk">
            <a href="<?php eval($plxShow->callHook('MyMultiLingueCommentLinkDisplay', array('url'))) ?>#comments">
              <b><?php eval($plxShow->callHook('MyMultiLingueCommentLinkDisplay', array('nb_com'))) ?> Comment(s)</b> <br/>on the blog.
            </a>
          </div>
        </div>
      </div>

      <div class="cardsocket mini col sml-4 med-4 lrg-4">
        <div class="cardblock mini">
          <figure class="thumbnail">
            <a href="<?php eval($plxShow->callHook('MyMultiLingueFramagitLinkDisplay')) ?>">
              <img src="<?php $plxShow->racine() ?>/plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/misc/low-res/2019-06_framagit-webcomic_by-David-Revoy.jpg&amp;w=275&amp;h=275&amp;s=1&amp;q=92" alt="Pepper doing shopping," />
            </a>
          </figure>
          <div class="button milk">
            <a href="<?php eval($plxShow->callHook('MyMultiLingueFramagitLinkDisplay')) ?>">
              <b>Git repository</b><br/>Source code (translation)
            </a>
          </div>
        </div>
      </div>

    <?php
    $buttonthemeA = 'button';
    $buttonthemeB = 'button moka';
    include(dirname(__FILE__).'/navigation.php');
    ?>
      <br/>

      <time style="color: rgba(0,0,0,0.6);" datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>">
        <?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>
      </time>
    </section>
  </div>
</div>

<div style="clear:both;"></div>
<br/>

<?php
}
?>
