<?php
include_once(dirname(__FILE__).'/bottom_links.php');

include(dirname(__FILE__) . '/header.php');

?>

<div class="containercomic" <?php eval($plxShow->callHook('MyMultiLingueBackgroundColor')) ?>>
  <main class="main grid" role="main">
    <section>
      <article class="article" role="article" id="post-<?php echo $plxShow->artId(); ?>">

        <div class="col sml-12 sml-text-right">
          <nav class="nav" role="navigation">
            <div class="responsive-langmenu">
              <?php
                eval($plxShow->callHook('MyMultiLingueComicToggleButtons'));
                $episodeData = $plxShow->callHook('MyMultiLingueEpisodeData');
                eval($plxShow->callHook('MyMultiLingueLanguageMenu', array(
                    'pageurl' => '?lang={LANG}',
                    'testdir' => $episodeData['directory'].'/low-res',
                    'includewebsite' => false
                )));
               ?>
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
          <?php eval($plxShow->callHook('MyMultiLingueComicDisplay')) ?>
        </section>

      </article>

      <?php
        showBottomArticleLinks();
      ?>

    </section>
  </main>
</div>

<?php include(dirname(__FILE__).'/footer.php'); ?>
