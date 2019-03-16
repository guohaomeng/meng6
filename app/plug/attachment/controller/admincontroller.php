<?php
/**
 * 插件：附件管理
 * By IT平民
**/

class AdminController extends PlugController
{
	public $num=0;
	public function __construct()
	{
		parent::__construct();
		if(!C('plug_attachment'))
		{
			die('插件未安装');
		}
		$this->check_admin();
	}

	public function Index()
	{
		$root=base64_decode(F('get.root'));
		if($root=='')
		{
			$root='upfile';
		}
		$data=self::deal_arr(scandir($root),$root);
		$folder=$data[0];
		$file=$data[1];
		$arr=explode('/',$root);
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
			$position.=' > <a href="'.U('index','root='.base64_encode($str).'').'">'.$val.'</a>';
		}
		$this->assign('dir',$root);
		$this->assign('position',$position);
		$this->assign('folder',$folder);
		$this->assign('file',$file);
		$this->display("index.php");
	}

	public function del()
	{
		$root=base64_decode(F('get.root'));
		$root=str_replace('..','',$root);
		if(substr($root,0,7)=='upfile/')
		{
			@unlink($root);
		}
		$this->success('删除成功');
		$this->add_log($this->msg);
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
				$ext=strtolower(strrchr($root.'/'.$val,'.'));
				$b[$key]=['0'=>iconv("gb2312","utf-8",$val),'1'=>filemtime($root.'/'.$val),'2'=>formatBytes(filesize($root.'/'.$val)),'3'=>$ext,'4'=>self::is_image($ext)];
			}
			else
			{
				unset($data[$key]);
			}
		}
		krsort($a);
		krsort($b);
		return ['0'=>$a,'1'=>$b];
	}

	public function clear()
	{
		self::get_files('upfile');
		$this->success('共清理'.$this->num.'个缩略图');
		$this->add_log($this->msg);
	}

	public function get_files($path)
	{
	  foreach(scandir($path) as $afile)
	  {
	    if($afile=='.'||$afile=='..') continue;
	    if(is_dir($path.'/'.$afile))
	    {
	      self::get_files($path.'/'.$afile);
	    }
	    else
	    {
	      if(substr($afile,0,6)=='thumb_')
	      {
	        @unlink($path.'/'.$afile);
	        $this->num=$this->num+1;
	      }
	    }
	  }
	}

	public function is_image($a)
	{
		if(in_array($a,['.gif','.jpg','.jpeg','.png','.bmp']))
		{
			return '1';
		}
		else
		{
			return '0';
		}
	}

}