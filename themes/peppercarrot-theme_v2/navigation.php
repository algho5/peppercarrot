<?php if(!defined('PLX_ROOT')) exit; ?>

<!-- Navigation-->
<div class="readernav col sml-12 med-12 lrg-12 sml-centered">
  <div class="grid">  

  <div class="col sml-hide sml-12 med-2 lrg-2 med-show">
    <a class="readernavbutton" style="text-align:left;" href="<?php $plxShow->lastArtList('#art_url',1,3,'','sort'); ?>">
      <img src="themes/peppercarrot-theme_v2/ico/first.svg" alt=""/> <?php $plxShow->lang('FIRST') ?>
    </a>
  </div>

  <?php 
  $nextep=$plxShow->getLang('UTIL_NEXT_EPISODE');
  $prevep=$plxShow->getLang('UTIL_PREVIOUS_EPISODE');
  eval($plxShow->callHook("artPrevNext", array(''.$prevep.'',''.$nextep.'')));
  ?>

  <div class="col sml-hide sml-12 med-2 lrg-2 med-show">
    <a class="readernavbutton" style="text-align:right;" href="<?php $plxShow->lastArtList('#art_url',1,3); ?>">
      <?php $plxShow->lang('LAST') ?> <img src="themes/peppercarrot-theme_v2/ico/last.svg" alt=""/>
    </a>
  </div>

  </div>
</div>
