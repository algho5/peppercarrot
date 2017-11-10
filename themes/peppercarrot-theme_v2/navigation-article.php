<?php if(!defined('PLX_ROOT')) exit; ?>

<!-- Navigation-->
<div class="readernav col sml-12 med-12 lrg-12 sml-centered">
  <div class="grid">  

  <div class="col sml-hide sml-12 med-2 lrg-2 med-show">
  </div>

  <?php 
  eval($plxShow->callHook("artPrevNext", array(' ',' ')));
  ?>

  <div class="col sml-hide sml-12 med-2 lrg-2 med-show">
  </div>

  </div>
</div>
