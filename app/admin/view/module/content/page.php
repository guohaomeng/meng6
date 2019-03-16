<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>内容管理</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script>var ue_url="{U('upload/imagelist','type=1&multiple=1')}";</script>
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/js/dropzone.js"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<script src="{WEB_ROOT}public/ueditor/ueditor.config.js"></script>
<script src="{WEB_ROOT}public/ueditor/ueditor.all.min.js"></script>
<script src="{WEB_ROOT}public/dialog/dialog-min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
	<div class="am-progress am-progress-striped am-active" id="progress"><div class="am-progress-bar am-progress-bar-success" style="width:0%"></div></div>
    <div class="position">当前位置：<a href="{U('lists')}">内容管理</a>{get_page_postion($classid)}</div>
    <div class="border">
        <!---->
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-1 am-form-label">组图</label>
                <div class="am-u-sm-11">
                    <span class="am-btn-group"><button type="button" class="am-btn am-btn-secondary dropzone-more" config="t1" url="{U('upload/upfile','type=1&thumb=1&water='.C('water_piclist').'')}" maxsize="{C('upload_image_max')}" title="上传">上传</button><button type="button" class="am-btn am-btn-primary am-radius fm-choose" data-name="t1" data-url="{U('upload/imagelist','type=1&multiple=1')}" data-type="0" data-multiple="1" 
title="选择">选择</button></span>	
                    <div class="imagelist">
                        <ul id="list_t1">
                            {php $data=json_decode($piclist,true)}
                            {if is_array($data)}
                            {foreach $data as $num=>$val}
                            <li num="{$num}">
                                <div class="preview">
                                    <input type="hidden" name="t1[{$num}][image]" value="{$val['image']}">
                                    <img src="{$val['image']}" />
                                </div>
                                <div class="intro">
                                    <textarea name="t1[{$num}][desc]" placeholder="图片描述...">{deal_strip($val['desc'])}</textarea>
                                </div>
                                <div class="action"><a href="javascript:;" class="img-left"><i class="am-icon-angle-double-left am-icon-fw"></i>左移</a><a href="javascript:;" class="img-right"><i class="am-icon-angle-double-right am-icon-fw"></i>右移</a><a href="javascript:;" class="img-del"><i class="am-icon-close am-icon-fw"></i>删除</a></div>
                            </li>
                            {/foreach}
                            {/if}
                        </ul>
                        <div class="am-cf"></div>
                    </div>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-1 am-form-label">介绍</label>
                <div class="am-u-sm-11">
                    <script id="t0" name="t0" type="text/plain" style="height:260px;">{$content}</script>
                    <script>UE.getEditor('t0',{serverUrl :'{U('upload/index')}'});</script>
                    <input type="button" class="am-btn am-btn-secondary am-btn-sm editor_savepic" data-url="{U('upload/outimage')}" data-name="t0" value="保存编辑器中外部图片">
                </div>
            </div>
            
            <div class="am-form-group">
                <div class="am-u-sm-11 am-u-sm-offset-1">
                    <button type="submit" class="am-btn am-btn-primary am-radius">保存</button>
                    <button type="button" class="am-btn am-radius am-back">返回</button>
                    {if $isdel==1}
                    <button type="button" class="am-btn am-radius isdel" data-url="{U('delpage','classid='.$classid.'')}">删除内容</button>
                    {/if}
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
			UE.getEditor('t0').sync();
			$("#t0").val(UE.getEditor('t0').getContent());
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
                    }
                    else
                    {
                        toastr.error(d.msg);
                    }
                    
                }
            })
        }
    });
	$(".isdel").click(function(){
        var url=$(this).attr("data-url");
        layer.confirm(
            '确定要删除？不可恢复！', 
            {
                btn: ['确定','取消']
            }, function()
            {
                $.ajax({
                    url:url,type:'post',dataType:'json',
					error:function(e){alert(e.responseText);},
                    success:function(d)
                    {
                        layer.closeAll();
                        if(d.state=='success')
                        {
                            toastr.success(d.msg);
                            setTimeout(function(){location.href='{THIS_LOCAL}';},1000);
                        }
                        else
                        {
                            toastr.error(d.msg);
                        }
                    }
                })
            }, function()
            {
               
            });
    });
});
$(".dropzone-more").dropzone(
{
	maxFiles:50,
	success:function(file,data,that)
	{
		data=jQuery.parseJSON(data);
        this.removeFile(file);
		if(data.state=="success")
		{
			var name=$(that).attr("config");
			var num=1;
			$("#list_"+name+" li").each(function()
			{
				var max=parseInt($(this).attr("num"));
				if (max>=num)
				{
					num=max+1;
				}
			});
			var html='';
			html+='<li num="'+num+'">';
			html+='	<div class="preview">';
			html+='		<input type="hidden" name="'+name+'['+num+'][image]" value="'+data.msg+'">';
			html+='		<img src="'+data.msg+'" />';
			html+='	</div>';
			html+='	<div class="intro">';
			html+='		<textarea name="'+name+'['+num+'][desc]" placeholder="图片描述..."></textarea>';
			html+='	</div>';
			html+='	<div class="action"><a href="javascript:;" class="img-left"><i class="am-icon-angle-double-left am-icon-fw"></i>左移</a><a href="javascript:;" class="img-right"><i class="am-icon-angle-double-right am-icon-fw"></i>右移</a><a href="javascript:;" class="img-del"><i class="am-icon-close am-icon-fw"></i>删除</a></div>';
			html+='</li>';
			$("#list_"+name).append(html);
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