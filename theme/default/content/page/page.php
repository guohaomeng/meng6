<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>{if strlen($catetitle)>0}{$catetitle}_{/if}{$catename}_{if $page>1}第{$page}页_{/if}{sdcms[web_name]}</title>
<meta name="keywords" content="{if strlen($catekey)>0}{$catekey}{else}{$catename}{/if}">
<meta name="description" content="{if strlen($catedesc)>0}{$catedesc}{else}{$catename}{/if}">
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
        
        <div class="home_nav">
            <ul id="subnav">
                {sdcms:rp top="0" table="sd_category" where="followid=$topid" order="catenum,cateid"}{php $sub_sonid=$rp[cateid]}
                <li{is_active($rp[cateid],$parentid)}><a href="{cateurl($rp[cateid])}" title="{$rp[catename]}">{$rp[catename]}</a><dl>
                    {sdcms:rs top="0" table="sd_category" where="followid=$sub_sonid" order="catenum,cateid"}
                    <dt><a href="{cateurl($rs[cateid])}" title="{$rs[catename]}"{if $rs[isblank]==1} target="_blank"{/if}>{$rs[catename]}</a></dt>
                    {/sdcms:rs}
                </dl></li>
                {/sdcms:rp}
            </ul>
            <div class="clear"></div>
        </div>
        <!--<h1>{$catename}</h1>-->
        {if is_array($piclist)}
        <div class="piclist mt20">
            <ul id="gallery" data-am-widget="gallery" data-am-gallery="{ pureview: true }" >
                {foreach $piclist as $key=>$rs}
                <li><a href="{$rs['image']}" title="{$rs['desc']}"><img src="{$rs['image']}" alt="{$rs['desc']}" width="230" /><p>{$rs['desc']}</p></a></li>
                {/foreach}
            </ul>
        </div>
        <div class="clear"></div>
        {/if}
        <div class="page_show">
        {$content}
        </div>
        <div class="pagelist"><ul>{pagelist($page,$pagenum)}</ul></div>
    </div>
    
    {include file="foot.php"}
    <script src="{WEB_ROOT}public/js/jquery.masonry.min.js"></script>
	<script>
    $(function() {
        $('#gallery img').load(function(){
			$('#gallery').masonry({itemSelector:'li'});
		});
        $('#gallery').masonry({itemSelector:'li'});
    });
    </script>
</body>
</html>