<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
</div>
</div><!--pjax-->
<div class="footer">
<!--?php widget_link($title); ?-->
	<div class="right_web">
	<p>Copyright &copy; 2017 <a href="<?php echo BLOG_URL; ?>" target="_blank"><?php echo $blogname; ?>  </a>Theme  <a target="_blank" rel="nofollow" href="http://www.drlog.pw/">iSingle</a></p>
	<p><?php echo $footer_info; ?></p>
	</div>
</div><!--footer-->
</div><!--content-->
<div class="back2top"></div>
<script src="<?php echo TEMPLATE_URL; ?>js/parts.js"></script>
<!--script src="<?php echo TEMPLATE_URL; ?>js/instantclick.min.js" data-no-instant></script>
<script data-no-instant>InstantClick.init();</script>
<style>#instantclick-bar {
    background: #f55;
}</style-->
<?php if(isMobile()!=true): ?>
<!--?php include View::getView('jinie_mp3');?-->
<?php endif; ?>
<?php doAction('index_bodys'); ?>
<?php doAction('index_footer'); ?>
</body>
</html>
<?php
        $html=ob_get_contents();
        ob_get_clean();
        echo sl_ys($html);
?>
