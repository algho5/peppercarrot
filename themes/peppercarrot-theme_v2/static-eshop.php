<?php 
include(dirname(__FILE__).'/header.php'); 
echo '<div class="container">';
echo '  <main class="main grid" role="main">';
echo '    <section class="col sml-12">';
echo '      <div class="grid">';

include(dirname(__FILE__).'/lib-transla-static.php');

echo '  <div class="col sml-12 med-10 lrg-10 sml-centered sml-text-center">';

echo '<h2>';
$plxShow->lang('SHOP');
echo '</h2>';

// Comic Print on demand service: commented for now.
//echo '      <a href="https://www.drivethrucomics.com/browse/pub/15557/David-Revoy">';
//echo '        <div class="eshopbox">';
//echo '          <div class="eshopdrive">';
                  //$plxShow->lang('ESHOP_COMIC');
//echo '            <br/>';
//echo '            <img src="pages/eshop/drivethrucomics_logo.png" alt="Drivethrucomics">';
//echo '         </div>';
//echo '        </div>';
//echo '      </a>';

//echo '      </br>';

            // Propose direct links translated for FR/ES/DE or fallback to English.
            if($lang=="fr" OR $lang=="es" OR $lang=="de"){
              echo '      <a href="https://www.redbubble.com/'.$lang.'/people/davidrevoy/portfolio?asc=u">';
            } else {
              echo '      <a href="https://www.redbubble.com/people/davidrevoy/portfolio?asc=u">';
            }

echo '        <div class="eshopbox">';
echo '          <div class="eshopred">';
                  $plxShow->lang('ESHOP_SHOP');
echo '            <br/>';
echo '            <img src="pages/eshop/redbubble_logo.png" alt="Redbubble">';
echo '         </div>';
echo '        </div>';
echo '      </a>';

echo '      </br>';
echo '      </br>';
echo '<a href="';
$plxShow->urlRewrite('?static6/sources&page=eshop'); 
echo '">';
$plxShow->lang('SOURCES');
echo ' (';
$plxShow->lang('SHOP');
echo ') </a>';
echo '      </br>';
echo '      </br>';
echo '      </br>';
echo '      </br>';
echo '      </br>';
echo '      </br>';
echo '      </br>';
echo '      </br>';
echo '      </br>';

echo '      </div>';
echo '      </div>';
echo '    </section>';
echo '  </main>';
echo '</div>';
include(dirname(__FILE__).'/footer.php'); 
?>
