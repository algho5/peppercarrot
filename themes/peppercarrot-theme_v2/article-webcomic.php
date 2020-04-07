<?php include(dirname(__FILE__) . '/header.php');

/**
 * An Option Button to show below the main page navigator
 */
class NavigationToggleButton {
  private $title;
  private $status;
  private $varname;
  private $alttext;

  /**
   * Construct a button.
   *
   * @param string  $title       Button title to display to user
   *
   * @param string  $varname     Variable name to add to URL, format '&varname=1'
   *
   * @param string  $sessionvar  Name of the $_SESSION entry to remember the option
   *
   * @param string  $alton       Link tooltip for toggling on
   *
   * @param string  $altoff      Link tooltip for toggling off
   *
   * @return void
   */
  function __construct($title, $varname, $sessionvar, $alton, $altoff) {
    global $_GET, $_SESSION;

    $this->title = $title;
    $this->varname = $varname;

    # Have we got a new variable 'varname' in URL? Grab it as boolean.
    $this->status = isset($_GET[$varname]) && $_GET[$varname] === '1';

    # Remember in session if we switched it off explicitly just now
    if (!$this->status && isset($_GET[$varname])) {
      $_SESSION[$sessionvar] = 0;
    }

    # Have we got a preference in memory from previous page?
    if ($_SESSION[$sessionvar]) {
      $this->status = true;
    }

    $this->alttext = $this->status ? $altoff : $alton;
  }

  /**
   * Print the button's HTML code.
   *
   * @return void
   */
  function printHtml() {
    global $plxShow;
    $link = $this->varname . '=' . ($this->status ? '0' : '1');
    ?>
    <div class="button top <?php print($this->status ? '' : 'moka'); ?>">
      <a href="<?php $plxShow->artUrl(); print('&'.$link); ?>" title="<?php print($this->alttext); ?>" class="lang option"><?php echo ''.$this->title.''; ?></a>
    </div>
    <?php
  }

  /**
   * @return  boolean  the button's status as parsed in the constructor from $_GET[$varname]
   */
  function status() {
    return $this->status;
  }
}
?>

<div class="containercomic" <?php eval($plxShow->callHook('MyMultiLingueBackgroundColor')) ?>>
  <main class="main grid" role="main">
    <section>
      <article class="article" role="article" id="post-<?php echo $plxShow->artId(); ?>">

        <div class="col sml-12 sml-text-right">
          <nav class="nav" role="navigation">
            <div class="responsive-langmenu">
              <?php
              $transcriptButton = new NavigationToggleButton(
                $plxShow->Getlang('NAVIGATION_TRANSCRIPT'),
                'transcript',
                'SessionTranscript',
                $plxShow->Getlang('NAVIGATION_TRANSCRIPT_ON'),
                $plxShow->Getlang('NAVIGATION_TRANSCRIPT_OFF')
              );
              $transcriptButton->printHtml();
              $hdButton = new NavigationToggleButton(
                $plxShow->Getlang('NAVIGATION_HD'),
                'hd',
                'SessionHD',
                $plxShow->Getlang('NAVIGATION_HD_ON'),
                $plxShow->Getlang('NAVIGATION_HD_OFF')
              );
              $hdButton->printHtml();
              ?>
              <label for="langmenu" style="display: inline-block;"><span class="translabutton"><img src="themes/peppercarrot-theme_v2/ico/language.svg" alt=""/> <?php echo $langlabel;?><img src="themes/peppercarrot-theme_v2/ico/dropdown.svg" alt=""/></span></label>
              <input type="checkbox" id="langmenu">
              <ul class="langmenu expanded">
              <?php eval($plxShow->callHook('MyMultiLingueComicLang')) ?>
              <li class="button"><a class="lang option" href="<?php $plxShow->urlRewrite('?static14/documentation&page=010_Translate_the_comic') ?>"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> <?php $plxShow->lang('ADD_TRANSLATION') ?></a></li>
              </ul>
            </div>
          </nav>
        </div>

        <div style="clear:both;">
        </div>

        <?php eval($plxShow->callHook('MyMultiLingueComicHeader', array('hd' => $hdButton->status(),
                                              'transcript' => $transcriptButton->status()))) ?>

        <?php
        $buttonthemeA = '';
        $buttonthemeB = '';
        include(dirname(__FILE__).'/navigation.php');
        ?>

        <section class="text-center">
          <?php eval($plxShow->callHook("MyMultiLingueComicDisplay",
                                        array('hd' => $hdButton->status(),
                                              'transcript' => $transcriptButton->status()))) ?>
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
