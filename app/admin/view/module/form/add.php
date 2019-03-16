<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>添加表单</title>
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
    <div class="position">当前位置：系统管理 > <a href="{U('index')}">表单管理</a> > <a href="{THIS_LOCAL}">添加表单</a></div>
    <div class="border">
        <!---->
        <form class="am-form am-form-horizontal" method="post">
        <div class="am-tabs" data-am-tabs="{noSwipe: 1}">
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                <li class="am-active"><a href="javascript:void(0)">基本设置</a></li>
                <li><a href="javascript:void(0)">模板设置</a></li>
                <li><a href="javascript:void(0)">SEO设置</a></li>
            </ul>
            
            <div class="am-tabs-bd">
                
                <div class="am-tab-panel am-active">
                    <!--aaa-->
                   <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">表单名称</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t0" size="50" placeholder="请输入表单名称" data-rule="表单名称:required;">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">表单标识</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t1" size="50" maxlength="20" placeholder="字母和数字的组合，长度3-50个字符" data-rule="表单标识:required;">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">验证码</label>
                        <div class="am-u-sm-10">
                            <label class="am-radio-inline">
                                <input type="radio" name="t2" id="t2_1" value="1" checked><span for="t2_1">启用</span>
                            </label>
                            <label class="am-radio-inline">
                                <input type="radio" name="t2" id="t2_2" value="0" ><span for="t2_2">锁定</span>
                            </label>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">提交后返回</label>
                        <div class="am-u-sm-10">
                            <label class="am-radio-inline">
                                <input type="radio" name="t11" id="t11_1" value="1" checked><span for="t11_1">列表页</span>
                            </label>
                            <label class="am-radio-inline">
                                <input type="radio" name="t11" id="t11_2" value="2" ><span for="t11_2">当前页</span>
                            </label>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">邮件提醒</label>
                        <div class="am-u-sm-10">
                            <select name="t12" class="w420">
                                <option value="0">不使用邮件提醒</option>
                                {sdcms:rs top="0" table="sd_temp_mail" where="islock=1 and mkey=''" order="id desc"}
                                <option value="{$rs[id]}">{$rs[title]}</option>
                                {/sdcms:rs}
                            </select>
                        </div>
                    </div>
                    <div class="am-form-group"> 
                        <label class="am-u-sm-2 am-form-label">表单排序</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t3" size="50" value="0">
                            <span class="am-margin-left input-tips">数字越小越靠前</span>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">状态</label>
                        <div class="am-u-sm-10">
                            <label class="am-radio-inline">
                                <input type="radio" name="t4" id="t4_1" value="1" checked><span for="t4_1">启用</span>
                            </label>
                            <label class="am-radio-inline">
                                <input type="radio" name="t4" id="t4_2" value="0"><span for="t4_2">锁定</span>
                            </label>
                        </div>
                    </div>
                    <!--aaa-->
                </div>
                <div class="am-tab-panel">
                    <!--aaa-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">提交模板</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t5" id="t5" size="50">　<input type="button" class="am-btn am-btn-secondary template" data-name="t5" data-url="{U('theme/template')}" value="选择">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">列表模板</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t6" id="t6" size="50">　<input type="button" class="am-btn am-btn-secondary template" data-name="t6" data-url="{U('theme/template')}" value="选择">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">内容模板</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t7" id="t7" size="50">　<input type="button" class="am-btn am-btn-secondary template" data-name="t7" data-url="{U('theme/template')}" value="选择">
                        </div>
                    </div>
                    <!--aaa-->
                </div>
                <div class="am-tab-panel">
                    <!--bbb-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">优化标题</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t8" size="50">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">关键字</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t9" size="50">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">描述</label>
                        <div class="am-u-sm-10">
                            <textarea name="t10" rows="5" cols="50"></textarea>
                        </div>
                    </div>
                    <!--bbb-->
                </div>
                                              
            </div>
        </div>
        <div class="am-form-group am-margin-top">
            <button type="submit" class="am-btn am-btn-primary am-radius">保存</button>
            <button type="button" class="am-btn am-radius am-back">返回</button>
        </div>
        </form>

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