<?php if (!defined('PLX_ROOT')) exit; ?>
<footer class="footer" role="contentinfo">
    <div class="container">
        <div class="grid">
            
            <div class="col sml-12 text-center"> 
            <p>
              <a href="#top" title="Back to top"><img src="themes/peppercarrot-theme_v2/ico/top.svg" alt="+"/> TOP <img src="themes/peppercarrot-theme_v2/ico/top.svg" alt="+"/></a>
                          
              <div class="follow">
                <?php $plxShow->lang('FOLLOW')?>&nbsp;<br/>
                <a class="logo" href="https://www.facebook.com/pages/Pepper-Carrot/307677876068903" title="<?php $plxShow->lang('FOLLOW')?> Facebook"><img class="svg" src="themes/peppercarrot-theme_v2/ico/s_fb.svg" alt="Facebook"/></a>
                <a class="logo" href="https://framapiaf.org/@davidrevoy" title="<?php $plxShow->lang('FOLLOW')?> Mastodon"><img class="svg" src="themes/peppercarrot-theme_v2/ico/s_mast.svg" alt="Mastodon"/></a>
                <a class="logo" href="http://twitter.com/davidrevoy" title="<?php $plxShow->lang('FOLLOW')?> Twitter"><img class="svg" src="themes/peppercarrot-theme_v2/ico/s_tw.svg" alt="Twitter"/></a>
                <a class="logo" href="<?php $plxShow->urlRewrite('feed.php?rss') ?>" title="RSS 2.0" target="blank"><img class="svg" src="themes/peppercarrot-theme_v2/ico/rss.svg" alt="Rss"/></a>
              </div>
              
              <p><a href="<?php $plxShow->urlRewrite('?static13/terms-of-service-and-privacy') ?>" target="_blank">Terms of Services and Privacy (GDPR)</a> - <a href="<?php $plxShow->urlRewrite('?static14/documentation&page=409_Code_of_Conduct') ?>" title="link to the Code of Conduct in the Documentation" target="_blank">Code of Conduct (CoC)</a></p> 
              
              <p>
                <p><?php $plxShow->lang('TRANSLATED_BY')?></p>
                <?php $plxShow->lang('FOOTER_CONTENT') ?> 
              </p>
                  
              <br/>      
            </p>
            </div>

            <br/>
        </div>
    </div>
</footer>

</body>
</html>
