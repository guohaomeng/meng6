<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>修改密码_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	<section>
        	<div class="subject">
                <b>修改密码</b>
            </div>
            <div class="clear"></div>
            <div class="intro am-padding-top">
            	<form class="am-form reg_css">
                    <div class="am-form-group">
                        <label>用户名</label>
                        <input type="text" value="{get_user_info('uname')}" disabled>
                    </div>
                    <div class="am-form-group">
                        <label>原密码</label>
                        <input type="password" name="oldpass" placeholder="请输入原密码" data-rule="原密码:required;password;">
                    </div>
                    <div class="am-form-group">
                        <label>新密码</label>
                        <input type="password" name="newpass" placeholder="请输入新密码" data-rule="新密码:required;password;">
                    </div>
                    <div class="am-form-group">
                        <label>确认新密码</label>
                        <input type="password" name="repass" placeholder="请再次输入新密码" data-rule="确认新密码:required;password;match(newpass)">
                    </div>
                    <p><button type="submit" class="am-btn am-btn-primary am-btn-block">修改密码</button></p>
                </form>
            </div>
        </section>
        
    </article>
    {include file="mobile/foot.php"}
	<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
    <script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
    <script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
    <script>
	$(function(){
		toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
		$('.reg_css').validator({
			timely:0,
			stopOnError:true,
			focusCleanup:true,
			ignore:':hidden',
			theme:'yellow_right_effect',
			msgMaker:function(opt){if(opt.type=='error'){toastr.clear();toastr.error(opt.msg);}},
			valid:function(form)
			{
				$.AMUI.progress.inc();
				$.ajax({
					type:'post',
					cache:false,
					dataType:'json',
					url:'{THIS_LOCAL}',
					data:$(form).serialize(),
					error:function(e){alert('服务器错误');},
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