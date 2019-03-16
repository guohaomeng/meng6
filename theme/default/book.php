<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>在线留言_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>

    {include file="head.php"}
    
    <div class="bg_inner am-animation-scale-up am-animation-delay-1">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a href="{N('book')}">在线留言</a></li>
                </ul>
            </div>
        	<div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>
    
    <div class="width inner_container am-animation-slide-bottom am-animation-delay-1">
    	
        <ol class="am-breadcrumb am-breadcrumb-slash am-animation-slide-top am-animation-delay-1">
            <li><a href="{WEB_DOMAIN}" class="am-icon-home">首页</a></li>
            <li class="am-active"><a href="{N('book')}" title="在线留言">在线留言</a></li>
        </ol>
        
        <h1>在线留言</h1>
        
        <!---->
        <div class="subject m20">
        	<b>留言列表</b>
        </div>
        {sdcms:rs pagesize="10" table="sd_book" where="islock=1" order="ontop desc,id desc"}
        {rs:eof}暂无留言{/rs:eof}
        <div class="am-panel am-panel-default">
            <div class="am-panel-hd">
            	{$rs[truename]} <span class="am-fr">{date('Y-m-d H:i:s',$rs[createdate])}</span>
            </div>
            <div class="am-panel-bd">
            	<p>{$rs[remark]}</p>
                {if strlen($rs[reply])>0}<hr><strong>回复：</strong>{$rs[reply]}{/if}
            </div>
        </div>
        {/sdcms:rs}
        <div class="clear"></div>
        <div class="pagelist"><ul>{$showpage}</ul></div>

        <div class="subject m20">
        	<b>我要留言</b>
        </div>
        <form class="am-form am-margin-top" id="form_book" method="post">
            <div class="am-input-group am-form-group">
                <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
                <input type="text" name="truename" class="am-form-field" placeholder="请输入您的姓名" data-rule="姓名:required;">
            </div>
            <div class="am-input-group am-form-group">
                <span class="am-input-group-label"><i class="am-icon-phone am-icon-fw"></i></span>
                <input type="text" name="mobile" maxlength="11" class="am-form-field" placeholder="请输入您的手机号码" data-rule="手机号码:required;mobile;">
            </div>
            <div class="am-input-group am-form-group">
                <span class="am-input-group-label"><i class="am-icon-fax am-icon-fw"></i></span>
                <input type="text" name="tel" class="am-form-field" placeholder="请输入您的座机号码" >
            </div>
            <div class="am-input-group am-form-group">
                <span class="am-input-group-label"><i class="am-icon-comments-o am-icon-fw"></i></span>
                <textarea name="remark" rows="5" placeholder="请输入留言内容" data-rule="留言内容:required;"></textarea>
            </div>
        	<button type="submit" class="am-btn am-btn-primary">提交留言</button>
        </form>
        <!---->
    </div>
    
    {include file="foot.php"}
    <link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
    <script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
    <script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
    <script>
		$(function(){
			toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
			$('#form_book').validator({
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