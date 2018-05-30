<?php
include(dirname(__FILE__).'/lib-parsedown.php');
include(dirname(__FILE__).'/header.php');

echo '<div class="container">';
echo '  <main class="grid" role="main">';

echo '<section class="tosprivacy col sml-12 sml-centered">';
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
