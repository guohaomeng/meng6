<?php
/**
 * 作用：文件上传
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

final class sdcms_upload
{
	private $file;
	private $config=[
		'ext'   => [".gif",".jpg",".jpeg",".png"],
		'size'  => 1,
	];
	public $msg;
	public $state;
	public $oldname;
	private $newname;
	private $filesize;
	private $fileext;
	private $filepath;
	private $file_thumb;
	private $file_water;
	private $file_face;
	private $file_face_min;

	public function __construct($file,$type=1,$file_thumb=0,$file_water=0,$face=0,$facemin=200)
	{
		$this->file=$file;
		switch ($type)
		{
			case "1":#图片
				$this->config=[
					'ext'   => [".gif",".jpg",".jpeg",".png"],
					'size'  => C('upload_image_max'),
				];
				break;
			case "2":#视频
				$this->config=[
					'ext'   => [".swf",".mp4",".flv"],
					'size'  => C('upload_video_max')
				];
				break;
			case "3":#附件
				$this->config=[
					'ext'   => [".gif",".jpg",".jpeg",".png",
					".swf",".mp4",".flv",
					".doc",".docx",".xls",".xlsx",".ppt",".pptx",
					".rar",".zip",".7z",".gz",".tar",
					".apk",".iso",".pdf",".txt",".pem",".ico"],
					'size'  => C('upload_file_max'),
				];
				break;
		}
		$this->file_thumb=$file_thumb;
		$this->file_water=$file_water;
		$this->file_face=$face;
		$this->file_face_min=$facemin;
		switch(C('upload_file_folder'))
		{
			case '1':
				$this->filepath='upfile/'.date("Y").'/';
				break;
			case '2':
				$this->filepath='upfile/'.date("Y").'/'.date("m").'/';
				break;
			case '3':
				$this->filepath='upfile/'.date("Y").'/'.date("m").'/'.date("d").'/';
				break;
			default:
				$this->filepath='upfile/'.date("Ym").'/';
				break;
		}
		$this->state='error';
		$this->upfile();
	}

	public function upfile()
	{
		if(!isset($_FILES[$this->file]))
		{
			$this->msg='来源错误(可能是空间禁止了上传)';
			return;
		}
		$file=$_FILES[$this->file];
		if(!$file)
		{
			$this->msg='没有文件上传';
			return;
		}
		if($file['error'])
		{
			$this->msg=$this->getError($file['error']);
			return;
		}
		if(!file_exists($file['tmp_name']))
		{
			$this->msg='找不到临时文件';
			return;
		}
		if(!is_uploaded_file($file['tmp_name']))
		{
			$this->msg='非法上传';
			return;
		}
		#本地文件名
		$this->oldname=$file['name'];
		#文件大小
		$this->filesize=$file['size'];
		#文件后缀
		$this->fileext=strtolower(strrchr($this->oldname,'.'));
		#新文件名
		$this->newname=time().mt_rand(100,999).$this->fileext;
		#检查文件大小
		if($this->filesize>$this->config['size']*1024*1024)
		{
			$this->msg='文件超出大小限制';
			return;
		}
		#检查文件类型
		if(!in_array($this->fileext,$this->config['ext']))
		{
			$this->msg='文件类型错误';
			return;
		}
		if(in_array($this->fileext,array('.jpg','.gif','.jpeg','.png','.bmp')))
		{
			$imginfo=getimagesize($file['tmp_name']);
			if(empty($imginfo)||($this->fileext=='.gif'&&empty($imginfo['bits'])))
			{
				$this->msg='非法图像文件';
				return;
			}
		}
		$fileway=C('file_way');
		if($fileway=='local')
		{
			#文件夹不存在时
			if(!is_dir($this->filepath))
			{
			  #创建文件夹
			  if(!mkfolder($this->filepath))
			  {
				  $this->msg='文件夹创建失败';
				  return;
			  }
			}
		}
		
		#如果是图像文件
		if(preg_match('/^image\//i',$file['type']))
		{
			$image=new sdcms_image();
			#压缩
			if(C('thumb_open')=='1'&&$this->file_thumb==1)
	        {
	            $image->create_thumb($file['tmp_name'],C('thumb_min'));
	        }
	        #水印
	        if(C('water_open')=='1'&&$this->file_water==1)
	        {
	            $image->watermark($file['tmp_name']);
	        }
	        #头像处理
	        if($this->file_face==1)
	        {
	        	$image->create_thumb($file['tmp_name'],$this->file_face_min);
	        }
		}
		$filename=$this->filepath.$this->newname;
		
		$up=new $fileway();
		$result=$up->upload($file,$filename);
		if($result)
		{
			$this->msg=$up->backurl;
			$this->state='success';
		}
		else
		{
			$this->msg=$up->msg;
		}
	}

	public function showmsg()
	{
		return json_encode(['state'=>$this->state,'msg'=>$this->msg],JSON_UNESCAPED_UNICODE);
	}

	private function getError($errorNo)
	{
        switch ($errorNo)
        {
            case 1:
                return '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值！';
                break;
            case 2:
                return '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值！';
                break;
            case 3:
                return '文件只有部分被上传！';
                break;
            case 4:
                return '没有文件被上传！';
                break;
            case 6:
                return '找不到临时文件夹！';
                break;
            case 7:
                return '文件写入失败！';
                break;
            default:
                return '未知上传错误！';
        }
    }
}