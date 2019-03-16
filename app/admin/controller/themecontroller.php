<?php
/**
 * 作用：模板管理
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class ThemeController extends AdminsController
{
	public function index()
	{
		$folder=scandir('theme');
		if(!$folder)
		{
			die('【scandir】函数不支持，请在Php.ini中去掉限制');
		}
		unset($folder[0]);
		unset($folder[1]);
		foreach ($folder as $key=>$val)
		{
			if(!is_dir('theme/'.$val))
			{
				unset($folder[$key]);
			}
			else
			{
				if(!is_file('theme/'.$val.'/_theme.php'))
				{
					unset($folder[$key]);
				}
				else
				{
					$folder[$key]=['0'=>$val,require('theme/'.$val.'/_theme.php')];
				}
			}
		}
		$this->assign('folder',$folder);
		$this->display("module/theme/index.php");
	}

	public function config()
	{
		if(IS_POST)
		{
			$config=F('config');
			if(!is_file('theme/'.$config.'/_theme.php'))
			{
				$this->error('模板配置错误');
			}
			else
			{
				$d['THEME_DIR']=$config;
				$data="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export($d, true).";\n?>";
				file_put_contents('app/lib/config/theme.php', $data);
			}
			$this->success('应用成功');
			$this->add_log($this->msg);
		}
	}

	public function lists()
	{
		$dir=base64_decode(F('root'));
		$dir=str_replace('..','',$dir);
		$root='theme/'.$dir;
		if(!is_dir($root))
		{
			die('非法路径');
		}
		list($theme)=explode('/',$dir);
		self::check_note($theme);
		$name=require('theme/'.$theme.'/_note.php');
		$data=self::deal_arr(scandir($root),$root);
		$folder=$data[0];
		$file=$data[1];
		$arr=explode('/',$dir);
		$str='';
		$position='';
		foreach ($arr as $key=>$val)
		{
			if($key==0)
			{
				$str=$val;
			}
			else
			{
				$str.='/'.$val;
			}
			$position.=' > <a href="'.U('lists','root='.base64_encode($str).'').'">'.$val.'</a>';
		}
		$arr=explode('/',$dir);
		array_shift($arr);
		$note=implode('/',$arr);
		if($note){$note.='/';}
		$this->assign('dir',$dir);
		$this->assign('note',$note);
		$this->assign('position',$position);
		$this->assign('folder',$folder);
		$this->assign('file',$file);
		$this->assign('name',$name);
		$this->display('module/theme/list.php');
	}

	public function edit()
	{
		if(IS_POST)
		{
			$dir=base64_decode(F('t0'));
			$dir=str_replace('..','',$dir);
			$root='theme/'.$dir;
			if(!is_file($root))
			{
				$this->error('非法文件');
				$this->add_log($this->msg);
				return;
			}
			list($theme)=explode('/',$dir);
			self::check_note($theme);
			$name=require('theme/'.$theme.'/_note.php');
			$db=explode('/',$dir);
			unset($db[0]);
			$note=implode('/',$db);
			if(strlen(F('t1'))==0)
			{
				unset($name[$note]);
			}
			else
			{
				$name[$note]=F('t1');
			}
			$text=self::deal_text($_POST['t2']);
			$data=[[$text,'null','内容不能为空']];
			if(self::check_bad($text)>0)
			{
				$data=array_merge($data,[[(1>1),'other','请勿提交非法内容']]);
			}
			$v=new sdcms_verify($data);
			if($v->result())
			{
				if(strpos($root,'.php'))
				{
					$text="<?php if(!defined('IN_SDCMS')) exit;?>".$text;
				}
				file_put_contents($root,$text);
				$this->success('保存成功');
				$data="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export($name, true).";\n?>";
				file_put_contents('theme/'.$theme.'/_note.php', $data);
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
			$root='theme/'.$dir;
			if(!is_file($root))
			{
				die('非法文件');
			}
			if(self::isImage($root))
			{
				die('图像文件不可编辑');
			}
			$arr=explode('/',$dir);
			array_pop($arr);
			list($theme)=explode('/',$dir);
			self::check_note($theme);
			$name=require('theme/'.$theme.'/_note.php');
			$remark='';
			$db=explode('/',$dir);
			unset($db[0]);
			$note=implode('/',$db);
			if(isset($name[$note]))
			{
				$remark=$name[$note];
			}
			$arr=explode('/',$dir);
			array_pop($arr);
			$str='';
			$position='';
			foreach ($arr as $key=>$val)
			{
				if($key==0)
				{
					$str=$val;
				}
				elseif($key!=count($arr))
				{
					$str.='/'.$val;
				}
				$position.=' > <a href="'.U('lists','root='.base64_encode($str).'').'">'.$val.'</a>';
			}
			$data=file_get_contents($root);
			$this->assign('file',$dir);
			$this->assign('remark',$remark);
			$this->assign('data',str_replace("<?php if(!defined('IN_SDCMS')) exit;?>",'',$data));
			$this->assign('old',implode('/',$arr));
			$this->assign('position',$position);
			$this->display('module/theme/edit.php');
		}
	}

	function isImage($filename)
	{ 
	    $types='.gif|.jpeg|.png|.bmp';//定义检查的图片类型 
	    if(file_exists($filename))
	    {
	        $info=getimagesize($filename);
	        $ext=image_type_to_extension($info['2']); 
	        return stripos($types,$ext);
	    }
	    else
	    { 
	        return false;
	    } 
	}

	public function deal_arr($data,$root,$name=[])
	{
		unset($data[0]);unset($data[1]);
		$a=[];
		$b=[];
		foreach ($data as $key=>$val)
		{
			if(is_dir($root.'/'.$val))
			{
				$a[$key]=['0'=>iconv("gb2312","utf-8",$val),'1'=>filemtime($root.'/'.$val)];
			}
			elseif(is_file($root.'/'.$val))
			{
				$b[$key]=['0'=>iconv("gb2312","utf-8",$val),'1'=>filemtime($root.'/'.$val),'2'=>formatBytes(filesize($root.'/'.$val))];
			}
			else
			{
				unset($data[$key]);
			}
		}
		return ['0'=>$a,'1'=>$b];
	}

	public function check_note($theme)
	{
		if(!file_exists('theme/'.$theme.'/_note.php'))
		{
			$d="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export([], true).";\n?>";
			file_put_contents('theme/'.$theme.'/_note.php', $d);
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

	public function template()
	{
		$root=base64_decode(F('root'));
		$root=str_replace('..','',$root);
		if(!$root)
		{
			$root='theme/'.C('theme_dir');
		}
		$root.='/';
		$dir=str_replace('theme/'.C('theme_dir').'/','',$root);
		if(!is_dir($root))
		{
			die($root.'文件夹不存在');
		}
		$arr=explode('/',$dir);
		$str='';
		$position='';
		$default='theme/'.C('theme_dir').'/';
		foreach ($arr as $key=>$val)
		{
			if($key==0)
			{
				$str=$val;
			}
			else
			{
				$str.='/'.$val;
			}
			$position.=' > <a href="'.U('template','root='.base64_encode($default.$str).'').'">'.$val.'</a>';
		}
		$data=self::deal_arr(scandir($root),$root);
		$folder=$data[0];
		$file=$data[1];
		self::check_note(C('theme_dir'));
		$name=require('theme/'.C('theme_dir').'/_note.php');
		$this->assign('folder',$folder);
		$this->assign('file',$file);
		$this->assign('name',$name);
		$this->assign('root',$root);
		$this->assign('dir',$dir);
		$this->assign('position',$position);
		$this->display("module/theme/template.php");
	}

	private function check_bad($str)
	{
		$num=preg_match_all("/(phpinfo|eval|file_put_contents|file_get_contents|passthru|exec|chroot|scandir|proc_open|delfolder|unlink|mkdir|fopen|fread|fwrite|fputs|tmpfile|flock|chmod|delete|assert|_post|_get|_request|_file)/Ui",$str,$match);
		return $num?$num:0;
	}

}