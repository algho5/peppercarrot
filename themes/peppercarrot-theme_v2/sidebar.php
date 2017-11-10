<?php if(!defined('PLX_ROOT')) exit; ?>

	<aside class="aside col sml-12 med-3" role="complementary">
    
  <div class="homebox">
		<h2>Categories:</h2>
    <section class="col sml-12 med-12 lrg-12" style="padding:0 0;">
      <?php 
      // blog list
      $plxShow->catList('','<a class="catbutton #cat_status" href="#cat_url" title="#cat_name">#cat_name <span class="catbuttonnumber">#art_nb</span></a>');
      // fan-art (list a folder)
      $fanartcounter = 0;
      $pathartworks = '0_sources/0ther/fan-art';
      $search = glob($pathartworks."/*.jpg");
      if (!empty($search)){ 
        foreach ($search as $filepath) {
          $fanartcounter = $fanartcounter + 1;
        }
      }
      ?>
      <a class="catbutton" href="<?php $plxShow->urlRewrite('?static10/fanart-gallery') ?>" title="<?php $plxShow->lang('HOMEPAGE_MOREPOSTS_BUTTON') ?> ( Fan-art ) ">Fan-art <span class="catbuttonnumber"><?php echo ''.$fanartcounter.''; ?></span></a>
    </section>
  </div>

  <div style="clear:both"></div><br/>
  
  <section class="col sml-12 med-12 lrg-12" style="padding:0 0;">
    <div class="homebox">
		<h2>Tags:</h2>
      <ul class="tags unstyled-list">
			<?php $plxShow->tagList('<a class="tag #tag_size" href="#tag_url" title="#tag_name">#tag_name</a> ',40); ?>
      </ul>
    </div>
  </section>
  
  <div style="clear:both"></div><br/>
  
  <section class="col sml-12 med-12 lrg-12" style="padding:0 0;">
    <div class="homebox">
		<h2>Latest comments:</h2>
      <ul class="lastcom unstyled-list">
			<?php $plxShow->lastComList('<li><a href="#com_url"><b>#com_author '.$plxShow->getLang('said').': </b> ( #com_date ) <br/> #com_content(128)</a></li>',5); ?>
      </ul>
    </div>
  </section>



	</aside>
