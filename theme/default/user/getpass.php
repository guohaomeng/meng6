<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>忘记密码_{if strlen(sdcms[seo_title])>0}{sdcms[seo_title]}_{/if}{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>

    {include file="head.php"}
    
    <div class="bg_inner am-animation-scale-up am-animation-delay-1">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a>忘记密码</a></li>
                </ul>
            </div>
        	<div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>
    
    <div class="width inner_container am-animation-slide-bottom am-animation-delay-1">
        <ol class="am-breadcrumb am-breadcrumb-slash am-animation-slide-top am-animation-delay-1">
            <li><a href="{WEB_ROOT}" class="am-icon-home">首页</a></li>
            <li class="am-active">忘记密码</li>
        </ol>

        <!---->
            <div class="page_login">
                <div class="left">
                    <div class="subject">
                        <b>忘记密码</b>
                    </div>
                    <form method="post" class="reg_css">
                    <ul>
                        <li><em>邮箱：</em><input type="text" name="email" class="ip w" placeholder="请输入注册时填写的邮箱" data-rule="邮箱:required;email;"></li>
                        {if sdcms[user_getpass_auth]==1}
                        <li><em>验证码：</em><input type="text" name="code" id="code" class="ip wcode" placeholder="请输入验证码" data-rule="验证码:required;"> <img src="{U('code')}" height="40" id="verify" title="点击更换验证码"> <span class="msg-box" for="code"></span></li>{/if}
                        <li><em>邮箱验证码：</em><input type="text" name="ecode" id="ecode" class="ip wcode" placeholder="请输入邮箱验证码" data-rule="邮箱验证码:required;"><button type="button">获取验证码</button> <span class="msg-box" for="ecode"></span></li>
                        <li><em>新密码：</em><input type="password" name="password" class="ip w" placeholder="请输入新密码" data-rule="新密码:required;password;"></li>
                        <li><em>确认密码：</em><input type="password" name="repass" class="ip w" placeholder="请再次输入密码" data-rule="确认密码:required;password;match(password)"></li>
                        <li><input type="submit" value="修改密码" class="bnt"></li>
                    </ul>
                    </form>
                </div>
                <div class="right">
                    <p>没有账户？</p>
                    <a href="{N('reg')}" class="btn">立即注册</a>
                    <div class="quick">
                        <h5>快捷登录</h5>
                        {if sdcms[api_qq_open]==1}<a href="{WEB_DOMAIN}api/login/qq/api.php" title="QQ登录"><span class="am-icon-qq"></span> 登录</a>{/if}
                        {if sdcms[api_weibo_open]==1}<a href="{WEB_DOMAIN}api/login/weibo/api.php" title="微博登录"><span class="am-icon-weibo"></span> 登录</a>{/if}
                    </div>
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
        toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
        {if sdcms[user_getpass_auth]==1}
        $("#verify").click(function(){
            $(this).attr("src",$(this).attr("src")+"{iif(sdcms[url_mode]==1,"&","?")}rnd="+Math.round());
            $("#code").val("");
        });{/if}
        $('.reg_css button').click(function(){
            var $email=$(this).parent().parent().find("[name=email]")
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
                var $code=$(this).parent().parent().find("[name=code]");
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