<?php if(!defined('PLX_ROOT')) exit; ?>
<div class="share col sml-12 med-8 lrg-8 sml-centered sml-text-center" style="padding: 0 0; margin-top: 1rem;" >
  
  <br/>Share on:&nbsp;
  
  <a class="social" href="http://www.facebook.com/sharer.php?u=<?php $plxShow->artUrl() ?>" title="Share on Facebook">
    Facebook
  </a>    
  &nbsp;|&nbsp;                               
  <a class="social" href="https://twitter.com/share?url=<?php $plxShow->artUrl() ?>&text=<?php urlencode($plxShow->artTitle()); ?>" title="Retweet on Twitter">
    Twitter
  </a>    
  &nbsp;|&nbsp;                                 
  <a class="social" href="https://plus.google.com/share?url=<?php $plxShow->artUrl() ?>" title="Share on Google+">
    Google+
  </a>   
  &nbsp;|&nbsp;  
  <a class="social" href="http://reddit.com/submit?url=<?php $plxShow->artUrl() ?>&title=<?php urlencode($plxShow->artTitle()); ?>" title="Share on Reddit">
    Reddit
  </a>
  &nbsp;|&nbsp;                                                                  
  <a class="social" href="http://www.tumblr.com/share/link?url=<?php $plxShow->artUrl() ?>&name=<?php urlencode($plxShow->artTitle()); ?>" title="Share on Tumblr">
    Tumblr
  </a>   
  &nbsp;|&nbsp;  
  <a class="social" href="https://share.diasporafoundation.org/?title=<?php $plxShow->artTitle() ?>%20%23peppercarrot&url=<?php $plxShow->artUrl() ?>" title="Share on Diaspora">
    Diaspora
  </a>
  
</div>
