<?php
/**
 * 作用：后台菜单
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class MenuController extends AdminsController
{
	public function index()
	{
		if(IS_POST)
		{
			$mid=F('mid');
			$ordnum=F('ordnum');
			foreach($mid as $key=>$val)
			{
				$this->db->update('sd_admin_menu','id='.$val.'',['ordnum'=>$ordnum[$key]]);
			}
			$this->success('保存成功');
			$this->add_log($this->msg);
		}
		else
		{
			$this->display("module/admin_menu/index.php");
		}
	}

	public function add()
	{
		$fid=getint(F('get.fid'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','菜单名称不能为空']];
			if($fid!=0)
			{
				array_push($data,[F('t1'),'null','控制器名称不能为空'],[F('t2'),'null','动作名称不能为空']);
			}
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select * from sd_admin_menu where followid=".$fid." and title='".F('t0')."' limit 1");
				if($rs)
				{
					$this->error('菜单名称已存在');
				}
				else
				{
					$d['title']=F('t0');
					$d['cname']=F('t1');
					$d['aname']=F('t2');
					$d['dname']=F('t3');
					$d['ordnum']=getint(F('t4'),0);
					$d['islock']=F('t5');
					$d['followid']=$fid;
					$this->db->add('sd_admin_menu',$d);
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
			$this->assign('fid',$fid);
			$this->display("module/admin_menu/add.php");
		}
	}

	public function edit()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','菜单名称不能为空']];
			if(getint(F('t6'),0)!=0)
			{
				array_push($data,[F('t1'),'null','控制器名称不能为空'],[F('t2'),'null','动作名称不能为空']);
			}
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['title']=F('t0');
				$d['cname']=F('t1');
				$d['aname']=F('t2');
				$d['dname']=F('t3');
				$d['ordnum']=getint(F('t4'),0);
				$d['islock']=F('t5');
				$this->db->update('sd_admin_menu','id='.$id.'',$d);
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
			$rs=$this->db->row("select * from sd_admin_menu where id=".$id." limit 1");
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$this->assign($key,$val);
				}
				$this->display("module/admin_menu/edit.php");
			}
		}
	}

	public function del()
	{
		$id=getint(F('get.id'),0);
		$rs=$this->db->row("select id from sd_admin_menu where followid=".$id." limit 1");
		if($rs)
		{
			$this->error('请先删除子菜单');
		}
		else
		{
			$this->db->del('sd_admin_menu','id='.$id.'');
			$this->success('删除成功');
		}
		$this->add_log($this->msg);
	}
}