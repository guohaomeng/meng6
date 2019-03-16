<?php
/**
 * 作用：Http类
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

final class sdcms_http
{
	public function __construct(){}
	
	public static function get($url,$timeout=30,$head='')
	{
		$head=($head='')?FALSE:$head;
		$ch=curl_init();
		#设置超时
		curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
		//Url
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		#设置header
		curl_setopt($ch,CURLOPT_HEADER,$head);
		#要求结果为字符串且输出到屏幕上
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		$result=curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	public static function post($url,$data,$timeout=30,$head='')
	{
		$head=($head='')?FALSE:$head;
		$ch=curl_init();
		#设置超时
		curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
		#Url
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		#设置header
		curl_setopt($ch,CURLOPT_HEADER,$head);
		#要求结果为字符串且输出到屏幕上
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		#post提交方式
		curl_setopt($ch,CURLOPT_POST,TRUE);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		$result=curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}