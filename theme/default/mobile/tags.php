<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>标签_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>
	{include file="mobile/head.php"}
    
    <article>
    	<section>
        	<div class="subject">
                <b>标签</b>
            </div>
            <div class="clear"></div>
            <ul class="tags mt20">
               {sdcms:rs pagesize="60" table="sd_tags" order="id desc"}
               <li><a href="{U('home/other/taglist/','tagname='.$rs[title].'')}" title="{$rs[title]}">{$rs[title]}</a></li>
               {/sdcms:rs}
             </ul>
             <div class="clear"></div>
             <div class="pagelist"><ul>{$showpage}</ul></div>
        </section>
    </article>
    {include file="mobile/foot.php"}

</body>
</html>