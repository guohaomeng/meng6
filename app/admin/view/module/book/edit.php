<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>编辑留言</title>
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
    <div class="position">当前位置：扩展管理 > <a href="{U('index')}">留言管理</a> > <a href="{THIS_LOCAL}">编辑留言</a></div>
    <div class="border">
        <!---->
        <legend>编辑留言</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">姓名</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t0" size="50" value="{$truename}" data-rule="姓名:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">电话</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t1" size="50" value="{$tel}">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">手机</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t2" size="50" value="{$mobile}">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">留言内容</label>
                <div class="am-u-sm-10">
                    <textarea name="t3" rows="4" cols="50" data-rule="留言内容:required;">{$remark}</textarea>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">回复内容</label>
                <div class="am-u-sm-10">
                    <textarea name="t4" rows="4" cols="50">{$reply}</textarea>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">是否置顶</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t5" id="t5_1" value="1"{if $ontop==1} checked{/if}><span for="t5_1">是</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t5" id="t5_2" value="0"{if $ontop==0} checked{/if}><span for="t5_2">否</span>
                    </label>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">状态</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t6" id="t6_1" value="1"{if $islock==1} checked{/if}><span for="t6_1">已审</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t6" id="t6_2" value="0"{if $islock==0} checked{/if}><span for="t6_2">未审</span>
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