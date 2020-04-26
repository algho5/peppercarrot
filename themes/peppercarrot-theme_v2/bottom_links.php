<?php
if(!defined('PLX_ROOT')) exit;

include_once(dirname(__FILE__).'/navigation.php');

/**
 * Shows links to art sources, comments, framagit if available
 * and a first/previous/next/last/ navigator.
 *
 * @param sourcelink       string  link to art sources
 * @param commentlink      array   comment link and number. Keys: url, nb_com
 * @param framagitlink     string  link to git repository
 * @param navigator_links  array   If this is set, switches into community page mode.
 *                                 See navigation.php -> showNavigator for expected keys.
 */
function showBottomArticleLinks($sourcelink, $commentlink, $framagitlink, $navigator_links = array()) {
  global $plxShow;
  ?>
<div class="content">
  <div style="clear:both;"></div>
  <div class="grid">

    <section class="col sml-12 med-12 lrg-11 text-center sml-centered">
<?php
  if (!empty($sourcelink)) {
?>
      <div class="cardsocket mini col sml-4 med-4 lrg-4">
        <div class="cardblock mini">
          <figure class="thumbnail">
            <a href="<?php print($sourcelink) ?>">
              <img src="<?php $plxShow->racine() ?>/plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/misc/low-res/2019-06_sources-webcomic_by-David-Revoy.jpg&amp;w=275&amp;h=275&amp;s=1&amp;q=92" alt="Pepper doing shopping,">
            </a>
          </figure>
          <div class="button milk">
            <a href="<?php print($sourcelink) ?>">
              <b>Artworks files</b><br/> Krita files, svg and jpg.
            </a>
          </div>
        </div>
      </div>

<?php
  } else {
    # Keep screen positions stable across pages
    echo '<div class="cardsocket mini col sml-4 med-4 lrg-4">&nbsp;</div>';
  }
  if (!empty($commentlink)) {
?>
      <div class="cardsocket mini col sml-4 med-4 lrg-4">
        <div class="cardblock mini">
          <figure class="thumbnail">
            <a href="<?php print($commentlink['url']); ?>#comments">
              <img src="<?php $plxShow->racine() ?>/plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/misc/low-res/2019-06_comment-webcomic_by-David-Revoy.jpg&amp;w=275&amp;h=275&amp;s=1&amp;q=92" alt="Pepper doing shopping," />
            </a>
          </figure>
          <div class="button milk">
            <a href="<?php print($commentlink['url']); ?>#comments">
              <b><?php print($commentlink['nb_com']); ?> Comment(s)</b> <br/>on the blog.
            </a>
          </div>
        </div>
      </div>

<?php
  } else {
    # Keep screen positions stable across pages
    echo '<div class="cardsocket mini col sml-4 med-4 lrg-4">&nbsp;</div>';
  }
  if (!empty($framagitlink)) {
?>
      <div class="cardsocket mini col sml-4 med-4 lrg-4">
        <div class="cardblock mini">
          <figure class="thumbnail">
            <a href="<?php print($framagitlink); ?>">
              <img src="<?php $plxShow->racine() ?>/plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/misc/low-res/2019-06_framagit-webcomic_by-David-Revoy.jpg&amp;w=275&amp;h=275&amp;s=1&amp;q=92" alt="Pepper doing shopping," />
            </a>
          </figure>
          <div class="button milk">
            <a href="<?php print($framagitlink); ?>">
              <b>Git repository</b><br/>Source code (translation)
            </a>
          </div>
        </div>
      </div>

<?php
  } else {
    # Keep screen positions stable across pages
    echo '<div class="cardsocket mini col sml-4 med-4 lrg-4">&nbsp;</div>';
  }
  if (empty($navigator_links)) {
    # This is a webcomic
    showWebcomicNavigator('button', 'button moka');
?>
          <br/>

      <time style="color: rgba(0,0,0,0.6);" datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>">
        <?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>
      </time>
<?php
  } else {
    # This is a community page. Article date is not available here.
    showNavigator($navigator_links, 'button', 'button moka');
  }
?>

    </section>
  </div>
</div>

<div style="clear:both;"></div>
<br/>

<?php
}
?>
