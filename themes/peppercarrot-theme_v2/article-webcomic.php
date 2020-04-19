<?php include(dirname(__FILE__) . '/header.php'); ?>

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
                    'testdir' => $episodeData['directory'].'/low-res'
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
                    <b>Artworks files</b><br/> Krita files, svg and jpg.
                  </a>
                </div>
              </div>
            </div>


            <div class="cardsocket mini col sml-4 med-4 lrg-4">
              <div class="cardblock mini">
                <figure class="thumbnail">
                  <a href="<?php eval($plxShow->callHook('MyMultiLingueCommentLinkDisplay', array('url'))) ?>#comments">
                    <img src="<?php $plxShow->racine() ?>/plugins/vignette/plxthumbnailer.php?src=0_sources/0ther/misc/low-res/2019-06_comment-webcomic_by-David-Revoy.jpg&amp;w=275&amp;h=275&amp;s=1&amp;q=92" alt="Pepper doing shopping,">
                  </a>
                </figure>
                <div class="button milk">
                  <a href="<?php eval($plxShow->callHook('MyMultiLingueCommentLinkDisplay', array('url'))) ?>#comments">
                    <b><?php eval($plxShow->callHook('MyMultiLingueCommentLinkDisplay', array('nb_com'))) ?> Comment(s)</b> <br/>on the blog.
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
                    <b>Git repository</b><br/>Sources code (translation)
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
