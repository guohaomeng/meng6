<?php
/**
 * 作用：文件本地上传
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

final class local
{
	public $backurl='';
	public $msg='';
	
	public function upload($file,$filename)
	{
		$state=move_uploaded_file($file['tmp_name'],$filename);
		if($state)
		{
			$this->backurl=WEB_ROOT.$filename;
		}
		else
		{
			$this->msg='上传失败';
		}
		return $state;
	}

}