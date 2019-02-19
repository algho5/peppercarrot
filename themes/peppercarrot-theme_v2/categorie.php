<?php include(dirname(__FILE__).'/header.php'); 
$lang = $plxShow->defaultLang($echo);
?>
<div class="container">
	<main class="grid" role="main">
    <div class="limit col sml-12 med-12 lrg-12 sml-centered lrg-centered med-centered sml-text-center">
        <?php 
        if ($lang !== 'en') {
          echo '&nbsp;<img class="svg" src="themes/peppercarrot-theme_v2/ico/nfog.svg" alt=" "/>';
          $plxShow->lang('LIMITATIONS');
        } else {
          echo '&nbsp;';
        }
        ?><br/>
    </div>
        
    <section class="col sml-12 med-6" style="padding: 0 0;">
      
      

      
      
        <h2 style="padding-top:0; margin-top: 0;">
          <?php $plxShow->catName() ?>
        </h2>
        
      <?php while($plxShow->plxMotor->plxRecord_arts->loop()): ?>
        
        <article class="thumbnail col sml-6 med-6 lrg-6" style="padding: 0 1rem 0 0;" role="article" id="post-<?php echo $plxShow->artId(); ?>">
          <a href="<?php $plxShow->artUrl() ?>">
            <?php 
            echo '<img src="plugins/vignette/plxthumbnailer.php?src='; 
            eval($plxShow->callHook('showVignette', 'true')); 
            echo '&w=370&h=255&a=t&s=1&q=92" alt="'; $plxShow->artTitle(); 
            echo '" title="'; $plxShow->artTitle(); 
            echo ', click to enlarge" >'; 
            ?>
          </a>
          
          <figcaption class="text-center">
            <a href="<?php $plxShow->artUrl(); ?>" title="<?php $plxShow->artTitle(''); ?>">
              <?php 
              $cooltitle = $plxShow->plxMotor->plxRecord_arts->f('title');
              $cooltitle = str_replace('by', '<br/></strong>by ', $cooltitle);
              if (strlen(strstr($cooltitle,'by'))>0) {
                echo '<strong>'.$cooltitle.'<span class="detail"> - <span>';
              } else {
                echo '<strong>'.$cooltitle.'</strong><br/>';
              }
              ?>
            </a>
                    
            <span class="detail">	
              <time datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>">
              <?php $plxShow->artDate('#num_day/#num_month/#num_year(2)'); ?>
              </time> - 
              <?php $plxShow->artNbCom('#nb <img class="svg" src="themes/peppercarrot-theme_v2/ico/com.svg" alt="com"/>','#nb <img class="svg" src="themes/peppercarrot-theme_v2/ico/com.svg" alt="com"/>','#nb <img class="svg" src="themes/peppercarrot-theme_v2/ico/com.svg" alt="com"/>'); ?>
              <br/>
              <?php $plxShow->artCat() ?>
            </span>
          </figcaption>
          
          <br/>
          
        </article>

      <?php endwhile; ?>
      
    <div style="clear:both;"></div>
            
    <br/><br/>
    
    <nav class="pagination text-center">
      <?php $plxShow->pagination(); ?>
    </nav>
      
    <br/><br/><br/><br/><br/>
    
    <span><center>
      <?php $plxShow->artFeed('rss',$plxShow->catId()); ?>
    </center><br/></span>

		</section>
    
    
    
  <aside class="aside col sml-12 med-6" role="complementary" style="border-left: 2px solid #ccc">
    
  
      <h2 style="padding-top:0; margin-top: 0;">
          Fan-art
      </h2>
<?php 

  $lang = $plxShow->getLang('LANGUAGE_ISO_CODE_2_LETTER');
  $pathartworks = '0_sources/0ther/fan-art';
  $search = glob($pathartworks."/*.jpg");
   if (!empty($search)){ 
    foreach ($search as $filepath) {
    $fanartcounter = $fanartcounter + 1;
    }
   }
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
      # filename extraction
      $fileweight = (filesize($filepath) / 1024) / 1024;
      $filename = basename($filepath);
      $fullpath = dirname($filepath);
      $dateextracted = substr($filename,0,10).'';
      $filenameclean = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
      $filenameclean = substr($filenameclean, 11); // rm iso date
      $filenameclean = str_replace('_', ' ', $filenameclean);
      $filenameclean = str_replace('-', ' ', $filenameclean);
      $filenameclean = str_replace('featured', '', $filenameclean);
      $filenameclean = str_replace('by', '</a><br/><span class="detail">by', $filenameclean);
      $filenamezip = str_replace('jpg', 'zip', $filename);
      echo '<figure class="thumbnail col sml-6">';
      echo '<a href="0_sources/0ther/fan-art/'.$filename.'" ><img src="plugins/vignette/plxthumbnailer.php?src='.$filepath.'&amp;w=370&amp;h=370&amp;s=1&amp;q=92" alt="'.$filename.'" title="'.$filename.'" ></a><br/>';
      echo '<figcaption class="text-center" >
      <a href="0_sources/0ther/fan-art/'.$filename.'" >
      '.$filenameclean.'
      '.$dateextracted.'</span><br/>
      </figcaption>
      <br/><br/>';
      echo '</figure>';
    }
  }
?>

	</aside>

	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
