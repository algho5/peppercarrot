<?php
/**
 * A URL tester for Pepper&Carrot
 *
 * Temporary
 **/

# Configuration
$root = "https://www.peppercarrot.com/";

# Display
echo '<b>Articles</b>';
echo '<ul>';
echo '<li><a href="'.$root.'article7/green-owl">7. &nbsp;Green Owl.</a></li>';
echo '<li><a href="'.$root.'article42/blue-rabbit">42. Blue Rabbit.</a></li>';
echo '<li><a href="'.$root.'article575/yellow-tigger">575. Yellow Tigger.</a></li>';
echo '<li><a href="'.$root.'article433/episode-24-the-unity-tree">433. Comic: Unity Tree.</a></li>';
echo '</ul>';
echo '<b>Static</b>';
echo '<ul>';
echo '<li><a href="'.$root.'static1/wiki">1. &nbsp;Wiki.</a></li>';
echo '<li><a href="'.$root.'article12/webcomics">12. webcomics.</a></li>';
echo '</ul>';
?>
