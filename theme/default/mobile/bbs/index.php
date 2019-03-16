<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{if strlen($seotitle)>0}{$seotitle}_{/if}{sdcms[bbs_webname]}</title>
<meta name="keywords" content="{$seokey}">
<meta name="description" content="{$seodesc}">
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	
    	<section>
        	
            <div class="am-btn-group">
            	<button class="am-btn am-round am-btn-secondary">{if strlen($seotitle)>0}{$seotitle}{else}全部主题{/if}</button>
                <div class="am-dropdown" data-am-dropdown>
                	<button class="am-btn am-round am-btn-secondary am-dropdown-toggle" data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                    <ul class="am-dropdown-content">
                        <li{if $fid==0} class="am-active"{/if}><a href="{N('bbs')}" >全部主题</a></li>
                        {foreach $bbscate as $key=>$val}
                        <li{if $fid==$val['cateid']} class="am-active"{/if}><a href="{N('bbs','','fid='.$val['cateid'].'')}" title="{$val['catename']}">{$val['catename']}</a></li>
                        {/foreach}
                    </ul>
                </div>
            </div>
            
            <a href="{N('bbsadd','','fid='.$fid.'')}" class="am-round am-btn am-btn-warning am-fr">发布主题</a>
            
            <div class="clear"></div>
            <ul class="bbs_list">
                {sdcms:rs pagesize="20" num="3" table="sd_bbs" join="left join sd_user on sd_bbs.userid=sd_user.id" where="sd_bbs.islock=1 $where" order="ontop desc,bbs_id desc" key="bbs_id"}
                {rs:eof}<p>没有主题</p>{/rs:eof}
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
             
             <div class="bbs_search">
                <form action="{U('home/bbs/search')}" method="get">
                    {if sdcms[url_mode]==1}<input type="hidden" name="c" value="bbs" /><input type="hidden" name="a" value="search" />{/if}
                    <input type="text" name="keyword" placeholder="请输入关键字"><input type="submit" value="搜索">
                </form>
            </div>
             
        </section>
    </article>
    {include file="mobile/foot.php"}

</body>
</html>