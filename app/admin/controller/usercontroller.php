<?php
/**
 * 作用：会员管理
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class UserController extends AdminsController
{
	public function index()
	{
		$where='1=1 ';
		$keyword=trim(F('get.keyword'));
		$uid=getint(F('get.uid'),0);
		if(strlen($keyword)>0)
		{
			$where.=" and (uname like binary '%".$keyword."%' or uemail like binary '%".$keyword."%')";
		}
		if($uid>0)
		{
			$where.=" and uid=$uid";
		}
		$type=getint(F('get.type'),0);
		switch ($type)
		{
			case '1':
				$where.=' and islock=1';
				break;
			case "2":
				$where.=' and islock=0';
				break;
			case "3":
				$where.=" and uface<>''";
				break;
			case '0':
				break;
		}
		$this->assign("where",$where);
		$this->assign("type",$type);
		$this->assign("keyword",$keyword);
		$this->display("module/user/index.php");
	}

	public function add()
	{
		if(IS_POST)
		{
			$data=[[F('t0'),'null','用户名不能为空'],[F('t1'),'null','密码不能为空'],[F('t2'),'email','邮箱格式错误']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select id from sd_user where uname='".F('t0')."' limit 1");
				if($rs)
				{
					$this->error('用户名已存在');
				}
				elseif($this->db->row("select id from sd_user where uemail='".F('t2')."' limit 1"))
				{
					$this->error('邮箱已存在');
				}
				else
				{
					$d['uname']=F('t0');
					$d['upass']=md5(F('t1'));
					$d['uemail']=F('t2');
					$d['uid']=getint(F('t3'),0);
					$d['islock']=getint(F('t4'),0);
					$d['uface']='';
					$d['regdate']=time();
					$d['regip']=getip();
					$d['lastlogindate']=time();
					$d['lastloginip']='';
					$d['logintimes']=0;
					$this->db->add('sd_user',$d);
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
			$this->display("module/user/add.php");
		}
	}

	public function edit()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','用户名不能为空'],[F('t2'),'email','邮箱格式错误']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['uname']=F('t0');
				if(strlen(F('t1')))
				{
					$d['upass']=md5(F('t1'));
				}
				$d['uemail']=F('t2');
				$d['uid']=getint(F('t3'),0);
				$d['islock']=getint(F('t4'),0);
				$t5=getint(F('t5'),0);
				$t6=getint(F('t6'),0);
				$this->db->update('sd_user','id='.$id.'',$d);
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
			$rs=$this->db->row("select * from sd_user where id=".$id." limit 1");
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$this->assign($key,$val);
				}
				$this->display("module/user/edit.php");
			}
		}
	}

	public function clear()
	{
		$id=getint(F('get.id'),0);
		$rs=$this->db->row("select uface from sd_user where id=$id");
		if($rs)
		{
			$uface=$rs['uface'];
			if(!empty($uface))
			{
				if(substr($uface,0,8)=='/upfile/')
				{
					$uface=str_replace('/upfile/','upfile/',$uface);
					@unlink($uface);
				}
				$this->db->update("sd_user","id=$id",['uface'=>'']);
			}
		}
		$this->success('清除成功');
		$this->add_log($this->msg);
	}


	public function del()
	{
		$id=getint(F('get.id'),0);
		$this->db->del('sd_user',"id=$id");
		$this->db->del('sd_user_login',"userid=$id");
		$this->db->del('sd_order',"userid=$id");
		$this->success('删除成功');
		$this->add_log($this->msg);
	}

	public function gouser()
	{
		$id=getint(F('get.id'),0);
		$rs=$this->db->row("select id,uname,upass,islock,logintimes,uid from sd_user where id=$id limit 1");
		if(!$rs)
		{
			die('用户不存在');
		}
		else
		{
			session('user_info',$rs);
			go(N('user'));
		}
	}

}