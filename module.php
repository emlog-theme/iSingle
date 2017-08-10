<?php 
/**
 * 侧边栏组件、页面模块
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 

?>
<?php
function index_tag(){global $CACHE;$tag_cache = $CACHE->readCache('tags');
?>
<div class="tag">
    <?php shuffle ($tag_cache);foreach($tag_cache as $value):?>
    <a href="<?php echo Url::tag($value['tagurl']); ?>"   title="<?php echo $value['usenum']; ?>篇文章">
    <?php if(empty($value['tagname'])){ echo "无标签";}else{echo $value['tagname'];}?>
	(<?php echo $value['usenum']; ?>)
    </a>
    <?php endforeach; ?>
</div>
<?php }?>
<?php
//统计文章总数
function count_log_all(){
$db = MySql::getInstance();
$data = $db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE type = 'blog'");
return $data['total'];
}
?>
<?php
//统计评论总数
function count_com_all(){
$db = MySql::getInstance();
$data = $db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment");
return $data['total'];
}
?>
<?php
//统计微语总数
function count_tw_all(){
$db = MySql::getInstance();
$data = $db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "twitter");
return $data['total'];
}
?>


<?php 
/**
 * 设置页面
 */

//图片链接
function pic_thumb($content){
    preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $content, $img);
    $imgsrc = !empty($img[1]) ? $img[1][0] : '';
	if($imgsrc):
		return $imgsrc;
	endif;
}

//获取文章图片数量
function pic($content){
	if(preg_match_all("/<img.*src=[\"'](.*)[\"']/Ui", $content, $img) && !empty($img[1])){
		echo $imgNum = count($img[1]);
	}else{
		echo "0";
	}
}

//获取附件第一张图片
function getThumbnail($blogid){
    $db = MySql::getInstance();
    $sql = "SELECT * FROM ".DB_PREFIX."attachment WHERE blogid=".$blogid." AND (`filepath` LIKE '%jpg' OR `filepath` LIKE '%gif' OR `filepath` LIKE '%png') ORDER BY `aid` ASC LIMIT 0,1";
    //die($sql);
    $imgs = $db->query($sql);
    $img_path = "";
    while($row = $db->fetch_array($imgs)){
         $img_path .= BLOG_URL.substr($row['filepath'],3,strlen($row['filepath']));
    }
    return $img_path;
}

//格式化內容工具
function blog_tool_purecontent($content, $strlen = null){
        $content = str_replace('繼續閱讀&gt;&gt;', '', strip_tags($content));
        if ($strlen) {
            $content = subString($content, 0, $strlen);
        }
        return $content;
}
// 分页函数
function pjax_page($count,$perlogs,$page,$url,$anchor=''){
	$pnums = @ceil($count / $perlogs);
	$page = @min($pnums,$page);
	$prepg=$page-1;
	$nextpg=($page==$pnums ? 0 : $page+1);
	$urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|","",$url);
	if($pnums<=1){
		return false;
	}
	if($prepg){
		$re .="<a href=\"$url$prepg$anchor\">Prev</a>";
	}
	if($nextpg){
		$re .="<a href=\"$url$nextpg$anchor\">Next</a>";
	}
	return $re;
}
?>
<?php
//获取文章首张图片 内容用
function getpostimagetop($gid){
$db = MySql::getInstance();
$sql = "SELECT * FROM ".DB_PREFIX."blog WHERE gid=".$gid."";
//die($sql);
$imgs = $db->query($sql);
$img_path = "";
while($row = $db->fetch_array($imgs)){
preg_match('|<img.*src=[\"](.*?)[\"]|', $row['content'], $img);
$rand_img = TEMPLATE_URL.'images/bg.jpg';
$imgsrc = !empty($img[0]) ? $img[1] : $rand_img;
    }
    return $imgsrc;
}
?>
<?php
//网站源码压缩
function sl_ys($buffer){
    $initial=strlen($buffer);
    $buffer=explode("<!--em-compress-html-->", $buffer);
    $count=count ($buffer);
    for ($i = 0; $i <= $count; $i++){
        if (stristr($buffer[$i], '<!--em-compress-html no compression-->')){
            $buffer[$i]=(str_replace("<!--em-compress-html no compression-->", " ", $buffer[$i]));
        }else{
            $buffer[$i]=(str_replace("\t", " ", $buffer[$i]));
            $buffer[$i]=(str_replace("\n\n", "\n", $buffer[$i]));
            $buffer[$i]=(str_replace("\n", "", $buffer[$i]));
            $buffer[$i]=(str_replace("\r", "", $buffer[$i]));
            while (stristr($buffer[$i], '  '))
            {
            $buffer[$i]=(str_replace("  ", " ", $buffer[$i]));
            }
        }
        $buffer_out.=$buffer[$i];
    }
    $final=strlen($buffer_out);
    $savings=($initial-$final)/$initial*100;
    $savings=round($savings, 2);
    $buffer_out.="\n<!--压缩前的大小: $initial bytes; 压缩后的大小: $final bytes; 节约：$savings% -->";
    return $buffer_out;
}
?>
<?php
//blog：相邻文章
function neighbor_log($neighborLog){
	extract($neighborLog);?>
	<?php if($prevLog):?>
	<div class="previous">&laquo; <a href="<?php echo Url::log($prevLog['gid']) ?>"><?php echo $prevLog['title'];?></a></div>
	<?php endif;?>
	<?php if($nextLog && $prevLog):?>
		
	<?php endif;?>
	<?php if($nextLog):?>
		 <div class="next"><a href="<?php echo Url::log($nextLog['gid']) ?>"><?php echo $nextLog['title'];?></a>&raquo;</div>
	<?php endif;?>

<?php }?>
<?php
//archive
function archive123(){
	?>
<?php
function displayRecord(){
	global $CACHE; 
	$record_cache = $CACHE->readCache('record');
	$output = '';
	foreach($record_cache as $value){
		$output .= '<div class="archive-title"><h3>'.$value['record'].'('.$value['lognum'].'篇文章)</h3>'.displayRecordItem($value['date']).'';
	}
	$output = '<div id="archives-temp">'.$output.'</div>';
	return $output;
}
function displayRecordItem($record){
	if (preg_match("/^([\d]{4})([\d]{2})$/", $record, $match)) {
		$days = getMonthDayNum($match[2], $match[1]);
		$record_stime = emStrtotime($record . '01');
		$record_etime = $record_stime + 3600 * 24 * $days;
	} else {
		$record_stime = emStrtotime($record);
		$record_etime = $record_stime + 3600 * 24;
	}
	$sql = "and date>=$record_stime and date<$record_etime order by top desc ,date desc";
	$result = archiver_db($sql);
	return $result;
}
function archiver_db($condition = ''){
	$DB = MySql::getInstance();
	$sql = "SELECT gid, title, date, views FROM " . DB_PREFIX . "blog WHERE type='blog' and hide='n' $condition";
	$result = $DB->query($sql);
	$output = '';
	while ($row = $DB->fetch_array($result)) {
		$log_url = Url::log($row['gid']);
		$output .= '<div class="brick"><span class="time">'.date('d日',$row['date']).'：</span><a href="'.$log_url.'">'.$row['title'].'</a></div>';
	}
	$output = empty($output) ? '<span class="ar-circle"></span><div class="arrow-left-ar"></div><div class="brick">暂无文章</div>' : $output;
	$output = '<div class="archives" id="monlist">'.$output.'</div></div>';
	return $output;
}
echo displayRecord();
?>
<?php }?>
<?php
//blog：导航
function blog_navi(){
	global $CACHE; 
	$navi_cache = $CACHE->readCache('navi');
	?>
	<?php
	foreach($navi_cache as $value):

        if ($value['pid'] != 0) {
            continue;
        }

		if($value['url'] == ROLE_ADMIN && (ROLE == ROLE_ADMIN || ROLE == ROLE_WRITER)):
			?>
			<li><a href="<?php echo BLOG_URL; ?>admin/">管理站点</a></li>
			<li><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
			<?php 
			continue;
		endif;
		$newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
        $value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
        $current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'current' : 'common';
		?>
		<li><a href="<?php echo $value['url']; ?>"><?php echo $value['naviname']; ?></a></li>
	<?php endforeach; ?>
<?php }?>
<?php //文章缩略图获取 返回地址
function is_img($str){
  preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $str, $match);
  if(!empty($match[1])){
    return $match[1][0];
  }else{
    return TEMPLATE_URL . 'images/bg.jpg';//     echo TEMPLATE_URL . 'image/random/tb'.rand(1,20).'.jpg';
  }
}
?>
<?php
//通过id在文章中获取图片
function idby_img($logid){
$db = MySql::getInstance();
$sql = 	"SELECT content,date,views,comnum FROM ".DB_PREFIX."blog WHERE gid=".$logid."";
$list = $db->query($sql);
while($row = $db->fetch_array($list)){ 
	$li=array(is_img($row['content']),date('20y年m月d日',$row['date']),$row['views'],$row['comnum']);
	return $li;
 }} ?>

<?php
//widget：随机文章
function widget_random_log(){
	$index_randlognum = Option::get('index_randlognum');
	$Log_Model = new Log_Model();
	$randLogs = $Log_Model->getRandLog($index_randlognum);?>
	<?php foreach($randLogs as $value):$li = idby_img($value['gid']); ?>
				<li>
					<a class="mimelove-thumb" href="<?php echo Url::log($value['gid']); ?>">
						<img src="<?php echo $li[0]; ?>">
					</a>
					<div class="mimelove-text">
						<div class="mimelove-title">
							<a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a>
						</div>
						<div class="mimelove-meta">
							<i><?php if($li[3]==0){echo "抢沙发";}else{echo $li[3]."条评论";}  ?><span class="separator">/</span><?php echo $li[2] ?>次浏览</i>
						</div>
					</div>
				</li>
	<?php endforeach; ?>
<?php }?>
 <?php
//widget：热门文章
function widget_hotlog($title){
	//if (blog_tool_ishome()) return;#只在非首页显示友链去掉双斜杠注释即可
	$index_hotlognum = Option::get('index_hotlognum');
	$Log_Model = new Log_Model();
	$randLogs = $Log_Model->getHotLog($index_hotlognum);?>
	<?php foreach($randLogs as $value):$li = idby_img($value['gid']); ?>

				<li>
					<a class="mimelove-thumb" href="<?php echo Url::log($value['gid']); ?>">
						<img src="<?php echo $li[0]; ?>">
					</a>
					<div class="mimelove-text">
						<div class="mimelove-title">
							<a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a>
						</div>
						<div class="mimelove-meta">
							<i><?php if($li[3]==0){echo "抢沙发";}else{echo $li[3]."条评论";}  ?><span class="separator">/</span><?php echo $li[2] ?>次浏览</i>
						</div>
					</div>
				</li>
	<?php endforeach; ?>
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $CACHE; 
	$com_cache = $CACHE->readCache('comment');
	//取前6个评论
	$com_cache_slice = array_slice($com_cache, 0,6);

	?>

	<?php
	foreach($com_cache_slice as $value):
	$url = Url::comment($value['gid'], $value['page'], $value['cid']);
			?>
	<li><a href="<?php echo $url; ?>"><img class="avatar" src="<?php echo eflyGravatar($value['mail']); ?>" style="display: block;"> <strong><?php echo $value['name']; ?></strong> 说<br /><?php echo $value['content']; ?></a></li>
	<?php endforeach; ?>

<?php }?>
<?php
//widget：侧栏链接
function widget_linkc($title){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
	shuffle($link_cache);$link_cache = array_slice($link_cache,0,10);
    //if (!blog_tool_ishome()) return;#只在首页显示友链去掉双斜杠注释即可
	?>
	<div class="items">
	<?php foreach($link_cache as $value): ?>
	<a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a>
	<?php endforeach; ?>
	</div>

<?php }?> 
<?php
//首页微语调用
function index_t($num){
	$t = MySql::getInstance();
	?>
	<?php
	$sql = "SELECT id,content,img,author,date,replynum FROM ".DB_PREFIX."twitter ORDER BY `date` DESC LIMIT $num";
	$list = $t->query($sql);
	while($row = $t->fetch_array($list)){
	?>
	 	<div class="notice">
	   <i class="iconfont icon-write"></i> : 
		<div class="notice-content">
		<?php echo $row['content'];?></div>
	</div>
	<?php }?>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
	shuffle($link_cache);$link_cache = array_slice($link_cache,0,6);
    //if (!blog_tool_ishome()) return;#只在首页显示友链去掉双斜杠注释即可
	?>
    <ul>
	<?php foreach($link_cache as $value): ?>
	<li><i class="icon-close" style="padding-left: 10px;"></i>
	<a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
	<?php endforeach; ?>
	</ul>

<?php }?> 
<?php
//widget：友情链接页面
function link_box($title){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
	shuffle($link_cache);$link_cache = array_slice($link_cache,0,20);
	?>
	<?php foreach($link_cache as $value): ?>
	<a href="<?php echo $value['url']; ?>" target="_blank" class="no-underline">
	<div class="thumb">
		<img width="200" height="200" src="<?php echo $value['des']; ?>" alt="Chris">
	</div>
	<div class="link-content">
		<div class="link-title">
			<h3><?php echo $value['link']; ?></h3>
		</div>
	</div>
	</a>
	<?php endforeach; ?>
<?php }?> 
<?php
//blog：文章标签
function blog_tag($blogid){
	global $CACHE;
	$log_cache_tags = $CACHE->readCache('logtags');
	if (!empty($log_cache_tags[$blogid])){
		$tag = '';
		foreach ($log_cache_tags[$blogid] as $value){
			$tag .= "	<a href=\"".Url::tag($value['tagurl'])."\">".$value['tagname'].'</a>';
		}
		echo $tag;
	}
}
?>

<?php
//blog：编辑
function editflg($logid,$author){
	$editflg = ROLE == ROLE_ADMIN || $author == UID ? '<a href="'.BLOG_URL.'admin/write_log.php?action=edit&gid='.$logid.'" target="_blank">编辑</a>' : '';
	echo $editflg;
}
?>
<?php
//widget：搜索
function widget_search($title){ ?>
	<input class="search" type="search" name="keyword" placeholder="谁能理解我.." value="" required>

<?php } ?>
<?php
//Custom：获取模板目录名称
function get_template_name(){
    $template_name = str_replace(BLOG_URL,"",TEMPLATE_URL);
    $template_name = str_replace("content/templates/","",$template_name);
    $template_name = str_replace("/","",$template_name);
    return $template_name;
}
?>
<?php
//blog-tool:头像缓存到本地
function myGravatar($email, $s = 40, $d = 'monsterid', $g = 'g'){
	$f = md5($email);
	$a = TEMPLATE_URL.'avatar/'.$f.'.jpg';
	$e = EMLOG_ROOT.'/content/templates/'.get_template_name().'/avatar/'.$f.'.jpg';
	$t = 1296000;//15天，单位：秒
	if (empty($d)){
		$d = TEMPLATE_URL.'images/avatar.jpg';
	}
	if(!is_file($e) || (time() - filemtime($e)) > $t ){//当头像不存在或者超过15天才更新
		$g = sprintf("http://secure.gravatar.com",(hexdec($f{0})%2)).'/avatar/'.$f.'?s='.$s.'&d='.$d.'&r='.$g;
		copy($g,$e);
		$a = $g;
	}
	if(filesize($e) < 500){
		copy($d,$e);
	}
	return $a;
}
?>
<?php
//blog-tool:获取qq头像并缓存到本地
function eflyGravatar($email,$s = 40) {
	if(empty($email)){
		$eflyGravatar = TEMPLATE_URL.'images/avatar.jpg';
	}
	else if(strpos($email,'@qq.com')){
		$qq = str_replace("@qq.com","",$email);
		if(is_numeric($qq) && strlen($qq) > 4 && strlen($qq) < 13){
			$f = md5($qq);
			$a = TEMPLATE_URL.'avatar/'.$f.'.jpg';
			$e = EMLOG_ROOT.'/content/templates/'.get_template_name().'/avatar/'.$f.'.jpg';
			$t = 1296000;
			if (empty($d)){
				$d = TEMPLATE_URL.'images/avatar.jpg';
			}
			if(!is_file($e) || (time() - filemtime($e)) > $t ){
				$g = sprintf("http://q.qlogo.cn").'/headimg_dl?dst_uin='.$qq.'&spec='.$s;
				copy($g,$e);
				$a = $g;
			}
			if(filesize($e) < 500){
				copy($d,$e);
			}
			$eflyGravatar = $a;
		}
		else{
			$eflyGravatar = myGravatar($email);
		}
	}
	else{
		$eflyGravatar = myGravatar($email);
	}
	return $eflyGravatar;
}
?>
<?php
//blog：评论列表
function blog_comments($comments){
    extract($comments);
    if($commentStacks): ?>

	<?php endif; ?>
	<?php
	$isGravatar = Option::get('isgravatar');
	foreach($commentStacks as $cid):
    $comment = $comments[$cid];
	$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<div class="comment" id="comment-<?php echo $comment['cid']; ?>">
		<div class="comment-info">
		<a name="<?php echo $comment['cid']; ?>"></a>
		<?php if($isGravatar == 'y'): ?><div class="avatar"><img src="<?php echo eflyGravatar($comment['mail']); ?>" /></div><?php endif; ?>
		<b><?php echo $comment['poster']; ?> | <span class="comment-time"><?php echo $comment['date']; ?></span><a class="comment-reply" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">回复</a></b>
		
			<div class="comment-content"><?php echo $comment['content']; ?></div>
			
		</div>
		<div class="comment comment-children" id="comment-<?php echo $comment['cid']; ?>">
		<?php blog_comments_children($comments, $comment['children']); ?>
		</div>
	</div>
	<?php endforeach; ?>
    <div id="pagenavi">
	    <?php echo $commentPageUrl;?>
    </div>
<?php }?>
<?php
//blog：子评论列表
function blog_comments_children($comments, $children){
	$isGravatar = Option::get('isgravatar');
	foreach($children as $child):
	$comment = $comments[$child];
	$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	
		<div class="comment-info" id="comment-<?php echo $comment['cid']; ?>">
		<a name="<?php echo $comment['cid']; ?>"></a>
		<?php if($isGravatar == 'y'): ?><div class="avatar"><img src="<?php echo eflyGravatar($comment['mail']); ?>" /></div><?php endif; ?>
		<b><?php echo $comment['poster']; ?> | <span class="comment-time"><?php echo $comment['date']; ?></span><?php if($comment['level'] < 4): ?><a class="comment-reply" href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">回复</a><?php endif; ?></b>

			<div class="comment-content"><?php echo $comment['content']; ?></div>
		</div>
		<?php blog_comments_children($comments, $comment['children']);?>
	
	<?php endforeach; ?>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
	if($allow_remark == 'y'): ?>
	<div id="comment-place">
	<div class="comment-post" id="comment-post">
		<div class="cancel-reply" id="cancel-reply" style="display:none"><a href="javascript:void(0);" onclick="cancelReply()">取消回复</a></div>
		<p class=""><b>发表评论：</b><a name="respond"></a></p>
		<form method="post" name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" id="commentform">
			<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
			<?php if(ROLE == ROLE_VISITOR): ?>
			<p>
				<input type="text" name="comname" maxlength="49" value="<?php echo $ckname; ?>" size="22" tabindex="1" placeholder="昵称">
				
			</p>
			<p>
				<input type="text" name="commail"  maxlength="128"  value="<?php echo $ckmail; ?>" size="22" tabindex="2" placeholder="邮件地址 (选填)">
				
			</p>
			<p>
				<input type="text" name="comurl" maxlength="128"  value="<?php echo $ckurl; ?>" size="22" tabindex="3" placeholder="个人主页 (选填)">
				
			</p>
			<?php endif; ?>
			<p><textarea name="comment" id="comment" rows="10" tabindex="4"></textarea></p>
			<p><?php echo $verifyCode; ?> <input type="submit" id="comment_submit" value="发表评论" tabindex="6" /></p>
			<input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>
		</form>
	</div>
	</div>
	<?php endif; ?>
<?php }?>
<?php 
	function isMobile(){ 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    { 
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
} 
?>
<?php //获取QQ信息
function getqqtx($qq){
	$url="http://q.qlogo.cn/headimg_dl?bs=qq&amp;dst_uin=$qq&amp;src_uin=qq.feixue.me&amp;fid=blog&amp;spec=100";
	return $url;}
	if(isset($_POST['qq'])){
	$spurl = "http://r.pengyou.com/fcg-bin/cgi_get_portrait.fcg?uins={$_POST['qq']}";
	$data = file_get_contents($spurl);
	$nc=explode('"',$data);
	$s=$nc[5];
	$bm=mb_convert_encoding($s,'UTF-8','UTF-8,GBK,GB2312,BIG5');
	if(empty($bm)){echo '<script>parent.document.getElementsByName("comname")[0].value = "QQ账号错误";parent.document.getElementsByName("commail")[0].value = "QQ账号错误";parent.document.getElementsByName("comurl")[0].value = "QQ账号错误";</script>';}
	else{echo '<script>parent.document.getElementsByName("comname")[0].value = "'.$bm.'";parent.document.getElementsByName("commail")[0].value = "'.$_POST['qq'].'@qq.com";parent.document.getElementsByName("comurl")[0].value = "http://user.qzone.qq.com/'.$_POST['qq'].'";parent.document.getElementById("toux").src="http://q.qlogo.cn/headimg_dl?bs=qq&amp;dst_uin='.$_POST['qq'].'&amp;src_uin=qq.feixue.me&amp;fid=blog&amp;spec=100";</script>';} }
function getqqxx($qq){	
	$ssud=explode("@",$qq,2);
	if($ssud[1]=='qq.com'){
	echo getqqtx($ssud[0]);
	}else{	
	echo MyGravatar($qq);	
}}
?>