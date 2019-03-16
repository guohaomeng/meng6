<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>会员登录_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	<section>
        	<div class="subject">
                <b>{if $ispai==1}账户绑定{else}会员登录{/if}</b>
            </div>
            <div class="clear"></div>
            <div class="intro am-padding-top">
            	{if $ispai==1}
                <div class="api_user"><span>{$api_info.nickname}</span>，请完成账户绑定，如还没有账户，请先完善资料。　【<a href="{U('home/user/apiout')}">退出</a>】</div>
                {/if}
            	<form class="am-form login_css">
                    <div class="am-form-group">
                        <label>用户名</label>
                        <input type="text" name="username" placeholder="请输入用户名" data-rule="用户名:required;username;">
                    </div>
                    <div class="am-form-group">
                        <label>密码</label>
                        <input type="password" name="password" placeholder="请输入密码" data-rule="密码:required;password;">
                    </div>
                    {if sdcms[user_login_auth]==1}
                    <div class="am-form-group">
                        <label>验证码</label>
                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-8"><input type="text" name="code" id="code" placeholder="请输入验证码" data-rule="验证码:required;"></div>
                            <div class="am-u-sm-4 am-text-center"><img src="{U('code')}" height="40" id="verify" title="点击更换验证码"></div>
                        </div>
                    </div>
                    {/if}
                    <p><button type="submit" class="am-btn am-btn-primary am-btn-block">{if $ispai==1}保存{else}登录{/if}</button></p>
                    <div class="am-g am-g-collapse am-margin-bottom">
                        <div class="am-u-sm-6"><a href="{N('getpass')}">忘记密码</a></div>
                        <div class="am-u-sm-6 am-text-right"><a href="{N('reg')}">{if $ispai==1}完善资料{else}立即注册{/if}</a></div>
                    </div>
                </form>
            </div>
            {if $ispai==0&&(sdcms[api_qq_open]==1||sdcms[api_weibo_open]==1)}
            <div class="subject">
                <b>快捷登录</b>
            </div>
            <div class="clear"></div>
            <div class="quick">
            {if sdcms[api_qq_open]==1}<a href="{WEB_ROOT}api/login/qq/api.php" title="QQ登录"><span class="am-icon-qq"></span></a>{/if}
            {if sdcms[api_weibo_open]==1}<a href="{WEB_ROOT}api/login/weibo/api.php" title="微博登录"><span class="am-icon-weibo"></span></a>{/if}
        	</div>
            {/if}
        </section>
        
    </article>
    {include file="mobile/foot.php"}
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
					error:function(e){alert(e.responseText);},
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