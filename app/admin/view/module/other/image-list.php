<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>图片选择</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/js/dropzone.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body class="bg_white">
 <div class="border_iframe">
 	<div class="am-progress am-progress-striped am-active" id="progress"><div class="am-progress-bar am-progress-bar-success" style="width:0%"></div></div>
 	<div class="position_file"><button type="button" class="am-btn am-btn-secondary dropzone am-icon-cloud-upload am-text-sm am-margin-bottom-sm am-radius" config="piclist" url="{U('upload/upfile','type=3')}" maxsize="{C('upload_file_max')}">上传文件</button>{$position}</div>
    <div class="imagelist">
        <ul id="list">
            {if count($file)==0}
                <div class="am-padding-top am-text-sm">该目录下暂无文件</div>
            {/if}
            {foreach $file as $key=>$val}
            {php list($name,$type)=explode(".",$val[0])}
            {if $val[4]==1}
            <li data-url="{WEB_ROOT}{$dir.'/'.$val[0]}" title="{$val[0]}"><div class="preview"><img src="{WEB_ROOT}{$dir.'/'.$val[0]}" /><span class="file-title">{$val[0]}</span></div></li>
            {else}
            <li data-url="{WEB_ROOT}{$dir.'/'.$val[0]}" title="{$val[0]}"><div class="preview"><i class="file-preview file-type-{$type}"></i><span class="file-title">{$val[0]}</span></div></li>
            {/if}
            {/foreach}
        </ul>
    </div>
</div>

<script>
$(function(){
	toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$(document).on("click","#list li",function(){
		var val=$(this).attr("data-url");
		{if $multiple==0}
		$("#list li").each(function(){
			$(this).removeClass("hover");
		})
		{/if}
		$(this).toggleClass("hover");
		var str='';
		$("#list li").each(function(){
			var val=$(this).attr("data-url");
			if($(this).hasClass("hover"))
			{
				if(str!='')
				{
					str=str+'|';
				}
				str=str+val;
			}
		})
		$('#piclist',parent.document).val(str);
	});
});
$(".dropzone").dropzone(
{
	maxFiles:50,
	success:function(file,data,that)
	{
		data=jQuery.parseJSON(data);
        this.removeFile(file);
		if(data.state=="success")
		{
			toastr.success("上传成功："+data.msg);
		}
		else
		{
			toastr.error("上传失败："+data.msg);
		}
	},
	sending:function(file){
		$("#progress").css("display","block");
	},
	totaluploadprogress:function(progress){
		progress=Math.round(progress*100)/100;
        $("#progress .am-progress-bar").css("width",progress+"%");
		$("#progress .am-progress-bar").html(progress+"%");
    },
	queuecomplete:function(progress){
		setTimeout(function(){
			$("#progress").css("display","none");
			location.href='{$uploadurl}';
		},1000);
		
		
	},
	error:function(file,msg)
	{
		toastr.error(msg);
	}
});
</script>
</body>
</html>