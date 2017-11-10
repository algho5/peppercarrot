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

<h2>Help</h2>
<p>vignette plugin help file</p>

<p>&nbsp;</p>
<h3>Usage</h3>
<p>This plugin add a "Thumbnail" field in the sidebar of your article administration.
You can specify a thumbnail file name, which will appear in the header of your article.</p>

<p>&nbsp;</p>
<h3>Other usage:</h3>
<p>If you disable auto integration of the thumbnail, in the plugin configuration,
you can use following method 'showVignette' in your template, to display the thumbnail where you need.
</p>

<p>&nbsp;</p>
<p>This method can take two parameters:</p>
	<ul>
	<li>- <b>PathOnly</b>: "true" / "false", if "true" only full path of thumbnail is retrieved.</li>
	<li>- <b>Format</b>: <?php echo plxUtils::strCheck('"<div class="vignette"><img src="#url" alt="vignette" /></div>"'); ?>, allow you to customize display format. #url will be replaced by the article thumbnail.</li>
	</ul>

<p>&nbsp;</p>
<h5>Example 1: Just display the thumbnail:</h5>
<pre>
	<div class="helpcode">
	<?php echo plxUtils::strCheck('<?php eval($plxShow->callHook("showVignette")); ?>') ?>
	</div>
</pre>

<p>&nbsp;</p>
<h5>Example 2: script integration:</h5>
<pre>
	<div class="helpcode">
	<?php echo plxUtils::strCheck('/script/timthumb.php?src=<?php eval($plxShow->callHook("showVignette", "true")); ?>') ?>
	</div>
</pre>

<h5>Example 3: Display thumbnail, and change default display format:</h5>
<pre>
	<div class="helpcode">
	<?php echo plxUtils::strCheck('<?php eval($plxShow->callHook("showVignette", array("false", "<ul><li><img src="#url" /></li></ul>"))); ?>') ?>
	</div>
</pre>

<h3>Usage of method "vignetteArtList"</h3>
<p>
	This method is the same as plxShow "lastArtList", but add a way to use thumbnail.
</p>
<p>This method can take 5 parameters (the same as lastArtList):</p>
<ul>
	<li><b>format</b>:<?php echo plxUtils::strCheck('<li><a href="#art_url" title="#art_title"><img src="#art_vignette" />#art_title</a></li>'); ?>, #art_vignette will be replaced by the thumbnail full path.</li>
	<li><b>max</b>: 5, maximum number of articles to display.</li>
	<li><b>cat_id</b>: '', category ID of which you want to display articles.</li>
	<li><b>ending</b>: '', padding characters, if chapo is truncated.</li>
	<li><b>sort</b>: 'rsort', articles sort order.</li>
</ul>
<p>&nbsp;</p>
<h5>Example 1: call the method with default parameters</h5>
<pre>
	<div class="helpcode">
	<?php echo plxUtils::strCheck('<?php eval($plxShow->callHook("vignetteArtList")); ?>'); ?>	
	</div>
</pre>

<h5>Example 2: call the method and just change formatting</h5>
<pre>
	<div class="helpcode">
	<?php echo plxUtils::strCheck('<?php eval($plxShow->callHook("vignetteArtList", \'<li><a href="#art_url" title="#art_title"><img src="#art_vignette" /></a></li>\')); ?>'); ?>
	</div>
</pre>

<h5>Exemple 3: call the method and change all parameters</h5>
<pre>
	<div class="helpcode">
	<?php echo plxUtils::strCheck('<?php eval($plxShow->callHook("vignetteArtList", array(\'<li><a href="#art_url" title="#art_title"><img src="#art_vignette" /></a></li>\', 10, "2", "...", "alpha"))); ?>'); ?>	
	</div>
</pre>	
