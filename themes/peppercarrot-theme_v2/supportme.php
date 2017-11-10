<?php if(!defined('PLX_ROOT')) exit; 
$lang = $plxShow->defaultLang($echo);
?>
<!-- Support me -->
<div class="followcomic col sml-12 med-12 lrg-12">
  <div class="grid">
    <div class="col sml-12 med-12 lrg-12">
      <a class="followbutton patreon" href="https://www.patreon.com/davidrevoy">
        <?php $plxShow->lang('HOMEPAGE_PATREON_BUTTON') ?>
      </a>
        <div class="supportmetxt">
          <?php $plxShow->lang('HOMEPAGE_ALTERNATIVES') ?>
          <a href="https://liberapay.com/davidrevoy/" class="link">Liberapay</a>,
          <a href="https://www.tipeee.com/pepper-carrot" class="link">Tipeee</a>,
          <a href="https://paypal.me/davidrevoy" class="link">Paypal</a><?php $plxShow->lang('UTIL_DOT') ?>
        </div>
    </div>
  </div>
</div>
