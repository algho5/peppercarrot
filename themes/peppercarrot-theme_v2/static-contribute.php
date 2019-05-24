<?php 
include(dirname(__FILE__).'/header.php'); 

# Setup
$folder = "pages/contribute";

# Start content
echo '<div class="container">';
echo '  <main class="main grid" role="main">';
echo '    <section class="col sml-12" style="padding: 0 0;">';

# Intro
echo '<div class="grid"><br/>';
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

<div class="pills">
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
  
<?php 

echo '  </div>';
echo '</div>';

# Start scanning community/*.json to feed our frames
$search = glob("".$folder."/*.json");
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
    $cleanlink = $get->{'linkurl'};
    if ( substr( $cleanlink, 0, 1 ) === "?" ){
    echo '<div class="communitybutton"><a href="';
    $plxShow->urlRewrite($cleanlink);
    echo '">'.$get->{'link'}.'</a></div>';
    } else {
    echo '<div class="communitybutton"><a href="'.$get->{'linkurl'}.'">'.$get->{'link'}.'</a></div>';
    }
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
