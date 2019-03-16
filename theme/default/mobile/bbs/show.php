<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{$title}_{sdcms[bbs_webname]}</title>
<meta name="keywords" content="{sdcms[bbs_seokey]}">
<meta name="description" content="{sdcms[bbs_seodesc]}">
<script src="{WEB_ROOT}public/ueditor/ueditor.config.js"></script>
<script src="{WEB_ROOT}public/ueditor/ueditor.all.min.js"></script>
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	<section>
        <div class="bbs_show">
            <div class="title">
                <h1>{$title}</h1>
                <div class="info">{$uname}　　{formatTime($createdate)}　　<span class="am-icon-eye am-icon-fw"></span>{$hits}　　<span class="am-icon-comment-o am-icon-fw"></span>{$replynum}{if $islogin==$userid}　　<a href="{N('bbsedit','','id='.$id.'')}"><span class="am-icon-edit am-icon-fw"></span>编辑</a>{/if}</div>
            </div>
            {if $view_lever==1}
                <div class="content">{$content}</div>
            {else}
                {if $islogin==0}
                <div class="tips">您需要登录后才可以查看，请先<a href="{N('login')}">登录</a>或<a href="{N('reg')}">注册</a></div>
                {elseif $view_lever==0}
                <div class="tips">您所在用户组，无法查看帖子</div>
                {else}
                <div class="content">{$content}</div>
                {/if}
            {/if}
         </div>
         
         <div class="bbs_reply">
                 	<div class="title">最新回复</div>
                    
                    {sdcms:rs pagesize="10" num="3" table="sd_bbs_reply" join="left join sd_user on sd_bbs_reply.userid=sd_user.id" where="sd_bbs_reply.islock=1 and bbsid=$id and istopic=0" order="replyid" key="replyid"}
                    <article class="am-comment am-margin-bottom">
                        <img class="am-comment-avatar" src="{if strlen($rs[uface])}{$rs[uface]}{else}{WEB_ROOT}upfile/noface.gif{/if}" alt="{$rs[uname]}">
                        <div class="am-comment-main">
                            <header class="am-comment-hd">
                                <div class="am-comment-meta"><a class="am-comment-author">{$rs[uname]}</a>　<time>{formatTime($rs[createdate])}</time></div>
                                <div class="am-comment-actions"><a>{switch ($i+15*($page-1))}{case 1}沙发{/case}{case 2}板凳{/case}{case 3}地板{/case}{default}{$i+15*($page-1)}楼{/switch}</a></div>
                            </header>
                            <div class="am-comment-bd">
                            	{if $view_lever==1}
                                    {$rs[content]}
                                    {if $rs[reply]<>''}<blockquote><strong>管理员回复：</strong>{$rs[reply]}</blockquote>{/if} 
                                {else}
                                    {if $islogin==0}
                                    <div class="tips">您需要登录后才可以查看，请先<a href="{N('login')}">登录</a>或<a href="{N('reg')}">注册</a></div>
                                    {elseif $view_lever==0}
                                    <div class="tips">您所在用户组，无法查看帖子</div>
                                    {else}
                                        {$rs[content]}
                                        {if $rs[reply]<>''}<blockquote><strong>管理员回复：</strong>{$rs[reply]}</blockquote>{/if}                                
                                    {/if}
                                {/if}
                            </div>
                        </div>
                    </article>
                    {/sdcms:rs}
                    {if $pg->totalpage>1}
                    <div class="pagelist"><ul>{$showpage}</ul></div>
                    {/if}
                    {if $islogin==0}
                        <div class="form_reply">
                            <div class="face"><img src="{WEB_ROOT}upfile/noface.gif"><p>{$r_uname}</p></div>
                            <div class="info">
                                <textarea placeholder="您需要登录后才可以回复" disabled></textarea>
                                <input type="submit" value="回复" disabled>
                            </div>
                            <div class="clear"></div>
                        </div>
                    {else}
                        {if $reply_lever==0}
                        <div class="form_reply">
                            <div class="face"><img src="{WEB_ROOT}upfile/noface.gif"><p>{$r_uname}</p></div>
                            <div class="info">
                                <textarea placeholder="您所在用户组没有回帖权限" disabled></textarea>
                                <input type="submit" value="回复" disabled>
                            </div>
                            <div class="clear"></div>
                        </div>
                        {else}
                        <form method="post" class="post_reply">
                            <div class="form_reply">
                                <div class="face"><img src="{if strlen($r_uface)}{$r_uface}{else}{WEB_ROOT}upfile/noface.gif{/if}"><p>{$r_uname}</p></div>
                                <div class="info">
                                    <script id="content" name="content" type="text/plain" style="height:150px;"></script>
                                    <script>UE.getEditor('content',{serverUrl:'{U('home/upload/index')}',toolbars:editorBbs});</script>
                                    <input type="submit" value="回复">
                                </div>
                                <div class="clear"></div>
                            </div>
                        </form>
                        {/if}
                    {/if}
                 </div>

            </div>
    	 </section>
    </article>
    {include file="mobile/foot.php"}
    <link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
    <script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
    <script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
    <script>
	$(function(){
		{if $islogin!=0&&$reply_lever==1}
		//快捷键提交评论
	    $(".post_reply").find('textarea').on("keydown", function(e){
	    	e.stopPropagation();
	    	if(e.ctrlKey && e.which ==13){
	    		$('.post_reply').submit();
	    	}
	    });
		toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
		$('.post_reply').validator({
			timely:2,
			stopOnError:true,
			focusCleanup:true,
			ignore:':hidden',
			theme:'yellow_right_effect',
			valid:function(form)
			{
				var content=UE.getEditor('content').getContent();
				if(content=='')
				{
					toastr.error('回复内容不能为空');
					return false;	
				}
				$.AMUI.progress.inc();
				$.ajax({
					type:'post',
					cache:false,
					dataType:'json',
					url:"{U('home/bbs/reply','id='.$id.'')}",
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
		{/if}
	})
	</script>
</body>
</html>