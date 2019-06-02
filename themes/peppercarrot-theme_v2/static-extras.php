<?php 
include(dirname(__FILE__).'/header.php'); 
echo '<div class="container">';
echo '  <main class="main grid" role="main">';
echo '    <section class="col sml-12">';
echo '      <div class="grid">';

echo '  <div class="col sml-12 med-8 lrg-6 sml-centered sml-text-center">';
if ($lang !== "en" ){
  echo '<div class="notice"><img src="themes/peppercarrot-theme_v2/ico/nfog.svg" alt="info:"/> ';
  echo $plxShow->Getlang(LIMITATIONS);
  echo '</div>';
}
?>

<br/>
<?php 

echo '  </div>';

$folder = "pages/extras";
$color = "gum";
include(dirname(__FILE__).'/lib-cards.php');

echo '      </div>';
echo '    </section>';
echo '  </main>';
echo '</div>';
include(dirname(__FILE__).'/footer.php'); 
?>
