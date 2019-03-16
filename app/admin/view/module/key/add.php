<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>关键字回复</title>
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
    <div class="position">当前位置：微信管理 > <a href="{U('index')}">关键字回复</a> > <a href="{THIS_LOCAL}">添加关键字</a></div>
    <div class="border">
        <!---->
        <legend>添加关键字</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">关键字名称</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t0" size="50" placeholder="请输入关键字" data-rule="关键字:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">回复类型</label>
                <div class="am-u-sm-10">
                    <select name="t1" id="t1" class="w420" data-rule="回复类型:required;">
                    	<option value="">请选择回复类型</option>
                        <option value="1">文本回复</option>
                        <option value="2">图文素材</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group dis" id="reply_content">
                <label class="am-u-sm-2 am-form-label">回复内容</label>
                <div class="am-u-sm-10">
                    <textarea name="t2" rows="5" cols="50" data-rule="回复内容:required;"></textarea>
                </div>
            </div>
            <div class="am-form-group dis" id="reply_id">
                <label class="am-u-sm-2 am-form-label">素材选择</label>
                <div class="am-u-sm-10">
                	<div class="am-btn-group am-btn-group am-btn-toolbar am-margin-left-xs">
                        <a class="am-btn am-btn-primary am-radius" href="javascript:;" id="select_master" data-name="t3" data-url="{U('all')}">选择素材</a>
                        <a class="am-btn am-btn-primary am-radius" href="javascript:;" id="delete_master" data-name="t3">清空素材</a>
                    </div>
                    <input type="hidden" name="t3" id="t3" size="50" value="0">
                    <div class="master_box">
                    </div>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">匹配方式</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t4" id="t4_1" value="1" checked><span for="t4_1">模糊匹配</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t4" id="t4_2" value="2"><span for="t6_2">完全匹配</span>
                    </label>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">排序</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t5" size="50" value="0">
                    <span class="am-margin-left input-tips">数字越小越靠前</span>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">状态</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t6" id="t6_1" value="1" checked><span for="t6_1">启用</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t6" id="t6_2" value="0"><span for="t6_2">锁定</span>
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
	$("#t1").change(function(){
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