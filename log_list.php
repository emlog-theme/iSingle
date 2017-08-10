<?php 
/**
 * 站点首页模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>

<div class="log">

<?php 
if (!empty($logs)):
foreach($logs as $value):
$logdes = blog_tool_purecontent($value['content'], 150);
?>
					<li>
<?php $imgsrc = preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $value['content'], $img);$imgsrc = !empty($img[1]) ? $img[1][0] : ''; ?>
<?php if($imgsrc): ?>
<div class="thumbnail">
<a href="<?php echo $value['log_url']; ?>" rel="bookmark">
<img src="<?php echo $imgsrc; ?>">
</a>
</div>
<?php else: ?><?php endif; ?>
					<article class="panel">
					<header>
					<h3><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a></h3>
					</header>
					

<p><?php echo $logdes; ?></p>

					<div class="panel-box">
<?php echo gmdate('Y-n-j', $value['date']); ?>发布 / <?php echo $value['comnum']; ?>条评论 / <?php echo $value['views'];?>次浏览
					</div>
					</article>
					</li>
<?php 
endforeach;
else:
?>
	<li class="nothing">你找到的东西已飞宇宙黑洞去了！</li>
<?php endif;?>
<nav class="reade_more"><?php echo pjax_page($lognum,$index_lognum,$page,$pageurl); ?></nav>




</div><!-- end #log-->

<?php include View::getView('footer');?>