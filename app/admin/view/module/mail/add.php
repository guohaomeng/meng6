<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>添加模板</title>
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
<script src="{WEB_ROOT}public/ueditor/ueditor.config.js"></script>
<script src="{WEB_ROOT}public/ueditor/ueditor.all.min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：系统管理 > <a href="{U('index')}">邮件模板</a> > <a href="{THIS_LOCAL}">添加模板</a></div>
    <div class="border">
        <!---->
        <legend>添加模板</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">用途</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t0" size="50" placeholder="请输入用途" data-rule="用途:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">邮件标题</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t1" size="50" placeholder="请输入邮件标题" data-rule="邮件标题:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">邮件内容</label>
                <div class="am-u-sm-10">
                    <script id="t2" name="t2" type="text/plain" style="height:260px;"></script>
                    <script>UE.getEditor("t2",{serverUrl:"{U('upload/index')}"});</script>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">状态</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t3" id="t3_1" value="1" checked><span for="t3_1">启用</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t3" id="t3_2" value="0"><span for="t3_2">锁定</span>
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
				UE.getEditor('t2').sync();
				$("#t2").val(UE.getEditor('t2').getContent());
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