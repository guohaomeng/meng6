<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>{$tagname}_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>

    {include file="head.php"}
    
    <div class="bg_inner am-animation-scale-up am-animation-delay-1">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a href="{N('tags')}">标签</a></li>
                </ul>
            </div>
        	<div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>
    
    <div class="width inner_container am-animation-slide-bottom am-animation-delay-1">
    	
        <ol class="am-breadcrumb am-breadcrumb-slash am-animation-slide-top am-animation-delay-1">
            <li><a href="{WEB_DOMAIN}" class="am-icon-home">首页</a></li>
            <li><a href="{N('tags')}" title="标签">标签</a></li>
            <li class="am-active">{$tagname}</li>
        </ol>
        
        <h1>{$tagname}</h1>

        <ul class="news_list mt20">
           {sdcms:rs pagesize="20" table="sd_content" where="$where" order="ontop desc,ordnum desc,id desc"}
           <li><span class="date">{date('d',$rs[createdate])}<em>{date('Y',$rs[createdate])}-{date('m',$rs[createdate])}</em></span><div><a href="{$rs[link]}" title="{$rs[title]}" target="_blank">{str_replace($tagname,"<font color=red>$tagname</font>",$rs[title])}</a>        {cutstr(nohtml($rs[intro]),500,1)}</div></li>
           {/sdcms:rs}
         </ul>
         <div class="clear"></div>
         <div class="pagelist"><ul>{$showpage}</ul></div>
    </div>
    
    {include file="foot.php"}
    
</body>
</html>