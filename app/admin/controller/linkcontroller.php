<?php
/**
 * 作用：友情链接
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class LinkController extends AdminsController
{
	public function config()
	{
		if(IS_POST)
		{
			$id=getint(F('get.id'),0);
			$data=$this->db->load("select id,ckey,ctype from sd_config where islock=1 and gid=$id order by ordnum,id");
			if(count($data)==0)
			{
				$this->error('没有数据可保存');
			}
			else
			{
				foreach ($data as $key=>$rs)
				{
					$cid=$rs['id'];
					$var='';
					if($rs['ctype']==7)
					{
						$array=F($rs['ckey']);
						if(is_array($array))
						{
							$var=implode(',',$array);
						}
						unset($array);
					}
					else
					{
						$var=F($rs['ckey']);			
					}
					$this->db->update('sd_config','id='.$cid.'',['cvalue'=>$var]);
				}
				$this->success('保存成功');
				$rs=$this->db->load("select ckey,cvalue from sd_config where islock=1 and ctype<9 order by ordnum,id");
				$data=[];
		        foreach ($rs as $c)
		        {
		            $data[strtoupper($c['ckey'])] = $c['cvalue'];
		        }
				$data="<?php\nif(!defined('IN_SDCMS')) exit;\nreturn ".var_export($data, true).";\n?>";
				file_put_contents('app/lib/config/config.php', $data);
			}
			$this->add_log($this->msg);
		}
		else
		{
			$this->display("module/link/config.php");
		}
	}

	public function btach()
	{
		$type=getint(F('get.type'),0);
		$id=F('get.id');
		switch ($type)
		{
			case '1':
				self::btach_some("islock",1,$id);
				break;
			case '2':
				self::btach_some("islock",0,$id);
				break;
			case '3':
				self::btach_clear($id);
				break;
		}
		$this->success('操作成功');
		$this->add_log($this->msg);
	}

	public function btach_clear($id)
	{
		$arr=explode(',',$id);
		foreach ($arr as $key=>$val)
		{
			$this->db->del('sd_link','id='.$val.'');
		}
	}

	public function btach_some($field,$val,$id)
	{
		$d=[];
		$d[$field]=$val;
		$this->db->update("sd_link",'id in('.$id.')',$d);
	}

	public function index()
	{
		if(IS_POST)
		{
			$mid=F('mid');
			$ordnum=F('ordnum');
			foreach($mid as $key=>$val)
			{
				$this->db->update('sd_link','id='.$val.'',['ordnum'=>$ordnum[$key]]);
			}
			$this->success('保存成功');
			$this->add_log($this->msg);
		}
		else
		{
			$type=getint(F('get.type'),0);
			$where='1=1 ';
			switch ($type)
			{
				case '1':
					$where.=' and islock=0';
					break;
				case "2":
					$where.=' and islock=1';
					break;
				case "3":
					$where.=' and islogo=0';
					break;
				case "4":
					$where.=' and islogo=1';
					break;
				case '0':
					break;
			}
			$this->assign("where",$where);
			$this->assign("type",$type);
			$this->display("module/link/index.php");
		}
	}

	public function add()
	{
		if(IS_POST)
		{
			$data=[[F('t0'),'null','网站名称不能为空'],[F('t2'),'null','网址不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select * from sd_link where webname='".F('t0')."' limit 1");
				if($rs)
				{
					$this->error('网站名称已存在');
				}
				else
				{
					$d['webname']=F('t0');
					$d['weblogo']=F('t1');
					$d['weburl']=F('t2');
					$d['islogo']=strlen(F('t1'))==0?0:1;
					$d['classid']=getint(F('t3'),0);
					$d['ordnum']=getint(F('t4'),0);
					$d['islock']=getint(F('t5'),0);
					$this->db->add('sd_link',$d);
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
			$this->display("module/link/add.php");
		}
	}

	public function edit()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','网站名称不能为空'],[F('t2'),'null','网址不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['webname']=F('t0');
				$d['weblogo']=F('t1');
				$d['weburl']=F('t2');
				$d['islogo']=strlen(F('t1'))==0?0:1;
				$d['classid']=getint(F('t3'),0);
				$d['ordnum']=getint(F('t4'),0);
				$d['islock']=getint(F('t5'),0);
				$this->db->update('sd_link','id='.$id.'',$d);
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
			$rs=$this->db->row("select * from sd_link where id=".$id." limit 1");
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$this->assign($key,$val);
				}
				$this->display("module/link/edit.php");
			}
		}
	}

	public function del()
	{
		$id=getint(F('get.id'),0);
		$this->db->del('sd_link','id='.$id.'');
		$this->success('删除成功');
		$this->add_log($this->msg);
	}

}