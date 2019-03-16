<?php
/**
 * 作用：会员组
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class UsergroupController extends AdminsController
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if(IS_POST)
		{
			$mid=F('mid');
			$ordnum=F('ordnum');
			foreach($mid as $key=>$val)
			{
				$this->db->update('sd_user_group','gid='.$val.'',['ordnum'=>$ordnum[$key]]);
			}
			$this->success('保存成功');
			$this->add_log($this->msg);
		}
		else
		{
			$this->display("module/user_group/index.php");
		}
	}

	public function add()
	{
		if(IS_POST)
		{
			$data=[[F('t0'),'null','会员组名称不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select * from sd_user_group where gname='".F('t0')."' limit 1");
				if($rs)
				{
					$this->error('会员组名称已存在');
				}
				else
				{
					$d['gname']=F('t0');
					$d['ordnum']=getint(F('t1'),0);
					$this->db->add('sd_user_group',$d);
					$this->success('添加成功');
				}
			}
			else
			{
				$this->error($v->msg);
			}
			$this->add_log($this->msg);
		}
		else
		{
			$this->display("module/user_group/add.php");
		}
	}

	public function edit()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','会员组名称不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['gname']=F('t0');
				$d['ordnum']=getint(F('t1'),0);
				$this->db->update('sd_user_group','gid='.$id.'',$d);
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
			$rs=$this->db->row("select * from sd_user_group where gid=".$id." limit 1");
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$this->assign($key,$val);
				}
				$this->display("module/user_group/edit.php");
			}
		}
	}

	public function del()
	{
		$id=getint(F('get.id'),0);
		$rs=$this->db->row("select id from sd_user where uid=".$id." limit 1");
		if($rs)
		{
			$this->error('会员组下面有会员，不能删除');
		}
		else
		{
			$this->db->del('sd_user_group','gid='.$id.'');
			$this->success('删除成功');
		}
		$this->add_log($this->msg);
	}

}