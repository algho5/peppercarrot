<?php if(!defined('PLX_ROOT')) exit;


/**
 * Show first, previous, next, last links on article page
 *
 * @param string  buttonthemeActive    css class for active link
 * @param string  buttonthemeInactive  css class for inactive link
 */
function showWebcomicNavigator($buttonthemeActive, $buttonthemeInactive) {
  global $plxShow;
?>

<!-- Navigation-->
<div class="readernav col sml-12 med-12 lrg-12 sml-centered">
  <div class="grid">

  <div class="col sml-hide sml-12 med-3 lrg-3 med-show">
    <div class="<?php echo ''.$buttonthemeActive.''; ?>">
      <a class="readernavbutton" style="text-align:left;" href="<?php $plxShow->lastArtList('#art_url',1,3,'','sort'); ?>">
        &nbsp; « &nbsp; <?php $plxShow->lang('FIRST') ?>
      </a>
    </div>
  </div>

  <?php
  $nextep=$plxShow->getLang('UTIL_NEXT_EPISODE');
  $prevep=$plxShow->getLang('UTIL_PREVIOUS_EPISODE');
  eval($plxShow->callHook("artPrevNext", array(''.$prevep.'',''.$nextep.'',''.$buttonthemeActive.'',''.$buttonthemeInactive.'')));
  ?>

  <div class="col sml-hide sml-12 med-3 lrg-3 med-show">
    <div class="<?php echo ''.$buttonthemeActive.''; ?>">
      <a class="readernavbutton" style="text-align:right;" href="<?php $plxShow->lastArtList('#art_url',1,3); ?>">
        <?php $plxShow->lang('LAST') ?>&nbsp; » &nbsp;
      </a>
    </div>
  </div>

  </div>
</div>

<?php
}

/**
 * HTML markup for "Back to index" button on bottom of page
 */
function showNavigatorBackButton($link) {
    echo '
    <div style="clear:both;"></div>
    <div class="button col sml-centered lrg-3" style="display:block">
        <a href="'.$link.'" class="readernavbutton">← Back to index</a>
    </div>
    ';
}


# Helper function for showing a navigator link
function showNavigatorLink($link, $label, $class, $text_align, $buttontheme) {
  echo '
  <div class="'.$class.'">
    <div class="'.$buttontheme.'">
      <a class="readernavbutton" style="text-align:'.$text_align.';" href="'.$link['url'].'" alt="'.$link['title'].'" title="'.$link['title'].'">
        '.$label.'
      </a>
    </div>
  </div>';
}

/**
 * Shows a horizontal First/Previous/Next/Last navigator.
 * Adapted from vignette->artPrevNext.
 *
 * @param  navigator_links      array   with keys 'first', 'previous', 'next', 'last'
 *                                      array entries have keys 'url' & 'title'
 * @param  buttonthemeActive    string  css class for active links
 * @param  buttonthemeInactive  string  css class for deactivated links
 *
 */
function showNavigator($navigator_links, $buttonthemeActive, $buttonthemeInactive) {
    global $plxShow;

    echo '<div class="readernav col sml-12 med-12 lrg-12 sml-centered"><div class="grid">';

    showNavigatorLink(
        $navigator_links['first'],
        '&nbsp; « &nbsp; '.$plxShow->getLang('FIRST'),
        'col sml-hide sml-12 med-3 lrg-3 med-show',
        'left',
        $buttonthemeActive);

    $theme = $buttonthemeActive;
    if ($navigator_links['previous']['link'] === '#') {
      $theme = $buttonthemeInactive . ' off';
    }
    showNavigatorLink(
        $navigator_links['previous'],
        '&nbsp; &lt; &nbsp; '.$plxShow->getLang('UTIL_PREVIOUS_EPISODE'),
        'col sml-6 med-3 lrg-3',
        'left',
        $theme);

    $theme = $buttonthemeActive;
    if ($navigator_links['next']['link'] === '#') {
      $theme = $buttonthemeInactive . ' off';
    }
    showNavigatorLink(
        $navigator_links['next'],
        $plxShow->getLang('UTIL_NEXT_EPISODE') . ' &nbsp; &gt; &nbsp;',
        'col sml-6 med-3 lrg-3',
        'right',
        $theme);

    showNavigatorLink(
        $navigator_links['last'],
        $plxShow->getLang('LAST') . ' &nbsp; » &nbsp;',
        'col sml-hide sml-12 med-3 lrg-3 med-show',
        'right',
        $buttonthemeActive);

    echo '</div></div>';
}
?>
