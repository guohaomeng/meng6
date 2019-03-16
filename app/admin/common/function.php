<?php
/**
 * 作用：后台相关程序
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

function get_admin_menu_url($b,$c,$d)
{
	$a=C('ADMIN');
	return U($a."/".$b."/".$c,$d,"",1);
}

function get_cate_postion($id,$mid=' > ')
{
	$arr=get_tree_parent($id);
	$html='';
	for($i=0;$i<count($arr);$i++)
	{
		if($arr[$i]!=0)
		{
			$html.=$mid.'<a href="'.U("index","fid=".$arr[$i]."").'">'.get_catename($arr[$i]).'</a>';
		}
	}
	return $html;
}

function get_content_postion($id,$mid=' > ')
{
	$arr=get_tree_parent($id);
	$html='';
	for($i=0;$i<count($arr);$i++)
	{
		if($arr[$i]!=0)
		{
			$html.=$mid.'<a href="'.U("lists","classid=".$arr[$i]."").'">'.get_catename($arr[$i]).'</a>';
		}
	}
	return $html;
}

function get_page_postion($id,$mid=' > ')
{
	$arr=get_tree_parent($id);
	$html='';
	for($i=0;$i<count($arr);$i++)
	{
		if($arr[$i]!=0)
		{
			$html.=$mid.'<a href="'.U("page","classid=".$arr[$i]."").'">'.get_catename($arr[$i]).'</a>';
		}
	}
	return $html;
}

function deal_strip($a)
{
	if(get_magic_quotes_gpc())
	{
		return stripslashes($a);
	}
	else
	{
		return $a;
	}
}

function geturl($a,$b)
{
	switch ($b)
	{
		case '-1':
			return U('page','classid='.$a.'','',1);
			break;
		case '-2':
			return 'javascript:;';
			break;
		default:
			return U('lists','classid='.$a.'','',1);
			break;
	}
}

#处理表单默认值
#{php:now}
#{php:get.classid}
function deal_default($a)
{
	$num=preg_match_all("/\{php:(.*?)}/",$a,$match);
	if($num)
	{
		for($i=0;$i<$num;$i++)
		{
			switch ($match[1][$i])
			{
				case 'now':
					return date('Y-m-d H:i:s');
					break;
				default:
					if(strpos($match[1][$i],"."))
					{
						list($type,$val)=explode(".",$match[1][$i]);
						if($type=='get')
						{
							return F('get.'.$val.'');
						}
						elseif($type=='post')
						{
							return F($val);
						}
					}
					else
					{
						return $a;
					}
					break;
			}
		}
	}
	else
	{
		return $a;
	}
}