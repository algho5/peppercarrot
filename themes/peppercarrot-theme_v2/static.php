<?php include(dirname(__FILE__).'/header.php'); ?>
<div class="container">
	<main class="main grid" role="main">

		<section class="col sml-12 med-12">

			<article class="article static" role="article" id="static-page-<?php echo $plxShow->staticId(); ?>">

				<section class="grid" >
					<?php $plxShow->staticContent(); ?>
				</section>

			</article>

		</section>

	</main>
</div>
<?php include(dirname(__FILE__).'/footer.php'); ?>
