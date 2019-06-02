<?php if (!defined('PLX_ROOT')) exit; 
// This is the shared code to add the translation buttons to static pages.
?>
 
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
<div style="clear:both;"></div>
