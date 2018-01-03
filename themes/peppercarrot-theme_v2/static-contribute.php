<?php include(dirname(__FILE__).'/header.php'); ?>
<div class="container">
<main class="page grid" role="main">

		<section class="col sml-12 med-12 lrg-10 sml-centered med-centered lrg-centered">

      <div class="grid">

      <div class="translabar col sml-12 med-12 lrg-12 sml-centered sml-text-center">
        <ul class="menu" role="toolbar">
          <?php eval($plxShow->callHook('MyMultiLingueStaticLang')) ?>
          <li><a class="lang" href="index.php?fr/article267/translation-tutorial"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> <?php $plxShow->lang('ADD_TRANSLATION') ?></a></li>
        </ul>
      </div>   

      <article class="col sml-12 med-12 lrg-12" role="article">
        <h2><?php $plxShow->lang('CONTRIBUTE_SOCIAL') ?></h2>
        <p><?php $plxShow->lang('FOLLOW') ?></p>
      </article>
        
        <!-- Facebook -->
        <figure class="thumbnail col sml-6 med-3 lrg-3">
          <a href="https://www.facebook.com/pages/Pepper-Carrot/307677876068903">
            <img src="data/images/static/facebook.jpg" alt="Facebook" >
          </a>
          <figcaption class="text-center">
            <a href="https://www.facebook.com/pages/Pepper-Carrot/307677876068903" title="<?php $plxShow->lang('FOLLOW') ?> Facebook">
            Facebook<br/>
            </a>
            <span class="detail">4.5K</span>
          </figcaption>
        </figure>
        
        <!-- Google+ -->
        <figure class="thumbnail col sml-6 med-3 lrg-3">
          <a href="https://plus.google.com/u/0/110962949352937565678/">
            <img src="data/images/static/googleplus.jpg" alt="Google+" >
          </a>
          <figcaption class="text-center">
            <a href="https://plus.google.com/u/0/110962949352937565678/" title="<?php $plxShow->lang('FOLLOW') ?> Google+">
            Google+<br/>
            </a>
            <span class="detail">8.5K</span>
          </figcaption>
        </figure>
        
        <!-- Twitter -->
        <figure class="thumbnail col sml-6 med-3 lrg-3">
          <a href="http://twitter.com/davidrevoy">
            <img src="data/images/static/twitter.jpg" alt="Twitter" >
          </a>
          <figcaption class="text-center">
            <a href="http://twitter.com/davidrevoy" title="<?php $plxShow->lang('FOLLOW') ?> Twitter">
            Twitter<br/>
            </a>
            <span class="detail">6K</span>
          </figcaption>
        </figure>
        
        <!-- IRC -->
        <figure class="thumbnail col sml-6 med-3 lrg-3">
          <a href="http://webchat.freenode.net/?channels=%23pepper%26carrot">
            <img src="data/images/static/irc.jpg" alt="IRC" >
          </a>
          <figcaption class="text-center">
              <a href="http://webchat.freenode.net/?channels=%23pepper%26carrot" title="Main Irc channel: #pepper&amp;carrot on Freenode">
                Irc
              </a>
            <span class="detail">|</span>
              <a href="https://riot.im/app/#/room/#freenode_#pepper&carrot:matrix.org" title="Bridged Irc channel for Riot, a Matrix client">
                Riot
              </a>
            <span class="detail">|</span>
              <a href="https://framateam.org/signup_user_complete/?id=gcaq67sntfgr5jbmoaogsgdfqc" title="Bridged Irc channel for Framateam, Mattermost client hosted by Framasoft">
                Framateam
              </a>
            <span class="detail">|</span>
              <a href="https://telegram.me/joinchat/BLVsYz_DIz-S-TJZB9XW7A" title="Bridged Irc channel for Telegram client">
                Telegram
              </a>
            <br/>
            <span class="detail">Online chat</span>
          </figcaption>
        </figure>
        
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
          
          
  <section class="col sml-12 med-12 lrg-12 text-center">
  <br/>
  <div class="moreposts" style="margin-top: 0.3rem;">
    <a  class="button blue" href="<?php $plxShow->urlRewrite('?categorie4/derivations') ?>" title="Go to the blog page">
      <?php $plxShow->catList('','#art_nb',4); ?> derivatives projects on the Blog &nbsp;&nbsp;<img class="svg" src="themes/peppercarrot-theme_v2/ico/go.svg" alt="→"/>
    </a>
  </div>
  </section>
          

         
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
      if ( $fanartcounter < 12 ){
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
        echo '<figure class="thumbnail col sml-3 med-3 lrg-3">';
        echo '<a href="0_sources/0ther/fan-art/'.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/fan-art/'.$filename.'&amp;w=230&amp;h=180&amp;s=1&amp;q=92" alt="'.$filenameclean.'" title="'.$filenameclean.', '.$dateextracted.'" ></a>';
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
        <h1><?php $plxShow->lang('CONTRIBUTE') ?></h1>
        <?php $plxShow->lang('CONTRIBUTE_TOP') ?>
      </article>
      
      <article class="col sml-12 med-12 lrg-12" role="article">
        <?php $plxShow->lang('CONTRIBUTE_TRANSLATION') ?>
      </article>
      
      <article class="col sml-12 med-12 lrg-12" role="article">
        <?php $plxShow->lang('CONTRIBUTE_PRESS') ?>
      </article>
      
      <article class="col sml-12 med-12 lrg-12" role="article">
        <?php $plxShow->lang('CONTRIBUTE_DONATION') ?> 
      </article>
      <section class="col sml-12 med-12 lrg-12">
        <?php $plxShow->lang('HOMEPAGE_ALTERNATIVES') ?>
          <a href="https://liberapay.com/davidrevoy/" class="link">Liberapay</a>,
          <a href="https://www.tipeee.com/pepper-carrot" class="link">Tipeee</a>,
          <!-- <a href="<?php $plxShow->template(); ?>/bitcoin.txt" class="link">Bitcoin</a>,
          <a href="https://flattr.com/submit/auto?user_id=davidrevoy&url=http%3A%2F%2Fwww.peppercarrot.com%2F">Flattr</a>, -->
          <a href="https://paypal.me/davidrevoy" class="link">Paypal</a><?php $plxShow->lang('UTIL_DOT') ?>
          <br/><br/>
      </section> 
      
      <article class="col sml-12 med-12 lrg-12" role="article">
        <?php $plxShow->lang('CONTRIBUTE_IRC') ?>
        <a href="http://webchat.freenode.net?channels=%23pepper%26carrot" title="Chat with me and the team!"> #pepper&amp;carrot , Freenode.net &nbsp;</a>     
      </article>
  
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
