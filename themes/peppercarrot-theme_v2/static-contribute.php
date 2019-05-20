<?php 
include(dirname(__FILE__).'/header.php'); 

# Start content
echo '<div class="container">';
echo '  <main class="grid" role="main">';
echo '    <section class="col sml-12" style="padding: 0 0;">';

# Intro
echo '<div class="grid"><br/>';
echo '  <div class="col sml-6 sml-centered sml-text-center">';
echo $plxShow->Getlang(CONTRIBUTE_TOP);
if ($lang !== "en" ){
  echo '<div class="notice"><img src="themes/peppercarrot-theme_v2/ico/nfog.svg" alt="info:"/> ';
  echo $plxShow->Getlang(LIMITATIONS);
  echo '</div>';
}
echo '  </div>';
echo '</div>';

# Start scanning community/*.json to feed our frames
$search = glob("community/*.json");
if (!empty($search)){ 
  foreach ($search as $jsonpath) {
    $contents = file_get_contents($jsonpath);
    $contents = utf8_encode($contents);
    $get = json_decode($contents); 
    echo '<div class="communitysocket col sml-6 med-4 lrg-3">';
    echo '<figure class="communityblock">';
    echo '<div class="communityblockcontent">';
    echo '<h3>'.$get->{'title'}.'</h3>';
    if ($get->{'by'} !== "" ){
      echo '<span class="communityby">'.$get->{'by'}.'</span>';
    } else {
      echo '<span class="communityby"><br/></span>';
    }
    
    echo '<a href="'.$get->{'linkurl'}.'"><img src="plugins/vignette/plxthumbnailer.php?src='.$get->{'img'}.'&amp;w=275&amp;h=275&amp;s=1&amp;q=92" alt="'.$get->{'imgalt'}.'"></a><br/>';
    echo '<figcaption>'.$get->{'desc'}.'</figcaption>';
    echo '</div>';
    if ($get->{'src'} !== "" ){
      echo '<div class="communitylink"><a href="'.$get->{'srcurl'}.'">'.$get->{'src'}.'</a></div>';
    } else {
      echo '<div class="communitylink"><br/></div>';
    }
    echo '<div class="communitybutton"><a href="'.$get->{'linkurl'}.'">'.$get->{'link'}.'</a></div>';
    echo '</figure>';
    echo '</div>';
  }
}

# Close content
echo '    </section>';
echo '  </main>';
echo '</div>';

include(dirname(__FILE__).'/footer.php'); 
?>
