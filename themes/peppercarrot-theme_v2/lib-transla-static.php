<?php if (!defined('PLX_ROOT')) exit;
// This is the shared code to add the translation buttons to static pages.
?>

<div class="col sml-12 sml-text-right">
  <nav class="nav" role="navigation">
    <div class="responsive-langmenu">
        <?php
          eval($plxShow->callHook('MyMultiLingueLanguageMenu', array(
              'pageurl' => '?lang={LANG}'
          )));
         ?>
    </div>
  </nav>
</div>
<div style="clear:both;"></div>
