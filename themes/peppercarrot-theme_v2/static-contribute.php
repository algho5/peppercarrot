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
      
      <article class="col sml-12 med-12 lrg-12" role="article">
        <h1><?php $plxShow->lang('COMMUNITY') ?></h1>
        <?php $plxShow->lang('CONTRIBUTE_TOP') ?>
        <br/>
        <div class="col sml-12 med-12 lrg-12 sml-centered sml-text-center">
          <a href="0_sources/0ther/misc/hi-res/2016-05-28_pepper-and-carrot_fixing-the-project_by-David-Revoy.jpg" alt="illustration: picture of Pepper and Carrot fixing a big machine"><img src="0_sources/0ther/misc/low-res/2016-05-28_pepper-and-carrot_fixing-the-project_by-David-Revoy.jpg" ></a>
        </div>
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
      

      <article class="col sml-12 med-12 lrg-12" role="article">
        <br/>
        <h2><?php $plxShow->lang('CONTRIBUTE_SOCIAL') ?></h2>
        <p><?php $plxShow->lang('FOLLOW') ?></p>
        
        <div class="buttonlist col sml-12 med-12 lrg-12 sml-centered sml-text-center">
        <ul class="menu">
          <li>
            <a href="https://www.peppercarrot.com/data/images/static/facebook.jpg">
              <b>Facebook</b>
            </a>
          </li>
          <li>
            <a href="https://framapiaf.org/@davidrevoy">
              <b>Mastodon</b>
            </a>
          </li>
          <li>
            <a href="http://twitter.com/davidrevoy">
              <b>Twitter</b>
            </a>
          </li>
          <li>
            <a href="https://framasphere.org/people/f36d0ea092e50134ec422a0000053625">
              <b>Diaspora</b>
            </a>
          </li>
          <li>
            <a href="https://deevad.deviantart.com/">
              <b>deviantArt</b>
            </a>
          </li>
          <li>
            <a href="https://davidrevoy.tumblr.com/">
              <b>Tumblr</b>
            </a>
          </li>
          <li>
            <a href="https://www.artstation.com/deevad">
              <b>Artstation</b>
            </a>
          </li>
          <li>
            <a href="https://www.pixiv.net/member.php?id=6028237">
              <b>Pixiv</b>
            </a>
          </li>
          <li>
            <a href="https://www.youtube.com/channel/UCnAbNwJjusY7zQ__sQyJlSA">
              <b>Youtube</b>
            </a>
          </li>
        </ul>
        </div>
      </article>
      
      <article class="col sml-12 med-12 lrg-12" role="article">
        <?php $plxShow->lang('CONTRIBUTE_PRESS') ?>
        <div class="buttonlist col sml-12 med-12 lrg-12 sml-centered sml-text-center">
        <ul class="menu">
          <li>
            <a href="https://plus.google.com/communities/108146253353928738338">
              <b>Google+</b> Community
            </a>
          </li>
          <li>
            <a href="https://peertube.touhoppai.moe/videos/search?search=david%20revoy">
              <b>Peertube</b> Videos
            </a>
          </li>
          <li>
            <a href="https://funnyjunk.com/channel/pepperandcarrot">
              <b>Funnyjunk</b> Community
            </a>
          </li>
          <li>
            <a href="https://imgur.com/gallery/8ABWs">
              <b>Imgur</b> Community
            </a>
          </li>
          <li>
            <a href="https://www.reddit.com/r/PepperCarrot/">
              <b>Reddit</b> Community
            </a>
          </li>
          <li>
            <a href="https://storyberries.com/author/david-revoy/">
              <b>Storyberries</b> Online Publishing
            </a>
          </li>
          <li>
            <a href="https://storyberries.com/author/david-revoy/">
              <b>Pipro k. Karoĉjo</b> Forum Esperanto
            </a>
          </li>
        </ul>
        </div>
      </article>
        
       
         
 <article class="col sml-12 med-12 lrg-12" role="article">
  <br/>
      <?php $plxShow->lang('CONTRIBUTE_DERIVATIONS') ?>

      <?php eval($plxShow->callHook("vignetteArtList", array('
      <!-- #art_title -->
      <figure class="thumbnail col sml-6 med-3 lrg-3">
        <a href="#art_url" title="#art_title">
          <img src="plugins/vignette/plxthumbnailer.php?src=#art_vignette&amp;w=230&amp;h=166&amp;s=1&amp;q=92" alt="#art_title" title="#art_title , click to read" >
        </a>
          <figcaption class="text-center"><a href="#art_url" title="#art_title">#art_supertitle #art_date</span></a></figcaption>
      </figure>
      ',12,'004', "...", "rsort"))); ?>
  </article>
          
<?php # =========== Derivations ================ ?>
  <section class="col sml-12 med-12 lrg-12 text-center">
  <br/>
  <div class="moreposts" style="margin-top: 0.3rem;">
    <a  class="button blue" href="<?php $plxShow->urlRewrite('?categorie4/derivations') ?>" title="Go to the blog page">
      <?php $plxShow->catList('','#art_nb',4); ?> derivatives projects on the Blog &nbsp;&nbsp;<img class="svg" src="themes/peppercarrot-theme_v2/ico/go.svg" alt="→"/>
    </a>
  </div>
  </section>
  
  <article class="col sml-12 med-12 lrg-12" role="article">
    <?php $plxShow->lang('CONTRIBUTE_TRANSLATION') ?>
  </article>

<?php # ===========  Fan Art ================ ?>
<article class="col sml-12 med-12 lrg-12" role="article">
  <br/><br/>
  <?php
  $plxShow->lang('CONTRIBUTE_FANART');
  #variables:
  $fanartcounter = 0;
  $pathartworks = '0_sources/0ther/fan-art';
  $hide = array('.', '..');
  $mainfolders = array_diff(scandir($pathartworks), $hide);
  $search = glob($pathartworks."/*.jpg");
  rsort($search);
  # we loop on found episodes
  if (!empty($search)){ 
    foreach ($search as $filepath) {
      if ( $fanartcounter < 24 ){
        # filename extraction
        $fileweight = (filesize($filepath) / 1024) / 1024;
        $fanartcounter = $fanartcounter + 1;
        $filename = basename($filepath);
        $fullpath = dirname($filepath);
        $dateextracted = substr($filename,0,10).'';
        $dateextracted = str_replace('-', '&#47;', $dateextracted);
        $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
        $filenameclean = substr($filenameclean, 11); // rm iso date
        $filenameclean = str_replace('_', ' ', $filenameclean);
        $filenameclean = str_replace('-', ' ', $filenameclean);
        $details = strstr($filenameclean, 'by');
        $title = stristr($filenameclean, 'by', true);
        $filenameclean = str_replace('featured', '', $filenameclean);
        $filenamezip = str_replace('jpg', 'zip', $filename);      
        echo '<figure class="thumbnail col sml-3 med-3 lrg-2">';
        echo '<a href="0_sources/0ther/fan-art/'.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/fan-art/'.$filename.'&amp;w=130&amp;h=130&amp;s=1&amp;q=92" alt="'.$filenameclean.'" title="'.$filenameclean.', '.$dateextracted.'" ></a>';
        echo '<figcaption class="text-center" >
        <a href="0_sources/0ther/original/'.$filename.'" >
        '.$title.'
        <br/><span class="detail">'.$details.' '.$dateextracted.'</span><br/>
        </figcaption>';
        echo '</figure>';
      }
    }
  }
  $fanartcounter = 0;
  $search = glob($pathartworks."/*.jpg");
  if (!empty($search)){ 
    foreach ($search as $filepath) {
      $fanartcounter = $fanartcounter + 1;
    }
  }
?>
  <section class="col sml-12 med-12 lrg-12 text-center">
  <br/>
  <div class="moreposts" style="margin-top: 0.3rem;">
    <a  class="button blue" href="<?php $plxShow->urlRewrite('?static10/fanart-gallery') ?>" title="Go to the blog page">
      Browse the <?php echo ''.$fanartcounter.''; ?> Fan-arts &nbsp;&nbsp;<img class="svg" src="themes/peppercarrot-theme_v2/ico/go.svg" alt="→"/>
    </a>
  </div>
  </section>
  
      <article class="col sml-12 med-12 lrg-12" role="article">
        <?php $plxShow->lang('CONTRIBUTE_DONATION') ?> 
      </article>
      <section class="col sml-12 med-12 lrg-12">
        <?php $plxShow->lang('HOMEPAGE_ALTERNATIVES') ?>
              <a href="https://paypal.me/davidrevoy" title="Send money via Paypal" class="alternativesbutton paypal">Paypal</a>
              <a href="https://www.tipeee.com/pepper-carrot" title="<?php $plxShow->lang('HOMEPAGE_PATREON_BOX') ?> Tipeee" class="alternativesbutton tipeee">Tipeee</a>
              <a href="https://liberapay.com/davidrevoy/" title="<?php $plxShow->lang('HOMEPAGE_PATREON_BOX') ?> Liberapay" class="alternativesbutton liberapay">Liberapay</a>
              <a href="https://g1.duniter.fr/#/app/wot/4nosBEwT8xQfMY11sq32AnZF1XcoqzG9tArXJq9mu8Wc/DavidRevoy" title="Send G1 to David Revoy" class="alternativesbutton G1">G1</a>
              <a href="<?php $plxShow->urlRewrite('?static12/iban-and-mail-adress') ?>" title="Send money via IBAN or Send goods via mail" class="alternativesbutton iban">Bank/Mail</a>
          <br/><br/>
      </section> 
  
      <article class="col sml-12 med-12 lrg-12" role="article">
        <?php $plxShow->lang('CONTRIBUTE_OTHER') ?>
      </article>
 

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
