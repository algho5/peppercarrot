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
<div class="translabar col sml-12 sml-centered sml-text-center">
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

  <?php include(dirname(__FILE__).'/supportme.php'); ?>
  
  <div style="margin: 70px auto 0 auto;">
    <?php eval($plxShow->callHook('MyMultiLingueSourceLinkDisplay')) ?>
    <?php include(dirname(__FILE__).'/share.php'); ?>  
  </div>
  
  <?php include(dirname(__FILE__).'/navigation.php'); ?>
  </div>
  </footer>
  <div style="clear:both;"><br/></div>

<?php include(dirname(__FILE__).'/commentaires.php'); ?>

</div>

</section>
</main>
</div>
  <?php include(dirname(__FILE__).'/footer.php'); ?>
