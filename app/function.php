<?php
/**
 * 作用：常用函数
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

#系统资源
function C($a=null)
{
	static $_config=[];
	if(empty($a))
	{
		return $_config;
	}
	if(is_string($a))
	{
		if(!strpos($a,'.'))
		{
			$a=strtoupper($a);
			return isset($_config[$a])?$_config[$a]:null;
		}
		else
		{
			$a=explode('.',$a);
			$a[0]=strtoupper($a[0]);
			return isset($_config[$a[0]][$a[1]])?$_config[$a[0]][$a[1]]:null;
		}
	}
	if(is_array($a))
	{
		$_config=array_merge($_config,array_change_key_case($a,CASE_UPPER));
		return null;
	}
	return null;
}

#模板资源
function T($a=null)
{
	static $_theme=[];
	if(empty($a))
	{
		return $_theme;
	}
	if(is_string($a))
	{
		if(!strpos($a,'.'))
		{
			$a=strtoupper($a);
			return isset($_theme[$a])?$_theme[$a]:null;
		}
		else
		{
			$a=explode('.',$a);
			$a[0]=strtoupper($a[0]);
			return isset($_theme[$a[0]][$a[1]])?$_theme[$a[0]][$a[1]]:null;
		}
	}
	if(is_array($a))
	{
		$_theme=array_merge($_theme,array_change_key_case($a,CASE_UPPER));
		return null;
	}
	return null;
}

#F函数（get和post）
function F($a,$b='')
{
	$a=strtolower($a);
	if(!strpos($a,'.'))
	{
		$method='other';
	}
	else
	{
		list($method,$a)=explode('.',$a,2);
	}
	switch ($method)
	{
		case 'get':
			$input=$_GET;
			break;
		case 'post':
			$input=$_POST;
			break;
		case 'other':
			switch (REQUEST_METHOD)
			{
				case 'GET':
					$input=$_GET;
					break;
				case 'POST':
					$input=$_POST;
					break;
				default:
					return '';
					break;
			}
			break;
		default:
			return '';
			break;
	}
	$data=isset($input[$a])?$input[$a]:$b;
	if(is_string($data))
	{
		$data=trim($data);
	}
	return enhtml($data);
}

#去掉bom
function require_bom($a)
{
	$b=file_get_contents($a);
	$c[1]=substr($b,0,1);
    $c[2]=substr($b,1,1);
    $c[3]=substr($b,2,1);
	if(ord($c[1])==239&&ord($c[2])==187&&ord($c[3])==191)
	{
		$d=substr($b,3);
        file_put_contents($a,$d);
	}
	unset($b);
	unset($c);
	return require($a);
}

#筛选URL
function filter_url($a,$b,$c)
{
	if(empty($a))
	{
		$url1=U('goodslist','classid='.$b);
		$url2=U('goodslist','classid='.$b.$c);
		$url3=cateurl($b);
		$ext=C('url_ext');
		if(strlen($ext))
		{
			$url1=substr($url1,0,strlen($url1)-strlen($ext));
			$url2=substr($url2,0,strlen($url2)-strlen($ext));
			$url3=substr($url3,0,strlen($url3)-strlen($ext));
		}
		$url=str_replace($url1,'',$url2);
		return $url3.$url.$ext;
	}
	else
	{
		$e=C('url_mid');
		$d=str_replace('=',$e,$c);
		$d=str_replace('&',$e,$d);
		switch (C('url_mode'))
		{
			case '1':
				return WEB_DOMAIN."?m=$a".$c;
				break;
			case '2':
				if(isempty(C('pathinfo')))
				{
					return WEB_DOMAIN."index.php/$a".$d.C('url_ext');
				}
				else
				{
					return WEB_DOMAIN."index.php?".C('pathinfo')."=$a".$d.C('url_ext');
				}
				break;
			case '3':
				return WEB_DOMAIN."$a".$d.C('url_ext');
				break;
		}
	}
}

#URL组装
function U($a='',$b='',$c=1,$d=0)
{
	return sdcms::geturl($a,$b,$c,$d);
}

function N($a,$b=0,$c='')
{
	if($b==0) $b=C('URL_MODE');
	if(strlen($c))
	{
		if($b==1)
		{
			$c='&'.$c;
		}
		else
		{
			$urlmid=C('url_mid');
			$c=str_replace('=',$urlmid,$c);
			$c=str_replace('&',$urlmid,$c);
			$c=$urlmid.$c;
		}
	}
	$webdomain=($a==C('admin'))?WEB_ROOT:WEB_DOMAIN;
	switch($b)
	{
		case '1':
			return $webdomain.'?m='.$a.$c;
			break;
		case '2':
			if(isempty(C('pathinfo')))
			{
				return $webdomain.'index.php/'.$a.$c.C('URL_EXT');
			}
			else
			{
				return $webdomain.'index.php?'.C('pathinfo').'='.$a.$c.C('URL_EXT');
			}
			break;
		case '3':
			return $webdomain.$a.$c.C('URL_EXT');
			break;
	}
}

#判断是否空值
function isempty($a)
{
	if(SYSVERSION)
	{
		return ($a=='');
	}
	else
	{
		return empty($a);
	}
}

function session($a,$b='')
{
	$prefix=C('PREFIX').$a;
	if($b=='')
	{
		if(isset($_SESSION[$prefix]))
		{
			return $_SESSION[$prefix];
		}
		else
		{
			return null;
		}
	}
	elseif($b=='[del]')#删除单个变量
	{
		unset($_SESSION[$prefix]);
	}
	elseif($b=='[delete]')#删除全部
	{
		session_unset();
        session_destroy();
	}
	else
	{
		$_SESSION[$prefix]=$b;
	}
}

function cookie($a,$b='')
{
	$prefix=C('PREFIX').$a;
	if($b=='')
	{
		if(isset($_COOKIE[$prefix]))
		{
			return $_COOKIE[$prefix];
		}
		else
		{
			return null;
		}
	}
	elseif($b=='[del]')
	{
		setcookie($prefix,'',time()-1,null,null,null,null,true);
	}
	else
	{
		setcookie($prefix,$b,null,null,null,null,true);
	}
}

#https判断
function is_https() 
{ 
    if(!empty($_SERVER['HTTPS'])&&strtolower($_SERVER['HTTPS'])!=='off') 
    { 
        return true; 
    } 
    elseif(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])&&$_SERVER['HTTP_X_FORWARDED_PROTO']==='https') 
    { 
        return true;
    } 
    elseif(!empty($_SERVER['HTTP_FRONT_END_HTTPS'])&&strtolower($_SERVER['HTTP_FRONT_END_HTTPS'])!=='off') 
    { 
        return true;
    } 
    return false;
}

function theme_html($a)
{
	$a=str_replace("&","&amp;",$a);
	$a=str_replace("'","&#39;",$a);
	$a=str_replace('"',"&#34;",$a);
	$a=str_replace("<","&lt;",$a);
	$a=str_replace(">","&gt;",$a);
	return $a;
}

function enhtml($a)
{
	if(is_array($a))
	{
		foreach ($a as $key=>$val)
		{
			$a[$key]=enhtml($val);
		}
	}
	else
	{
		return htmlspecialchars(filterExp(stripslashes($a)),ENT_QUOTES,'UTF-8');
	}
	return $a;
}

function dehtml($a)
{
	return htmlspecialchars_decode($a);
}

function nohtml($a)
{
	if(is_string($a))
	{
		$a=dehtml($a);
		$a=str_replace('&nbsp;','',$a);
		$a=str_replace('&amp;nbsp;','',$a);
		$a=str_replace('　','',$a);
		$a=preg_replace("@<style(.*?)</style>@is",'',$a);
		$a=trim(strip_tags($a));
	}
	return $a;
}

function filterExp($a)
{
    if(preg_match('/^select|insert|create|update|delete|alter|sleep|payload|\'|\\|\.\.\/|\.\/|union|into|load_file|outfile/i',$a))
	{
		return '';
	}
	else
	{
		return $a;
	}
}

function getint($a,$b=0)
{
	if(is_array($a))
	{
		$a=implode($a);
	}
	if(strlen($a))
	{
		return (!preg_match("/^[-0-9]+$/",$a))?$b:substr($a,0,11);
	}
	else
	{
		return $b;
	}
}

function iif($a,$b,$c)
{
	return $a?$b:$c;
}

#cutstr函数
function cutstr($a,$b,$c=0)
{
	$d=mb_strcut($a,0,$b,'UTF8');
	if(strlen($a)>$b&&$c==1) $d.='…';
	return $d;
}

#getip函数
function getip($type=0)
{
    $type=$type?1:0;
    static $ip=NULL;
    if($ip!==NULL) return $ip[$type];
    if(isset($_SERVER['HTTP_X_REAL_IP']))
    {
        $ip=$_SERVER['HTTP_X_REAL_IP'];     
    }
    elseif(isset($_SERVER['HTTP_CLIENT_IP']))
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $arr=explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos=array_search('unknown',$arr);
        if(false!==$pos) unset($arr[$pos]);
        $ip=trim($arr[0]);
    }
    elseif(isset($_SERVER['REMOTE_ADDR']))
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    $long=sprintf("%u",ip2long($ip));
    $ip=$long?array($ip,$long):array('0.0.0.0',0);
    return enhtml($ip[$type]);
}

#跳转
function go($url,$time=0,$msg='')
{
	$msg=(isempty($msg))?"系统将在{$time}秒之后自动跳转到【{$url}】":$msg;
	if($time===0)
	{
		header('Location:'.$url);
		exit();
	}
	else
	{
		header("refresh:{$time};url={$url}");
		echo $msg;
	}
}

#发邮件
function send_mail($a,$b,$c)
{
	$mail=new sdcms_mail();
	return $mail->send($a,$b,$c);
}

function ismobile()
{
    if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    if(isset($_SERVER['HTTP_VIA']))
    {
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    if(isset($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ("android","phone","ipod","mqqbrowser","blackberry","nokia","windowsce","symbian","lg","ucweb","skyfire","webos","incognito","blackberry","mobile","bada"); 
        if(preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
	}
    if(isset($_SERVER['HTTP_ACCEPT']))
    { 
        if((strpos($_SERVER['HTTP_ACCEPT'],'vnd.wap.wml')!==false)&&(strpos($_SERVER['HTTP_ACCEPT'],'text/html')===false||(strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml')<strpos($_SERVER['HTTP_ACCEPT'],'text/html'))))
        {
            return true;
        }
    }
    return false;
}

#是否微信浏览器
function isweixin()
{
	return (bool)(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'micromessenger'));	
}

#是否Ipad
function isipad()
{
	return (bool)(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'ipad'));	
}

#获取内容中所有图片，返回数组
function get_all_picurl($a,$b='')
{
	#去掉反斜杠
	$a=stripslashes($a);
	$num=preg_match_all('/<img.*?src="(.*?)".*?>/is',$a,$match);
	if($num)
	{
		$d=[];
		for($i=0;$i<$num;$i++)
		{
			if(isempty($b))
			{
				$d[$i]=$match[1][$i];
			}
			else
			{
				if(!strpos($match[1][$i],$b)&&strpos($match[1][$i],"://"))
				{
					$d[$i]=$match[1][$i];
				}
			}
			
		}
		return $d;
	}
	else
	{
		return '';
	}
}

#处理筛选参数
function deal_filter($data,$field,$default)
{
	$str='';
	foreach ($data as $key=>$val)
	{
		if($key!=$field)
		{
			$str.='&'.$key.'='.$val.'';
		}
		else
		{
			$str.='&'.$key.'='.$default.'';
		}
	}
	return $str;
}

#文件单位
function formatBytes($size)
{ 
	$units=array('B','K','M','G','TB'); 
	for($i=0;$size>=1024&&$i<4;$i++)
	{
		$size/=1024;
	}
	return round($size,2).' '.$units[$i]; 
}

#创建文件夹(无限级)
function mkfolder($a)
{
	if(!is_dir($a))
	{
		return mkdir($a,0777,true);
	}
}

#删除文件夹(包含子目录)
function delfolder($a)
{
    $a=str_replace('','/',$a);
    $a=substr($a,-1)=='/'?$a:$a.'/';
    if(!is_dir($a))
    {
        return false;
    }
    $b=opendir($a);
    while(false!==($file=readdir($b)))
    {
        if($file=='.'||$file=='..')
        {
            continue;
        }
        if(!is_dir($a.$file))
        {
            unlink($a.$file);
        }
        else
        {
            delfolder($a.$file);
        }
    }
    closedir($b);
    return rmdir($a);
}


#生成缩略图
function thumb($file,$width=200,$height=200,$type=1)
{
	if($type==0)
	{
		return $file;
	}
	if(isempty($file))
	{
		return '';
	}
	if(strpos($file,'://'))
	{
		return $file;
	}
	if(preg_match(WEB_ROOT."upfile(.*)\$/",$file,$matches))
    {
        $file=$matches[0];
    }
    if(!file_exists(SYS_PATH.$file))
    {
    	return WEB_ROOT.$file;
    }
    $newpic=dirname($file).'/thumb_'.$width.'_'.$height.'_'.basename($file);
    if(!file_exists(SYS_PATH.$newpic)||filemtime(SYS_PATH.$newpic)<filemtime(SYS_PATH.$file))
    {
    	$image=new sdcms_image();
    	return $image->thumb($file,$width,$height,$newpic);
    }
    return WEB_ROOT.$newpic;
}

#数据库相关
function sysdb($a)
{
	return C($a=strtoupper($a));
}

function is_active($classid,$pid=0,$style=' class="hover"')
{
	$data=explode(',',$pid);
	if(in_array($classid,$data))
	{
		return $style;
	}
	else
	{
		return;
	}
}

function get_cate_info($id,$field,$default='')
{
	$arr=C('category');
	return isset($arr[$id])?$arr[$id][$field]:$default;
}

#获取栏目父ID
function get_followid($id)
{
	return get_cate_info($id,'followid',0);
}

#获取栏目名称
function get_catename($id)
{
	return get_cate_info($id,'catename');
}

#获取某一分类的子类数量
function get_sonid_num($id)
{
	return get_cate_info($id,'child',0);
}

#查找某一分类的所有子类
function get_sonid_all($id)
{
	return get_cate_info($id,'sonid',$id);
}

#查找某一分类的所有父类
function get_tree_parent($id)
{
	return get_cate_info($id,'parent',$id);
}

function get_cate_self($t0,$t1,$t2,$t3)
{
	if(strlen($t0))
	{
		return $t0;
	}
	else
	{
		$t4=get_cate_info($t1,$t2);
		if(strlen($t4))
		{
			return $t4;
		}
		else
		{
			return $t3;
		}
	}
}

#栏目URL
function cateurl($a)
{
	$cate=C('category');
	$a=(string)$a;
	$d=$cate[$a];
	$b=(is_array($d))?$d['cateurl']:'';
	$c=0;
	$e=$d['catedomain'];
	if(!isempty($e)&&!IS_MOBILE)
	{
		return WEB_HTTP."$e";
	}
	if(is_array($d))
	{
		if($d['catetype']=='-2')
		{
			$c=1;
		}
	}
	return link_url($a,$b,0,1,$c);
}

#内容URL
function showurl($a,$b='',$c=0)
{
	return link_url($a,$b,$c,2);
}

function link_url($a,$b,$c,$d,$e=0)
{
	#$b是别名
	if(isempty($b))
	{
		if($d==1)
		{
			#获取栏目
			if(C('url_mode')==1)
			{
				return U('home/index/cate','classid='.$a.'');
			}
			else
			{
				if(!isempty(C('url_list')))
				{
					if(C('url_mode')==2)
					{
						$prefix=isempty(C('pathinfo'))?'index.php/':'index.php?'.C('pathinfo').'=';
					}
					else
					{
						$prefix='';
					}
					$domain=get_cate_info($a,'catedomain',0);
					$pid=explode(',',get_tree_parent($a));
					#获取顶级分类ID
					$topid=$pid[0];
					$domain=get_cate_self($domain,$topid,'catedomain','');
					if($domain=='')
					{
						$domain=WEB_DOMAIN;
					}
					else
					{
						if(!IS_MOBILE)
						{
							$domain=WEB_HTTP.$domain.WEB_ROOT;
						}
						else
						{
							$domain=WEB_DOMAIN;
						}
					}
					return $domain.$prefix.C('url_list').C('url_mid').$a.C('url_ext');
				}
				else
				{
					return U('home/index/cate','classid='.$a.'');
				}
			}
		}
		else
		{
			if(C('url_mode')==1)
			{
				return U('home/index/show','id='.$a.'');
			}
			else
			{
				#获取内容所在类别的别名
				$alias=get_cate_info($c,'cateurl',0);
				$domain=get_cate_info($c,'catedomain',0);
				$pid=explode(',',get_tree_parent($c));
				#获取顶级分类ID
				$topid=$pid[0];
				#如果当前栏目没有别名，则获取顶级栏目的别名，如果顶级栏目没有别名，则调用系统内容的映射
				$alias=get_cate_self($alias,$topid,'cateurl',C('url_show'));
				if(get_cate_info($topid,'catetype',0)==-2)
				{
					$alias=C('url_show');
				}
				$domain=get_cate_self($domain,$topid,'catedomain','');
				if($domain=='')
				{
					$domain=WEB_DOMAIN;
				}
				else
				{
					if(!IS_MOBILE)
					{
						$domain=WEB_HTTP.$domain.WEB_ROOT;
					}
					else
					{
						$domain=WEB_DOMAIN;
					}
				}
				if(!isempty($alias))
				{
					if(C('url_mode')==2)
					{
						$prefix=isempty(C('pathinfo'))?'index.php/':'index.php?'.C('pathinfo').'=';
					}
					else
					{
						$prefix='';
					}
					return $domain.$prefix.$alias.C('url_mid').$a.C('url_ext');
				}
				else
				{
					return U('home/index/show','id='.$a.'');
				}
			}
		}
	}
	else
	{
		$ext=C('url_ext');
		if($e==0)
		{
			$domain=get_cate_info($a,'catedomain',0);
			$pid=explode(',',get_tree_parent($a));
			#获取顶级分类ID
			$topid=$pid[0];
			$domain=get_cate_self($domain,$topid,'catedomain','');
			if($domain=='')
			{
				$domain=WEB_DOMAIN;
			}
			else
			{
				if(!IS_MOBILE)
				{
					$domain=WEB_HTTP.$domain.WEB_ROOT;
				}
				else
				{
					$domain=WEB_DOMAIN;
				}
			}
			switch (C('url_mode'))
			{
				case '1':
					return $domain."?m=$b";
					break;
				case '2':
					if(C('pathinfo')=='')
					{
						return $domain."index.php/$b$ext";
					}
					else
					{
						return $domain."index.php?".C('pathinfo')."=$b$ext";
					}
					break;
				default:
					return $domain."$b$ext";
					break;
			}
		}
		else
		{
			return $b;
		}
	}
}

#处理副栏目查询
function deal_subid($subid)
{
	$str='';
	if(!empty($subid))
	{
		$arr=explode(',', $subid);
		foreach ($arr as $key=>$val)
		{
			$val=",".$val.",";
			if($str=='')
			{
				$str.=" subid like binary '%$val%'";
			}
			else
			{
				$str.=" or subid like binary '%$val%'";
			}
		}
		if(!isempty($str))
		{
			$str=" or ($str)";
		}
	}
	return $str;
}

#内容分页
function pagelist($a,$b=0,$c=5)
{
	if($b<=1)
	{
		return '';
	}
	$page=new sdcms_page(1,$b,20,$a);
	return $page->pageList($c);
}

#列表自定义字段使用
function deal_field($a,$b,$c)
{
	if(isset($c[$b]))
	{
		$rs=$c[$b];
		switch ($rs['field_type'])
		{
			case '2':#日期
				return date('Y-m-d',$a);
				break;
			case '10':#复选框
				return deal_checkbox($a,$rs['field_list']);
				break;
			case '9':#单选按钮
			case '11':#下拉列表
				return deal_defaults($a,$rs['field_list']);
				break;
			default:
				return $a;
				break;
		}
	}
	else
	{
		return $a;
	}
}

function deal_checkbox($a,$b)
{
	$r='';
	$c=explode(',',$b);
	foreach ($c as $key=>$val)
	{
		list($d,$e)=explode('|', $val);
		if(strpos('-_-,'.$a.',',','.$e.','))
		{
			$r.=$d.' ';
		}
	}
	return $r;
}

function deal_defaults($a,$b)
{
	$c=explode(',',$b);
	foreach ($c as $key=>$val)
	{
		list($d,$e)=explode('|', $val);
		if($e==$a)
		{
			return $d;
		}
	}
}

#以下为自定义表单使用
function deal_rule($a,$b)
{
	$c='';
	switch ($a) 
	{
		case '1':
			$c='null';
			break;
		case "2":
			$c='date';
			break;
		case "3":
			$c='int';
			break;
		case "4":
			$c='dot';
			break;
		case "5":
			$c='tel';
			break;
		case "6":
			$c='mobile';
			break;
		case "7":
			$c='email';
			break;
		case "8":
			$c='zipcode';
			break;
		case "9":
			$c='qq';
			break;
		case "10":
			$c='url';
			break;
		case "11":
			$c='username';
			break;
		case "12":
			$c='password';
			break;
		default:
			break;
	}
	if($c=='')
	{
		return '';
	}
	else
	{
		$c=str_replace('null', '', $c);
		return 'data-rule="'.$b.':required;'.$c.'"';
	}
}

#后台相关
function is_admin()
{
	$info=session('admin_info');
	return (isempty($info)?0:$info['adminid']);
}

function get_admin_info($a)
{  
	$info=session('admin_info');
	return $info[$a];
}

#会员相关
function is_user()
{
	$info=session('user_info');
	return (empty($info)?0:$info['id']);
}

function get_user_info($a)
{  
	$info=session('user_info');
	return $info[$a];
}

#时间显示
function formatTime($time)
{     
	$rtime=date("m-d H:i",$time);     
	$htime=date("H:i",$time);           
	$time=time()-$time;       
	if($time<60)
	{         
		$str='刚刚';     
	}
	elseif($time<60*60)
	{         
		$min=floor($time/60);         
		$str=$min.'分钟前';     
	}
	elseif($time<60*60*24)
	{         
		$h=floor($time/(60*60));         
		$str=$h.'小时前';     
	}
	elseif($time<60*60*24*3)
	{         
		$d=floor($time/(60*60*24));         
		if($d==1)
		{
			$str='昨天 '.$rtime;
		}
		else
		{
			$str='前天 '.$rtime;     
		}
	}
	else
	{         
		$str=$rtime;     
	}     
	return $str; 
}

#运行时间
function runtime()
{
	$GLOBALS['end']=['0'=>microtime(true),'1'=>memory_get_usage()];
	return 'Processed in '.number_format(($GLOBALS['end'][0]-$GLOBALS['begin'][0]),6).' s , Memory '.formatBytes(($GLOBALS['end'][1]-$GLOBALS['begin'][1])).' , '.$GLOBALS['query'].' queries';
}

#5.4版本不支持此函数
if (!function_exists('curl_file_create')) {
    function curl_file_create($filename, $mimetype = '', $postname = '') {
        return "@$filename;filename="
            . ($postname ?: basename($filename))
            . ($mimetype ? ";type=$mimetype" : '');
    }
}