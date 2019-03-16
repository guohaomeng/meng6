<?php
/**
 * 首页
 * By IT平民
**/

class IndexController extends PlugController
{
	public function __construct()
	{
		parent::__construct();
		if(!C('plug_map'))
		{
			die('插件未安装');
		}
	}

	public function Index()
	{
		$rs=$this->db->row("select * from sd_plug_map where id=1 limit 1");
		if($rs)
		{
			foreach($rs as $key=>$val)
			{
				if($key=='remark')
				{
					$this->assign($key,str_replace('"','\"',$val));
				}
				else
				{
					$this->assign($key,$val);
				}
				
			}
			if(ismobile())
			{
				$this->assign('width','100%');
			}
			$this->display("index.php");
		}
	}
	
}