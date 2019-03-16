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

class UploadController extends HomeController
{
	public function index()
	{
		$action=F('get.action');
		switch ($action) 
		{
			case 'image':
				self::editor(1);
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
			'imageCompressBorder'=>9999,
			'imageInsertAlign'=>'none',
			'imageUrlPrefix'=>'',
			'imagePathFormat'=>'',

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
		    ));
		    return;
		}

		/* 获取指定范围的列表 */
		$len = count($files);

		for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i--)
		{
		    $list[] = $files[$i];
		}
		/*倒序
		for ($i = $end, $list = array(); $i < $len && $i < $end; $i++)
		{
		    $list[] = $files[$i];
		}
		*/

		/* 返回数据 */
		$result = json_encode(array(
		    "state" => "SUCCESS",
		    "list" => $list,
		    "start" => $start,
		    "total" => count($files)
		));

		echo $result;
	}

	function getfiles($path, $allowFiles, &$files = array())
	{
	    if (!is_dir($path)) return null;
	    if(substr($path, strlen($path) - 1) != '/') $path .= '/';
	    $handle = opendir($path);
	    while (false !== ($file = readdir($handle))) 
	    {
	        if ($file != '.' && $file != '..') {
	            $path2 = $path . $file;
	            if (is_dir($path2)) {
	                self::getfiles($path2, $allowFiles, $files);
	            } else {
	                if (preg_match("/\.(".$allowFiles.")$/i", $file)) {
	                    $files[] = array(
	                        'url'=> substr($path2, strlen($_SERVER['DOCUMENT_ROOT'])),
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
		$type=getint(F('get.type'),1);
		$up=new sdcms_upload('file',$type);
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
		$this->assign('action',$action);
		$this->assign('multiple',$multiple);
		$this->display('module/other/image.php');
	}
}