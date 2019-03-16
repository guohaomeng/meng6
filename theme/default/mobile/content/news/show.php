<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{if strlen($seotitle)>0}{$seotitle}_{/if}{$title}_{if $page>1}第{$page}页_{/if}{$catename}_{sdcms[web_name]}</title>
<meta name="keywords" content="{if strlen($seokey)>0}{$seokey}{else}{$title}{/if}">
<meta name="description" content="{if strlen($seodesc)>0}{$seodesc}{else}{$title}{/if}">
{include file="mobile/wxshare.php"}
</head>

<body>
	{include file="mobile/head.php"}
    <article>
    	<section>
            <div class="news_show">
                <h1>{$title}</h1>
                <div class="info">日期：{date('Y-m-d',$createdate)}　人气：{$hits}</div>
                <div class="intro">
                    {$content}
                    <div class="clear"></div>
                </div>
                <div class="pagelist"><ul>{pagelist($page,$pagenum,3)}</ul></div>
                {if count($tags)>0}
                <hr class="am-margin-top-lg">
                <div class="tags"><a href="{N('tags')}" class="hover">标签</a>{foreach $tags as $rs}<a href="{U('home/other/taglist/','tagname='.$rs.'')}" title="{$rs}">{$rs}</a>{/foreach}</div>
                {/if}
            </div>
        </section>
        
        <section>
        	<div class="subject">
                <b>您的观点</b>
            </div>
            <div class="clear"></div>
            <div class="news_show">
                <div class="other">
                    <a title="赞一下" class="digs" data-url="{U('home/other/digs/','id='.$id.'&act=up')}"><span class="am-icon-thumbs-o-up"></span><em>{$upnum}</em></a><a title="踩一下" class="digs"  data-url="{U('home/other/digs/','id='.$id.'&act=down')}"><span class="am-icon-thumbs-o-down"></span><em>{$downnum}</em></a>
                </div>
            </div>
        </section>
        
        {if count($tags)>0}
        <section>
        	<div class="subject">
                <b>相关内容</b>
            </div>
            <div class="clear"></div>
            <ul class="home_news">
               {sdcms:rs top="10" table="sd_content" where="$like" order="ontop desc,ordnum desc,id desc"}
               {rs:eof}暂无资料{/rs:eof}
               <li><span class="date">{date('m-d',$rs[createdate])}</span><div class="right"><a href="{$rs[link]}" title="{$rs[title]}" class="text-hide">{$rs[title]}</a><p class="text-hide">{cutstr(nohtml($rs[intro]),200)}</p></div></li>
               {/sdcms:rs}
             </ul>
             <div class="clear"></div>
        </section>
        {/if}
    </article>
    {include file="mobile/foot.php"}

</body>
</html>