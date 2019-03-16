<?php
/**
 * 作用：管理员
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class AdminController extends AdminsController
{
	public function index()
	{
		$this->display("module/admin/index.php");
	}

	public function add()
	{
		if(IS_POST)
		{
			$data=[[F('t0'),'username','请填写3-20位数字、字母、下划线'],[F('t1'),'password','请填写5-16位字符，不能包含空格'],[F('t2'),'null','笔名不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select * from sd_admin where adminname='".F('t0')."' limit 1");
				if($rs)
				{
					$this->error('用户名已存在');
				}
				else
				{
					$d['adminname']=F('t0');
					$d['adminpass']=md5(F('t1'));
					$d['penname']=F('t2');
					$d['pid']=getint(F('t3'),0);
					$d['islock']=getint(F('t4'),0);
					$d['logintimes']=0;
					$this->db->add('sd_admin',$d);
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
			$this->display("module/admin/add.php");
		}
	}

	public function edit()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t2'),'null','笔名不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				if(strlen(F('t1'))!=0)
				{
					$d['adminpass']=md5(F('t1'));
				}
				$d['penname']=F('t2');
				$d['pid']=getint(F('t3'),0);
				$d['islock']=getint(F('t4'),0);
				$this->db->update('sd_admin','adminid='.$id.'',$d);
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
			$rs=$this->db->row("select * from sd_admin where adminid=".$id." limit 1");
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$this->assign($key,$val);
				}
				$this->display("module/admin/edit.php");
			}
		}
	}

	public function del()
	{
		$id=getint(F('get.id'),0);
		if($id==ADMIN_ID)
		{
			$this->error('不能删除自己');
		}
		else
		{
			$this->db->del('sd_admin','adminid='.$id.'');
			$this->success('删除成功');
		}
		$this->add_log($this->msg);
	}

}