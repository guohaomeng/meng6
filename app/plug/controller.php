<?php
/**
 * 控制器
 * By IT平民
**/

class PlugController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$plugname=PLUG_NAME;
		$this->tp->isCache=false;
		$this->tp->skinDir="app/plug/$plugname/view/";
		$this->tp->cacheDir="app/plug/$plugname/html/";
		$this->tp->compileDir=C('COMPILE_DIR')."/plug/$plugname/";
	}

	public function check_admin()
	{
		if(ADMIN_ID==0)
		{
			die('没有管理权限');
		}
		if(get_admin_info('pid')!=0)
		{
			define('PAGE_LEVER',get_admin_info('page_list'));
			if(strlen(PAGE_LEVER)==0)
			{
				die('没有管理权限');
			}
			else
			{
				$rs=$this->db->load("select cname from sd_admin_menu where followid>0 and id in(".PAGE_LEVER.")");
				if($rs)
				{
					$mname=C('ADMIN');
					foreach($rs as $key=>$value)
					{
						$rs[$key]=$mname.'/'.$value['cname'];
					}
					if(!(in_array(''.$mname.'/plug',$rs)))
					{
						die('没有管理权限');
					}
				}
			}
		}
	}

}