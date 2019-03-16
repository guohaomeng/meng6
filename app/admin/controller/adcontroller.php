<?php
/**
 * 作用：广告管理
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class AdController extends AdminsController
{
	public function index()
	{
		if(IS_POST)
		{
			$mid=F('mid');
			$ordnum=F('ordnum');
			foreach($mid as $key=>$val)
			{
				$this->db->update('sd_ad','id='.$val.'',['ordnum'=>$ordnum[$key]]);
			}
			$this->success('保存成功');
			$this->add_log($this->msg);
		}
		else
		{
			$this->display("module/ad/index.php");
		}
	}

	public function add()
	{
		if(IS_POST)
		{
			$data=[[F('t0'),'null','广告名称不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select * from sd_ad where title='".F('t0')."' limit 1");
				if($rs)
				{
					$this->error('广告名称已存在');
				}
				else
				{
					$d['title']=F('t0');
					$d['datalist']=json_encode(F('t1'),JSON_UNESCAPED_UNICODE);
					$d['ordnum']=getint(F('t2'),0);
					$d['islock']=getint(F('t3'),0);
					$d['akey']='';
					$this->db->add('sd_ad',$d);
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
			$this->display("module/ad/add.php");
		}
	}

	public function edit()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','广告名称不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['title']=F('t0');
				$d['datalist']=json_encode(F('t1'),JSON_UNESCAPED_UNICODE);
				$d['ordnum']=getint(F('t2'),0);
				$d['islock']=getint(F('t3'),0);
				$this->db->update('sd_ad','id='.$id.'',$d);
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
			$rs=$this->db->row("select * from sd_ad where id=".$id." limit 1");
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$this->assign($key,$val);
				}
				$this->display("module/ad/edit.php");
			}
		}
	}

	public function del()
	{
		$id=getint(F('get.id'),0);
		$this->db->del('sd_ad',"id=".$id." and akey=''");
		$this->success('删除成功');
		$this->add_log($this->msg);
	}

}