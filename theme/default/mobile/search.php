<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{$keyword}_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>
	{include file="mobile/head.php"}
    
    <article>
    	<section>
        	<div class="subject">
                <b>{$keyword}</b>
            </div>
            <div class="clear"></div>
            <ul class="home_news">
                {sdcms:rs pagesize="20" num="3" table="sd_content" where="$where" order="ontop desc,ordnum desc,id desc"}
                <li><span class="date">{date('m-d',$rs[createdate])}</span><div class="right"><a href="{$rs[link]}" title="{$rs[title]}" class="text-hide">{str_replace($keyword,"<font color=red>$keyword</font>",$rs[title])}</a><p class="text-hide">{str_replace($keyword,"<font color=red>$keyword</font>",cutstr(nohtml($rs[intro]),200,1))}</p></div></li>
                {/sdcms:rs}
             </ul>
             <div class="clear"></div>
             <div class="pagelist"><ul>{$showpage}</ul></div>
        </section>
    </article>
    {include file="mobile/foot.php"}

</body>
</html>