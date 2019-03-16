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

	#开启错误提示：On为开启，Off为关闭
	ini_set('display_errors','Off');

	#错误提示类型：0表示关闭，E_ALL为显示
	error_reporting(0);

	#设置编码
	header("Content-Type:text/html;charset=utf-8");
	
	#PHP版本检查
	if(version_compare(PHP_VERSION,'5.4.0','<')) die('Php版本最低要求：5.4，请检查!（当前版本是：'.PHP_VERSION.'）');

	#只能被同域的Iframe
	header('X-Frame-Options: SAMEORIGIN');
	
	#设置时区
	date_default_timezone_set("Asia/Shanghai");

	#设置HttpOnly
	ini_set("session.cookie_httponly",1);

	#Session跨域(同域)，使用栏目绑定域名时使用
	#ini_set("session.cookie_domain",'.sdcms.cn');

	#加载核心文件
	require 'app/sdcms.php';