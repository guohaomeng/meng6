<?php
/**
 * 作用：插件列表
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class PlugController extends AdminsController
{
	public function index()
	{
		$folder=scandir('app/plug');
		if(!$folder)
		{
			die('【scandir】函数不支持，请在Php.ini中去掉限制');
		}
		unset($folder[0]);
		unset($folder[1]);
		foreach ($folder as $key=>$val)
		{
			if(!is_dir('app/plug/'.$val))
			{
				unset($folder[$key]);
			}
			else
			{
				if(!is_file('app/plug/'.$val.'/_config.php'))
				{
					unset($folder[$key]);
				}
				else
				{
					$folder[$key]=['0'=>$val,require('app/plug/'.$val.'/_config.php')];
				}
			}
		}
		$this->assign('folder',$folder);
		$this->display("module/other/plug.php");
	}

	public function install()
	{
		$name=F('get.name');
		if(!is_dir('app/plug/'.$name))
		{
			$this->error('插件路径错误');
		}
		else
		{
			if(!is_file('app/plug/'.$name.'/_config.php'))
			{
				$this->error('插件配置错误');
			}
			else
			{
				$config=require('app/plug/'.$name.'/_config.php');
				if($config['install'])
				{
					$split=explode('@@@@',$config['install']);
					foreach ($split as $key=>$val)
					{
						$this->db->query($val);
					}
				}
				$d=require('app/lib/config/plug.php');
				$d['plug_'.$name]=$name;
				$data="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export($d, true).";\n?>";
				file_put_contents('app/lib/config/plug.php', $data);
				$this->success('安装成功');
			}
		}
	}

	public function delete()
	{
		$name=F('get.name');
		if(!is_dir('app/plug/'.$name))
		{
			$this->error('插件路径错误');
		}
		else
		{
			if(!is_file('app/plug/'.$name.'/_config.php'))
			{
				$this->error('插件配置错误');
			}
			else
			{
				if(C('plug_'.$name))
				{
					$config=require('app/plug/'.$name.'/_config.php');
					if($config['delete'])
					{
						$split=explode('@@@@',$config['delete']);
						foreach ($split as $key=>$val)
						{
							$this->db->query($val);
						}
					}
					$d=require('app/lib/config/plug.php');
					unset($d['plug_'.$name]);
					$data="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export($d, true).";\n?>";
					file_put_contents('app/lib/config/plug.php', $data);
					$this->success('卸载成功');
				}
				else
				{
					$this->error('插件没有安装');
				}
			}
		}
	}

}