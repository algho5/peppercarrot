<?php
include(dirname(__FILE__).'/lib-parsedown.php');
include(dirname(__FILE__).'/header.php');

echo '<div class="container">';
echo '<main class="main grid" role="main">';

echo '<section class="page col sml-12 med-12 lrg-11 sml-centered">';
echo '<br/>';

$contents = file_get_contents('TERMS-OF-SERVICE-AND-PRIVACY.md');
$Parsedown = new Parsedown();
echo $Parsedown->text($contents);

echo '<br/>';
echo '<br/>';
echo '</section>';

// footer
echo '  </main>';
echo '</div>';
include(dirname(__FILE__).'/footer.php');
?> 
