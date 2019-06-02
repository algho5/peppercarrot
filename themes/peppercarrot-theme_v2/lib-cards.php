<?php
// depends of:
// $color: the color of the buttons (css class)
// $folder: the folder with the collection of json to display
// Start scanning community/*.json to feed our frames
$search = glob("".$folder."/*.json");
if (!empty($search)){ 
  foreach ($search as $jsonpath) {
    $contents = file_get_contents($jsonpath);
    $get = json_decode($contents); 
    echo '<div class="cardsocket col sml-6 med-4 lrg-3">';
    echo '<div class="cardblock">';
    echo '<div class="cardblockcontent">';
    echo '<h3>'.$get->{'title'}.'</h3>';
    if ($get->{'by'} !== "" ){
      echo '<span class="cardby">'.$get->{'by'}.'</span>';
    } else {
      echo '<span class="cardby"><br/></span>';
    }
    
    echo '<figure class="thumbnail">';
    if ($get->{'linkurl'} !== "" ){
      $cleanlink = $get->{'linkurl'};
      if ( substr( $cleanlink, 0, 1 ) === "?" ){
        echo '<a href="';
        $plxShow->urlRewrite($cleanlink);
        echo '">';
      } else {
        echo '<a href="'.$get->{'linkurl'}.'">';
      }
    }
    echo '<img src="plugins/vignette/plxthumbnailer.php?src='.$get->{'img'}.'&amp;w=275&amp;h=275&amp;s=1&amp;q=92" alt="'.$get->{'imgalt'}.'"></a><br/>';
    echo '</figure>';
    echo '<p>'.$get->{'desc'}.'</p>';
    echo '</div>';
    if ($get->{'src'} !== "" ){
      echo '<div class="cardlink"><a href="'.$get->{'srcurl'}.'">'.$get->{'src'}.'</a></div>';
    } else {
      echo '<div class="cardlink"><br/></div>';
    }
    if ($get->{'linkurl'} !== "" ){
      $cleanlink = $get->{'linkurl'};
      if ( substr( $cleanlink, 0, 1 ) === "?" ){
        echo '<div class="button big '.$color.'"><a href="';
        $plxShow->urlRewrite($cleanlink);
        echo '">'.$get->{'link'}.'</a></div>';
      } else {
        echo '<div class="button big '.$color.'"><a href="'.$get->{'linkurl'}.'">'.$get->{'link'}.'</a></div>';
      }
    }
    echo '</div>';
    echo '</div>';
  }
}
?>
