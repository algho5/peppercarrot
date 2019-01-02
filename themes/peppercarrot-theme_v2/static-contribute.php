<?php include(dirname(__FILE__).'/header.php'); ?>
<div class="container">
<main class="page grid" role="main">
  <section class="col sml-12 med-12 lrg-10 sml-centered med-centered lrg-centered">
    <div class="grid">
    
      <div class="translabar col sml-12 med-12 lrg-12 sml-centered sml-text-center">
        <ul class="menu" role="toolbar">
          <?php eval($plxShow->callHook('MyMultiLingueStaticLang')) ?>
          <li><a class="lang" href="<?php $plxShow->urlRewrite('?static14/documentation&page=010_Translate_the_comic') ?>"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> <?php $plxShow->lang('ADD_TRANSLATION') ?></a></li>
        </ul>
      </div>
      
      <div class="contribute col sml-12 med-12">
            
        <article class="col sml-12 med-12 lrg-12" role="article">
          <?php $plxShow->lang('CONTRIBUTE_TOP') ?>
        </article>

        <article class="col sml-12 med-12 lrg-12" role="article">
          <?php $plxShow->lang('CONTRIBUTE_DONATION') ?> 
          <?php $plxShow->lang('HOMEPAGE_ALTERNATIVES') ?>
          <a href="https://paypal.me/davidrevoy" title="Send money via Paypal" class="alternativesbutton paypal">Paypal</a>
          <a href="https://www.tipeee.com/pepper-carrot" title="<?php $plxShow->lang('HOMEPAGE_PATREON_BOX') ?> Tipeee" class="alternativesbutton tipeee">Tipeee</a>
          <a href="https://liberapay.com/davidrevoy/" title="<?php $plxShow->lang('HOMEPAGE_PATREON_BOX') ?> Liberapay" class="alternativesbutton liberapay">Liberapay</a>
          <a href="https://g1.duniter.fr/#/app/wot/4nosBEwT8xQfMY11sq32AnZF1XcoqzG9tArXJq9mu8Wc/DavidRevoy" title="Send G1 to David Revoy" class="alternativesbutton G1">G1</a>
          <a href="<?php $plxShow->urlRewrite('?static12/iban-and-mail-adress') ?>" title="Send money via IBAN or Send goods via mail" class="alternativesbutton iban">Bank/Mail</a>
          <br/>
          <br/>
          <img src="https://www.peppercarrot.com/0_sources/0ther/misc/low-res/2018-11-22_contribute_01-donation_by-David-Revoy.jpg" alt="A monochromatic illustration representing Pepper being happy after going to various shops. Carrot holds money." title="Illustration: CC-By David Revoy | Sources: Sources→Misc.">
        </article>
        
        <article class="col sml-12 med-12 lrg-12" role="article">
          <?php $plxShow->lang('CONTRIBUTE_TRANSLATION') ?>
          <img src="https://www.peppercarrot.com/0_sources/0ther/misc/low-res/2018-11-22_contribute_02-translation_by-David-Revoy.jpg" alt="A monochromatic illustration representing Carrot holding a long flag tagged with Thank you in many languages." title="Illustration: CC-By David Revoy | Sources: Sources→Misc.">
        </article>
        
        <article class="col sml-12 med-12 lrg-12" role="article">
          <?php $plxShow->lang('CONTRIBUTE_DERIVATIONS') ?>
          <a class="contributelink" href="<?php $plxShow->urlRewrite('?categorie4/derivations') ?>" title="Go to the blog page">
            <b><?php $plxShow->catList('','#art_nb',4); ?> derivatives projects</b> on the Blog &nbsp;&nbsp;<img class="svg" src="themes/peppercarrot-theme_v2/ico/go.svg" alt="→"/>
          </a>
        </article>
        
        <article class="col sml-12 med-12 lrg-12" role="article">
          <?php $plxShow->lang('CONTRIBUTE_FANART');
          $fanartcounter = 0;
          $pathartworks = '0_sources/0ther/fan-art';
          $search = glob($pathartworks."/*.jpg");
          if (!empty($search)){ 
            foreach ($search as $filepath) {
              $fanartcounter = $fanartcounter + 1;
            }
          }?>
          <a class="contributelink" href="<?php $plxShow->urlRewrite('?static10/fanart-gallery') ?>" title="Go to the blog page">
            <b><?php echo ''.$fanartcounter.''; ?> fan-arts</b> on the Blog&nbsp;&nbsp;<img class="svg" src="themes/peppercarrot-theme_v2/ico/go.svg" alt="→"/>
          </a>
        </article>
  
        <article class="col sml-12 med-12 lrg-12" role="article">
          <?php $plxShow->lang('CONTRIBUTE_PRESS') ?>
          <div class="buttonlist col sml-12 med-12 lrg-12 sml-centered sml-text-center">
          <ul class="menu">
            <li>
              <a href="https://peertube.touhoppai.moe/videos/search?search=david%20revoy">
                <b>Peertube</b> <?php $plxShow->lang('COMMUNITY') ?>
              </a>
            </li>
            <li>
              <a href="https://funnyjunk.com/channel/pepperandcarrot">
                <b>Funnyjunk</b> <?php $plxShow->lang('COMMUNITY') ?>
              </a>
            </li>
            <li>
              <a href="https://imgur.com/gallery/8ABWs">
                <b>Imgur</b> <?php $plxShow->lang('COMMUNITY') ?>
              </a>
            </li>
            <br/>
            <li>
              <a href="https://www.reddit.com/r/PepperCarrot/">
                <b>Reddit</b> <?php $plxShow->lang('COMMUNITY') ?>
              </a>
            </li>
            <li>
              <a href="https://storyberries.com/author/david-revoy/">
                <b>Storyberries</b> <?php $plxShow->lang('COMMUNITY') ?>
              </a>
            </li>
            <li>
              <a href="https://storyberries.com/author/david-revoy/">
                <b>Pipro k. Karoĉjo</b> <?php $plxShow->lang('COMMUNITY') ?>
              </a>
            </li>
          </ul>
          </div>
        </article>

        <article class="col sml-12 med-12 lrg-12" role="article">
          <?php $plxShow->lang('CONTRIBUTE_OTHER') ?>
        </article>
        
        <article class="col sml-12 med-12 lrg-12" role="article">
          <?php $plxShow->lang('CONTRIBUTE_IRC') ?>
          <div class="buttonlist col sml-12 med-12 lrg-12 sml-centered sml-text-center">
          <ul class="menu">
            <li>
              <a href="http://webchat.freenode.net?channels=%23pepper%26carrot" title="#pepper&amp;Carrot , freenode.net">
                <b>IRC</b> #pepper&amp;carrot
              </a>
            </li>
            <li>
              <a href="https://telegram.me/joinchat/BLVsYz_DIz-S-TJZB9XW7A" title="Bridged Irc channel for Telegram client">
                <b>Telegram</b> (IRC bridge)
              </a>
            </li>
            <li>
              <a href="https://riot.im/app/#/room/#freenode_#pepper&carrot:matrix.org" title="Bridged Irc channel for Riot, a Matrix client">
                <b>Matrix</b> (IRC bridge)
              </a>
            </li>
            <li>
              <a href="https://framateam.org/signup_user_complete/?id=gcaq67sntfgr5jbmoaogsgdfqc" title="Bridged Irc channel for Framateam, Mattermost client hosted by Framasoft">
                <b>Framateam</b> (IRC bridge)
              </a>
            </li>
          </ul>
          </div>
        </article>

          <a href="0_sources/0ther/misc/hi-res/2016-05-28_pepper-and-carrot_fixing-the-project_by-David-Revoy.jpg" alt="illustration: picture of Pepper and Carrot fixing a big machine">
            <img src="0_sources/0ther/misc/low-res/2016-05-28_pepper-and-carrot_fixing-the-project_by-David-Revoy.jpg" >
          </a>

      </div>
    </div>
      
    <!-- Footer infos -->
    <div style="clear:both;"><br/><br/></div>

    <footer class="col sml-12 med-12 lrg-12 text-center">
      <?php include(dirname(__FILE__).'/share-static.php'); ?>          
      <div class="col sml-12 text-center">
        <br/><?php $plxShow->lang('TRANSLATED_BY') ?>
      </div>
    </footer>

		</section>
	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
