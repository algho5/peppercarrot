<?php include(dirname(__FILE__).'/header.php'); ?>
<div class="container">
  <main class="main grid" role="main">
    <section class="col sml-12">

      <div class="grid">
        <?php include(dirname(__FILE__).'/lib-transla-static.php'); ?>
        <article class="col sml-12 med-12 lrg-12" role="article" >
        
          <figure style="margin-top: 1rem;">
            <a href="data/images/static/2015_Portrait-of-David-Revoy_by-Elisa_de_Castro_Guerra.jpg" title="David Revoy, Photo credit : Elisa de Castro Guerra " alt="Photo of David Revoy" >
              <img src="data/images/static/david-revoy_photo.jpg" title="David Revoy, Photo credit : Elisa de Castro Guerra " alt="Photo of David Revoy">
            </a>
          </figure>
          
          <em>
          Photo credit : Elisa de Castro Guerra
          </em>

          <h1>
            <?php $plxShow->lang('AUTHOR_TITLE') ?>
          </h1>
          
          <?php $plxShow->lang('AUTHOR_BIO') ?>

          <div class="button big moka">
            <a href="http://www.davidrevoy.com" style="text-decoration:none;" title="www.davidrevoy.com">
              www.davidrevoy.com
            </a>
          </div>
          
          <br/>

          <div class="button moka">
            <a href="mailto:info@davidrevoy.com" style="text-decoration:none;" title="Contact David Revoy by email">
              info@davidrevoy.com
            </a>
          </div>

          <?php $plxShow->lang('AUTHOR_TODO_DREAM') ?>

          <h3>
            <?php $plxShow->lang('AUTHOR_CARREER_TITLE') ?>
          </h3>

          <img src="data/images/static/2015-02-11_author-achivements.jpg" alt="" />

          <?php $plxShow->lang('AUTHOR_CARREER_BUBBLE_DESCRIPTIONS') ?>

          <?php
          # Listing here: https://framagit.org/peppercarrot/webcomics/blob/master/AUTHORS.md
          include(dirname(__FILE__).'/lib-parsedown.php');
          $contributorfilepath = '0_sources/AUTHORS.md';
          $contents = file_get_contents($contributorfilepath);
          $Parsedown = new Parsedown();
          echo $Parsedown->text($contents);
          ?>
        </article>
      </div>
      
    </section>
  </main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
