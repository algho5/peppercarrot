<?php
$myPlugin = $plxAdmin->plxPlugins->aPlugins[$plugin];
?>
<h2><?php echo $myPlugin->getInfo('title'); ?></h2>
<h3>By <?php echo $myPlugin->getInfo('author'); ?></h3>
<div id="html5uploader-help">
	<p>
		Ce plugin vous permet d'améliorer de manière importante votre expérience utilisateur pour la gestion des médias.
	</p><p>
		En effet, il utilise des nouvelles technologies comme HTML5, Drap and Drop (<i>DnD</i>) et Ajax.
	</p>
	<ol>
		<li>Ouvrez votre gestionnaire de médias dans votre navigateur web.</li>
		<li>A côté, ouvrez votre gestionnaire ou explorateur de fichiers sur le bureau de votre OS préféré. Sélectionnez un ou plusieurs fichiers médias à la fois avec la souris, en appuyant simultanément, si besoin, sur la touche "majuscules" ou " control" de votre clavier.</li>
		<li>Et ensuite, glissez et déposez votre sélection sur le tableau de médias dans le navigateur Web.</li>
	</ol>
	<p>
		Votre sélection de médias est envoyée immédiatement sur votre serveur Web.
	</p><p>
		En retour la liste des médias est actualisée dans le tableau sans recharger la page (<i>Ajax technology</i>).
	</p><p>
		Bon amusement.
	</p>
</div>
