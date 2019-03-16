<?php
/**
 * 作用：入口文件
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

	#开启错误提示
	ini_set('display_errors','Off');

	#错误提示类型，0表示关闭，E_ALL：全部显示
	error_reporting(0);

	#设置编码
	header("Content-Type:text/html;charset=utf-8");

	#PHP版本检查
	if(version_compare(PHP_VERSION,'5.4.0','<')) die('Php版本最低要求：5.4，请检查!');
	
	#设置时区
	date_default_timezone_set("Asia/Shanghai");

	#加载核心文件
	require 'sdcms.php';