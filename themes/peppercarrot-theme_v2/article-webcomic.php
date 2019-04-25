<?php include(dirname(__FILE__) . '/header.php'); ?>
  <div class="containercomic">
    <main class="main grid" role="main">
<section>

<?php
$lang = $plxShow->defaultLang($echo);

  # Have we got a new variable 'option' in URL ? grab and security fix it.
  $UrlAdressOption = htmlspecialchars($_GET["option"]);
  $UrlAdressOption = preg_replace('/[^A-Za-z0-9\._-]/', '', $UrlAdressOption);  

  if ($UrlAdressOption == "hd") {
    $ButtonStatus = 'class="active"';
    $LinkVariable = '&option=low';
    
    } elseif ($UrlAdressOption == "low") {
    $ButtonStatus = 'class=""';
    $LinkVariable = '&option=hd';
    $_SESSION['SessionMemory'] = "RemoveHD";
    
    } else {
    $ButtonStatus = 'class=""';
    $LinkVariable = '&option=hd';
  }
  
  # Have we got a preference in memory from previous page?
  if ($_SESSION['SessionMemory'] == "KeepHD") {
    $ButtonStatus = 'class="active"';
    $LinkVariable = '&option=low';
    
    } elseif ( $_SESSION['SessionMemory'] == "RemoveHD") {
    $memoryoption = 'low';
  }
?>


<article class="article" role="article" id="post-<?php echo $plxShow->artId(); ?>">



    
<!-- Translation webcomic-->
<div class="translabar comicwidth col sml-12 sml-centered sml-text-center">
  <ul class="menu" role="toolbar">
    <?php eval($plxShow->callHook('MyMultiLingueComicLang')) ?>
    <li <?php echo ''.$ButtonStatus.''; ?>><a id="hdbutton" href="<?php $plxShow->artUrl() ?><?php echo ''.$LinkVariable.''; ?>" class="lang option"><img src="themes/peppercarrot-theme_v2/ico/full.svg" alt=">"/> HD</a></li>
    <li><a class="lang option" href="<?php $plxShow->urlRewrite('?static14/documentation&page=010_Translate_the_comic') ?>"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> <?php $plxShow->lang('ADD_TRANSLATION') ?></a></li>
  </ul>
</div>

<?php eval($plxShow->callHook('MyMultiLingueComicHeader')) ?>



<?php include(dirname(__FILE__).'/navigation.php'); ?>

<!-- Content -->
<section class="text-center">
<?php eval($plxShow->callHook("MyMultiLingueComicDisplay", array(''.$UrlAdressOption.''))) ?>  
  <small>
    <time style="color: rgba(0,0,0,0.6);" datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>"><?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?></time>
  </small>

</section>
</article>
<div class="content">
  <!-- Footer infos -->
  <div style="clear:both;"><br/></div>
  <footer class="col sml-12 med-12 lrg-12 text-center">
<?php
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
?>
  <h3>Comments have moved <a href="https://www.davidrevoy.com/<?php echo $path_on_dr_com; ?>">to the blog</a></h3>
  
  <div style="margin: 70px auto 0 auto;">
    <?php eval($plxShow->callHook('MyMultiLingueSourceLinkDisplay')) ?>
  </div>
  
  <?php include(dirname(__FILE__).'/navigation.php'); ?>
  </div>
  </footer>
  <div style="clear:both;"><br/></div>
  
<section class="comments col sml-12 sml-centered text-center" >
</section>

</div>

</section>
</main>
</div>
  <?php include(dirname(__FILE__).'/footer.php'); ?>
