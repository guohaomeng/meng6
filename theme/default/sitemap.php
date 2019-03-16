<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>网站地图_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>

    {include file="head.php"}
    
    <div class="bg_inner am-animation-scale-up am-animation-delay-1">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a>网站地图</a></li>
                </ul>
            </div>
        	<div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>
    
    <div class="width inner_container am-animation-slide-bottom am-animation-delay-1">
    	
        <ol class="am-breadcrumb am-breadcrumb-slash am-animation-slide-top am-animation-delay-1">
            <li><a href="{WEB_DOMAIN}" class="am-icon-home">首页</a></li>
            <li class="am-active">网站地图</li>
        </ol>
                
            {sdcms:rp top="0" table="sd_category" where="followid=0 and isshow=1" order="catenum,cateid"}{php $map_sonid=$rp[cateid]}
            <div class="map_one"><a href="{cateurl($rp[cateid])}" title="{$rp[catename]}"{if $rp[isblank]==1} target="_blank"{/if}>{$rp[catename]}</a></div>
            <div class="map_two">
                {sdcms:rs top="0" table="sd_category" where="followid=$map_sonid and isshow=1" order="catenum,cateid"}
                <a href="{cateurl($rs[cateid])}" title="{$rs[catename]}"{if $rs[isblank]==1} target="_blank"{/if}>{$rs[catename]}</a>
                {/sdcms:rs}
            </div>
            {/sdcms:rp}
        
    </div>
    
    {include file="foot.php"}
    
</body>
</html>