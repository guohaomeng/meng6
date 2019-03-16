<?php
/**
 * 插件：电子地图管理
 * By IT平民
**/

class AdminController extends PlugController
{
	public function __construct()
	{
		parent::__construct();
		if(!C('plug_map'))
		{
			die('插件未安装');
		}
		$this->check_admin();
	}

	public function Index()
	{
		if(IS_POST)
		{
			$d['point_x']=F('t0');
			$d['point_y']=F('t1');
			$d['mapkey']=F('t3');
			$d['height']=getint(F('t4'),400);
			if(isset($_POST['t2']))
			{
				$d['remark']=$_POST['t2'];
			}
			else
			{
				$d['remark']='';
			}
			
			$this->db->update('sd_plug_map','id=1',$d);
			$this->success('保存成功');
			$this->add_log($this->msg);
		}
		else
		{
			$rs=$this->db->row("select * from sd_plug_map where id=1 limit 1");
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$this->assign($key,$val);
				}
				$this->display("admin/index.php");
			}
		}
	}

	public function view()
	{
		$this->display("admin/view.php");
	}

}