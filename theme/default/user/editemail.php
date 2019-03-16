<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>修改邮箱_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>

    {include file="head.php"}
    
    <div class="bg_inner am-animation-scale-up am-animation-delay-1">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a>修改邮箱</a></li>
                </ul>
            </div>
        	<div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>
    
    <div class="width inner_container am-animation-slide-bottom am-animation-delay-1">
        <ol class="am-breadcrumb am-breadcrumb-slash am-animation-slide-top am-animation-delay-1">
            <li><a href="{WEB_ROOT}" class="am-icon-home">首页</a></li>
            <li><a href="{N('user')}">会员中心</a></li>
            <li class="am-active">修改邮箱</li>
            
        </ol>
        <div class="user_center">
            <div class="lefter">
            	{include file="user/nav.php"}
            </div>
            <div class="righter">
                
                <div class="subject m20 am-animation-slide-bottom">
                    <b>修改邮箱</b>
                </div>
                {sdcms:rs top="1" table="sd_user left join sd_user_group on sd_user.uid=sd_user_group.gid" where="id=$userid"}
                <form method="post" class="reg_css">
                <ul>
                    <li><em>用户名：</em><input type="text" class="ip w" value="{get_user_info('uname')}" disabled></li>
                    <li><em>邮箱：</em><input name="email" type="text" class="ip w" value="{$rs[uemail]}" placeholder="请输入邮箱" data-rule="邮箱:required;email;"></li>
                    <li><input type="submit" value="修改邮箱" class="bnt"></li>
                </ul>
                </form>
                {/sdcms:rs}
            </div>
        </div>
        
    </div>
    
    {include file="foot.php"}
    <link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
    <script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
    <script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
    <script>
	$(function(){
		toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
		$('.reg_css').validator({
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