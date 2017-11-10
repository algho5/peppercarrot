<?php include(dirname(__FILE__).'/header.php'); 
$lang = $plxShow->defaultLang($echo);
?>
<div class="container">
	<main class="grid" role="main">
        
    <section class="col sml-12 med-9" style="padding: 0 0;">
      
      <div class="limit col sml-12 med-12 lrg-12 sml-centered lrg-centered med-centered sml-text-center">
        <?php 
        if ($lang !== 'en') {
          echo '&nbsp;<img class="svg" src="themes/peppercarrot-theme_v2/ico/nfog.svg" alt=" "/>';
          $plxShow->lang('LIMITATIONS');
        } else {
          echo '&nbsp;';
        }
        ?>
      </div>
        
        <h2 style="padding-top:0; margin-top: 0;">
            Tag: <?php $plxShow->tagName(); ?>
        </h2>
        
        <?php while($plxShow->plxMotor->plxRecord_arts->loop()): ?>
        
        <article class="thumbnail col sml-4 med-4 lrg-4" style="padding: 0 1rem 0 0;" role="article" id="post-<?php echo $plxShow->artId(); ?>">
          <a href="<?php $plxShow->artUrl() ?>">
            <?php 
            echo '<img src="plugins/vignette/plxthumbnailer.php?src='; 
            eval($plxShow->callHook('showVignette', 'true')); 
            echo '&w=370&h=255&a=t&s=1&q=92" alt="'; $plxShow->artTitle(); 
            echo '" title="'; $plxShow->artTitle(); 
            echo ', click to enlarge" >'; 
            ?>
          </a>
          
          <figcaption class="text-center">
            <a href="<?php $plxShow->artUrl(); ?>" title="<?php $plxShow->artTitle(''); ?>">
              <?php 
              $cooltitle = $plxShow->plxMotor->plxRecord_arts->f('title');
              $cooltitle = str_replace('by', '<br/></strong>by ', $cooltitle);
              if (strlen(strstr($cooltitle,'by'))>0) {
                echo '<strong>'.$cooltitle.'<span class="detail"> - <span>';
              } else {
                echo '<strong>'.$cooltitle.'</strong><br/>';
              }
              ?>
            </a>
                    
            <span class="detail">	
              <time datetime="<?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>">
              <?php $plxShow->artDate('#num_day/#num_month/#num_year(2)'); ?>
              </time> - 
              <?php $plxShow->artNbCom('#nb <img class="svg" src="themes/peppercarrot-theme_v2/ico/com.svg" alt="com"/>','#nb <img class="svg" src="themes/peppercarrot-theme_v2/ico/com.svg" alt="com"/>','#nb <img class="svg" src="themes/peppercarrot-theme_v2/ico/com.svg" alt="com"/>'); ?>
              <br/>
              <?php $plxShow->artCat() ?>
            </span>
          </figcaption>
          
          <br/>
          
        </article>

      <?php endwhile; ?>
      
    <div style="clear:both;"></div>
            
    <br/><br/>
    
    <nav class="pagination text-center">
      <?php $plxShow->pagination(); ?>
    </nav>
      
    <br/><br/><br/><br/><br/>
    
    <span><center>
      <?php $plxShow->artFeed('rss',$plxShow->catId()); ?>
    </center><br/></span>

		</section>

		<?php include(dirname(__FILE__).'/sidebar.php'); ?>

	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
