<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>编辑链接</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/js/dropzone.js"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<script src="{WEB_ROOT}public/dialog/dialog-min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
	<div class="am-progress am-progress-striped am-active" id="progress"><div class="am-progress-bar am-progress-bar-success" style="width:0%"></div></div>
    <div class="position">当前位置：扩展管理 > <a href="{U('index')}">链接管理</a> > <a href="{THIS_LOCAL}">编辑链接</a></div>
    <div class="border">
        <!---->
        <legend>编辑链接</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">网站名称</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t0" size="50" value="{$webname}" placeholder="请输入网站名称" data-rule="网站名称:required;">
                </div>
            </div>
            <div class="am-form-group{if C('link_logo')==0} dis{/if}">
                <label class="am-u-sm-2 am-form-label">网站Logo</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t1" id="t1" size="50" value="{$weblogo}">
                    <span class="am-btn-group"><button type="button" class="am-btn am-btn-secondary am-radius dropzone" config="t1" url="{U('upload/upfile','type=1')}" maxsize="{C('upload_image_max')}" title="上传">上传</button><button type="button" class="am-btn am-btn-primary am-radius fm-choose" data-name="t1" data-url="{U('upload/imagelist','type=1&multiple=0')}" data-type="1" data-multiple="0" title="选择">选择</button><button type="button" class="am-btn am-btn-secondary am-radius pic-preview" data-name="t1" title="预览">预览</button></span>
                    <span class="am-margin-left input-tips">可以为空</span>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">网址</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t2" size="50" value="{$weburl}" placeholder="请输入网址" data-rule="网址:required;">
                </div>
            </div>
            <div class="am-form-group{if C('link_class')==0} dis{/if}">
                <label class="am-u-sm-2 am-form-label">类别</label>
                <div class="am-u-sm-10">
                    <select name="t3" class="w420">
                    	<option value="0" >不分类</option>
                        {php $arr=explode("\r\n",C('link_class_data'))}
                        {foreach $arr as $key=>$val}
                        {php list($a,$b)=explode('|',$val)}
                        <option value="{$b}" {if $b==$classid} selected{/if}>{$a}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">排序</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t4" size="50" value="{$ordnum}">
                    <span class="am-margin-left input-tips">数字越小越靠前</span>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">状态</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t5" id="t5_1" value="1"{if $islock==1} checked{/if}><span for="t5_1">启用</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t5" id="t5_2" value="0"{if $islock==0} checked{/if}><span for="t5_2">锁定</span>
                    </label>
                </div>
            </div>
            <div class="am-form-group">
                <div class="am-u-sm-10 am-u-sm-offset-2">
                    <button type="submit" class="am-btn am-btn-primary am-radius">保存</button>
                    <button type="button" class="am-btn am-radius am-back">返回</button>
                </div>
            </div>
        </form>
        <!---->
    </div>

<script>
$(function(){
    toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
    $('.am-form').validator({
        timely:2,
        stopOnError:true,
        focusCleanup:true,
        ignore:':hidden',
        theme:'yellow_right_effect',
        valid:function(form)
        {
            $.AMUI.progress.inc();
            $.ajax({
                type:'post',
                cache:false,
                dataType:'json',
                url:'{THIS_LOCAL}',
                data:$(form).serialize(),
                error:function(e){alert(e.responseText);},
                success:function(d)
                {
                    $.AMUI.progress.set(1.0);
                    if(d.state=='success')
                    {
                        toastr.success(d.msg);
                        setTimeout(function(){location.href='{U("index")}';},1500);
                    }
                    else
                    {
                        toastr.error(d.msg);
                    }
                    
                }
            })
        }
    });
})
$(".dropzone").dropzone(
{
	maxFiles: 1,
	acceptedFiles: ".jpg,.gif,.png",
	success:function(file,data,that)
	{
		data=jQuery.parseJSON(data);
        this.removeFile(file);
		if(data.state=="success")
		{
			toastr.success("上传成功");
			$("#"+$(that).attr("config")).val(data.msg);
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