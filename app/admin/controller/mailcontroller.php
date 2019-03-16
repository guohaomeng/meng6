<?php
/**
 * 作用：邮件模板
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class MailController extends AdminsController
{
	
	public function index()
	{
		$this->display("module/mail/index.php");
	}

	public function add()
	{
		if(IS_POST)
		{
			$data=[[F('t0'),'null','标题不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select * from sd_temp_mail where title='".F('t0')."' limit 1");
				if($rs)
				{
					$this->error('标题已存在');
				}
				else
				{
					$d['title']=F('t0');
					$d['mail_title']=F('t1');
					$d['mail_content']=isset($_POST['t2'])?$_POST['t2']:'';
					$d['islock']=getint(F('t3'),0);
					$d['mkey']='';
					$this->db->add('sd_temp_mail',$d);
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
			$this->display("module/mail/add.php");
		}
	}

	public function edit()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','标题不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['title']=F('t0');
				$d['mail_title']=F('t1');
				$d['mail_content']=isset($_POST['t2'])?$_POST['t2']:'';
				$d['islock']=getint(F('t3'),0);
				$this->db->update('sd_temp_mail','id='.$id.'',$d);
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
			$rs=$this->db->row("select * from sd_temp_mail where id=".$id." limit 1");
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$this->assign($key,$val);
				}
				$this->display("module/mail/edit.php");
			}
		}
	}

	public function del()
	{
		$id=getint(F('get.id'),0);
		$this->db->del('sd_temp_mail',"id=$id and mkey=''");
		$this->success('删除成功');
		$this->add_log($this->msg);
	}
	
}