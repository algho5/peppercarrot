<?php
$myPlugin = $plxAdmin->plxPlugins->aPlugins[$plugin];
?>
<h2><?php echo $myPlugin->getInfo('title'); ?></h2>
<h3>By <?php echo $myPlugin->getInfo('author'); ?></h3>
<div id="html5uploader-help">
	<p>
		This plugin allows you to significantly improve your user experience for media management.
	</p><p>
		In fact, it uses new technologies such as HTML5, drag and drop (<i>DnD</ i>) and Ajax.
	</p>
	<ol>
		<li>Open your Media Manager in your web browser.</li>
		<li>Next, open your manager or file explorer on the desktop of your favorite OS. Select one or more media files at once with the mouse, pressing, if necessary, the "shift" or "control" key on the keyboard.</li>
		<li>And then drag and drop your selection on the media table in the Web browser.</li>
	</ol>
	<p>
		Your selection of media is sent immediately to your web server.
	</p><p>
		In return, the media list is updated in the table without reloading all the page (<i>Ajax technology </i>).
	</p><p>
		Have a good fun.
	</p>
</div>
