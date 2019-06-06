<?php include(dirname(__FILE__) . '/header.php');

  # Redirect the Comments
  switch ($plxShow->artId()) {
  /*01*/ case 234: $path_on_dr_com = "article434/potion-of-flight#comments"; break;
  /*02*/ case 237: $path_on_dr_com = "article437/episode-2-rainbow-potions#comments"; break;
  /*03*/ case 241: $path_on_dr_com = "article441/episode-3-the-secret-ingredients#comments"; break;
  /*04*/ case 243: $path_on_dr_com = "article443/episode-4-moment-of-genius#comments"; break;
  /*05*/ case 244: $path_on_dr_com = "article444/special-holiday-episode#comments"; break;
  /*06*/ case 271: $path_on_dr_com = "article471/episode-6-the-potion-contest#comments"; break;
  /*07*/ case 273: $path_on_dr_com = "article473/episode-7-the-wish#comments"; break;
  /*08*/ case 285: $path_on_dr_com = "article485/episode-8-pepper-s-birthday-party#comments"; break;
  /*09*/ case 289: $path_on_dr_com = "article489/episode-9-the-remedy#comments"; break;
  /*10*/ case 298: $path_on_dr_com = "article498/episode-10-summer-special#comments"; break;
  /*11*/ case 301: $path_on_dr_com = "article501/the-witches-of-chaosah#comments"; break;
  /*12*/ case 331: $path_on_dr_com = "article531/episode-12-autumn-clearout#comments"; break;
  /*13*/ case 338: $path_on_dr_com = "article538/episode-13-the-pyjama-party#comments"; break;
  /*14*/ case 350: $path_on_dr_com = "article550/episode-14-the-dragon-s-tooth#comments"; break;
  /*15*/ case 364: $path_on_dr_com = "article564/episode-15-the-crystal-ball#comments"; break;
  /*16*/ case 369: $path_on_dr_com = "article569/episode-16-the-sage-of-the-mountain#comments"; break;
  /*17*/ case 377: $path_on_dr_com = "article577/episode-17-a-fresh-start#comments"; break;
  /*18*/ case 379: $path_on_dr_com = "article579/episode-18-the-encounter#comments"; break;
  /*19*/ case 383: $path_on_dr_com = "article583/episode-19-pollution#comments"; break;
  /*20*/ case 393: $path_on_dr_com = "article593/episode-20-the-picnic#comments"; break;
  /*21*/ case 400: $path_on_dr_com = "article600/episode-21-the-magic-contest#comments"; break;
  /*22*/ case 412: $path_on_dr_com = "article612/episode-22-the-voting-system#comments"; break;
  /*23*/ case 421: $path_on_dr_com = "article621/episode-23-take-a-chance#comments"; break;
  /*24*/ case 433: $path_on_dr_com = "article633/episode-24-the-unity-tree#comments"; break;
  /*25*/ case 440: $path_on_dr_com = "article640/episode-25-there-are-no-shortcuts#comments"; break;
  /*26*/ case 445: $path_on_dr_com = "article645/episode-26-books-are-great#comments"; break;
  /*27*/ case 451: $path_on_dr_com = "article651/episode-27-coriander-s-invention#comments"; break;
  /*28*/ case 460: $path_on_dr_com = "article660/episode-28-the-festivities#comments"; break;
  /*29*/ case 462: $path_on_dr_com = "article717/episode-29-the-underworld-dragon#comments"; break;
  default: $path_on_dr_com = "categorie2/webcomics";
  }

  # Have we got a new variable 'option' in URL ? grab and security fix it.
  $UrlAdressOption = htmlspecialchars($_GET["option"]);
  $UrlAdressOption = preg_replace('/[^A-Za-z0-9\._-]/', '', $UrlAdressOption);  

  if ($UrlAdressOption == "hd") {
    $hdstatus = '';
    $LinkVariable = '&option=low';
    
    } elseif ($UrlAdressOption == "low") {
    $hdstatus = 'moka';
    $LinkVariable = '&option=hd';
    $_SESSION['SessionMemory'] = "RemoveHD";
    
    } else {
    $hdstatus = 'moka';
    $LinkVariable = '&option=hd';
  }
  
  # Have we got a preference in memory from previous page?
  if ($_SESSION['SessionMemory'] == "KeepHD") {
    $hdstatus = '';
    $LinkVariable = '&option=low';
    
    } elseif ( $_SESSION['SessionMemory'] == "RemoveHD") {
    $memoryoption = 'low';
  }
?>

<div class="containercomic">
  <main class="main grid" role="main">
    <section>
    
      <article class="article" role="article" id="post-<?php echo $plxShow->artId(); ?>">
      
        <div class="col sml-12 sml-text-right">
          <nav class="nav" role="navigation">
            <div class="responsive-langmenu">
              <label for="langmenu"><span class="translabutton"><img src="themes/peppercarrot-theme_v2/ico/language.svg" alt=""/> <?php echo $langlabel;?><img src="themes/peppercarrot-theme_v2/ico/dropdown.svg" alt=""/></span></label>
              <input type="checkbox" id="langmenu">
              <ul class="langmenu expanded">
              <?php eval($plxShow->callHook('MyMultiLingueComicLang')) ?>
              <li class="button"><a class="lang option" href="<?php $plxShow->urlRewrite('?static14/documentation&page=010_Translate_the_comic') ?>"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> <?php $plxShow->lang('ADD_TRANSLATION') ?></a></li>
              </ul>
            </div>
            <div class="button big <?php echo ''.$hdstatus.''; ?>">
              <a href="<?php $plxShow->artUrl() ?><?php echo ''.$LinkVariable.''; ?>" class="lang option">HD 2400px</a>
            </div>
          </nav>
        </div>
        
        <div style="clear:both;">
        </div>

        <?php eval($plxShow->callHook('MyMultiLingueComicHeader')) ?>
        
        <?php 
        $buttonthemeA = '';
        $buttonthemeB = '';
        include(dirname(__FILE__).'/navigation.php'); 
        ?>

        <section class="text-center">
          <?php eval($plxShow->callHook("MyMultiLingueComicDisplay", array(''.$UrlAdressOption.''))) ?>  
        </section>
        
      </article>
      
      <div class="content">
        <div style="clear:both;">
        </div>
        
        <div class="grid">
        
          <section class="col sml-12 med-12 lrg-11 text-center sml-centered">
            
            <div class="cardsocket mini col sml-4 med-4 lrg-4">
              <div class="cardblock mini">
                <figure class="thumbnail">
                  <a href="<?php eval($plxShow->callHook('MyMultiLingueSourceLinkDisplay')) ?>">
                    <img src="<?php $plxShow->racine() ?>/plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/misc/low-res/2019-06_sources-webcomic_by-David-Revoy.jpg&amp;w=275&amp;h=275&amp;s=1&amp;q=92" alt="Pepper doing shopping,">
                  </a>
                </figure>
                <div class="button milk">
                  <a href="<?php eval($plxShow->callHook('MyMultiLingueSourceLinkDisplay')) ?>">
                    Source *.kra files and *.svg for this episode
                  </a>
                </div>
              </div>
            </div>
            
          
            <div class="cardsocket mini col sml-4 med-4 lrg-4">
              <div class="cardblock mini">
                <figure class="thumbnail">
                  <a href="https://www.davidrevoy.com/<?php echo $path_on_dr_com; ?>">
                    <img src="<?php $plxShow->racine() ?>/plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/misc/low-res/2019-06_comment-webcomic_by-David-Revoy.jpg&amp;w=275&amp;h=275&amp;s=1&amp;q=92" alt="Pepper doing shopping,">
                  </a>
                </figure>
                <div class="button milk">
                  <a href="https://www.davidrevoy.com/<?php echo $path_on_dr_com; ?>">
                    Open the Comments<br/>(on my Blog)
                  </a>
                </div>
              </div>
            </div>

            <div class="cardsocket mini col sml-4 med-4 lrg-4">
              <div class="cardblock mini">
                <figure class="thumbnail">
                  <a href="<?php eval($plxShow->callHook('MyMultiLingueFramagitLinkDisplay')) ?>">
                    <img src="<?php $plxShow->racine() ?>/plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/misc/low-res/2019-06_framagit-webcomic_by-David-Revoy.jpg&amp;w=275&amp;h=275&amp;s=1&amp;q=92" alt="Pepper doing shopping,">
                  </a>
                </figure>
                <div class="button milk">
                  <a href="<?php eval($plxShow->callHook('MyMultiLingueFramagitLinkDisplay')) ?>">
                    Open this lang and episode on Framagit
                  </a>
                </div>
              </div>
            </div>
            
          <?php 
          $buttonthemeA = 'button';
          $buttonthemeB = 'button moka';
          include(dirname(__FILE__).'/navigation.php'); 
          ?>
          
            <br/>
            
            <time style="color: rgba(0,0,0,0.6);" datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>">
              <?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>
            </time>
            
          </section>
          
      </div>
      
      <div style="clear:both;">
      <br/>
      

    </section>
  </main>
</div>

<?php include(dirname(__FILE__).'/footer.php'); ?>
