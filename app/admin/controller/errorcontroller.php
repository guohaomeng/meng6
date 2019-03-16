<?php
/**
 * 作用：错误日志
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class ErrorController extends AdminsController
{
	public function index()
	{
		$root='app/lib/log';
		$db=self::deal_arr(scandir($root),$root);
		$this->assign('db',$db[0]);
		$this->display("module/other/error.php");
	}

	public function view()
	{
		$key=base64_decode(F('key'));
		$key=str_replace('..','',$key);
		if(!is_file('app/lib/log/'.$key))
		{
			echo '日志文件名错误';
		}
		else
		{
			echo file_get_contents('app/lib/log/'.$key);
		}
	}

	public function del()
	{
		$key=base64_decode(F('get.key'));
		$key=str_replace('..','',$key);
		@unlink('app/lib/log/'.$key);
		$this->success('删除成功');
		$this->add_log($this->msg);
	}

	public function clear()
	{
		$root='app/lib/log';
		$db=self::deal_arr(scandir($root),$root);
		foreach ($db[0] as $rs)
		{
			@unlink($root.'/'.$rs[0]);
		}
		$this->success('清理成功');
		$this->add_log($this->msg);
	}
	
	public function deal_arr($data,$root)
	{
		unset($data[0]);unset($data[1]);
		$a=[];
		foreach ($data as $key=>$val)
		{
			if(is_file($root.'/'.$val))
			{
				$a[$key]=['0'=>iconv("gb2312","utf-8",$val),'1'=>filemtime($root.'/'.$val),'2'=>formatBytes(filesize($root.'/'.$val))];
			}
			else
			{
				unset($data[$key]);
			}
		}
		rsort($a);
		return ['0'=>$a];
	}
}