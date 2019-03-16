<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>修改密码_{if strlen(sdcms[seo_title])>0}{sdcms[seo_title]}_{/if}{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>

    {include file="head.php"}
    
    <div class="bg_inner am-animation-scale-up am-animation-delay-1">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a>修改密码</a></li>
                </ul>
            </div>
        	<div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>
    
    <div class="width inner_container am-animation-slide-bottom am-animation-delay-1">
        <ol class="am-breadcrumb am-breadcrumb-slash am-animation-slide-top am-animation-delay-1">
            <li><a href="{WEB_ROOT}" class="am-icon-home">首页</a></li>
            <li><a href="{N('user')}">会员中心</a></li>
            <li class="am-active">修改密码</li>
            
        </ol>
        <div class="user_center">
            <div class="lefter">
            	{include file="user/nav.php"}
            </div>
            <div class="righter">
                
                <div class="subject m20 am-animation-slide-bottom">
                    <b>修改密码</b>
                </div>
                <form method="post" class="reg_css">
                <ul>
                    <li><em>用户名：</em><input type="text" class="ip w" value="{get_user_info('uname')}" disabled></li>
                    <li><em>原密码：</em><input type="password" name="oldpass" class="ip w" placeholder="请输入原密码" data-rule="原密码:required;password;"></li>
                    <li><em>新密码：</em><input type="password" name="newpass" class="ip w" placeholder="请输入新密码" data-rule="新密码:required;password;"></li>
                    <li><em>确认新密码：</em><input type="password" name="repass" class="ip w" placeholder="请再次输入新密码" data-rule="确认新密码:required;password;match(newpass)"></li>
                    <li><input type="submit" value="修改密码" class="bnt"></li>
                </ul>
                </form>
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