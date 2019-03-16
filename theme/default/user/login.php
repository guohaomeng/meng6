<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>会员登录_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>

    {include file="head.php"}
    
    <div class="bg_inner am-animation-scale-up am-animation-delay-1">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a>会员登录</a></li>
                </ul>
            </div>
        	<div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>
    
    <div class="width inner_container am-animation-slide-bottom am-animation-delay-1">
        <ol class="am-breadcrumb am-breadcrumb-slash am-animation-slide-top am-animation-delay-1">
            <li><a href="{WEB_ROOT}" class="am-icon-home">首页</a></li>
            <li class="am-active">会员登录</li>
        </ol>

        <!---->
            <div class="page_login">
                <div class="left">
                    <div class="subject">
                        <b>{if $ispai==1}账户绑定{else}会员登录{/if}</b>
                    </div>
                    {if $ispai==1}
                    <div class="api_user"><span>{$api_info.nickname}</span>，请完成账户绑定，如还没有账户，请先完善资料。　【<a href="{U('home/user/apiout')}">退出</a>】</div>
                    {/if}
                    <form method="post" class="login_css">
                    <ul>
                        <li><em>用户名：</em><input type="text" name="username" class="ip w" placeholder="请输入用户名" data-rule="用户名:required;username;"></li>
                        <li><em>密码：</em><input type="password" name="password" class="ip w" placeholder="请输入密码" data-rule="密码:required;password;"></li>
                        {if sdcms[user_login_auth]==1}
                        <li><em>验证码：</em><input type="text" name="code" id="code" class="ip wcode" placeholder="请输入验证码" data-rule="验证码:required;"> <img src="{U('code')}" height="40" id="verify" title="点击更换验证码"> <span class="msg-box" for="code"></span></li>{/if}
                        <li><input type="submit" value="{if $ispai==1}保存{else}登录{/if}" class="bnt">　<a href="{N('getpass')}" class="getpass">忘记密码</a></li>
                    </ul>
                    </form>
                </div>
                <div class="right">
                    <p>没有账户？</p>
                    <a href="{N('reg')}" class="btn">{if $ispai==1}完善资料{else}立即注册{/if}</a>
                    {if $ispai==0&&(sdcms[api_qq_open]==1||sdcms[api_weibo_open]==1)}
                    <div class="quick">
                        <h5>快捷登录</h5>
                        {if sdcms[api_qq_open]==1}<a href="{WEB_DOMAIN}api/login/qq/api.php" title="QQ登录"><span class="am-icon-qq"></span> 登录</a>{/if}
                        {if sdcms[api_weibo_open]==1}<a href="{WEB_DOMAIN}api/login/weibo/api.php" title="微博登录"><span class="am-icon-weibo"></span> 登录</a>{/if}
                    </div>
                    {/if}
                </div>
                <div class="clear"></div>
            </div>
            <!---->
        
    </div>
    
    {include file="foot.php"}
    <link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
    <script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
    <script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
    <script>
	$(function(){
		toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
		{if sdcms[user_login_auth]==1}
		$("#verify").click(function(){
			$(this).attr("src",$(this).attr("src")+"{iif(sdcms[url_mode]==1,"&","?")}rnd="+Math.round());
			$("#code").val("");
		});{/if}
		$('.login_css').validator({
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
							setTimeout(function(){location.href='{$lasturl}';},1500);
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