<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>编辑主题_{if strlen(sdcms[bbs_seotitle])>0}{sdcms[bbs_seotitle]}_{/if}{sdcms[bbs_webname]}</title>
<meta name="keywords" content="{sdcms[bbs_seokey]}">
<meta name="description" content="{sdcms[bbs_seodesc]}">
<script src="{WEB_ROOT}public/ueditor/ueditor.config.js"></script>
<script src="{WEB_ROOT}public/ueditor/ueditor.all.min.js"></script>
</head>

<body>
	
    {include file="head.php"}

    <div class="bg_inner">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a>{sdcms[bbs_webname]}</a></li>
                </ul>
            </div>
            <div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>

    <div class="width">
        <ol class="am-breadcrumb am-breadcrumb-slash">
            <li><a href="{WEB_DOMAIN}" class="am-icon-home">首页</a></li>
            <li><a href="{N('bbs')}">社区首页</a></li>
            <li class="am-active"><a href="{THIS_LOCAL}">编辑主题</a></li>
        </ol>
    </div>
    
	<div class="width minheight">
    	<!---->
        <div class="bbs">
            <div class="lefter box">
                <div class="nav">
                	<a href="{THIS_LOCAL}" class="hover">编辑主题</a>
                </div>
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
                        <label class="am-u-sm-2 am-form-label">验证码</label>
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
                
            </div>
            <div class="righter box">
            	<div class="searchs">
                	<h2>论坛搜索</h2>
                    <form action="{U('home/bbs/search')}" method="get">
                        {if sdcms[url_mode]==1}<input type="hidden" name="c" value="bbs" /><input type="hidden" name="a" value="search" />{/if}
                    	<input type="text" name="keyword" placeholder="请输入关键字"><input type="submit" value="搜索">
                    </form>
                </div>
                
                <div class="topic">
                	<h2>热门主题</h2>
                    <ul>
                    	{sdcms:rs top="20" table="sd_bbs" where="islock=1" order="hits desc,replynum desc,bbs_id desc"}
                    	<li><span{if $i<4} class="hover"{/if}>{substr("0".$i,-2)}</span><a href="{N('bbsshow','','id='.$rs[bbs_id].'')}" title="{$rs[title]}">{$rs[title]}</a></li>
                        {/sdcms:rs}
                    </ul>
                </div>
                
            </div>
        </div>
        <!---->
    </div>
    
    {include file="foot.php"}
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