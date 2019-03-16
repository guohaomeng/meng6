<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>修改邮箱_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	<section>
        	<div class="subject">
                <b>修改邮箱</b>
            </div>
            <div class="clear"></div>
            <div class="intro am-padding-top">
            	{sdcms:rs top="1" table="sd_user left join sd_user_group on sd_user.uid=sd_user_group.gid" where="id=$userid"}
            	<form class="am-form reg_css">
                    <div class="am-form-group">
                        <label>用户名</label>
                        <input type="text" value="{get_user_info('uname')}" disabled>
                    </div>
                    <div class="am-form-group">
                        <label>邮箱</label>
                        <input type="text" name="email" value="{$rs[uemail]}" placeholder="请输入邮箱" data-rule="邮箱:required;email;">
                    </div>
                    <p><button type="submit" class="am-btn am-btn-primary am-btn-block">修改邮箱</button></p>
                </form>
                {/sdcms:rs}
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