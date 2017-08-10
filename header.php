<?php
/*
Template Name:iSingle
Description:瑾忆博客
Version:1.0
Author:瑾忆
Author Url:http://www.drlog.pw
Sidebar Amount:0
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once View::getView('module');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo $site_title; ?> - <?php echo $site_key; ?> - <?php echo $site_description; ?></title>
    <meta name="keywords" content="<?php echo $site_key; ?>" />
    <meta name="description" content="<?php echo $site_description; ?>" />
	<meta name="generator" content="emlog" />
    <meta name="HandheldFriendly" content="True" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?php echo TEMPLATE_URL; ?>images/tx.png">
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />
<link type="<?php echo TEMPLATE_URL; ?>images/tx.jpg" href="<?php echo TEMPLATE_URL; ?>images/tx.jpg" rel="shortcut icon">
<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL; ?>main.css">
<script src="<?php echo TEMPLATE_URL; ?>js/jquery.min.js"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/jquery.pjax.min.js"></script>
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/view-image.min.js"></script>
<?php doAction('index_head'); ?>
</head>
<body>
<div class="content">
<header class="header"> 
<div class="menu"><ul>
<?php blog_navi();?>
</ul></div>
</header> 
<div class="pjax">
    
    <div class="about-me" style="background-image: url(<?php if($logid): ?><?php echo getpostimagetop($logid); ?><?php else:?><?php echo _g('topimg');?><?php endif; ?>)">
<div class="bg-fixed">
     </div>
	 <div id="settingTheme">
                <i class="iconfont icon-menu"></i>
            </div>
     </div>
<div class="contents">
<div class="profile">
<?php if($logid): ?>
              <div class="info">
            <h1><?php echo $log_title; ?></h1>
            <p><?php echo gmdate('Y-n-j', $date);?> / <?php echo $views; ?> 次阅读&nbsp;&nbsp;<?php editflg($logid,$author); ?></p>
          </div>
<?php elseif($tws):?>
<div class="info">
            <h1>微语<span class="online">在线：<?php echo floor((time()-strtotime(""._g('webtime').""))/86400); ?> 天</span></h1>
</div>
<?php else:?>
              <img alt="" src="<?php echo _g("tximg");?>" class="avatar avatar-450 photo" height="450" width="450">
              <div class="info">
            <h1>Single<span class="online">在线：<?php echo floor((time()-strtotime(""._g('webtime').""))/86400); ?> 天</span></h1>
            <p><?php echo widget_search($title); ?></p>
          </div>   
<?php endif; ?>
</div>