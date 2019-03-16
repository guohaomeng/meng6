<?php
/**
 * 插件：数据备份
 * By IT平民
**/

class AdminController extends PlugController
{
	public function __construct()
	{
		parent::__construct();
		if(!C('plug_backup'))
		{
			die('插件未安装');
		}
		$this->check_admin();
	}

	public function Index()
	{
		$rs=$this->db->query('show table status');
		$db=$rs->fetchall();
        $this->assign('db',$db);
		$this->display("backup.php");
	}

	public function import()
	{
		set_time_limit(0);
		if(IS_POST)
		{
			$key=F('key');
			$key=str_replace('..','',$key);
			$name='app/plug/backup/data/'.$key;
			if(!is_file($name))
			{
				$this->error('备份文件不存在');
			}
			else
			{
				$f=fopen($name,"rb");
		        //创建表缓冲变量
		        $create_table='';
		        while(!feof($f))
		        {
		            $line=fgets($f);
		            // 这一步为了将创建表合成完整的sql语句
		            // 如果结尾没有包含';'(即为一个完整的sql语句，这里是插入语句)，并且不包含'ENGINE='(即创建表的最后一句)
		            if (!preg_match('/;/',$line) || preg_match ( '/ENGINE=/', $line )) 
		            {
		                // 将本次sql语句与创建表sql连接存起来
		                $create_table .= stripslashes($line);
		                // 如果包含了创建表的最后一句
		                if (preg_match ( '/ENGINE=/', $create_table)) {
		                    //执行sql语句创建表
		                     $this->db->query(stripslashes($create_table));
		                    //清空当前，准备下一个表的创建
		                    $create_table = '';
		                }
		                // 跳过本次
		                continue;
		            }
		            $this->db->query($line);
		        }
		        fclose($f);
				$this->success('还原成功');
			}
		}
		else
		{
			$root='app/plug/backup/data';
			$db=self::deal_arr(scandir($root),$root);
			$this->assign('db',$db[0]);
			$this->display("import.php");
		}
	}

	public function del()
	{
		$key=base64_decode(F('get.key'));
		$key=str_replace('..','',$key);
		@unlink('app/plug/backup/data/'.$key);
		$this->success('删除成功');
		$this->add_log($this->msg);
	}

	public function btach()
	{
		$type=getint(F('type'),0);
		$id=F('id');
		if(empty($id))
		{
			$this->error('至少选择一个表');
			exit();
		}
		else
		{
			switch ($type)
			{
				case '1':
					self::backup($id);
					break;
				case '2':
					self::optimize($id);
					break;
				case '3':
					self::repair($id);
					break;
			}
		}
		$this->success('操作成功');
		$this->add_log($this->msg);
	}

	public function optimize($table)
	{
		$db=explode(',',$table);
		foreach($db as $key)
		{
			$this->db->query("OPTIMIZE TABLE `{$key}`");
		}
		return '优化成功';
	}

	public function repair($table)
	{
		$db=explode(',',$table);
		foreach($db as $key)
		{
			$this->db->query("REPAIR TABLE `{$key}`");
		}
		return '修复成功';
	}
	public function backup($table='')
	{
		set_time_limit(0);
		$db=explode(',',$table);
		$name=uniqid().'-'.date('Ymd-his').'.sql';
		$sql  = "-- -----------------------------\n";
        $sql .= "-- SDCMS MySQL Data Transfer \n";
        $sql .= "-- \n";
        $sql .= "-- Date:".date("Y-m-d H:i:s") . "\n";
        $sql .= "-- -----------------------------\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

		foreach($db as $key)
		{
			$result=$this->db->query("SHOW CREATE TABLE `{$key}`");
			$data=$result->fetchall();
			$sql .= "\n";
            $sql .= "-- -----------------------------\n";
            $sql .= "-- Table structure for `{$key}`\n";
            $sql .= "-- -----------------------------\n";
            $sql .= "DROP TABLE IF EXISTS `{$key}`;\n";
            $sql .= trim($data[0]['Create Table']) . ";\n\n";
		}

		foreach($db as $key)
		{
			$result=$this->db->query("SELECT * FROM `{$key}`");
			$data=$result->fetchall(PDO::FETCH_ASSOC);
			$sql .= "-- -----------------------------\n";
	        $sql .= "-- Records of `{$key}`\n";
	        $sql .= "-- -----------------------------\n";
	        foreach($data as $row)
	        {
	        	$row=self::deal_backup($row);
	        	$val=implode("','",$row);
	        	$sql.= "INSERT INTO `{$key}` VALUES ('".$val."');\n";
	        }
		}
		file_put_contents('app/plug/backup/data/'.$name,$sql);
		return '备份成功';
	}

	public function deal_backup($data)
	{
		foreach ($data as $key=>$val)
		{
			$val=addslashes($val);
			#换行
        	$val=str_replace(PHP_EOL,'\r\n',$val);
        	$val=str_replace(chr(10),'\n',$val);
			$data[$key]=$val;
		}
		return $data;
	}

	public function deal_arr($data,$root)
	{
		unset($data[0]);unset($data[1]);
		$a=[];
		foreach ($data as $key=>$val)
		{
			if(is_file($root.'/'.$val))
			{
				$a[$key]=['0'=>iconv("gb2312","utf-8",$val),'1'=>filemtime($root.'/'.$val),'2'=>formatBytes(filesize($root.'/'.$val))];
			}
			else
			{
				unset($data[$key]);
			}
		}
		return ['0'=>$a];
	}

}