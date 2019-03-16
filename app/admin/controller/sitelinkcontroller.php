<?php
/**
 * 作用：内链管理
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class SitelinkController extends AdminsController
{
	public function index()
	{
		if(IS_POST)
		{
			$mid=F('mid');
			$ordnum=F('ordnum');
			foreach($mid as $key=>$val)
			{
				$this->db->update('sd_sitelink','id='.$val.'',['ordnum'=>$ordnum[$key]]);
			}
			$this->success('保存成功');
			$this->add_log($this->msg);
			$this->cache();
		}
		else
		{
			$this->display("module/sitelink/index.php");
		}
	}

	public function cache()
	{
		$rs=$this->db->load("select title,url,num from sd_sitelink where islock=1 order by ordnum,id");
		$data="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export($rs, true).";\n?>";
		file_put_contents('app/lib/config/sitelink.php', $data);
		unset($data);
	}

	public function add()
	{
		if(IS_POST)
		{
			$data=[[F('t0'),'null','关键字不能为空'],[F('t1'),'null','链接网址不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select * from sd_sitelink where title='".F('t0')."' limit 1");
				if($rs)
				{
					$this->error('关键字已存在');
				}
				else
				{
					$d['title']=F('t0');
					$d['url']=F('t1');
					$d['num']=getint(F('t2'),0);
					$d['ordnum']=getint(F('t3'),0);
					$d['islock']=getint(F('t4'),0);
					$this->db->add('sd_sitelink',$d);
					$this->success('添加成功');
					$this->cache();
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
			$this->display("module/sitelink/add.php");
		}
	}

	public function edit()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','关键字不能为空'],[F('t1'),'null','链接网址不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['title']=F('t0');
				$d['url']=F('t1');
				$d['num']=getint(F('t2'),0);
				$d['ordnum']=getint(F('t3'),0);
				$d['islock']=getint(F('t4'),0);
				$this->db->update('sd_sitelink','id='.$id.'',$d);
				$this->success('保存成功');
				$this->cache();
			}
			else
			{
				$this->error($v->msg);
			}
			$this->add_log($this->msg);
		}
		else
		{
			$rs=$this->db->row("select * from sd_sitelink where id=".$id." limit 1");
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$this->assign($key,$val);
				}
				$this->display("module/sitelink/edit.php");
			}
		}
	}

	public function del()
	{
		$id=getint(F('get.id'),0);
		$this->db->del('sd_sitelink',"id=".$id."");
		$this->success('删除成功');
		$this->add_log($this->msg);
		$this->cache();
	}

}