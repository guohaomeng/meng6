<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>编辑主题_{if strlen(sdcms[bbs_seotitle])>0}{sdcms[bbs_seotitle]}_{/if}{sdcms[bbs_webname]}</title>
<meta name="keywords" content="{sdcms[bbs_seokey]}">
<meta name="description" content="{sdcms[bbs_seodesc]}">
<script src="{WEB_ROOT}public/ueditor/ueditor.config.js"></script>
<script src="{WEB_ROOT}public/ueditor/ueditor.all.min.js"></script>
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	<section>
        	<div class="newpost">
                 <!---->
                 <form class="am-form am-form-horizontal form-add" method="post">
                      <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">标题</label>
                        <div class="am-u-sm-10">
                        	<input type="text" name="title" value="{$title}" size="60" maxlength="50" data-rule="标题:required;">
                        </div>
                      </div>
                      <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">内容</label>
                        <div class="am-u-sm-10">
                        	<script id="content" name="content" type="text/plain" style="height:260px;">{$content}</script>
                            <script>UE.getEditor('content',{serverUrl:'{U('home/upload/index')}',toolbars:editorBbs});</script>
                        </div>
                      </div>
                      <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">验证</label>
                        <div class="am-u-sm-10">
                        	<input type="text" name="code" id="code" size="8" maxlength="8" data-rule="验证码:required;"> <img src="{U('code')}" height="40" id="verify" title="点击更换验证码"> <span class="msg-box" for="code"></span>
                        </div>
                      </div>
                      <div class="am-form-group">
                        <div class="am-u-sm-10 am-u-sm-offset-2">
                          <button type="submit" class="am-btn am-btn-primary am-margin-right">保存</button>
                          <button type="button" class="am-btn am-btn-default" onClick="location.href='{PRE_URL}'">返回</button>
                        </div>
                      </div>
                    </form>
                 <!---->
                </div>
        </section>
    </article>
    {include file="mobile/foot.php"}
    <link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
    <script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
    <script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
    <script>
	$(function(){
		$("#nav_bbs").addClass("hover");
		toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
		$("#verify").click(function(){
			$(this).attr("src",$(this).attr("src")+"{iif(sdcms[url_mode]==1,"&","?")}rnd="+Math.round());
			$("#code").val("");
		});
		$('.am-form').validator({
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
							setTimeout(function(){location.href='{PRE_URL}';},1500);
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