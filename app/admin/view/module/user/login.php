<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>快捷登录</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/js/dropzone.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
	<div class="am-progress am-progress-striped am-active" id="progress"><div class="am-progress-bar am-progress-bar-success" style="width:0%"></div></div>
    <div class="position">当前位置：会员管理 > <a href="{U('user/index')}">会员管理</a> > <a href="{THIS_LOCAL}">快捷登录</a></div>
    <div class="border">
        <!---->
        <legend>快捷登录</legend>
        <form class="am-form am-form-horizontal" method="post">
            {sdcms:rp top="1" table="sd_config_group" where="islock=1 and gkey='login'" order="ordnum,id" auto="j"}
            {php $gid=$rp[id]}
            {sdcms:rs top="0" table="sd_config" where="islock=1 and gid=$gid" order="ordnum,id"}
                    {if $rs[ctype]==9}
                    <div class="am-panel am-panel-default"><div class="am-panel-hd">{$rs[ctitle]}</div></div>
                    {else}
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">{$rs[ctitle]}</label>
                        <div class="am-u-sm-10">
                            {switch $rs[ctype]}
                            {case 1}<input type="text" name="{$rs[ckey]}" size="50" value="{$rs[cvalue]}">{/case}
                            {case 2}<input type="password" name="{$rs[ckey]}" size="50" value="{$rs[cvalue]}">{/case}
                            {case 4}<input type="text" name="{$rs[ckey]}" id="{$rs[ckey]}" size="50" value="{$rs[cvalue]}"> <button type="button" class="am-btn am-btn-secondary dropzone" config="{$rs[ckey]}" title="上传">上传</button>{/case}
                            {case 5}<textarea name="{$rs[ckey]}" rows="4" cols="50">{$rs[cvalue]}</textarea>{/case}
                            {case 6}
                            {php $arr=explode(",",$rs[dvalue])}
                            {foreach $arr as $index=>$key}
                            {php $data=explode("|",$key)}
                            {if $rs[rtype]==1}<label class="am-radio-inline">{else}<div class="am-radio">{/if}
                                <input type="radio" name="{$rs[ckey]}" id="{$rs[ckey]}_{$index}" value="{$data[1]}" {if $rs[cvalue]=="".$data[1].""} checked{/if}>
                                {if $rs[rtype]==1}<span for="{$rs[ckey]}_{$index}">{$data[0]}</span>{else}<label for="{$rs[ckey]}_{$index}">{$data[0]}</label>{/if}
                                {if $rs[rtype]==1}</label>{else}</div>{/if}
                            {/foreach}
                            {/case}
                            {case 7}
                            {php $arr=explode(",",$rs[dvalue])}
                            {foreach $arr as $index=>$key}
                            {php $data=explode("|",$key)}
                            <label class="am-checkbox-inline">
                                <input type="checkbox" name="{$rs[ckey]}[]" id="{$rs[ckey]}_{$index}" value="{$data[1]}" {if stristr(",".$rs[cvalue].",",",".$data[1].",")} checked{/if}><span for="{$rs[ckey]}_{$index}">{$data[0]}</span>
                            </label>
                            {/foreach}
                            {/case}
                            {case 8}
                            <select name="{$rs[ckey]}" class="w420">
                            {if $rs[ckey]=='user_reg_group'}
                                <option value="0">不加入任何组</option>
                                {sdcms:rg top="0" table="sd_user_group"}
                                <option value="{$rg[gid]}" {if $rs[cvalue]==$rg[gid]} selected{/if}>{$rg[gname]}</option>
                                {/sdcms:rg}
                            {else}
                                {php $arr=explode(",",$rs[dvalue])}
                                {foreach $arr as $index=>$key}
                                {php $data=explode("|",$key)}
                                <option value="{$data[1]}" {if $rs[cvalue]=="".$data[1].""} selected{/if}>{$data[0]}</option>
                                {/foreach}
                            {/if}
                            
                            </select>
                            {/case}
                            {/switch}
                            <span class="am-margin-left input-tips">{$rs[dtext]}</span>
                        </div>
                    </div>
                    {/if}
                    {/sdcms:rs}
            <div class="am-form-group">
                <div class="am-u-sm-10 am-u-sm-offset-2">
                    <button type="submit" class="am-btn am-btn-primary am-radius">保存</button>
                    <button type="button" class="am-btn am-radius am-back">返回</button>
                </div>
            </div>
            {/sdcms:rp}
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
                url:'{U("index","id=".$gid."")}',
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
	url: "{U('upload/upfile')}",
	maxFiles: 1,
	maxFilesize: 10,
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