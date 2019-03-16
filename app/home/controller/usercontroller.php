<?php
/**
 * 作用：会员程序
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class UserController extends HomeController
{

	public function Index()
	{
		self::check();
		$strTimeToString="000111222334455556666667";
		$strWenhou=array('夜深了！','凌晨了！','早上好！','上午好！','中午好！','下午好！','晚上好！','夜深了！');
		$this->assign('userid',USER_ID);
		$this->assign('welcome',$strWenhou[(int)$strTimeToString[(int)date('G',time())]]);
		$this->display(T('user'));
	}

	public function face()
	{
		$userid=USER_ID;
		if($userid==0)
		{
			echo json_encode(['state'=>'error','msg'=>'登录超时'],JSON_UNESCAPED_UNICODE);
			return;
		}
		else
		{
			$up=new sdcms_upload('file',1,0,0,1,200);
			if($up->state=='success')
			{
				#删除原来的头像
				$rs=$this->db->row("select uface from sd_user where id=$userid limit 1");
				if($rs)
				{
					if(strlen($rs['uface'])&&!strpos($rs['uface'],'http'))
					{
						@unlink(str_replace(WEB_ROOT.'upfile/','upfile/',$rs['uface']));
					}
				}
				#替换头像
				$uface=$up->msg;
				$this->db->update('sd_user','id='.$userid.'',['uface'=>$uface]);
			}
			echo $up->showmsg();
		}
	}

	public function myorder()
	{
		self::check();
		$type=getint(F('get.type'),0);
		$userid=USER_ID;
		$where="userid=$userid";
		switch ($type)
		{
			case '1':
				$where.=' and ispay=1';
				break;
			case '2':
				$where.=' and ispay=0';
				break;
		}
		$this->assign('userid',USER_ID);
		$this->assign('type',$type);
		$this->assign('where',$where);
		$this->display(T('myorder'));
	}

	public function editemail()
	{
		self::check();
		if(IS_POST)
		{
			$userid=USER_ID;
			$email=trim(F('email'));
			$data=[[$email,'email','邮箱格式不正确']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select id from sd_user where uemail='$email' and id<>$userid limit 1");
				if($rs)
				{
					$this->error('邮箱已存在，请更换');
				}
				else
				{
					$this->db->update('sd_user','id='.$userid.'',['uemail'=>$email]);
					$this->success('修改成功');
				}
			}
			else
			{
				$this->error($v->msg);
			}
		}
		else
		{
			$this->assign('userid',USER_ID);
			$this->display(T('editemail'));
		}
	}

	public function editpass()
	{
		self::check();
		if(IS_POST)
		{
			$data=[[F('oldpass'),'null','原密码不能为空'],[md5(F('oldpass'))==get_user_info('upass'),'other','原密码错误'],[F('newpass'),'null','新密码不能为空'],[F('repass'),'null','确认密码不能为空'],[F('newpass')==F('repass'),'other','两次密码不一致']];
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$d['upass']=md5(F('newpass'));
				$this->db->update('sd_user','id='.USER_ID.'',$d);
				$a=session('user_info');
				$a['upass']=md5(F('newpass'));
				session('user_info',$a);
				$this->success('修改成功');
			}
			else
			{
				$this->error($v->msg);
			}
		}
		else
		{
			$this->display(T('editpass'));
		}
	}

	public function regcode()
	{
		if(IS_POST)
		{
			if(C('mail_type')==0)
			{
				$this->error('未开启邮件设置');
				return;
			}
			$code=session('ucode');
			$email=F('email');
			$data=[
				[$email,'email','邮箱格式不正确']
			];
			if(C('user_reg_auth')==1)
			{
				$data=array_merge($data,[[F('code'),'null','验证码不能为空'],[$code,'null','无法获取系统验证码'],[$code==md5(strtolower(F('code'))),'other','验证码不正确']]);
			}
			if(session('regcode')!='')
			{
				if((time()-session('regcode'))<60)
				{
					$this->error('操作太快');
					return;
				}
			}
			#检查邮箱是否已被注册
			$rs=$this->db->row("select id from sd_user where uemail='".$email."' limit 1");
			if($rs)
			{
				$this->error('邮箱已被使用过，请更换。');
				return;
			}
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rnd=mt_rand(10000,99999);
				$rs=$this->db->row("select id from sd_code where email='".$email."' and types=1 and isover=0 limit 1");
				if($rs)
				{
					$this->db->update("sd_code","id=".$rs['id']."",['code'=>$rnd,'createdate'=>time()]);
				}
				else
				{
					$this->db->add("sd_code",['email'=>$email,'code'=>$rnd,'createdate'=>time(),'types'=>1,'isover'=>0]);
				}
				#发邮件
				$mail=parent::mail_temp(0,'reg');
				if(count($mail)>0)
				{
					$title=$mail['mail_title'];
					$content=$mail['mail_content'];
					$content=str_replace('$code',$rnd,$content);
					send_mail($email,$title,$content);
					session('regcode',time());
					$this->success('发送成功，请至邮箱查找验证码');
				}
				else
				{
					$this->error('找不到邮件模板');
				}
			}
			else
			{
				$this->error($v->msg);
			}
		}
		else
		{
			$this->error('参数错误');
		}
	}

	public function getpasscode()
	{
		if(IS_POST)
		{
			if(C('mail_type')==0)
			{
				$this->error('未开启邮件设置');
				return;
			}
			$code=session('ucode');
			$email=F('email');
			$data=[
				[$email,'email','邮箱格式不正确']
			];
			if(C('user_getpass_auth')==1)
			{
				$data=array_merge($data,[[F('code'),'null','验证码不能为空'],[$code,'null','无法获取系统验证码'],[$code==md5(strtolower(F('code'))),'other','验证码不正确']]);
			}
			if(session('getpasscode')!='')
			{
				if((time()-session('getpasscode'))<60)
				{
					$this->error('操作太快');
					return;
				}
			}
			#检查邮箱是否已被注册
			$rs=$this->db->row("select id from sd_user where uemail='".$email."' limit 1");
			if(!$rs)
			{
				$this->error('邮箱不存在，请检查。');
				return;
			}
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rnd=mt_rand(10000,99999);
				$rs=$this->db->row("select id from sd_code where email='".$email."' and types=2 and isover=0 limit 1");
				if($rs)
				{
					$this->db->update("sd_code","id=".$rs['id']."",['code'=>$rnd,'createdate'=>time()]);
				}
				else
				{
					$this->db->add("sd_code",['email'=>$email,'code'=>$rnd,'createdate'=>time(),'types'=>2,'isover'=>0]);
				}
				#发邮件
				$mail=parent::mail_temp(0,'getpass');
				if(count($mail)>0)
				{
					$title=$mail['mail_title'];
					$content=$mail['mail_content'];
					$content=str_replace('$code',$rnd,$content);
					send_mail($email,$title,$content);
					session('getpasscode',time());
					$this->success('发送成功，请至邮箱查找验证码');
				}
				else
				{
					$this->error('找不到邮件模板');
				}
			}
			else
			{
				$this->error($v->msg);
			}
		}
		else
		{
			$this->error('参数错误');
		}
	}

	public function getpass()
	{
		if(IS_POST)
		{
			if(C('mail_type')==0)
			{
				$this->error('未开启邮件设置');
				return;
			}
			$code=session('ucode');
			$email=F('email');
			$data=[
				[$email,'email','邮箱格式不正确'],
				[F('ecode'),'null','邮箱验证码不能为空'],
				[F('password'),'password','密码为5-16位字符'],
				[F('repass'),'password','确认密码为5-16位字符'],
				[F('password')==F('repass'),'other','两次密码输入不一致']
			];
			if(C('user_getpass_auth')==1)
			{
				$data=array_merge($data,[[F('code'),'null','验证码不能为空'],[$code,'null','无法获取系统验证码'],[$code==md5(strtolower(F('code'))),'other','验证码不正确']]);
			}

			$eid=0;
			$rs=$this->db->row("select id,code from sd_code where email='".$email."' and types=2 and isover=0 limit 1");
			if(!$rs)
			{
				$data=array_merge([[1!=1,'other','邮箱不存在，请检查']]);
			}
			elseif(F('ecode')!=$rs['code'])
			{
				$data=array_merge([[1!=1,'other','邮箱验证码不正确']]);
			}
			else
			{
				$eid=$rs['id'];
			}	
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select id from sd_user where uemail='".$email."' limit 1");
				if(!$rs)
				{
					$this->error('邮箱不存在，请检查');
				}
				else
				{
					$this->db->update('sd_user','id='.$rs['id'].'',['upass'=>md5(F('repass'))]);
					if($eid>0)
					{
						$this->db->update("sd_code","id=".$eid."",['isover'=>1]);
						session('getpasscode','[del]');
					}
					$this->success('密码修改成功');
				}
			}
			else
			{
				$this->error($v->msg);
			}
		}
		else
		{
			if(C('mail_type')==0)
			{
				$this->assign("data",['msg'=>'未开启邮件设置，请联系管理员找回密码。','url'=>'']);
				$this->display(T('error'));
			}
			else
			{
				$this->display(T('getpass'));
			}
			
		}
	}

	public function reg()
	{
		if(IS_POST)
		{
			if(C('user_open')==2)
			{
				$this->error('系统未开启会员注册');
				return;
			}
			$code=session('ucode');
			$email=F('email');
			$data=[
				[F('username'),'username','用户名为3-12位字符'],
				[F('password'),'password','密码为5-16位字符'],
				[F('repass'),'password','确认密码为5-16位字符'],
				[F('username')!=F('password'),'other','不能使用用户名作为密码'],
				[F('password')==F('repass'),'other','两次密码输入不一致'],
				[$email,'email','邮箱格式不正确']
			];
			if(C('user_reg_auth')==1)
			{
				$data=array_merge($data,[[F('code'),'null','验证码不能为空'],[$code,'null','无法获取系统验证码'],[$code==md5(strtolower(F('code'))),'other','验证码不正确']]);
			}
			if(strlen(C('user_badname')))
			{
				$badname=explode('|',C('user_badname'));
				$data=array_merge($data,[[!(in_array(F('username'),$badname)),'other','系统禁止注册此用户名']]);
			}
			$eid=0;
			#如果是邮箱验证，则需要验证验证码
			if(C('user_reg_type')==2&&C('mail_type')>0)
			{
				$data=array_merge($data,[[F('ecode'),'null','邮箱验证码不能为空']]);
				$rs=$this->db->row("select id,code from sd_code where email='".$email."' and types=1 and isover=0 limit 1");
				if(!$rs)
				{
					$data=array_merge([[1!=1,'other','邮箱不存在，请检查']]);
				}
				elseif(F('ecode')!=$rs['code'])
				{
					$data=array_merge([[1!=1,'other','邮箱验证码不正确']]);
				}
				else
				{
					$eid=$rs['id'];
				}
			}
			$v=new sdcms_verify($data);
			if($v->result())
			{
				if($this->db->row("select id from sd_user where uname='".F('username')."' limit 1"))
				{
					$this->error('用户名已存在，请更换');
					return;
				}
				if($this->db->row("select id from sd_user where uemail='".$email."' limit 1"))
				{
					$this->error('邮箱已存在，请更换');
					return;
				}				
				$d['uname']=F('username');
				$d['upass']=md5(F('password'));
				$d['uemail']=$email;
				$d['uface']='';
				#获取默认加入的会员组
				$d['uid']=isempty(C('user_reg_group'))?0:C('user_reg_group');
				$d['islock']=(C('user_reg_type')==3)?0:1;
				$d['regdate']=time();
				$d['regip']=getip();
				$d['lastlogindate']=time();
				$d['logintimes']=(C('user_reg_type')==3)?0:1;
				$this->db->add('sd_user',$d);
				$userid=$this->db->newid;
				#新增OpenId
				$openid=session('api_login_openid');
				$apiuser=session('api_login_info');
				if(!isempty($openid))
				{
					$this->db->add('sd_user_login',['userid'=>$userid,'type'=>$apiuser['type'],'openid'=>$openid]);
					#保存用户头像
					$this->db->update('sd_user','id='.$userid.'',['uface'=>$apiuser['face']]);
					#清理数据
					session('api_login_openid','[del]');
					session('api_login_info','[del]');
				}
				$arr['state']='success';
				#更新邮箱验证码状态
				if($eid>0)
				{
					$this->db->update("sd_code","id=".$eid."",['isover'=>1]);
					session('sendcode','[del]');
				}
				if(C('user_reg_type')!=3)
				{
					#直接变登录状态
					$rs=$this->db->row("select id,uname,upass,islock,logintimes,uid,uface from sd_user where uname='".F('username')."' limit 1");
					session('user_info',$rs);
					$this->success('注册成功');
				}
				else
				{
					$this->success('注册成功，您的账户需要审核后才能登录');
				}

			}
			else
			{
				$this->error($v->msg);
			}
		}
		else
		{
			if(USER_ID!=0)
			{
				Go(N('user'));
			}
			if(C('user_open')==2)
			{
				$this->assign("data",['msg'=>'系统未开启会员注册','url'=>'']);
				$this->display(T('error'));
				return;
			}
			$apiuser=session('api_login_openid');
			if(!isempty($apiuser))
			{
				$ispai=1;
				$api_info=session('api_login_info');
			}
			else
			{
				$ispai=0;
				$api_info='';
			}
			$this->assign('ispai',$ispai);
			$this->assign('api_info',$api_info);
			$this->display(T('reg'));
		}
		
	}

	public function login()
	{
		if(IS_POST)
		{
			$code=session('ucode');
			$data=[
				[F('username'),'username','用户名为3-12位字符'],
				[F('password'),'password','密码为5-16位字符']
			];
			if(C('user_login_auth')==1)
			{
				$data=array_merge($data,[[F('code'),'null','验证码不能为空'],[$code,'null','无法获取系统验证码'],[$code==md5(strtolower(F('code'))),'other','验证码不正确']]);
			}
			$v=new sdcms_verify($data);
			if($v->result())
			{
				$rs=$this->db->row("select id,uname,upass,islock,logintimes,uid,uface from sd_user where uname='".F('username')."' and upass='".md5(F('password'))."' limit 1");
				if(!$rs)
				{
					$this->error('用户名或密码错误');
				}
				else
				{
					if($rs['islock']==0)
					{
						$this->error('用户被锁定，不能登录');
					}
					else
					{
						$uface=$rs['uface'];
						unset($rs['uface']);
						$userid=$rs['id'];
						$logintimes=$rs['logintimes'];
						session('user_info',$rs);
						$this->db->update('sd_user','id='.$userid.'',['logintimes'=>$logintimes+1,'lastlogindate'=>time(),'lastloginip'=>getip()]);
						#新增OpenId
						$openid=session('api_login_openid');
						$apiuser=session('api_login_info');
						if(!isempty($openid))
						{
							$this->db->add('sd_user_login',['userid'=>$userid,'type'=>$apiuser['type'],'openid'=>$openid]);
							if($uface=='')
							{
								#保存用户头像
								$this->db->update('sd_user','id='.$userid.'',['uface'=>$apiuser['face']]);
							}
							#清理数据
							session('api_login_openid','[del]');
							session('api_login_info','[del]');
						}
						$this->success('登录成功');
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
			if(USER_ID!=0)
			{
				Go(N('user'));
			}
			$lasturl=PRE_URL;
			if(!strlen($lasturl))
			{
				$lasturl=N('user');
			}
			else
			{
				if(strrpos($lasturl,'reg')||strrpos($lasturl,'login')||strrpos($lasturl,'getpass'))
				{
					$lasturl=N('user');
				}
			}
			$apiuser=session('api_login_openid');
			if(!isempty($apiuser))
			{
				$lasturl=N('user');
				$ispai=1;
				$api_info=session('api_login_info');
			}
			else
			{
				$ispai=0;
				$api_info='';
			}
			session("lasturl",$lasturl);
			$this->assign('ispai',$ispai);
			$this->assign('api_info',$api_info);
			$this->assign('lasturl',$lasturl);
			$this->display(T('login'));
		}
	}

	public function out()
	{
		session('user_info','[del]');
		Go(N('login'));
	}

	public function apiout()
	{
		#清理数据
		session('api_login_openid','[del]');
		session('api_login_info','[del]');
		Go(PRE_URL);
	}

	private function check()
	{
		if(USER_ID==0)
		{
			Go(N('login'));
		}
	}

	public function code()
	{
		$c=new sdcms_captcha();
        $c->doimg();
        $code=$c->getCode();
        session('ucode',$code);
	}

}