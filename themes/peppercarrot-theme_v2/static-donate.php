<?php 
include(dirname(__FILE__).'/header.php'); 
echo '<div class="container">';
echo '  <main class="main grid" role="main">';
echo '    <section class="col sml-12">';
echo '      <div class="grid">';

include(dirname(__FILE__).'/translate-button-static.php');

echo '  <div class="col sml-12 med-8 lrg-6 sml-centered sml-text-center">';
$plxShow->lang('DONATE_INTRO');
if ($lang !== "en" ){
  echo '<div class="notice"><img src="themes/peppercarrot-theme_v2/ico/nfog.svg" alt="info:"/> ';
  echo $plxShow->Getlang(LIMITATIONS);
  echo '</div>';
} else {
  echo '<br/>';
}
echo '  </div>';

$folder = "pages/donate";
$color = "mandarine";
include(dirname(__FILE__).'/lib-cards.php'); 

echo '      </div>';
echo '    </section>';
echo '  </main>';
echo '</div>';
include(dirname(__FILE__).'/footer.php'); 
?>
