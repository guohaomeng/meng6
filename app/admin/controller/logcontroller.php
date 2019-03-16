<?php
/**
 * 作用：管理日志
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class LogController extends AdminsController
{
	public function btach()
	{
		$type=getint(F('get.type'),0);
		$id=F('get.id');
		self::btach_del($id);
		$this->success('操作成功');
		$this->add_log($this->msg);
	}

	public function btach_del($id)
	{
		$overdate=strtotime('-1 month');
		$this->db->del('sd_admin_log','id in('.$id.') and createdate<'.$overdate.'');
	}

	public function index()
	{
		$where='1=1 ';
		if(get_admin_info('pid')!=0)
		{
			$where=" title='".get_admin_info('adminname')."'";
		}
		$this->assign("where",$where);
		$this->display("module/other/log.php");
	}

	public function del()
	{
		$id=getint(F('get.id'),0);
		self::btach_del($id);
		$this->success('删除成功');
		$this->add_log($this->msg);
	}
}