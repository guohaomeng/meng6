<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>在线留言_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	<section>
        	<div class="subject">
                <b>在线留言</b>
            </div>
            <div class="clear"></div>
            <div class="intro am-padding-top">
            	{sdcms:rs pagesize="10" num="3" table="sd_book" where="islock=1" order="ontop desc,id desc"}
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
            </div>
        </section>
        
        <section>
        	<div class="subject">
                <b>我要留言</b>
            </div>
            <div class="clear"></div>
            <div class="intro">
            	<form class="am-form am-margin-top am-margin-bottom" id="form_book" method="post">
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
                <button type="submit" class="am-btn am-btn-block am-btn-primary">提交留言</button>
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
			$('#form_book').validator({
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