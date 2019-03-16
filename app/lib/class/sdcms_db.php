<?php
/**
 * 作用：数据库
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

final class sdcms_db
{
	public $conn;
	public $newid;
	public $sql;
	public $prefix='sd_';
	public function __construct($db)
	{
		try
		{
			$this->conn=new PDO('mysql:host='.$db['DB_HOST'].';port='.$db['DB_PORT'].';dbname='.$db['DB_BASE'].'',$db['DB_USER'],$db['DB_PASS']);
			$this->conn->exec("set names 'UTF8'");
			$this->prefix=$db['DB_PREFIX'];
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}

	public function __destruct()
	{
		$this->conn=null;
	}

	public function query($sql)
	{
		$GLOBALS['query']+=1;
		$sql=str_replace('sd_',$this->prefix,$sql);
		$sql=str_replace('%s',$this->prefix,$sql);
		$db=$this->conn->query($sql);
		if($this->conn->errorCode()=='00000')
		{
			return $db;
		}
		else
		{
			#写错误日志
			$error=$this->conn->errorInfo();
			$str="Sql：$sql<br>日期：".date('Y-m-d H:i:s')."<br>详细：".$error[2]."<br>Url：".THIS_LOCAL."<br>IP：".getip()."";
			file_put_contents('app/lib/log/'.date('Y-m-d-H-i-s').'.txt',$str);
			$arr=['state'=>'error','msg'=>'SQL错误，详细请查阅日志'];
			echo json_encode($arr,JSON_UNESCAPED_UNICODE);
			die();
		}		
	}

	public function total($sql)
	{
		if(!$sql){$sql=$this->sql;}
		return $this->conn->query($sql)->rowCount();
	}

	public function count($sql)
	{
		$array=$this->query($sql)->fetch(PDO::FETCH_NUM);
		return $array[0];
	}

	public function load($sql)
	{
		#echo $sql.'<br>';
		$array=[];
		$this->sql=$sql;
		$result=$this->query($sql);
		while($data=$result->fetch(PDO::FETCH_ASSOC))
		{
			$array[]=$data;
		}
		unset($result);
		return $array;
	}

	public function row($sql)
	{
		$result=$this->query($sql);
		if($result)
		{
			return $result->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function getkeylist($id,$table,$join,$where,$order,$begin,$end,$way=0)
	{
		$str=$where;
		if($way==1)
		{
			$order=str_replace("desc","asc",$order);
		}
		$sql="select $id from $table $join $where $order limit $begin,$end";
		$data_id=$this->load($sql);
		if (count($data_id)>0)
		{
			foreach ($data_id as $key=>$val)
			{
				$data_id[$key]=$val[$id];
			}
			$str="where $id in(".implode(',',$data_id).")";
		}
		return $str;
	}

	public function add($table,$array)
	{
		$field=array_keys($array);
		$value=array_values($array);
		array_walk($field,array($this,'add_special_char'));
		array_walk($value,array($this,'escape_string'));
		$field=implode(',',$field);
		$value=implode(',',$value);
		$result=$this->query("insert into $table ($field) values ($value)");
		$this->newid=$this->conn->lastInsertId();
		return $result;
	}

	public function update($table,$where,$array)
	{
		$where=!isempty($where)?'where '.$where:'';
		$field='';
		foreach($array as $key=>$value)
		{
			$field[]=$this->add_special_char($key).'='.$this->escape_string($value);
		}
		$field=implode(',',$field);
		return $this->query("update $table set $field $where");
	}

	public function del($table,$where)
	{
		$where=!isempty($where)?'where '.$where:'';
		return $this->query("delete from $table $where");
	}

	public function load_field($field,$table,$where,$data='')
	{
		$where=!isempty($where)?'where '.$where:'';
		$sql="select $field from $table $where limit 1";
		$rs=$this->row($sql);
		if($rs)
		{
			return $rs[$field];
		}
		else
		{
			return $data;
		}
	}

	public function add_special_char(&$value)
	{
		if('*'==$value||false!==strpos($value, '(') || false !== strpos($value, '.') || false !== strpos ( $value, '`'))
		{
			#不处理包含* 或者 使用了sql方法。
		} 
		else 
		{
			$value='`'.trim($value).'`';
		}
		if(preg_match("/\b(select|insert|update|delete)\b/i", $value))
		{
			$value=preg_replace("/\b(select|insert|update|delete)\b/i",'',$value);
		}
		return $value;
	}
	
	public function escape_string(&$value,$key='',$quotation=1)
	{
		if($quotation)
		{
			$q='\'';
		} 
		else
		{
			$q='';
		}
		$value=$q.$value.$q;
		return $value;
	}
}