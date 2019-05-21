<?php if (!defined('PLX_ROOT')) exit;
$version = "190108";
$idStat = $plxShow->staticId();
$idCats = $plxShow->catId();
$idMode = $plxShow->mode();
$lang = $plxShow->getLang('LANGUAGE_ISO_CODE_2_LETTER');

if($idMode=="home"){ $status = "active"; } else { $status = "no-active"; }
?>
<!DOCTYPE html>
<html lang="<?php $plxShow->lang('LANGUAGE_ISO_CODE_2_LETTER') ?>">
<!--

 ▄▄▄·▄▄▄ . ▄▄▄· ▄▄▄·▄▄▄ .▄▄▄   ▄▄·  ▄▄▄· ▄▄▄  ▄▄▄        ▄▄▄▄▄    ▄▄·       • ▌ ▄ ·.
▐█ ▄█▀▄.▀·▐█ ▄█▐█ ▄█▀▄.▀·▀▄ █·▐█ ▌▪▐█ ▀█ ▀▄ █·▀▄ █·▪     •██     ▐█ ▌▪▪     ·██ ▐███▪
 ██▀·▐▀▀▪▄ ██▀· ██▀·▐▀▀▪▄▐▀▀▄ ██ ▄▄▄█▀▀█ ▐▀▀▄ ▐▀▀▄  ▄█▀▄  ▐█.▪   ██ ▄▄ ▄█▀▄ ▐█ ▌▐▌▐█·
▐█▪·•▐█▄▄▌▐█▪·•▐█▪·•▐█▄▄▌▐█•█▌▐███▌▐█ ▪▐▌▐█•█▌▐█•█▌▐█▌.▐▌ ▐█▌·   ▐███▌▐█▌.▐▌██ ██▌▐█▌
.▀    ▀▀▀ .▀   .▀    ▀▀▀ .▀  ▀·▀▀▀  ▀  ▀ .▀  ▀.▀  ▀ ▀█▄▀▪ ▀▀▀  ▀ ·▀▀▀  ▀█▄▀▪▀▀  █▪▀▀▀
V.<?php echo $version ?>, 11/2016
-->
<head>
  <meta charset="<?php $plxShow->charset('min'); ?>">
  <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">


  <meta property="og:description" content="<?php $plxShow->lang('Website_DESCRIPTION') ?>"/>
  <meta property="og:type" content="article"/>
  <meta property="og:site_name" content="<?php $plxShow->mainTitle() ?>"/>

  <?php $idMode = $plxShow->mode(); ?>
  <?php if($idMode=="article"){ ?>
     <meta property="og:url" content="<?php $plxShow->artUrl() ?>"/>
     <meta property="og:title" content="<?php $plxShow->artTitle() ?>"/>
     <meta property="og:image" content="<?php $plxShow->racine() ?><?php eval($plxShow->callHook('showVignette', 'true')); ?>"/>
     <meta property="og:image:type" content="image/jpeg" />
  <?php } else { ?>
     <meta property="og:image" content="<?php $plxShow->racine() ?>data/images/static/preview/<?php $plxShow->staticTitle() ?>.jpg"/>
     <meta property="og:image:type" content="image/jpeg" />
  <?php } ?>
  <title><?php $plxShow->pageTitle(); ?></title>
  <meta name="description" content="<?php $plxShow->lang('Website_DESCRIPTION') ?>">
  <?php $plxShow->meta('keywords') ?>
  <?php $plxShow->meta('author') ?>
  <link rel="icon" href="<?php $plxShow->template(); ?>/img/favicon.png" />
  <link rel="apple-touch-icon" href="<?php $plxShow->template(); ?>/img/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php $plxShow->template(); ?>/img/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php $plxShow->template(); ?>/img/apple-touch-icon-114x114.png">
  <link rel="stylesheet" href="<?php $plxShow->template(); ?>/css/plucss.css" media="screen"/>
  <link rel="stylesheet" href="<?php $plxShow->template(); ?>/css/theme.css?version=<?php echo $version ?>" media="screen"/>
  <link rel="alternate" type="application/rss+xml" title="<?php $plxShow->lang('ARTICLES_RSS_FEEDS') ?>" href="<?php $plxShow->urlRewrite('feed.php?rss') ?>" />
  <link rel="alternate" type="application/rss+xml" title="<?php $plxShow->lang('COMMENTS_RSS_FEEDS') ?>" href="<?php $plxShow->urlRewrite('feed.php?rss/commentaires') ?>" />

  <?php
  // conditional: we embed the javascript only if the CMS detect we are displaying a webcomic
  if( $idCats=="003" AND $idMode=="article" ){?>
 <?php } ?>

</head>
<body id="top">
 

 <?php
  if (strpos($_SERVER['SERVER_NAME'], "localhost") !== false){
    echo '<div style="position: fixed; font-size: 0.8rem; text-align: right; width: 100%; bottom: 0px; padding: 2px 8px 2px 8px; background: #000000; color: #FFFFFF; opacity: 0.75; z-index: 500 !important;">';
    $currenturl=$_SERVER['REQUEST_URI'];
    $currenturl=str_replace('/peppercarrot','',$currenturl);
    echo 'Notice: you are browsing localhost: <a href="https://www.peppercarrot.com'.$currenturl.'">online version is here</a>';
    echo '</div>';
  }
  ?>

<?php // récupération de l'identifiant de la page static
$idStat = $plxShow->staticId();
$idCats = $plxShow->catId();
$idMode = $plxShow->mode();
echo "<!-- Debug :";
echo "idStat :"; echo $idStat;
echo "| idCats :"; echo $idCats;
echo "| idMode :"; echo $idMode;
echo "-->";
?>


  <header class="header" role="banner">
      <div class="grid">
      
          <div class="title col sml-4 med-3 lrg-2 sml-text-left">
            <a href="<?php $plxShow->racine() ?>">
              <img src="<?php $plxShow->template(); ?>/img/en_pepper-carrot_title.svg" height="30px" alt="Pepper&amp;Carrot" title="<?php $plxShow->lang('PEPPERCARROT_VEGETABLE') ?>">
            </a>
            <h1 class="no-margin sml-hide med-hide lrg-hide"><?php $plxShow->mainTitle('link'); ?></h1>
          </div>
          
          <div class="topmenu col sml-4 med-6 lrg-8 sml-text-left med-text-center">
            <nav class="nav" role="navigation">
              <div class="responsive-menu">
                <label for="menu"><img src="themes/peppercarrot-theme_v2/ico/menu.svg" alt=""/></label>
                <input type="checkbox" id="menu">
                <ul class="menu expanded">
                <?php if($idStat=="003" OR $idCats=="003" AND $idMode=="article" OR $idCats=="005" AND $idMode=="article" OR $idCats=="009" AND $idMode=="article" ){ $status = "active"; } else { $status = "no-active"; }?>
                <li class="<?php echo $status; ?>" >
                <a href="<?php $plxShow->urlRewrite('?static3/webcomics') ?>"><?php $plxShow->lang('WEBCOMICS') ?></a>
                </li>
                <?php if($idStat=="002"){ $status = "active"; } else { $status = "no-active"; }?>
                <li class="<?php echo $status; ?>" >
                <a href="<?php $plxShow->urlRewrite('?static2/philosophy') ?>"><?php $plxShow->lang('PHILOSOPHY') ?></a>
                </li>
                <?php if($idStat=="004" OR $idStat=="011"){ $status = "active"; } else { $status = "no-active"; }?>
                <li class="<?php echo $status; ?>" >
                <a href="<?php $plxShow->urlRewrite('?static4/contribute') ?>"><?php $plxShow->lang('CONTRIBUTE') ?></a>
                </li>
                <?php if($idStat=="008"){ $status = "active"; } else { $status = "no-active"; }?>
                <li class="<?php echo $status; ?>" >
                <a href="<?php $plxShow->urlRewrite('?static8/wiki') ?>" id="active"><?php $plxShow->lang('WIKI') ?></a>
                </li>
                <?php if($idStat=="006" OR $idStat=="014"){ $status = "active"; } else { $status = "no-active"; }?>
                <li class="<?php echo $status; ?>" >
                <a href="<?php $plxShow->urlRewrite('?static6/sources') ?>"><?php $plxShow->lang('SOURCES') ?></a>
                </li>
                <?php if($idStat=="007"){ $status = "active"; } else { $status = "no-active"; }?>
                <li class="<?php echo $status; ?>" >
                <a href="<?php $plxShow->urlRewrite('?static7/author') ?>" id="active"><?php $plxShow->lang('AUTHOR') ?></a>
                </li>
                <li class="external"><a href="https://www.davidrevoy.com/blog" target="blank"><?php $plxShow->lang('BLOG') ?> <img src="themes/peppercarrot-theme_v2/ico/external-menu.svg" alt=""/></a></li>
                </ul>
              </div>
            </nav>
          </div>
          
          <div class="col sml-4 med-3 lrg-2 sml-text-right">
            <div class="follow"><br/>
              <a class="patronbutton" href="TODO-DONATEPAGE" title="TODO">
              ♥ Donate
              <?php // echo $plxShow->Getlang(PATRONAGE_BUTTON); ?>
              </a>
          </div>

        </div>

    </div>
    
    <div style="clear:both;"></div>

  </header>

<!--
<div style="position: fixed; right: 0px; bottom: 0px; background: #FFF8BB; color: #B27951; z-index: 500 !important;">
    <div class="sml-show med-hide lrg-hide"> SML </div>
    <div class="sml-hide med-show lrg-hide"> MED </div>
    <div class="sml-hide med-hide lrg-show"> LRG </div>
</div>-->
