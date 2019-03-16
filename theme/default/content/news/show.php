<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>{if strlen($seotitle)>0}{$seotitle}_{/if}{$title}_{if $page>1}第{$page}页_{/if}{$catename}_{sdcms[web_name]}</title>
<meta name="keywords" content="{if strlen($seokey)>0}{$seokey}{else}{$title}{/if}">
<meta name="description" content="{if strlen($seodesc)>0}{$seodesc}{else}{$title}{/if}">
</head>

<body>

    {include file="head.php"}
    
    <div class="bg_inner am-animation-scale-up am-animation-delay-1">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a>{get_catename($topid)}</a></li>
                </ul>
            </div>
        	<div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>
    
    <div class="width inner_container am-animation-slide-bottom am-animation-delay-1">
    	
        <ol class="am-breadcrumb am-breadcrumb-slash am-animation-slide-top am-animation-delay-1">
            <li><a href="{WEB_DOMAIN}" class="am-icon-home">首页</a></li>
            {foreach $position as $rs}
            <li><a href="{cateurl($rs)}" title="{get_catename($rs)}">{get_catename($rs)}</a></li>
            {/foreach}
            <li class="am-active">内容</li>
        </ol>

        <div class="news_show">
            <h1>{$title}</h1>
            <div class="info">作者：{sdcms:rs table="sd_admin" where="adminid=$adminid"}{$rs[penname]}{/sdcms:rs}　日期：{date('Y-m-d',$createdate)}　人气：{$hits}</div>
            <div class="intro">
                {$content}
                <div class="clear"></div>
            </div>
            {if $pagenum>1}
            <div class="pagelist"><ul>{pagelist($page,$pagenum)}</ul></div>
            {/if}
            <div class="other">
                <p>你觉得这篇文章怎么样？</p><a title="赞一下" class="digs" data-url="{U('home/other/digs/','id='.$id.'&act=up','',1)}"><span class="am-icon-thumbs-o-up"></span><em>{$upnum}</em></a><a title="踩一下" class="digs"  data-url="{U('home/other/digs/','id='.$id.'&act=down','',1)}"><span class="am-icon-thumbs-o-down"></span><em>{$downnum}</em></a>
            </div>
            {if count($tags)>0}
            <hr class="am-margin-top-lg">
            <div class="tags"><span class="am-icon-tags"></span> 标签：{foreach $tags as $rs}<a href="{U('home/other/taglist/','tagname='.$rs.'')}" title="{$rs}" target="_blank">{$rs}</a>{/foreach}</div>
            {/if}
        </div>
        {if count($tags)>0}
        <div class="subject m20">
        	<b>相关内容</b>
        </div>
        <ul class="home_news_list">
           {sdcms:rs top="10" table="sd_content" where="$like" order="ontop desc,ordnum desc,id desc"}
           {rs:eof}暂无资料{/rs:eof}
           <li><span class="date">{date('m-d',$rs[createdate])}</em></span><div><a href="{$rs[link]}" title="{$rs[title]}">{$rs[title]}</a>        {cutstr(nohtml($rs[intro]),100,1)}</div></li>
           {/sdcms:rs}
         </ul>
         <div class="clear"></div>
         {/if}
    </div>
    
    {include file="foot.php"}
    
</body>
</html>