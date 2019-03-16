<?php
/**
 * 作用：缓存管理
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class CacheController extends AdminsController
{
	public function index()
	{
		$data=[];
		if(file_exists(C('COMPILE_DIR').'/'.C('admin').''))
		{
			$data[0]=['title'=>'后台缓存','path'=>C('COMPILE_DIR').'/'.C('admin').'','id'=>1];
		}
		if(file_exists(C('COMPILE_DIR').'/compile'))
		{
			$data[1]=['title'=>'前台缓存','path'=>C('COMPILE_DIR').'/compile','id'=>2];
		}
		if(file_exists(C('COMPILE_DIR').'/plug'))
		{
			$data[2]=['title'=>'插件缓存','path'=>C('COMPILE_DIR').'/plug','id'=>3];
		}
		if(file_exists(C('COMPILE_DIR').'/'.C('HTML_CACHE_DIR').''))
		{
			$data[3]=['title'=>'页面缓存','path'=>C('COMPILE_DIR').'/'.C('HTML_CACHE_DIR').'','id'=>4];
		}
		$this->assign("data",$data);
		$this->display("module/other/cache.php");
	}

	public function del()
	{
		$file='';
		switch(getint(F('get.id'),0))
		{
			case '1':
				$file=C('COMPILE_DIR').'/'.C('admin');
				break;
			case '2':
				$file=C('COMPILE_DIR').'/compile';
				break;
			case '3':
				$file=C('COMPILE_DIR').'/plug';
				break;
			case '4':
				$file=C('COMPILE_DIR').'/'.C('HTML_CACHE_DIR');
				break;
		}
		if($file!='')
		{
			delfolder($file);
		}
		$this->success('清理成功');
		$this->add_log($this->msg);
	}
	
	public function clear()
	{
		delfolder(C('COMPILE_DIR'));
		$this->success('清理成功');
		$this->add_log($this->msg);
	}

	public function weixin()
	{
		$db="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export([],true).";\n?>";
		file_put_contents('app/lib/config/weixin.php',$db);
		file_put_contents('app/lib/config/weixin_ticket.php',$db);
		$this->success('清理成功');
		$this->add_log($this->msg);
	}
}