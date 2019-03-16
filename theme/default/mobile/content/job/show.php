<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{if strlen($seotitle)>0}{$seotitle}_{/if}{$title}_{$catename}_{sdcms[web_name]}</title>
<meta name="keywords" content="{if strlen($seokey)>0}{$seokey}{else}{$title}{/if}">
<meta name="description" content="{if strlen($seodesc)>0}{$seodesc}{else}{$title}{/if}">
{include file="mobile/wxshare.php"}
</head>

<body>
	{include file="mobile/head.php"}
    <article>
    	<section>
            <div class="job_show">
                <h1>{$title}</h1>
                <div class="info">
                    <ul>
                        <li><span>地点：</span>{$work_address}</li><li><span>性质：</span>{$work_nature}</li>
                        <li><span>学历：</span>{$work_education}</li><li><span>年限：</span>{$work_age}</li>
                        <li><span>薪资：</span>{$work_money}</li><li><span>人数：</span>{$work_num}</li>
                        <li><span>日期：</span>{date('Y-m-d',$createdate)}</li><li><span>人气：</span>{$hits}</li>
                    </ul>
                </div>
                
                <div class="tags"><div class="action"><a href="{U('home/form/add','fid=1&jobname='.$title.'')}">在线应聘</a></div>{if count($tags)>0}<a href="{N('tags')}" class="hover">标签</a>{foreach $tags as $rs}<a href="{U('home/other/taglist/','tagname='.$rs.'')}" title="{$rs}">{$rs}</a>{/foreach}{/if}</div>
                
            </div>
        </section>
        <section>
        	<div class="subject">
                <b>工作内容</b>
            </div>
            <div class="clear"></div>
            <div class="job_show">
                <div class="intro">
                    {$content}
                    <div class="clear"></div>
                </div>
            </div>
        </section>
        
        <section>
        	<div class="subject">
                <b>任职要求</b>
            </div>
            <div class="clear"></div>
            <div class="job_show">
                <div class="intro">
                    {$intro}
                    <div class="clear"></div>
                </div>
            </div>
        </section>
        
        <section>
        	<div class="subject">
                <b>您的观点</b>
            </div>
            <div class="clear"></div>
            <div class="job_show">
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