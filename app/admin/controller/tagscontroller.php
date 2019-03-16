<?php
/**
 * 作用：标签管理
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class TagsController extends AdminsController
{
	public function index()
	{
		$this->display("module/other/tags.php");	
	}

	public function del()
	{
		$id=getint(F('get.id'),0);
		$this->db->del('sd_tags','id='.$id.'');
		$this->success('删除成功');
		$this->add_log($this->msg);
	}

	public function clear()
	{
		$this->db->del('sd_tags','hits<=0');
		$this->success('删除成功');
		$this->add_log($this->msg);
	}

}