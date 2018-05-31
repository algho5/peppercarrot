<?php if(!defined('PLX_ROOT')) exit; ?>
<div class="share col sml-12 med-8 lrg-8 sml-centered sml-text-center" style="padding: 0 0; margin-top: 1rem;" >
  <br/>
  Share on:
  <br/>
  
  <a class="social" href="http://www.facebook.com/sharer.php?u=<?php $plxShow->staticUrl() ?>" target="_blank" title="Share on Facebook">Facebook</a>    

  <a class="social" href="https://twitter.com/share?url=<?php $plxShow->staticUrl() ?>&text=<?php $plxShow->staticTitle('url'); ?>" target="_blank" title="Retweet on Twitter">Twitter</a>

  <a class="social" href="web+mastodon://share?text=On%20Pepper%26Carrot%20blog%3A%20%22<?php $plxShow->staticTitle('url'); ?>%22%0A%23peppercarrot%0A%0A<?php echo rawurlencode($plxShow->staticUrl()); ?>" target="_blank" title="Share on Mastodon">Mastodon</a>
  
  <a class="social" href="http://www.tumblr.com/share/link?url=<?php $plxShow->staticUrl() ?>&name=<?php $plxShow->staticTitle('url'); ?>" target="_blank" title="Share on Tumblr">Tumblr</a>

  <a class="social" href="https://plus.google.com/share?url=<?php $plxShow->staticUrl() ?>" target="_blank" title="Share on Google+">Google+</a>

  <a class="social" href="https://share.diasporafoundation.org/?title=<?php $plxShow->staticTitle() ?>%20%23peppercarrot&url=<?php $plxShow->staticUrl() ?>" target="_blank" title="Share on Diaspora">Diaspora</a>

  <a class="social" href="http://reddit.com/submit?url=<?php $plxShow->staticUrl() ?>&title=<?php $plxShow->staticTitle('url'); ?>" target="_blank" title="Share on Reddit">Reddit</a>

</div>

