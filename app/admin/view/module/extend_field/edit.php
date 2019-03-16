<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>编辑字段</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：系统管理 > <a href="{U('extend/index')}">内容扩展</a> > <a href="{U('index',"eid=".$eid."")}">{$mtitle}</a> > <a href="{U('index',"eid=".$eid."")}">字段管理</a> > <a href="{THIS_LOCAL}">编辑字段</a></div>
    <div class="border">
        <!---->
        <legend>编辑字段</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段名称</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t0" size="50" value="{$field_title}" placeholder="请输入字段名称" data-rule="字段名称:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段Key</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t1" size="50" value="{$field_key}" disabled="disabled">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段类型</label>
                <div class="am-u-sm-10">
                    <select name="t2" id="t2" class="w420" data-rule="字段类型:required;">
                        <option value="">请选择字段类型</option>
                        <option value="1"{if $field_type==1} selected{/if}>普通文本</option>
                        <option value="2"{if $field_type==2} selected{/if}>下拉列表</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group dis" id="listval">
                <label class="am-u-sm-2 am-form-label">候选值</label>
                <div class="am-u-sm-10">
                    <textarea name="t3" rows="5" cols="50" data-rule="候选值:required;">{$field_list}</textarea>
                    <span class="gray"><br>示范：项目名称1<br>　　　项目名称2</span>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">默认值</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t4" size="50" value="{$field_default}">
                </div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段排序</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t5" size="50" value="{$ordnum}">
                    <span class="am-margin-left input-tips">数字越小越靠前</span>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">状态</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t6" id="t6_1" value="1" {if $islock==1} checked{/if}><span for="t6_1">正常</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t6" id="t6_2" value="0" {if $islock==0} checked{/if}><span for="t6_2">锁定</span>
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
    {if $field_type==1}
    $("#listval").css("display","none");
    {else}
	$("#listval").css("display","block");
    {/if}
	$("#t2").change(function(){
        switch ($(this).val())
        {
            case "1":
				$("#listval").css("display","none");
				break;
            case "2":
				$("#listval").css("display","block");
				break;
        }
    });
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
                        setTimeout(function(){location.href='{U("index","eid=".$eid."")}';},1500);
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