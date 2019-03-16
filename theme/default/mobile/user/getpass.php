<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>忘记密码_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	<section>
        	<div class="subject">
                <b>忘记密码</b>
            </div>
            <div class="clear"></div>
            <div class="intro am-padding-top">
            	<form class="am-form reg_css">
                    <div class="am-form-group">
                        <label>邮箱</label>
                        <input type="text" name="email" placeholder="请输入注册时填写的邮箱" data-rule="邮箱:required;email;">
                    </div>
                    {if sdcms[user_getpass_auth]==1}
                    <div class="am-form-group">
                        <label>验证码</label>
                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-8"><input type="text" name="code" id="code" placeholder="请输入验证码" data-rule="验证码:required;"></div>
                            <div class="am-u-sm-4 am-text-center"><img src="{U('code')}" height="40" id="verify" title="点击更换验证码"></div>
                        </div>
                    </div>
                    {/if}
                    <div class="am-form-group">
                        <label>邮箱验证码</label>
                        <div class="am-g am-g-collapse">
                            <div class="am-u-sm-8"><input type="text" name="ecode" id="ecode" placeholder="请输入邮箱验证码" data-rule="邮箱验证码:required;"></div>
                            <div class="am-u-sm-4 am-text-center"><button type="button" class="am-btn am-btn-default">获取验证码</button></div>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label>新密码</label>
                        <input type="password" name="password" placeholder="请输入新密码" data-rule="新密码:required;password;">
                    </div>
                    <div class="am-form-group">
                        <label>确认密码</label>
                        <input type="password" name="repass" placeholder="请再次输入密码" data-rule="确认密码:required;password;match(password)">
                    </div>
                    <p><input type="submit" class="am-btn am-btn-primary am-btn-block" value="保存密码"></p>
                </form>
            </div>
        </section>
        
    </article>
    {include file="mobile/foot.php"}
	<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
    <script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
    <script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
    <script>
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
    $(function(){
        toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
        {if sdcms[user_getpass_auth]==1}
        $("#verify").click(function(){
            $(this).attr("src",$(this).attr("src")+"{iif(sdcms[url_mode]==1,"&","?")}rnd="+Math.round());
            $("#code").val("");
        });{/if}
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
            {if sdcms[user_getpass_auth]==1}
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
                url:"{U('getpasscode','','',1)}",
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