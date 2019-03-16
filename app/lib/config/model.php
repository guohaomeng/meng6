<?php
if(!defined('IN_SDCMS')) exit;
return array (
  1 => 
  array (
    'id' => '1',
    'title' => '文章模型',
    'tablename' => 'news',
    'model_desc' => '',
    'list_skins' => 'content/news/list.php',
    'show_skins' => 'content/news/show.php',
    'form_group' => '基本设置|1,SEO设置|2,可选设置|3',
    'ordnum' => '0',
    'islock' => '1',
    'issys' => '1',
  ),
  2 => 
  array (
    'id' => '2',
    'title' => '产品模型',
    'tablename' => 'pro',
    'model_desc' => '',
    'list_skins' => 'content/pro/list.php',
    'show_skins' => 'content/pro/show.php',
    'form_group' => '基本设置|1,SEO设置|2,可选设置|3',
    'ordnum' => '0',
    'islock' => '1',
    'issys' => '1',
  ),
  3 => 
  array (
    'id' => '3',
    'title' => '招聘模型',
    'tablename' => 'job',
    'model_desc' => '',
    'list_skins' => 'content/job/list.php',
    'show_skins' => 'content/job/show.php',
    'form_group' => '基本设置|1,SEO设置|2,可选设置|3',
    'ordnum' => '0',
    'islock' => '1',
    'issys' => '1',
  ),
);
?>