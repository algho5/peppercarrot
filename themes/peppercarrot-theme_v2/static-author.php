<?php include(dirname(__FILE__).'/header.php'); ?>
<?php include(dirname(__FILE__).'/lib-parsedown.php'); ?>
<div class="container">
<main class="main grid" role="main">

		<section class="col sml-12">

      <div class="grid">

      <div class="translabar col sml-12 med-12 lrg-12 sml-centered sml-text-center">
        <ul class="menu" role="toolbar">
          <?php eval($plxShow->callHook('MyMultiLingueStaticLang')) ?>
          <li><a class="lang" href="<?php $plxShow->urlRewrite('?static14/documentation&page=010_Translate_the_comic') ?>"><img src="themes/peppercarrot-theme_v2/ico/add.svg" alt="+"/> <?php $plxShow->lang('ADD_TRANSLATION') ?></a></li>
        </ul>
      </div>   
       
       
       <article class="col sml-12 med-12 lrg-12 text-center" role="article" >
           <figure style="margin-top: 1rem;">
           <a href="data/images/static/2015_Portrait-of-David-Revoy_by-Elisa_de_Castro_Guerra.jpg" title="David Revoy, Photo credit : Elisa de Castro Guerra " alt="Photo of David Revoy" ><img src="data/images/static/david-revoy_photo.jpg" title="David Revoy, Photo credit : Elisa de Castro Guerra " alt="Photo of David Revoy"></a>
           </figure>
        <h1>
<?php $plxShow->lang('AUTHOR_TITLE') ?>
        </h1>
    </div>
    
    <div style="max-width: 850px; margin: 0 auto; ">
    <?php $plxShow->lang('AUTHOR_BIO') ?>
    </div>

        <div align="center" style="font-size:2em;">
            <a href="http://www.davidrevoy.com" style="text-decoration:none;" title="www.davidrevoy.com">
                www.davidrevoy.com
            </a>
        </div>
        
        <div align="center" style="font-size:1.4em;">
            <a href="mailto:info@davidrevoy.com" style="text-decoration:none;" title="Contact David Revoy by email">
                info@davidrevoy.com
            </a>
        </div>
    <div style="max-width: 850px; margin: 0 auto; ">
    <?php $plxShow->lang('AUTHOR_TODO_DREAM') ?>
    </div>

    <h3 align="center">
        <?php $plxShow->lang('AUTHOR_CARREER_TITLE') ?>
    </h3>

    <p align="center">
        <img src="data/images/static/2015-02-11_author-achivements.jpg" alt="" />
    </p>
    
    <div style="max-width: 850px; margin: 0 auto; text-align:center; ">
    <?php $plxShow->lang('AUTHOR_CARREER_BUBBLE_DESCRIPTIONS') ?>
    </div>
    

    <p align="right" style="color:#999">
                Photo credit : Elisa de Castro Guerra
    </p>
    
    <?php
    # Dynamic: can be edited here: 
    # https://framagit.org/peppercarrot/webcomics/blob/master/AUTHORS.md
    $contributorfilepath = '0_sources/AUTHORS.md';
    $contents = file_get_contents($contributorfilepath);
    $Parsedown = new Parsedown();
    echo '<div style="text-align:left;">';
    echo $Parsedown->text($contents);
    echo '</div>';
    ?>
       </article> 

          
            <div class="col sml-12 text-center">
                <br/><?php $plxShow->lang('TRANSLATED_BY') ?>
            </div>


		</section>
    


	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
