<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>网站地图_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	<section>
        	<div class="subject">
                <b>网站地图</b>
            </div>
            <div class="clear"></div>
            <div class="intro am-padding-top">
            	{sdcms:rp top="0" table="sd_category" where="followid=0 and isshow=1" order="catenum,cateid"}{php $map_sonid=$rp[cateid]}
                <div class="map_one"><a href="{cateurl($rp[cateid])}" title="{$rp[catename]}"{if $rp[isblank]==1}{/if}>{$rp[catename]}</a></div>
                <div class="map_two">
                    {sdcms:rs top="0" table="sd_category" where="followid=$map_sonid and isshow=1" order="catenum,cateid"}
                    <a href="{cateurl($rs[cateid])}" title="{$rs[catename]}"{if $rs[isblank]==1}{/if}>{$rs[catename]}</a>
                    {/sdcms:rs}
                </div>
                {/sdcms:rp}
            </div>
        </section>
        
        
    </article>
    {include file="mobile/foot.php"}

</body>
</html>