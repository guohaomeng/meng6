<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>编辑菜单</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
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
    <div class="position">当前位置：微信管理 > <a href="{U('index')}">菜单管理</a> > <a href="{THIS_LOCAL}">编辑菜单</a></div>
    <div class="border">
        <!---->
        <legend>编辑菜单</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">菜单名称</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t0" size="50" value="{$title}" placeholder="请输入菜单名称" data-rule="菜单名称:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">菜单类型</label>
                <div class="am-u-sm-10">
                    <select name="t1" id="t1" class="w420" data-rule="菜单类型:required;">
                    	{if $followid==0}<option value="0"{if $reply_type==0} selected{/if}>作为一级菜单</option>{/if}
                        <option value="1"{if $reply_type==1} selected{/if}>文本消息</option>
                        <option value="2"{if $reply_type==2} selected{/if}>图文素材</option>
                        <option value="3"{if $reply_type==3} selected{/if}>外链</option>
                        <option value="4"{if $reply_type==4} selected{/if}>小程序</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group" id="reply_content">
                <label class="am-u-sm-2 am-form-label">消息内容</label>
                <div class="am-u-sm-10">
                    <textarea name="t2" rows="5" cols="50" data-rule="消息内容:required;">{$reply_text}</textarea>
                </div>
            </div>
            <div class="am-form-group" id="reply_id">
                <label class="am-u-sm-2 am-form-label">素材选择</label>
                <div class="am-u-sm-10">
                	<div class="am-btn-group am-btn-group am-btn-toolbar am-margin-left-xs">
                        <a class="am-btn am-btn-primary am-radius" href="javascript:;" id="select_master" data-name="t3" data-url="{U('all')}">选择素材</a>
                        <a class="am-btn am-btn-primary am-radius" href="javascript:;" id="delete_master" data-name="t3">清空素材</a>
                    </div>
                    <input type="hidden" name="t3" id="t3" size="50" value="{$reply_id}">
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
            <div class="am-form-group" id="reply_url">
                <label class="am-u-sm-2 am-form-label">网页链接</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t4" size="50" value="{$reply_url}" data-rule="网页链接:required;">
                </div>
            </div>
            <div class="am-form-group dis" id="appid">
                <label class="am-u-sm-2 am-form-label">小程序appid</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t5" size="50" value="{$appid}" data-rule="小程序appid:required;">
                </div>
            </div>
            <div class="am-form-group dis" id="pagepath">
                <label class="am-u-sm-2 am-form-label">小程序页面路径</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t6" size="50" value="{$pagepath}" data-rule="小程序的页面路径:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">排序</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t7" size="50" value="{$ordnum}">
                    <span class="am-margin-left input-tips">数字越小越靠前</span>
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
	{if $reply_type==0}
	$("#reply_content,#reply_id,#reply_url,#appid,#pagepath").css("display","none");
	{/if}
	{if $reply_type==1}
	$("#reply_id,#reply_url,#appid,#pagepath").css("display","none");
	$("#reply_content").css("display","block");
	{/if}
	{if $reply_type==2}
	$("#reply_content,#reply_url,#appid,#pagepath").css("display","none");
	$("#reply_id").css("display","block");
	{/if}
	{if $reply_type==3}
	$("#reply_content,#reply_id,#appid,#pagepath").css("display","none");
	$("#reply_url").css("display","block");
	{/if}
	{if $reply_type==4}
	$("#reply_content,#reply_id").css("display","none");
	$("#reply_url,#appid,#pagepath").css("display","block");
	{/if}
	$("#t1").change(function(){
		switch ($(this).val())
		{
			case "1":
				$("#reply_id,#reply_url,#appid,#pagepath").css("display","none");
				$("#reply_content").css("display","block");
				break;
			case "2":
				$("#reply_content,#reply_url,#appid,#pagepath").css("display","none");
				$("#reply_id").css("display","block");
				break;
			case "3":
				$("#reply_content,#reply_id,#appid,#pagepath").css("display","none");
				$("#reply_url").css("display","block");
				break;
			case "4":
				$("#reply_content,#reply_id").css("display","none");
				$("#reply_url,#appid,#pagepath").css("display","block");
				break;
			default:
				$("#reply_content,#reply_id,#reply_url,#appid,#pagepath").css("display","none");
				break;
		}
	})
	$("#delete_master").click(function(){
		$(".master_box").html("");
		$("#t3").val("0");
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
</script>
</body>
</html>