<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>我的回复_{sdcms[bbs_webname]}</title>
<meta name="keywords" content="{$seokey}">
<meta name="description" content="{$seodesc}">
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
            <li class="am-active"><a href="{THIS_LOCAL}">我的回复</a></li>
        </ol>
    </div>
    
	<div class="width minheight">
    	<!---->
        <div class="bbs">
            <div class="lefter">                     
                 <div class="box reply">
                 	<div class="title">我的回复</div>
                    
                    {sdcms:rs pagesize="15" table="sd_bbs_reply" join="left join sd_user on sd_bbs_reply.userid=sd_user.id" where="sd_bbs_reply.islock=1 and istopic=0 and userid=$uid" order="replyid desc"}
                    <article class="am-comment am-margin-bottom">
                        <a><img class="am-comment-avatar" src="{if strlen($rs[uface])}{$rs[uface]}{else}{WEB_ROOT}upfile/noface.gif{/if}" alt="{$rs[uname]}"></a>
                        <div class="am-comment-main">
                            <header class="am-comment-hd">
                                <div class="am-comment-meta">
                                    <a class="am-comment-author">{$rs[uname]}</a>
                                </div>
                                <div class="am-comment-actions"><a>{formatTime($rs[createdate])}</a></div>
                            </header>
                            <div class="am-comment-bd">
                                {$rs[content]}
                            </div>
                        </div>
                    </article>
                    {/sdcms:rs}
                    {if $pg->totalpage>1}
                    <div class="pagelist"><ul>{$showpage}</ul></div>
                    {/if}
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
    <script>
	$(function(){
		$("#nav_bbs").addClass("hover");
	})
	</script>
</body>
</html>