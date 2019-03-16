<?php
/**
 * 作用：留言管理
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class BookController extends AdminsController
{
	
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
				self::btach_some("ontop",1,$id);
				break;
			case '4':
				self::btach_some("ontop",0,$id);
				break;
			case '5':
				self::btach_del($id);
				break;
		}
		$this->success('操作成功');
		$this->add_log($this->msg);
	}

	public function btach_some($field,$val,$id)
	{
		$d=[];
		$d[$field]=$val;
		$this->db->update("sd_book",'id in('.$id.')',$d);
	}

	public function btach_del($id)
	{
		$this->db->del('sd_book','id in('.$id.')');
	}

	public function index()
	{
		$type=getint(F('get.type'),0);
		$where='1=1 ';
		$keyword=rawurldecode(F('get.keyword'));
		if(strlen($keyword)>0)
		{
			$where.=" and (truename like binary '%".$keyword."%' or tel like binary '%".$keyword."%' or mobile like binary '%".$keyword."%')";
		}
		switch ($type)
		{
			case '1':
				$where.=' and islock=0';
				break;
			case "2":
				$where.=' and islock=1';
				break;
			case '0':
				break;
		}
		$this->assign("where",$where);
		$this->assign("type",$type);
		$this->assign("keyword",$keyword);
		$this->display("module/book/index.php");
	}

	public function edit()
	{
		$id=getint(F('get.id'),0);
		if(IS_POST)
		{
			$data=[[F('t0'),'null','姓名称不能为空'],[F('t3'),'null','留言内容不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['truename']=F('t0');
				$d['tel']=F('t1');
				$d['mobile']=F('t2');
				$d['remark']=F('t3');
				$d['reply']=F('t4');
				if(strlen(F('t4'))!=0)
				{
					$d['replydate']=time();
				}
				$d['ontop']=getint(F('t5'),0);
				$d['islock']=getint(F('t6'),0);
				$this->db->update('sd_book','id='.$id.'',$d);
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
			$rs=$this->db->row("select * from sd_book where id=".$id." limit 1");
			if($rs)
			{
				foreach($rs as $key=>$val)
				{
					$this->assign($key,$val);
				}
				$this->display("module/book/edit.php");
			}
		}
	}

	public function del()
	{
		$id=getint(F('get.id'),0);
		self::btach_del($id);
		$this->success('删除成功');
		$this->add_log($this->msg);
	}

}