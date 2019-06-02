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

<p>
  I always welcome new contributors! You can help me to make Pepper&amp;Carrot a better 
  webcomic. If you have any question, <a href="http://webchat.freenode.net/?channels=%23pepper%26carrot">
  ask on the Pepper&amp;Carrot channel</a>.
</p>

<div class="button moka">
  <a href="http://webchat.freenode.net?channels=%23pepper%26carrot" title="#pepper&amp;Carrot , freenode.net">
    IRC
  </a>
  <a href="https://telegram.me/joinchat/BLVsYz_DIz-S-TJZB9XW7A" title="Bridged Irc channel for Telegram client">
    Telegram
  </a>
  <a href="https://riot.im/app/#/room/#freenode_#pepper&carrot:matrix.org" title="Bridged Irc channel for Riot, a Matrix client">
    Matrix
  </a>
  <a href="https://framateam.org/signup_user_complete/?id=gcaq67sntfgr5jbmoaogsgdfqc" title="Bridged Irc channel for Framateam, Mattermost client hosted by Framasoft">
    Framateam
  </a>
</div>

<br/>
<?php 

echo '  </div>';

$folder = "pages/contribute";
$color = "";
include(dirname(__FILE__).'/lib-cards.php'); 

echo '      </div>';
echo '    </section>';
echo '  </main>';
echo '</div>';
include(dirname(__FILE__).'/footer.php'); 
?>
