<?php
/**
 * 作用：区块管理
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class BlockController extends AdminsController
{
	public function index()
	{
		$dir='block';
		$root='theme/'.C('theme_dir').'/'.$dir;
		mkfolder($root);
		self::check_note();
		$name=require('theme/'.C('theme_dir').'/_note.php');
		$data=self::deal_arr(scandir($root),$root);
		$file=$data[0];
		$this->assign('dir',$dir);
		$this->assign('file',$file);
		$this->assign('name',$name);
		$this->display('module/block/list.php');
	}

	public function add()
	{
		if(IS_POST)
		{
			$t1=strtolower(F('t1'));
			$t1=str_replace('..','',$t1);
			$file=C('theme_dir').'/block/'.$t1.'.php';
			$data=[[F('t0'),'null','区块说明不能为空'],[$t1,'field','关键字只能为字母和数字的组合'],[!file_exists('theme/'.$file),'other','关键字已存在，请更换']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				self::check_note();
				$name=require('theme/'.C('theme_dir').'/_note.php');
				$name['block/'.$t1.'.php']=F('t0');

				$data="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export($name, true).";\n?>";
				file_put_contents('theme/'.C('theme_dir').'/_note.php', $data);

				$data="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export([0=>self::deal_text($_POST['t2'])], true).";\n?>";
				file_put_contents('theme/'.$file,$data);
				$this->success('添加成功');
			}
			else
			{
				$this->error($v->msg);
			}
			$this->add_log($this->msg);
		}
		else
		{
			$this->display('module/block/add.php');
		}
	}

	public function edit()
	{
		if(IS_POST)
		{
			$dir=base64_decode(F('t1'));
			$dir=str_replace('..','',$dir);
			$root='theme/'.C('theme_dir').'/block/'.$dir.'.php';
			if(!is_file($root))
			{
				$this->error('非法文件');
				$this->add_log($this->msg);
				return;
			}
			$data=[[F('t0'),'null','区块说明不能为空'],[file_exists($root),'other','区块不存在']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				self::check_note();
				$name=require('theme/'.C('theme_dir').'/_note.php');
				$name['block/'.$dir.'.php']=F('t0');
				$data="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export($name, true).";\n?>";
				file_put_contents('theme/'.C('theme_dir').'/_note.php', $data);
				$data="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export([0=>self::deal_text($_POST['t2'])], true).";\n?>";
				file_put_contents($root,$data);
				$this->success('保存成功');
			}
			else
			{
				$this->error($v->msg);
			}
			$this->add_log($this->msg);
		}
		else
		{
			$dir=base64_decode(F('get.root'));
			$dir=str_replace('..','',$dir);
			$root='theme/'.C('theme_dir').'/block/'.$dir;
			if(!is_file($root))
			{
				die('非法文件');
			}
			$arr=explode('/',$dir);
			array_pop($arr);
			list($theme)=explode('/',$dir);
			self::check_note();
			$name=require('theme/'.C('theme_dir').'/_note.php');
			$title='';
			if(isset($name['block/'.$dir]))
			{
				$title=$name['block/'.$dir];
			}
			$content=require($root);
			$this->assign('title',$title);
			$this->assign('key',basename($root,'.php'));
			$this->assign('content',$content[0]);
			$this->display('module/block/edit.php');
		}
	}

	public function del()
	{
		$key=base64_decode(F('get.key'));
		$key=str_replace('..','',$key);
		self::check_note();
		$name=require('theme/'.C('theme_dir').'/_note.php');
		unset($name['block/'.$key]);
		$data="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export($name, true).";\n?>";
		file_put_contents('theme/'.C('theme_dir').'/_note.php', $data);
		@unlink('theme/'.C('theme_dir').'/block/'.$key);
		$this->success('删除成功');
		$this->add_log($this->msg);
	}

	public function deal_arr($data,$root,$name=[])
	{
		unset($data[0]);
		unset($data[1]);
		$a=[];
		foreach ($data as $key=>$val)
		{
			if(is_file($root.'/'.$val))
			{
				$a[$key]=['0'=>iconv("gb2312","utf-8",$val),'1'=>filemtime($root.'/'.$val)];
			}
			else
			{
				unset($data[$key]);
			}
		}
		return ['0'=>$a];
	}

	public function check_note()
	{
		if(!file_exists('theme/'.C('theme_dir').'/_note.php'))
		{
			$d="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export([], true).";\n?>";
			file_put_contents('theme/'.C('theme_dir').'/_note.php', $d);
		}
	}

	public function deal_text($str)
	{
		if(!get_magic_quotes_gpc())
		{
			return stripslashes($str);
		}
		else
		{
			return $str;
		}
	}

}