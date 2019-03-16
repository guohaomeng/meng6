<?php
/**
 * 作用：前端相关程序
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class OtherController extends HomeController
{
	public function test()
	{
		
	}

	#标签
	public function tags()
	{
		$this->display(T('tags'));
	}

	#标签列表
	public function taglist()
	{
		$tagname=rawurldecode($_GET['tagname']);
		$encode=mb_detect_encoding($tagname,['UTF-8','GBK','GB2312']);
		if($encode!='UTF-8')
		{
			$tagname=mb_convert_encoding($tagname,'utf-8',$encode);   
		}
		$tagname=enhtml($tagname);
		if(isempty($tagname))
		{
			$this->assign("data",['msg'=>'标签不能为空','url'=>'']);
			$this->display(T('error'));
			return;
		}
		$where="islock=1 and (title like binary '%$tagname%' or tags like binary '%$tagname%')";
		$this->assign('tagname',$tagname);
		$this->assign('where',$where);
		$this->display(T('taglist'));
	}

	#搜索
	public function search()
	{
		$keyword=isset($_GET['keyword'])?rawurldecode(trim($_GET['keyword'])):'';
		if(isempty($keyword))
		{
			$this->assign("data",['msg'=>'关键字不能为空','url'=>'']);
			$this->display(T('error'));
			return;
		}
		else
		{
			$encode=mb_detect_encoding($keyword,['UTF-8','GBK','GB2312']);
			if($encode!='UTF-8')
			{
				$keyword=mb_convert_encoding($keyword,'utf-8',$encode);   
			}
			$keyword=enhtml($keyword);
		}
		$where="islock=1 and ( title like binary '%$keyword%' or intro like binary '%$keyword%' )";
		$this->assign('keyword',$keyword);
		$this->assign('where',$where);
		$this->display(T('search'));
	}

	#赞一下
	public function digs()
	{
		if(IS_POST)
		{
			$id=getint(F("get.id"),0);
			$act=F("get.act");
			if(getint(cookie('digs_'.$id.''),0)==1)
			{
				$this->error('您已赞或踩过');
			}
			else
			{
				$rs=$this->db->row("select upnum,downnum from sd_content where islock=1 and id=$id limit 1");
				if($rs)
				{
					$old=0;
					$field='';
					switch ($act)
					{
						case 'up':
							$old=$rs['upnum']+1;
							$field='upnum';
							break;
						case 'down':
							$old=$rs['downnum']+1;
							$field='downnum';
							break;
						default:
							break;
					}
					if($field!='')
					{
						$d[$field]=$old;
						$this->db->update("sd_content","id=$id",$d);
						cookie('digs_'.$id.'',1);
						$this->success($old);
					}
				}		
			}
		}
	}

	#留言
	public function book()
	{
		if(IS_POST)
		{
			$userip=getip();
			#获取IP用户上次留言时间
			$rs=$this->db->row("select createdate from sd_book where postip='$userip' order by id desc limit 1");
			if($rs)
			{
				#默认1分钟
				if((time()-$rs['createdate'])/60<1)
				{
					$this->error('留言提交太频繁');
					return;
				}
			}
			if(F('mobile')==''&&F('tel')=='')
			{
				$this->error('请至少填写一种联系方式');
				return;
			}
			if(F('mobile')!='')
			{
				if(!sdcms_verify::check(F('mobile'),'mobile',''))
				{
					$this->error('手机号码不正确');
					return;
				}
			}
			if(F('tel')!='')
			{
				if(!sdcms_verify::check(F('tel'),'tel',''))
				{
					$this->error('电话号码不正确');
					return;
				}
			}
			$data=[[F('truename'),'null','姓名不能为空'],[F('remark'),'null','留言内容不能为空']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['truename']=F('truename');
				$d['mobile']=F('mobile');
				$d['tel']=F('tel');
				$d['remark']=F('remark');
				$d['islock']=0;
				$d['ontop']=0;
				$d['reply']='';
				$d['postip']=$userip;
				$d['createdate']=time();
				$this->db->add('sd_book',$d);
				$this->success('提交成功');

				#处理邮件
				if(!isempty(C('mail_admin')))
				{
					#获取邮件模板
					$mail=$this->mail_temp(0,'book',$this->db);
					if(count($mail)>0)
					{
						$title=$mail['mail_title'];
						$title=str_replace('$webname',C('web_name'),$title);
						$title=str_replace('$weburl',WEB_URL,$title);
						$content=$mail['mail_content'];
						$content=str_replace('$webname',C('web_name'),$content);
						$content=str_replace('$weburl',WEB_URL,$content);
						$content=str_replace('$name',F('truename'),$content);
						$content=str_replace('$mobile',F('mobile'),$content);
						$content=str_replace('$tel',F('tel'),$content);
						$content=str_replace('$remark',F('remark'),$content);
						#发邮件
						send_mail(C('mail_admin'),$title,$content);
					}
				}
			}
			else
			{
				$this->error($v->msg);
			}
		}
		else
		{
			$this->display(T('book'));
		}
	}

	#询价
	public function inquiry()
	{
		if(IS_POST)
		{
			$id=getint(F("get.id"),0);
			$userip=getip();
			#获取IP用户上次提交时间
			$rs=$this->db->row("select createdate from sd_inquiry where postip='$userip' order by id desc limit 1");
			if($rs)
			{
				#默认1分钟
				if((time()-$rs['createdate'])/60<1)
				{
					$this->error('提交太频繁');
					return;
				}
			}
			$rs=$this->db->row("select title from sd_model_pro left join sd_content on sd_model_pro.cid=sd_content.id where islock=1 and id=$id limit 1");
			if(!$rs)
			{
				$this->error('参数错误');
			}
			else
			{
				$proname=enhtml($rs['title']);
				$data=[[F('truename'),'null','姓名不能为空'],[F('mobile'),'mobile','手机号码不正确'],[F('remark'),'null','询价内容不能为空']];
				$v=new sdcms_verify($data);
				if($v->result())
				{
					$d['title']=$proname;
					$d['truename']=F('truename');
					$d['mobile']=F('mobile');
					$d['remark']=F('remark');
					$d['isover']=0;
					$d['postip']=$userip;
					$d['createdate']=time();
					$this->db->add('sd_inquiry',$d);
					$this->success('提交成功');

					#处理邮件
					if(!isempty(C('mail_admin')))
					{
						#获取邮件模板
						$mail=parent::mail_temp(0,'inquiry');
						if(count($mail)>0)
						{
							$title=$mail['mail_title'];
							$title=str_replace('$webname',C('web_name'),$title);
							$title=str_replace('$weburl',WEB_URL,$title);
							$content=$mail['mail_content'];
							$content=str_replace('$webname',C('web_name'),$content);
							$content=str_replace('$weburl',WEB_URL,$content);
							$content=str_replace('$proname',$proname,$content);
							$content=str_replace('$name',F('truename'),$content);
							$content=str_replace('$mobile',F('mobile'),$content);
							$content=str_replace('$remark',F('remark'),$content);
							#发邮件
							send_mail(C('mail_admin'),$title,$content);
						}
					}
				}
				else
				{
					$this->error($v->msg);
				}
			}
		}
	}

	#订单
	public function order()
	{
		if(IS_POST)
		{
			$id=getint(F("get.id"),0);
			$userip=getip();
			$userid=USER_ID;
			if(C('web_order_login')==1)
			{
				if($userid==0)
				{
					$this->error('请先登录或注册');
					return;
				}
			}
			#获取IP用户上次提交时间
			$rs=$this->db->row("select createdate from sd_order where postip='$userip' and userid=$userid order by id desc limit 1");
			if($rs)
			{
				#默认1分钟
				if((time()-$rs['createdate'])/60<1)
				{
					$this->error('提交太频繁');
					return;
				}
			}
			$rs=$this->db->row("select title,price from sd_model_pro left join sd_content on sd_model_pro.cid=sd_content.id where islock=1 and id=$id limit 1");
			if(!$rs)
			{
				$this->error('参数错误');
			}
			else
			{
				$proname=enhtml($rs['title']);
				$price=$rs['price'];
				$data=[[F('truename'),'null','姓名不能为空'],[F('mobile'),'mobile','手机号码不正确'],[F('pronum'),'int','订购数量不能为空'],[(getint(F('pronum'),0)!=0),'other','订购数量不能为空'],[F('address'),'null','收货地址不能为空']];
				$v=new sdcms_verify($data);
				if($v->result())
				{
					$orderid=date('YmdHis').mt_rand(0,9);
					$d['pro_name']=$proname;
					$d['pro_num']=getint(F('pronum'),0);
					$d['pro_price']=getint(F('pronum'),0)*$price;
					$d['orderid']=$orderid;
					$d['truename']=F('truename');
					$d['mobile']=F('mobile');
					$d['address']=F('address');
					$d['remark']=F('remark');
					$d['ispay']=0;
					$d['isover']=0;
					$d['createdate']=time();
					$d['postip']=$userip;
					$d['userid']=$userid;
					$this->db->add('sd_order',$d);
					$this->success(U('other/ordershow','orderid='.$orderid.''));
					
					#处理邮件
					if(!isempty(C('mail_admin')))
					{
						#获取邮件模板
						$mail=parent::mail_temp(0,'order');
						if(count($mail)>0)
						{
							$title=$mail['mail_title'];
							$title=str_replace('$webname',C('web_name'),$title);
							$title=str_replace('$weburl',WEB_URL,$title);
							$content=$mail['mail_content'];
							$content=str_replace('$webname',C('web_name'),$content);
							$content=str_replace('$weburl',WEB_URL,$content);
							$content=str_replace('$orderid',$orderid,$content);
							$content=str_replace('$proname',$proname,$content);
							$content=str_replace('$num',getint(F('pronum'),0),$content);
							$content=str_replace('$money',getint(F('pronum'),0)*$price,$content);
							$content=str_replace('$name',F('truename'),$content);
							$content=str_replace('$mobile',F('mobile'),$content);
							$content=str_replace('$address',F('address'),$content);
							$content=str_replace('$remark',F('remark'),$content);
							#发邮件
							send_mail(C('mail_admin'),$title,$content);
						}
					}
				}
				else
				{
					$this->error($v->msg);
				}
			}
		}
	}

	public function ordershow()
	{
		$orderid=enhtml(F('get.orderid'));
		if(IS_POST)
		{
			$rs=$this->db->row("select pro_price from sd_order where orderid='$orderid' and ispay=1 limit 1");
			if($rs)
			{
				echo '1';
			}
			else
			{
				echo '0';
			}
		}
		else
		{
			if(isempty($orderid))
			{
				$this->assign("data",['msg'=>'订单号不能为空','url'=>'']);
				$this->display(T('error'));
				return;
			}
			$rs=$this->db->row("select * from sd_order where orderid='$orderid' limit 1");
			if(!$rs)
			{
				$this->assign("data",['msg'=>'订单号错误','url'=>'']);
				$this->display(T('error'));
				return;
			}
			foreach($rs as $key=>$val)
			{
				$this->assign($key,$val);
			}
			$this->assign('orderid',$orderid);
			$this->display(T('ordershow'));
		}
		
	}

	public function sitemap()
	{
		$this->display(T('sitemap'));
	}
	
}