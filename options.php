<?php

/*@support tpl_options*/
!defined('EMLOG_ROOT') && exit('access deined!');
$options = array(
	'topimg' => array(
		'type' => 'image',
		'name' => '顶部背景图',
		'values' => array(
            TEMPLATE_URL . 'images/bg.jpg',
        ),
            ),	
	'tximg' => array(
		'type' => 'image',
		'name' => '头像',
		'values' => array(
            TEMPLATE_URL . 'images/tx.jpg',
        ),
            ),
	'jinie' =>array(
		'type' => 'text',
		'name' => '昵称',
		'description' => '',
		'values' => array(
			'Jinie',
		),
	),

	'home_strong_1' => array(
		'type' => 'text',
		'name' => '首页一句话',
		'description' => '',
		'default' => '突如其来的装逼让我无法呼吸',
    ),
	'qq' => array(
		'type' => 'text',
		'name' => 'QQ账号',
		'description' => '',
		'default' => '837233287',
    ),
	'webtime' => array(
		'type' => 'text',
		'name' => '建站日期',
		'description' => '格式：xxxx-xx-xx',
		'default' => '2016-07-19',
	),
	'music' => array(
        'type' => 'text',
        'name' => '音乐',
        'multi' => true,
        'default' => '',
        'description' => '',
    ),
);