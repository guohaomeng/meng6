<?php
/**
 * 作用：分页类
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

final class sdcms_page
{
	public $totalnum;#总记录数
	private $pagesize;#每页显示多少条
	private $thispage;#当前页数,外部传递的
	public $totalpage;#总页数
	private $url;
	private $config=[
		'home'  => '首页',
		'pre'   => '上一页',
		'next'  => '下一页',
		'last'  => '末页',
	];

	public function __construct($totalnum,$totalpage,$pagesize=20,$thispage)
	{
		$this->totalnum=$totalnum;
		$this->totalpage=$totalpage;
		$this->pagesize=$pagesize;
		$this->thispage=$thispage;
		$this->url=$this->getParam();
		if($this->totalnum==0)
		{
			$this->totalpage=0;
		}
		if($this->totalpage==0)
		{
			$this->thispage=1;
		}
		if($this->thispage>$this->totalpage)
		{
			$this->thispage=1;
		}
	}
	
	private function getParam()
	{
		$url=$_SERVER["REQUEST_URI"].(strpos($_SERVER["REQUEST_URI"],"?") ? "" : "?");
		$parse=parse_url($url);
		if(isset($parse['query']))
		{
			parse_str($parse['query'],$params);#把url字符串解析为数组
			unset($params['page']);#删除数组下标为page的值
			$url=$parse['path'].'?'.http_build_query($params);#再次构建url
		}
		return $url;
	}

	private function getUrl($num)
	{
		if(C('url_mode')==1)
		{
			$str=$this->url.'&page='.$num;
			$str=str_replace("?&","?",$str);
			if($num==1)
			{
				$str=str_replace('&page='.$num.'','',$str);
			}
		}
		else
		{
			$arr=sdcms::$routes;
			if(!empty($arr['alias']))
			{
				$arr['m']=$arr['alias'];
				unset($arr['c']);
				unset($arr['a']);
				if(isset($arr['param']))
				{
					unset($arr[$arr['param']]);
					unset($arr['param']);
				}
				unset($arr['alias']);
			}
			$arr['page']=$num;
			if($arr['m']!='plug')
			{
				unset($arr['p']);
			}
			$str=http_build_query($arr,'','&');
			$str=str_replace('m=','',$str);
			$str=str_replace('p=','',$str);
			$str=str_replace('c=','',$str);
			$str=str_replace('a=','',$str);
			$str=str_replace('=',C('url_mid'),$str);
			$str=str_replace('&',C('url_mid'),$str);
			if(isempty(C('pathinfo')))
			{
				$str=(C('url_mode')==2)?(WEB_ROOT.'index.php/'.$str.C('url_ext')):(WEB_ROOT.$str.C('url_ext'));
			}
			else
			{
				$str=(C('url_mode')==2)?(WEB_ROOT.'index.php?'.C('pathinfo').'='.$str.C('url_ext')):(WEB_ROOT.$str.C('url_ext'));
			}
			$str=str_replace('%2F','/',$str);
			if($num==1)
			{
				$m=(C('url_mid')=='/')?'\\'.C('url_mid'):C('url_mid');
				$str=str_replace(C('url_mid').'page'.C('url_mid').$num.'','',$str);
			}
		}
		return $str;
	}

	public function pageList($j=5)
	{
		if($this->totalpage==1)
		{
			#return '';
		}
		$i=$j;
		$begin=$this->thispage;
   		$end=$this->thispage; 
   		while(true)
   		{
   			if($begin>1)
   			{
   				$begin=$begin-1;
   				$i=$i-1;
   			}
   			if($i>1&&$end<$this->totalpage)
   			{
   				$end=$end+1;
   				$i=$i-1;
   			}
   			if(($begin<=1&&$end>=$this->totalpage)||$i<=1)
   			{
   				break;
   			}
   		}
   		$str='';
   		if($this->thispage>1)
   		{
   			$str.='<li><a href="'.$this->getUrl($this->thispage-1).'">'.$this->config['pre'].'</a></li>';
   		}
   		if($begin!=1)
   		{
   			$str.='<li><a href="'.$this->getUrl(1).'">1...</a></li>';
   		}
   		for($i=$begin;$i<=$end;$i++)
   		{
   			if($i==$this->thispage)
   			{
   				$str.='<li class="active"><a href="'.$this->getUrl($i).'">'.$this->thispage.'</a></li>';
   			}
   			else
   			{
   				$str.='<li><a href="'.$this->getUrl($i).'">'.$i.'</a></li>';
   			}
   		}
   		if($end!=$this->totalpage)
   		{
   			$str.='<li><a href="'.$this->getUrl($this->totalpage).'">...'.$this->totalpage.'</a></li>';
   		}
   		if($this->thispage<$this->totalpage)
   		{
   			$str.='<li><a href="'.$this->getUrl($this->thispage+1).'">'.$this->config['next'].'</a></li>';
   		}
   		$str.='<li><a>'.$this->thispage.'/'.$this->totalpage.'</a></li>';
   		return $str;
  	}

  	#组合
	public function showpage($a)
	{
		if($this->totalpage==0)
		{
			return '';
		}
		return self::pageList($a);
	}

	#首页
	public function home()
	{
		if($this->totalpage==0)
		{
			return '';
		}
		return '<a href="'.$this->getUrl(1).'">'.$this->config['home'].'</a>';		
	}

	#上一页
	public function pre()
	{
		if($this->totalpage==0)
		{
			return '';
		}
		if($this->thispage>1&&$this->thispage<=$this->totalpage)
		{
			return '<a href="'.$this->getUrl($this->thispage-1).'">'.$this->config['pre'].'</a>';
		}
		else
		{
			return '<a>'.$this->config['pre'].'</a>';
		}
		
	}

	#下一页
	public function next()
	{
		if($this->totalpage==0)
		{
			return '';
		}
		if($this->thispage<$this->totalpage)
		{
			return '<a href="'.$this->getUrl($this->thispage+1).'">'.$this->config['next'].'</a>';
		}
		else
		{
			return '<a>'.$this->config['next'].'</a>';
		}
	}

	#末页
	public function last()
	{
		if($this->totalpage==0)
		{
			return '';
		}
		return '<a href="'.$this->getUrl($this->totalpage).'">'.$this->config['last'].'</a>';
	}
	
}