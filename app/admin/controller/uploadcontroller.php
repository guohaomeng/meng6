<?php
/**
 * 作用：上传
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

class UploadController extends AdminsController
{
	private $step;
	public function __construct()
	{
		parent::__construct();
		$this->step=0;
	}

	function tree($root,$pid=0,$type,$multiple)
	{
		$str='';
		$tid=$this->step+1;
		$name=explode("/", $root);
		$name=end($name);
		$str.=",{id:$tid,pId:$pid,name:'$name',url:'".U('imagelists','type='.$type.'&multiple='.$multiple.'&root='.base64_encode($root).'')."',target:'content_body'}";
		$this->step=$this->step+1;

		$data=scandir($root);
		if(is_array($data))
		{
			unset($data[0]);
			unset($data[1]);
			#降序排列
			rsort($data);
			foreach($data as $key=>$val)
			{
				if(is_dir($root.'/'.$val))
				{
					$str.=$this->tree($root.'/'.$val,$tid,$type,$multiple);
				}
			}
		}
		return $str;
	}

	public function index()
	{
		$action=F('get.action');
		switch ($action) 
		{
			case 'image':
				self::editor(1);
				break;
			case 'video':
				self::editor(2);
				break;
			case 'file':
				self::editor(3);
				break;
			case 'listimage':
				self::list_file(1);
				break;
			case 'listfile':
				self::list_file(2);
				break;
			case 'catchimage':
				self::catch_image();
				break;
			default:
				self::config();
				break;
		}
	}

	public function config()
	{
		list($host)=explode(':',$_SERVER['HTTP_HOST']);
		$arr=[
			'imageActionName'=>'image',
			'imageFieldName'=>'file',
			'imageMaxSize'=>C('upload_image_max')*1024*1024,
			'imageAllowFiles'=>[".png",".jpeg",".jpg",".gif"],
			'imageCompressEnable'=>false,
			'imageCompressBorder'=>99999,
			'imageInsertAlign'=>'none',
			'imageUrlPrefix'=>'',
			'imagePathFormat'=>'',

			'videoActionName'=>'video',
			'videoFieldName'=>'file',
			'videoMaxSize'=>C('upload_video_max')*1024*1024,
			'videoAllowFiles'=>[".mp4"],
			'videoUrlPrefix'=>'',
			'videoPathFormat'=>'',

			'fileActionName'=>'file',
			'fileFieldName'=>'file',
			'filePathFormat'=>'',
			'fileUrlPrefix'=>'',
			'fileMaxSize'=>C('upload_file_max')*1024*1024,
			'fileAllowFiles'=>[".gif",".jpeg",".jpg",".png",
				".swf",".mp4",".flv",
				".doc",".docx",".xls",".xlsx",".ppt",".pptx",
				".rar",".zip",".7z",".gz",".tar",
				".apk",".iso",".pdf",".txt"],

			'imageManagerActionName'=>'listimage',
			'imageManagerListSize'=>'20',
			'imageManagerUrlPrefix'=>'',
			'imageManagerInsertAlign'=>'none',

			'fileManagerActionName'=>'listfile',
			'fileManagerListSize'=>'20',
			'fileManagerUrlPrefix'=>'',
			
			'catcherLocalDomain'=>["127.0.0.1","localhost",$host],
			'catcherActionName'=>'catchimage',
			'catcherFieldName'=>'source',
			'catcherPathFormat'=>'',
			'catcherUrlPrefix'=>'',
			'catcherMaxSize'=>C('upload_image_max')*1024*1024,
			'catcherAllowFiles'=>[".png",".jpg",".jpeg",".gif",".bmp"]
		];
		echo json_encode($arr);
	}

	public function catch_image()
	{
		$list=[];
		$data=[];
		if(isset($_POST['source']))
		{
			$data=$_POST['source'];
		}
		else
		{
			if(isset($_GET['source']))
			{
				$data=$_GET['source'];
			}
		}
		if(is_array($data))
		{
			foreach($data as $key)
			{
				$info=self::saveRemote($key);
				array_push($list,["state"=>$info['state'],"url"=>$info['url'],"source"=>$key]);
			}
		}
		echo json_encode(array('state'=>count($list)?'SUCCESS':'ERROR','list'=>$list));
	}

	public function saveRemote($url)
	{
		$info=['state'=>'错误','url'=>null];
		#enhtml可能会造成远程图片保存失败（原因：URL路径中含有非法字符）
		#$url=enhtml($url);
		$url=str_replace('&amp;','&',$url);
		if(strpos($url,'http')!==0)
		{
			$info['state']='链接不是http链接';
			return $info;
		}
		preg_match('/(^https*:\/\/[^:\/]+)/', $url, $matches);
        $host_with_protocol=count($matches)>1? $matches[1]:'';

        #判断是否是合法 url
        if(!filter_var($host_with_protocol, FILTER_VALIDATE_URL))
        {
            $info['state']='非法URL';
			return $info;
        }

        preg_match('/^https*:\/\/(.+)/',$host_with_protocol,$matches);
        $host_without_protocol=count($matches)>1?$matches[1]:'';

        #此时提取出来的可能是 ip 也有可能是域名，先获取 ip
        $ip=gethostbyname($host_without_protocol);
        #判断是否是私有 ip
        if(!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE))
        {
            $info['state']='非法IP';
			return $info;
        }
        #获取请求头并检测死链
        $heads = get_headers($url, 1);
        if (!(stristr($heads[0], "200") && stristr($heads[0], "OK")))
        {
            $info['state']='链接不可用';
			return $info;
        }
        #格式验证(扩展名验证和Content-Type验证)
        if(isset($heads['Content-Type']))
        {
        	switch ($heads['Content-Type'])
        	{
        	 	case 'image/gif':
        	 		$ext='.gif';
        	 		break;
        	 	case 'image/jpeg':
        	 		$ext='.jpg';
        	 		break;
        	 	case 'image/png':
        	 		$ext='.png';
        	 		break;
        	 	case 'image/bmp':
        	 		$ext='.bmp';
        	 		break;
        	 	default:
        	 		$ext=strtolower(strrchr($url,'.'));
        	 		break;
        	 }
        }
        if (!in_array($ext, [".png",".jpg",".jpeg",".gif",".bmp"]) || !isset($heads['Content-Type']) || !stristr($heads['Content-Type'], "image"))
        {
            $info['state']='链接contentType不正确';
			return $info;
        }
        #打开输出缓冲区并获取远程图片
        ob_start();
        $context=stream_context_create(
            array('http' => array(
                'follow_location' => false // don't follow redirects
            ))
        );
        readfile($url,false,$context);
        $img=ob_get_contents();
        ob_end_clean();
        preg_match("/[\/]([^\/]*)[\.]?[^\.\/]*$/",$url,$m);
        $size=strlen($img);
        if($size>C('upload_image_max')*1024*1024)
        {
        	$info['state']='文件大小超出网站限制';
			return $info;
        }
        switch (C('upload_file_folder'))
		{
			case '1':
				$filepath='upfile/'.date("Y").'/';
				break;
			case '2':
				$filepath='upfile/'.date("Y").'/'.date("m").'/';
				break;
			case '3':
				$filepath='upfile/'.date("Y").'/'.date("m").'/'.date("d").'/';
				break;
			default:
				$filepath='upfile/'.date("Ym").'/';
		}
		if(!is_dir($filepath))
		{
		  if(!mkfolder($filepath))
		  {
			  $info['state']='文件夹创建失败';
			  return $info;
		  }
		}
		$newname=time().mt_rand(100,999).$ext;
		if (!(file_put_contents($filepath.$newname, $img) && file_exists($filepath.$newname)))
		{
            $info['state']='移动失败';
        }
        else
        {
	        $fileway=C('file_way');
			if($fileway=='local')
			{
				$info['state']='SUCCESS';
            	$info['url']=WEB_ROOT.$filepath.$newname;
            }
            else
            {
            	$data['tmp_name']=$filepath.$newname;
	        	$data['type']='image/'.$ext;
				$up=new $fileway();
				$result=$up->upload($data,$filepath.$newname);
				if($result)
				{
					$info['url']=$up->backurl;
					$info['state']='SUCCESS';
					#删除本地文件
					@unlink($filepath.$newname);
				}
				else
				{
					$info['state']=$up->msg;
				}
			}
        }
        return $info;
	}

	public function outimage()
	{
		$a='';
		if(isset($_POST['content']))
		{
			$a=$_POST['content'];
		}
		if(empty($a))
		{
			echo '';
			exit;
		}
		#去掉反斜杠
		if(!get_magic_quotes_gpc())
		{
			$a=stripslashes($a);
		}
		list($host)=explode(':',$_SERVER['HTTP_HOST']);
		$d=get_all_picurl($a,$host);
		if(is_array($d))
		{
			foreach ($d as $key => $val)
			{
				$info=self::saveRemote($val);
				if($info['state']=='SUCCESS')
				{
					$a=str_replace($val,$info['url'],$a);
				}
				/*
				else
				{
					$a=$info['state'];
				}
				*/
			}
		}
		echo $a;
	}

	public function list_file($type)
	{
		header("Content-Type: text/html; charset=utf-8");
		if($type==1)
		{
			$allowFiles=[".png",".jpg",".gif"];
		}
		else
		{
			$allowFiles=[
			    ".png", ".jpg", ".jpeg", ".gif", ".bmp",
			    ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
			    ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
			    ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
			    ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
			];
		}
        $listSize=20;
        $path=WEB_ROOT.'upfile/';
        $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);
        /* 获取参数 */
		$size = getint(F('get.size'),$listSize);
		$start =getint(F('get.start'),0);
		$end = $start+$size;

		/* 获取文件列表 */
		$path = $_SERVER['DOCUMENT_ROOT'] . (substr($path, 0, 1) == "/" ? "":"/") . $path;
		$files = self::getfiles($path, $allowFiles);
		if (!count($files)) {
		    echo json_encode(array(
		        "state" => "no match file",
		        "list" => array(),
		        "start" => $start,
		        "total" => count($files)
		    ),JSON_UNESCAPED_UNICODE);
		    return;
		}

		/* 获取指定范围的列表 */
		$len = count($files);
		rsort($files);
		for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--)
		{
		    $list[] = $files[$i];
		}

		/* 返回数据 */
		$result = json_encode(array(
		    "state" => "SUCCESS",
		    "list" => $list,
		    "start" => $start,
		    "total" => count($files)
		),JSON_UNESCAPED_UNICODE);
		echo $result;
	}

	function getfiles($path, $allowFiles, &$files = array())
	{
	    if (!is_dir($path)) return null;
	    if(substr($path, strlen($path) - 1) != '/') $path .= '/';
	    $handle = opendir($path);
	    while (false !== ($file = readdir($handle))) 
	    {
	        if ($file != '.' && $file != '..')
	        {
	            $path2 = $path . $file;
	            if (is_dir($path2))
	            {
	                self::getfiles($path2, $allowFiles, $files);
	            }
	            else
	            {
	                if (preg_match("/\.(".$allowFiles.")$/i", $file))
	                {
	                    $files[] = array(
	                        'url'=> iconv("gbk","utf-8",substr($path2,strlen($_SERVER['DOCUMENT_ROOT']))),
	                        'mtime'=> filemtime($path2)
	                    );
	                }
	            }
	        }
	    }
	    return $files;
	}

	public function editor($type)
	{
		$up=new sdcms_upload('file',$type,1,1);
		if($up->state=='success')
		{
			$arr=['state'=>'SUCCESS','url'=>$up->msg,'original'=>$up->oldname,'title'=>$up->oldname];
		}
		else
		{
			$arr=['state'=>$up->msg];
		}
		echo json_encode($arr);
	}

	public function upfile()
	{
		$water=getint(F('get.water'),0);
		$thumb=getint(F('get.thumb'),0);
		$type=getint(F('get.type'),1);
		$up=new sdcms_upload('file',$type,$thumb,$water);
		echo $up->showmsg();
	}

	public function imagelist()
	{
		$type=getint(F('get.type'),0);
		$multiple=getint(F('get.multiple'),0);
		if($type==1)
		{
			$action='listimage';
		}
		else
		{
			$action='listfile';
		}
		$root=base64_decode(F('get.root'));
		if($root=='')
		{
			$root='upfile';
		}
		$data=self::deal_arr(scandir($root),$root);
		$folder=$data[0];
		
		$this->assign('tree',trim($this->tree('upfile',0,$type,$multiple),","));
		$this->assign('dir',$root);
		$this->assign('type',$type);
		$this->assign('folder',$folder);

		$this->assign('action',$action);
		$this->assign('multiple',$multiple);
		$this->display('module/other/image.php');
	}

	public function imagelists()
	{
		$type=getint(F('get.type'),0);
		$multiple=getint(F('get.multiple'),0);
		if($type==1)
		{
			$action='listimage';
		}
		else
		{
			$action='listfile';
		}
		$root=base64_decode(F('get.root'));
		if($root=='')
		{
			$root='upfile';
		}
		$data=self::deal_arr(scandir($root),$root);
		$folder=$data[0];
		$file=$data[1];
		$arr=explode('/',$root);
		$str='';
		$position='';
		foreach ($arr as $key=>$val)
		{
			if($key==0)
			{
				$str=$val;
			}
			else
			{
				$str.='/'.$val;
			}
			if($val=='upfile')
			{
				$val='根目录';
			}
			if($key>0)
			{
				$position.=' > ';
			}
			$position.='<a href="'.U('imagelists','type='.$type.'&multiple='.$multiple.'&root='.base64_encode($str).'').'">'.$val.'</a>';
		}
		switch(C('upload_file_folder'))
		{
			case '1':
				$filepath='upfile/'.date("Y");
				break;
			case '2':
				$filepath='upfile/'.date("Y").'/'.date("m");
				break;
			case '3':
				$filepath='upfile/'.date("Y").'/'.date("m").'/'.date("d");
				break;
			default:
				$filepath='upfile/'.date("Ym");
				break;
		}
		$uploadurl=U('imagelists','type='.$type.'&multiple='.$multiple.'&root='.base64_encode($filepath));
		$this->assign('dir',$root);
		$this->assign('position',$position);
		$this->assign('file',$file);
		$this->assign('uploadurl',$uploadurl);
		$this->assign('action',$action);
		$this->assign('multiple',$multiple);
		$this->display('module/other/image-list.php');
	}

	function deal_arr($data,$root,$name=[])
	{
		unset($data[0]);unset($data[1]);
		$a=[];
		$b=[];
		foreach($data as $key=>$val)
		{
			if(is_dir($root.'/'.$val))
			{
				$a[$key]=['0'=>iconv("gb2312","utf-8",$val),'1'=>filemtime($root.'/'.$val)];
			}
			elseif(is_file($root.'/'.$val))
			{
				$ext=strtolower(strrchr($root.'/'.$val,'.'));
				$b[filemtime($root.'/'.$val)]=['0'=>iconv("gb2312","utf-8",$val),'1'=>filemtime($root.'/'.$val),'2'=>formatBytes(filesize($root.'/'.$val)),'3'=>$ext,'4'=>self::is_image($ext)];
			}
			else
			{
				unset($data[$key]);
			}
		}
		krsort($a);
		krsort($b);
		return ['0'=>$a,'1'=>$b];
	}

	public function is_image($a)
	{
		if(in_array($a,['.gif','.jpg','.jpeg','.png','.bmp']))
		{
			return '1';
		}
		else
		{
			return '0';
		}
	}
}