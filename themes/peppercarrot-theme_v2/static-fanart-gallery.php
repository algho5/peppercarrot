<?php include(dirname(__FILE__).'/header.php'); ?>
<div class="container">
	<main class="grid" role="main">
        
    <section class="col sml-12 med-12" style="padding: 0 0;">
      
<?php 
  $plxShow->lang('CONTRIBUTE_FANART');
  $lang = $plxShow->getLang('LANGUAGE_ISO_CODE_2_LETTER');
  $pathartworks = '0_sources/0ther/fan-art';
  $search = glob($pathartworks."/*.jpg");
   if (!empty($search)){ 
    foreach ($search as $filepath) {
    $fanartcounter = $fanartcounter + 1;
    }
   }
  echo ''.$fanartcounter.' % <meter value="'.$fanartcounter.'" min="0" max="100"></meter> of my dream to receive 100 fan-arts !<br><br><br>';
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
      echo '<figure class="thumbnail col sml-6 med-3 lrg-3">';
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
    </section>

	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
