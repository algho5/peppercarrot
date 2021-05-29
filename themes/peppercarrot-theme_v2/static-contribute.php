<?php 
include(dirname(__FILE__).'/header.php'); 
echo '<div class="container">';
echo '  <main class="main grid" role="main">';
echo '    <section class="col sml-12">';
echo '      <div class="grid">';

echo '  <div class="col sml-12 med-10 lrg-8 sml-centered sml-text-center">';
if ($lang !== "en" ){
  echo '<div class="notice"><img src="themes/peppercarrot-theme_v2/ico/nfog.svg" alt="info:"/> ';
  echo $plxShow->Getlang(LIMITATIONS);
  echo '</div>';
}
?>

<article class="page col sml-12 sml-centered" role="article" >
  <b>I always welcome new contributors!</b><br/> You can help me to make Pepper&amp;Carrot a better 
  webcomic.
  <h3>Chat room</h3>
  If you have any question, proposition, or want to discuss about the comic: <b>feel free to join our chat room!</b> If you begin, just click on the button under to read our discussions and then create an account to interact with us. You might also want to read and accept <a href="https://www.peppercarrot.com/en/static14/documentation&page=409_Code_of_Conduct">our CoC</a> before interacting.
  <br/><br/>
 
	<center>
	<div class="button mandarine">
	  <a href="https://app.element.io/#/room/#peppercarrot:matrix.org" title="Pepper&amp;Carrot official room on #peppercarrot:matrix.org">
		 Pepper&amp;Carrot chat room on Element
	  </a>
	</div>
	
	<br/><br/>This room uses the <a href="https://matrix.org/">[matrix]</a> network and is bridged to two services: an IRC channel (#pepper&amp;carrot on <a href="https://libera.chat/">libera.chat</a>) and a community <a href="https://telegram.me/joinchat/BLVsYz_DIz-S-TJZB9XW7A" title="A community Telegram bridge"> Telegram bridge</a>. It's content is public.
</article>

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
