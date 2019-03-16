<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>我的主题_{sdcms[bbs_webname]}</title>
<meta name="keywords" content="{$seokey}">
<meta name="description" content="{$seodesc}">
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	
    	<section>
        	<div class="subject">
                <b>我的主题</b>
            </div>
            <div class="clear"></div>
            <ul class="bbs_list">
                {sdcms:rs pagesize="20" num="3" table="sd_bbs" join="left join sd_user on sd_bbs.userid=sd_user.id" where="sd_bbs.islock=1 and userid=$uid" order="ontop desc,bbs_id desc"}
                {rs:eof}没有主题{/rs:eof}
                <li>
                    <div class="face"><img src="{if strlen($rs[uface])}{$rs[uface]}{else}{WEB_ROOT}upfile/noface.gif{/if}" alt="{$rs[uname]}"></div>
                    <div class="info">
                        <h5><a href="{N('bbsshow','','id='.$rs[bbs_id].'')}" title="{$rs[title]}">{$rs[title]}</a>{if $rs[ontop]==1}<em>置顶</em>{/if}{if $rs[isnice]==1}<em>精</em>{/if}</h5>
                        <div class="nickname"><a href="{U('home/bbs/mytopic','uid='.$rs[userid].'')}">{$rs[uname]}</a>　{formatTime($rs[createdate])}</div>
                        <div class="other"><span class="am-icon-eye am-icon-fw"></span>{$rs[hits]}　<span class="am-icon-comment-o am-icon-fw"></span>{$rs[replynum]} </div>
                    </div>
                </li>
                {/sdcms:rs}
             </ul>
             <div class="clear"></div>
             <div class="pagelist"><ul>{$showpage}</ul></div>
        </section>
    </article>
    {include file="mobile/foot.php"}

</body>
</html>