<?php
/**
 * 插件：客服管理
 * By IT平民
**/

class AdminController extends PlugController
{
	public function __construct()
	{
		parent::__construct();
		if(!C('plug_service'))
		{
			die('插件未安装');
		}
		$this->check_admin();
	}

	public function cache()
	{
		$rs=$this->db->load("select qq,title from sd_plug_service where islock=1 order by ordnum,id");
		$data="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export($rs, true).";\n?>";
		file_put_contents('app/lib/config/plug_service.php', $data);
		unset($data);
	}

	public function Index()
	{
		if(IS_POST)
		{
			$mid=F('mid');
			$ordnum=F('ordnum');
			foreach($mid as $key=>$val)
			{
				$this->db->update('sd_plug_service','id='.$val.'',['ordnum'=>$ordnum[$key]]);
			}
			$this->success('保存成功');
			$this->add_log($this->msg);
			$this->cache();
		}
		else
		{
			$this->display("admin/index.php");
		}
	}

	public function add()
	{
		if(IS_POST)
		{
			$data=[[F('t0'),'null','客服名称不能为空'],[F('t1'),'null','QQ不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select * from sd_plug_service where title='".F('t0')."' limit 1");
				if($rs)
				{
					$this->error('客服名称已存在');
				}
				else
				{
					$d['title']=F('t0');
					$d['qq']=F('t1');
					$d['ordnum']=getint(F('t2'),0);
					$d['islock']=getint(F('t3'),0);
					$this->db->add('sd_plug_service',$d);
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
			$this->display("admin/add.php");
		}
	}

	public function edit()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','客服名称不能为空'],[F('t1'),'null','QQ不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['title']=F('t0');
				$d['qq']=F('t1');
				$d['ordnum']=getint(F('t2'),0);
				$d['islock']=getint(F('t3'),0);
				$this->db->update('sd_plug_service','id='.$id.'',$d);
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
			$rs=$this->db->row("select * from sd_plug_service where id=".$id." limit 1");
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$this->assign($key,$val);
				}
				$this->display("admin/edit.php");
			}
		}
	}

	public function del()
	{
		$id=getint(F('get.id'),0);
		$this->db->del('sd_plug_service','id='.$id.'');
		$this->success('删除成功');
		$this->add_log($this->msg);
		$this->cache();
	}

}