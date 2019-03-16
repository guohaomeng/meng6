<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>添加模型</title>
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
    <div class="position">当前位置：系统管理 > <a href="{U('index')}">模型管理</a> > <a href="{THIS_LOCAL}">添加模型</a></div>
    <div class="border">
        <!---->
        <legend>添加模型</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">模型名称</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t0" size="50" placeholder="请输入模型名称" data-rule="模型名称:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">模型标识</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t1" size="50" maxlength="20" placeholder="字母和数字的组合，长度3-50个字符" data-rule="模型标识:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">模型描述</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t2" size="50">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">列表模板</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t3" id="t3" size="50">　<input type="button" class="am-btn am-btn-secondary template" data-name="t3" data-url="{U('theme/template')}" value="选择">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">内容模板</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t4" id="t4" size="50">　<input type="button" class="am-btn am-btn-secondary template" data-name="t4" data-url="{U('theme/template')}" value="选择">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">模型排序</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t5" size="50" value="0">
                    <span class="am-margin-left input-tips">数字越小越靠前</span>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">表单分组</label>
                <div class="am-u-sm-10">
                    <textarea name="t7" rows="5" cols="50">基本设置|1
SEO设置|2
可选设置|3
                    </textarea>
                    <span class="am-margin-left input-tips"><br>示范：项目名称1|项目值1<br>　　　项目名称2|项目值2</span>
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