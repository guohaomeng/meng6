<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>登录页面</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body class="bg-login">

    <div class="ui-login am-animation-scale-up">
        <div class="logo"><a href="{WEB_ROOT}"><img src="data:image/gif;base64,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"></a></div>
        <form id="form_login" method="post">
            <div class="group">
                <input type="text" name="t0" placeholder="请输入用户名" class="am-form-field am-radius" data-rule="用户名:required;username;"><em class="am-icon-user am-icon-fw"></em>
            </div>
            <div class="group">
                <input type="password" name="t1" placeholder="请输入密码" class="am-form-field am-radius" data-rule="密码:required;password;"><em class="am-icon-lock am-icon-fw"></em>
            </div>
            {if C('admin_code')==1}
            <div class="group">
                <input type="text" name="t2" id="t2" placeholder="请输入验证码" class="am-form-field am-radius" data-rule="验证码:required;"><em class="am-icon-ticket am-icon-fw"></em>
                <img src="{U('code')}" title="点击更换验证码">
            </div>
            {/if}
            <div class="group">
                <input type="submit" value="登录" class="am-btn am-btn-primary am-btn-block am-radius">
            </div>
        </form>
        <div id="myContainer"></div>
        <div class="am-text-center am-text-xs am-animation-slide-bottom am-animation-delay-1"><a href="https://www.sdcms.cn" target="_blank">Powered By Sdcms.Cn</a><br>建议在至少1280*1024分辨率下使用</div>
    </div>
<script>
$(function(){
    toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$("img").click(function(){
		var img=$(this).attr("src");
		if(img.indexOf('?')>0)
		{
			$(this).attr("src",img+'&random='+Math.random());
		}
		else
		{
			$(this).attr("src",img.replace(/\?.*$/,'')+'?'+Math.random());
		}
		$("#t2").val("");
	});
    $('#form_login').validator({
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
				url:'{U("check")}',
				data:$(form).serialize(),
				error:function(e){alert(e.responseText);},
				success:function(d)
				{
					$.AMUI.progress.set(1.0);
					if(d.state=='success')
					{
						toastr.success(d.msg);
						setTimeout(function(){location.href='{N(MODULE_NAME)}';},1500);
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