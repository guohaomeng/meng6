<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>我的回复_{sdcms[bbs_webname]}</title>
<meta name="keywords" content="{$seokey}">
<meta name="description" content="{$seodesc}">
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	<section>
        <div class="subject">
            <b>我的回复</b>
        </div>
        <div class="bbs_reply">
        	{sdcms:rs pagesize="10" num="3" table="sd_bbs_reply" join="left join sd_user on sd_bbs_reply.userid=sd_user.id" where="sd_bbs_reply.islock=1 and istopic=0 and userid=$uid" order="replyid desc"}
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
    	 </section>
    </article>
    {include file="mobile/foot.php"}
</body>
</html>