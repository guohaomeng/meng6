<?php
/**
 * 作用：无限分类
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

final class sdcms_tree
{
	#查找某一分类的所有子类
	public static function get_tree_child($id,$data)
	{
		$subs=[$id];
	    do{
	        $len=count($subs);
	        foreach($data as $item)
	        {
	            if(in_array($item['followid'],$subs))
	            {
	                $subs[]=$item['cateid'];
	                unset($data[$item['cateid']]);
	            }
	        }
	    }
	    while(count($subs)>$len);
		return implode(',', $subs);
	}

	#查找某一分类的所有父类
	public static function get_tree_parent($id,$data='')
	{
		if(!$data){$data=C('category');}
		$tree=[];
		do
		{
			$tree[]=$data[$id]['cateid'];
			$id=$data[$id]['followid'];
		}
		while($id!=0);
		return array_reverse($tree);
	}

	public static function get_tree($data)
	{
		$tree=[];
		foreach($data as $key=>$val)
		{
			$val['parent']=implode(',',self::get_tree_parent($val['cateid'],$data));
			$val['depth']=count(explode(',',$val['parent']));
			$val['sonid']=self::get_tree_child($val['cateid'],$data);
			$val['child']=count(explode(',', $val['sonid']))-1;
		 	$tree[$key]=$val;
		}
		return $tree;
	}
	
}