<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>关注回复</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
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
    <div class="position">当前位置：微信管理 > <a href="{THIS_LOCAL}">关注回复</a></div>
    <div class="border">
        <!---->
        <legend>关注回复</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">是否启用</label>
                <div class="am-u-sm-10">
                    <select name="t0" id="t0" class="w420" data-rule="是否启用:required;">
                    	<option value="0"{if $reply_type==0} selected{/if}>关闭</option>
                        <option value="1"{if $reply_type==1} selected{/if}>文本回复</option>
                        <option value="2"{if $reply_type==2} selected{/if}>图文素材</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group" id="reply_content">
                <label class="am-u-sm-2 am-form-label">回复内容</label>
                <div class="am-u-sm-10">
                    <textarea name="t1" rows="5" cols="50" data-rule="回复内容:required;">{$reply_text}</textarea>
                </div>
            </div>
            <div class="am-form-group" id="reply_id">
                <label class="am-u-sm-2 am-form-label">素材选择</label>
                <div class="am-u-sm-10">
                	<div class="am-btn-group am-btn-group am-btn-toolbar am-margin-left-xs">
                        <a class="am-btn am-btn-primary am-radius" href="javascript:;" id="select_master" data-name="t2" data-url="{U('all')}">选择素材</a>
                        <a class="am-btn am-btn-primary am-radius" href="javascript:;" id="delete_master" data-name="t2">清空素材</a>
                    </div>
                    <input type="hidden" name="t2" id="t2" size="50" value="{$reply_id}">
                    <div class="master_box">
                        {sdcms:rp top="1" field="id,title" table="sd_mater" where="islock=1 and id=$reply_id" order="id desc" auto="j"}
                        {php $cid=$rp[id]}
                        <div class="list-loop" config="{$rp[id]}">
                            <div class="info">{$rp[title]}</div>
                            {sdcms:rs field="id,title,pic" table="sd_mater_data" where="cid=$cid and islock=1" order="ordnum,id"}
                            {if $i==1}
                            <div class="hover">
                                <img src="{$rs[pic]}" width="267" >
                                <a href="javascript:;">{$rs[title]}</a>
                            </div>
                            {else}
                            <div class="item">
                                <img src="{$rs[pic]}">
                                <a href="javascript:;">{$rs[title]}</a>
                            </div>
                            {/if}
                            {/sdcms:rs}
                            <div class="add"></div>
                        </div>
                        {/sdcms:rp}
                    </div>
                </div>
            </div>
            <div class="am-form-group">
                <div class="am-u-sm-10 am-u-sm-offset-2">
                    <button type="submit" class="am-btn am-btn-primary am-radius">保存</button>
                </div>
            </div>
        </form>
        <!---->
    </div>

<script>
$(function(){
	{if $reply_type==0}
	$("#reply_content,#reply_id").css("display","none");
	{/if}
	{if $reply_type==1}
	$("#reply_content").css("display","block");$("#reply_id").css("display","none");
	{/if}
	{if $reply_type==2}
	$("#reply_content").css("display","none");$("#reply_id").css("display","block");
	{/if}
	$("#t0").change(function(){
		switch ($(this).val())
		{
			case "1":
				$("#reply_content").css("display","block");$("#reply_id").css("display","none");
				break;
			case "2":
				$("#reply_content").css("display","none");$("#reply_id").css("display","block");
				break;
			default:
				$("#reply_content,#reply_id").css("display","none");
				break;
		}
	})
    toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$("#delete_master").click(function(){
		$(".master_box").html("");
		$("#t2").val("0");
	});
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
                        setTimeout(function(){location.href='{THIS_LOCAL}';},1500);
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
</script>
</body>
</html>