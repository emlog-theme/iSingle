<?php 
/**
 * 阅读文章页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="emlog">
<div class="echolog">
<!--section id="banner">
                <h1><?php echo $log_title; ?></h1>
                <div id="info">
                    <li><?php echo gmdate('Y-n-j', $date);?></li>
                    <li><?php echo $views; ?> 次阅读&nbsp;&nbsp;<?php editflg($logid,$author); ?></li>
                </div>
</section-->
	<?php echo $log_content; ?>
	<div class="tag"><?php blog_tag($logid); ?></div>
	<?php doAction('down_log',$logid); ?>
	<div class="adjacent-post">
	<?php neighbor_log($neighborLog); ?>
    </div>
<div class="comment-k">
	<div class="comment-header"><b>Comments | <span><?php echo $comnum; ?> 条评论 </span></b></div>
	<?php blog_comments($comments); ?>
	<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
</div>
</div>
</div><!-- end emlog-->
<?php
 include View::getView('footer');
?>