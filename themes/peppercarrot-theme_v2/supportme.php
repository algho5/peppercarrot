<?php if(!defined('PLX_ROOT')) exit;?>
<div style="padding: 0.8rem 0 0.8rem 0;">
  <a class="bigbuttonpatreon" href="https://www.patreon.com/davidrevoy" title="<?php $plxShow->lang('HOMEPAGE_PATREON_INFO') ?>">
    <span style="font-size: 65%; font-weight: normal;"><?php $plxShow->lang('HOMEPAGE_PATREON_BOX') ?></span><br>
    <span style="padding-left: 50px;">Patreon</span>
  </a>
  <div>
    <div class="alternatives">
      <?php $plxShow->lang('HOMEPAGE_ALTERNATIVES') ?>
    </div>
    <a href="https://paypal.me/davidrevoy" title="Send money via Paypal" class="alternativesbutton paypal">Paypal</a>
    <a href="https://www.tipeee.com/pepper-carrot" title="<?php $plxShow->lang('HOMEPAGE_PATREON_BOX') ?> Tipeee" class="alternativesbutton tipeee">Tipeee</a>
    <a href="https://liberapay.com/davidrevoy/" title="<?php $plxShow->lang('HOMEPAGE_PATREON_BOX') ?> Liberapay" class="alternativesbutton liberapay">Liberapay</a>
    <a href="https://g1.duniter.fr/#/app/wot/4nosBEwT8xQfMY11sq32AnZF1XcoqzG9tArXJq9mu8Wc/DavidRevoy" title="Send G1 to David Revoy" class="alternativesbutton G1">G1</a>
    <a href="<?php $plxShow->urlRewrite('?static12/iban-and-mail-adress') ?>" title="Send money via IBAN or Send goods via mail" class="alternativesbutton iban">Bank/Mail</a>
  </div>
</div>
