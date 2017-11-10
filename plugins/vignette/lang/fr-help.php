<?php if(!defined('PLX_ROOT')) exit; ?>

<style>
h2	{ font-size: 2.0em; margin: .75em 0; color: #013162 } 
h3	{ font-size: 1.8em; margin: .83em 0; color: #13518C }
h4	{ font-size: 1.6em; margin: 1.12em 0; color: #2D7CC1 }
h5	{ font-size: 1.4em; font-style: italic; margin: 1.5em 0; color: #A4A4A4 } 
p	{ font-size: 1.2em; }
pre	{ font-size: 12px; }
.helpcode { "color:#000; padding:0 10px 15px 10px; border:1px solid #dedede" }
</style>

<h2>Aide</h2>
<p>Fichier d'aide du plugin vignette</p>

<p>&nbsp;</p>
<h3>Utilisation:</h3>
<p>Ce plugin ajoute un champs "vignette" dans la sidebar d'édition des articles.
Vous pouvez spécifier un nom d'image, qui apparaitra en illustration de votre article.
</p>

<p>&nbsp;</p>
<h3>Autres usages:</h3>
<p>Si vous désactivez l'intégration automatique dans la configuration du plugin,
vous pouvez utiliser la méthode 'showVignette' dans vos template, afin d'afficher la vignette où vous le souhaitez dans l'article.
</p>

<p>&nbsp;</p>
<p>Cette méthode peut prendre deux paramètres: </p>
	<ul>
	<li><b>PathOnly</b>: "true" / "false", si "true" permet de ne récupérer que le chemin complet de la vignette.</li>
	<li><b>Format</b>: <?php echo plxUtils::strCheck('"<div class="vignette"><img src="#url" alt="vignette" /></div>"'); ?>, permet de customiser le formatage. #url sera remplacer par la vignette de l'article</li>
	</ul>
<p>&nbsp;</p>
<h5>Exemple 1: Afficher simplement la vignette:</h5>
<pre>
	<div class="helpcode">
	<?php echo plxUtils::strCheck('<?php eval($plxShow->callHook("showVignette")); ?>') ?>
	</div>
</pre>

<p>&nbsp;</p>
<h5>Exemple 2: Intégration dans un script:</h5>
<pre>
	<div class="helpcode">
	<?php echo plxUtils::strCheck('/script/timthumb.php?src=<?php eval($plxShow->callHook("showVignette", "true")); ?>') ?>
	</div>
</pre>

<h5>Exemple 3: Afficher la vignette, et changer le formatage par défaut:</h5>
<pre>
	<div class="helpcode">
	<?php echo plxUtils::strCheck('<?php eval($plxShow->callHook("showVignette", array("false", "<ul><li><img src="#url" /></li></ul>"))); ?>') ?>
	</div>
</pre>

<h3>Utilisation de la fonction "vignetteArtList"</h3>
<p>
	Cette méthode est l'équivalente de la fonction plxShow "lastArtList", mais elle permet en plus l'utilisation de la vignette.
</p>
<p>Cette méthode peut prendre 5 paramètres (les mêmes que lastArtList):</p>
<ul>
	<li><b>format</b>:<?php echo plxUtils::strCheck('<li><a href="#art_url" title="#art_title"><img src="#art_vignette" />#art_title</a></li>'); ?>, #art_vignette sera remplacer par le chemin de la vignette.</li>
	<li><b>max</b>: 5, nombre d'articles à afficher.</li>
	<li><b>cat_id</b>: '', ID de la catégorie dont vous voulez afficher les articles.</li>
	<li><b>ending</b>: '', caractères à afficher en fin de chaine, si besoin de tronquer le chapo.</li>
	<li><b>sort</b>: 'rsort', ordre de tri des articles.</li>
</ul>
<p>&nbsp;</p>
<h5>Exemple 1: Appeler la méthode avec les paramètres par défaut</h5>
<pre>
	<div class="helpcode">
	<?php echo plxUtils::strCheck('<?php eval($plxShow->callHook("vignetteArtList")); ?>'); ?>	
	</div>
</pre>

<h5>Exemple 2: Appeler la méthode en changeant juste le format</h5>
<pre>
	<div class="helpcode">
	<?php echo plxUtils::strCheck('<?php eval($plxShow->callHook("vignetteArtList", \'<li><a href="#art_url" title="#art_title"><img src="#art_vignette" /></a></li>\')); ?>'); ?>
	</div>
</pre>

<h5>Exemple 3: Appeler la méthode en changeant tout les paramètres</h5>
<pre>
	<div class="helpcode">
	<?php echo plxUtils::strCheck('<?php eval($plxShow->callHook("vignetteArtList", array(\'<li><a href="#art_url" title="#art_title"><img src="#art_vignette" /></a></li>\', 10, "2", "...", "alpha"))); ?>'); ?>	
	</div>
</pre>	
