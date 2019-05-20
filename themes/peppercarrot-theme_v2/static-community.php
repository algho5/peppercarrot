<?php 
include(dirname(__FILE__).'/header.php'); 

# Start content
echo '<div class="container">';
echo '  <main class="grid" role="main">';
echo '    <section class="col sml-12" style="padding: 0 0;">';

# Display a frame with language limitations (for other lang than english).
if ($lang !== "en" ){
  echo '<div class="grid"><br/>';
  echo '  <div class="col sml-12 sml-centered lrg-centered med-centered sml-text-center alert blue">';
  echo '  <img src="themes/peppercarrot-theme_v2/ico/nfo.svg" alt="info:"/>';
  echo $plxShow->Getlang(LIMITATIONS);
  echo '  </div>';
  echo '</div>';
} else {
  echo '<div class="grid"><br/>';
  echo '  <div class="col sml-12 sml-centered lrg-centered med-centered sml-text-center">';
  echo '  &nbsp;';
  echo '  </div>';
  echo '</div>';
}

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
    echo '<span class="communityby">'.$get->{'by'}.'</span>';
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
