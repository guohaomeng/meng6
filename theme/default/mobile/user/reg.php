<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>会员注册_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	<section>
        	<div class="subject">
                <b>{if $ispai==1}完善资料{else}会员注册{/if}</b>
            </div>
            <div class="clear"></div>
            <div class="intro am-padding-top">
            	{if $ispai==1}
                <div class="api_user"><span>{$api_info.nickname}</span>，请完成账户绑定，如还没有账户，请先完善资料。　【<a href="{U('home/user/apiout')}">退出</a>】</div>
                {/if}
            	<form class="am-form reg_css">
                    <div class="am-form-group">
                        <label>用户名</label>
                        <input name="username" type="text" {if $ispai==1}value="{$api_info.nickname}" {/if}placeholder="请输入用户名" data-rule="用户名:required;username;">
                    </div>
                    <div class="am-form-group">
                        <label>密码</label>
                        <input type="password" name="password" placeholder="请输入密码" data-rule="密码:required;password;">
                    </div>
                    <div class="am-form-group">
                        <label>确认密码</label>
                        <input type="password" name="repass" placeholder="请再次输入密码" data-rule="确认密码:required;password;match(password)">
                    </div>
                    <div class="am-form-group">
                        <label>邮箱</label>
                        <input type="text" name="email" placeholder="请输入邮箱，用于找回密码等" data-rule="邮箱:required;email;">
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
                    {if sdcms[user_reg_type]==2&&sdcms[mail_type]>0}
                    <div class="am-form-group">
                        <label>邮箱验证码</label>
                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-8"><input type="text" name="ecode" id="ecode" placeholder="请输入邮箱验证码" data-rule="邮箱验证码:required;"></div>
                            <div class="am-u-sm-4 am-text-center"><button type="button" class="am-btn am-btn-default">获取验证码</button></div>
                        </div>
                    </div>
                    {/if}
                    <p><input type="submit" class="am-btn am-btn-primary am-btn-block" value="{if $ispai==1}保存{else}注册{/if}"></p>
                    <div class="am-text-center am-margin-bottom"><a href="{N('login')}">{if $ispai==1}绑定账户{else}已有账户登录{/if}</a></div>
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
    {if sdcms[user_reg_type]==2&&sdcms[mail_type]>0}
    function sms(t0)
    {
        var $button=$('.reg_css button');
        $button.text(""+t0+"秒后重发");
        t0=t0-1;
        if(t0>=0)
        {
            window.setTimeout("sms('"+t0+"')",1000);
        }
        else
        {
            $button.attr("disabled",false);
            $button.text("获取验证码");
        }
    }
    {/if}
	$(function(){
		toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
		{if sdcms[user_reg_auth]==1}
		$("#verify").click(function(){
			$(this).attr("src",$(this).attr("src")+"{iif(sdcms[url_mode]==1,"&","?")}rnd="+Math.round());
			$("#code").val("");
		});{/if}
        {if sdcms[user_reg_type]==2&&sdcms[mail_type]>0}
        $('.reg_css button').click(function(){
            var $email=$(this).parent().parent().parent().parent().find("[name=email]");
            var email=$email.val();
            var reg=/^[\w\+\-]+(\.[\w\+\-]+)*@[a-z\d\-]+(\.[a-z\d\-]+)*\.([a-z]{2,4})$/i;
            if(email=='')
            {
                toastr.error('请输入邮箱');
                $email.focus();
                return false;
            }
            if(!(reg.test(email)))
            {
                toastr.error('邮箱格式不正确');
                $email.focus();
                return false;
            }
            var code='';
            {if sdcms[user_reg_auth]==1}
                var $code=$(this).parent().parent().parent().parent().find("[name=code]");
                code=$code.val();
                if(code=='')
                {
                    toastr.error('请输入验证码');
                    $code.focus();
                    return false;
                }
            {/if}
            var that=this;
            $(that).attr("disabled",true);
            $.ajax({
                url:"{U('regcode','','',1)}",
                type:'post',
                cache:false,
                dataType:'json',
                data:'email='+encodeURIComponent(email)+'&code='+encodeURIComponent(code),
                error:function(e){alert(e.responseText);},
                success:function(d)
                {
                    if(d.state=='success')
                    {
                        toastr.success(d.msg);
                        sms(60);
                    }
                    else
                    {
                        toastr.error(d.msg);
                        $(that).attr("disabled",false);
                    }
                }
            });
        });
        {/if}
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
					error:function(e){alert(e.responseText);},
					success:function(d)
					{
						$.AMUI.progress.set(1.0);
						if(d.state=='success')
						{
							toastr.success(d.msg);
							setTimeout(function(){location.href='{N('login')}';},1500);
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