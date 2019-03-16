<?php
/**
 * 作用：部门管理
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class PartController extends AdminsController
{
	public function index()
	{
		if(IS_POST)
		{
			$mid=F('mid');
			$ordnum=F('ordnum');
			foreach($mid as $key=>$val)
			{
				$this->db->update('sd_admin_part','id='.$val.'',['ordnum'=>$ordnum[$key]]);
			}
			$this->success('保存成功');
			$this->add_log($this->msg);
		}
		else
		{
			$this->display("module/admin_part/index.php");
		}
	}

	public function add()
	{
		if(IS_POST)
		{
			$data=[[F('t0'),'null','部门名称不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select * from sd_admin_part where title='".F('t0')."' limit 1");
				if($rs)
				{
					$this->error('部门名称已存在');
				}
				else
				{
					$d['title']=F('t0');
					$d['ordnum']=getint(F('t1'),0);
					$d['page_list']='';
					$d['cate_list']='';
					$this->db->add('sd_admin_part',$d);
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
			$this->display("module/admin_part/add.php");
		}
	}

	public function edit()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','部门名称不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['title']=F('t0');
				$d['ordnum']=getint(F('t1'),0);
				$this->db->update('sd_admin_part','id='.$id.'',$d);
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
			$rs=$this->db->row("select * from sd_admin_part where id=".$id." limit 1");
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$this->assign($key,$val);
				}
				$this->display("module/admin_part/edit.php");
			}
		}
	}

	public function del()
	{
		$id=getint(F('get.id'),0);
		$rs=$this->db->row("select adminid from sd_admin where pid=".$id." limit 1");
		if($rs)
		{
			$this->error('请先删除管理员');
		}
		else
		{
			$this->db->del('sd_admin_part','id='.$id.'');
			$this->success('删除成功');
		}
		$this->add_log($this->msg);
	}

	public function page()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','至少选择一个权限']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['page_list']=F('t0');
				$this->db->update('sd_admin_part','id='.$id.'',$d);
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
			$rs=$this->db->row("select page_list from sd_admin_part where id=".$id." limit 1");
			if($rs)
			{
				$this->assign('page_list',explode(",",$rs['page_list']));
				$this->display("module/admin_part/page.php");
			}
		}
	}

	public function cate()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','至少选择一个权限']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['cate_list']=F('t0');
				$this->db->update('sd_admin_part','id='.$id.'',$d);
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
			$rs=$this->db->row("select cate_list from sd_admin_part where id=".$id." limit 1");
			if($rs)
			{
				$this->assign('cate_list',explode(",",$rs['cate_list']));
				$this->assign("cate",C('category'));
				$this->display("module/admin_part/cate.php");
			}
		}
	}
}