<?php defined('IN_SDCMS') or die();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<title>{$webname}参数配置</title>
<link rel="stylesheet" href="../public/css/amazeui.min.css">
<link rel="stylesheet" href="../public/admin/css/toastr.css">
<link rel="stylesheet" href="css/app.css">
<script src="../public/js/jquery.min.js"></script>
<script src="../public/js/amazeui.min.js"></script>
<script src="../public/admin/js/toastr.min.js"></script>
<script src="../public/validator/jquery.validator.min.js?local=zh-CN"></script>
</head>

<body>
    <div class="bg_header">
        <div class="header width">
        	<div class="logo"></div>
            <div class="nav">
                <ul>
                	<li><a href="javascript:;">安装协议</a></li>
                    <li><a href="javascript:;">环境检测</a></li>
                    <li class="hover"><a href="javascript:;">参数配置</a></li>
                    <li><a href="javascript:;">安装结果</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="bg_inner"></div>
    <form class="am-form am-form-horizontal" id="config" method="post">
    <div class="width inner_container">
        <div class="install">
            <div class="subject">
                <b>MySql数据库配置</b>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">数据库IP</label>
                <div class="am-u-sm-5"><input type="text" name="t0" maxlength="50" placeholder="请输入数据库IP" data-rule="数据库IP:required;"></div>
                <div class="am-u-sm-5"><span class="msg-box" for="t0"></span></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">端口</label>
                <div class="am-u-sm-5"><input type="text" name="t1" maxlength="50" value="3306" data-rule="端口:required;"></div>
                <div class="am-u-sm-5"><span class="msg-box" for="t1"></span></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">数据库名称</label>
                <div class="am-u-sm-5"><input type="text" name="t2" maxlength="50" data-rule="数据库名称:required;"></div>
                <div class="am-u-sm-5"><span class="msg-box" for="t2"></span></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">数据库用户名</label>
                <div class="am-u-sm-5"><input type="text" name="t3" maxlength="50" data-rule="数据库用户名:required;"></div>
                <div class="am-u-sm-5"><span class="msg-box" for="t3"></span></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">数据库密码</label>
                <div class="am-u-sm-5"><input type="text" name="t4" maxlength="50" data-rule="数据库密码:required;"></div>
                <div class="am-u-sm-5"><span class="msg-box" for="t4"></span></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">表前缀</label>
                <div class="am-u-sm-5"><input name="t5" type="text" value="sd_" maxlength="50" data-rule="表前缀:required;"></div>
                <div class="am-u-sm-5"><span class="msg-box" for="t5"></span></div>
            </div>
            
            <div class="subject">
                <b>管理员配置</b>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">用户名</label>
                <div class="am-u-sm-5"><input type="text" name="t6" maxlength="12" data-rule="用户名:required;username;"></div>
                <div class="am-u-sm-5"><span class="msg-box" for="t6"></span></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">密码</label>
                <div class="am-u-sm-5"><input type="text" name="t7" maxlength="16" data-rule="密码:required;password"></div>
                <div class="am-u-sm-5"><span class="msg-box" for="t7"></span></div>
            </div>
            <div class="am-text-center am-margin-top-lg"><button type="button" class="am-btn am-btn-default am-margin-right" onClick="location.href='?act=check'">上一步</button><button type="submit" class="am-btn am-btn-primary">下一步</button></div>
        </div>
        
    </div>
    </form>
    <div class="am-text-center am-text-xs am-padding-bottom">版权所有 @  苏州烟火网络科技有限公司　<a href="http://www.sdcms.cn" target="_blank">Powered By Sdcms.Cn</a></div>

    <!--[if lt IE 9]>
    <div class="notsupport">
        <h1>:( 非常遗憾</h1>
        <h2>您的浏览器版本太低，请升级您的浏览器</h2>
    </div>
    <![endif]-->
    <script>
		$(function(){
			toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
			$('#config').validator({
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
						error:function(e){alert('数据库链接失败');},
						success:function(d)
						{
							$.AMUI.progress.set(1.0);
							if(d.state=='success')
							{
								toastr.success(d.msg);
								setTimeout(function(){location.href='?act=result';},1500);
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