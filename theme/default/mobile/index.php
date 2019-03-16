<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{if strlen(sdcms[seo_title])>0}{sdcms[seo_title]}_{/if}{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
<link rel="stylesheet" href="{WEB_ROOT}theme/default/mobile/css/swiper.min.css">
{include file="mobile/wxshare.php"}
</head>

<body>

	<header class="header">
    	<div class="am-fr"><a href="{N('user')}" class="am-icon-user am-icon-sm"></a></div>
    	<div class="am-fl"><a href="javascript:;" class="am-icon-bars am-icon-sm" data-am-offcanvas="{target:'#nav_top'}"></a></div>
        <div class="logo"><a href="{WEB_ROOT}"><img src="{sdcms[mobile_logo]}" alt="{sdcms[web_name]}" /></a></div>
        <div class="clear"></div>
    </header>
    <div class="nav am-offcanvas" id="nav_top">
        <div class="am-offcanvas-bar">
            <ul id="collapase-nav">
            	<li><a href="{WEB_ROOT}">网站首页</a></li>
              	{sdcms:rp top="0" table="sd_category" where="followid=0 and isshow=1" order="catenum,cateid"}{php $sub_sonid=$rp[cateid]}
                <li class="am-panel">{if get_sonid_num($rp[cateid])!=0}
                <span class="am-icon-angle-right" data-am-collapse="{parent:'#collapase-nav', target:'#nav_{$rp[cateid]}'}"></span>
                {/if}<a href="{cateurl($rp[cateid])}" title="{$rp[catename]}">{$rp[catename]}</a>
                <ul class="am-collapse" id="nav_{$rp[cateid]}">
                    {sdcms:rs top="0" table="sd_category" where="followid=$sub_sonid and isshow=1" order="catenum,cateid"}
                    <li><a href="{cateurl($rs[cateid])}" title="{$rs[catename]}">{$rs[catename]}</a></li>
                    {/sdcms:rs}
                </ul></li>
                {/sdcms:rp}
                {if C('bbs_open')==1}
                <li id="nav_bbs"><a href="{N('bbs')}" title="{sdcms[bbs_webname]}">{sdcms[bbs_webname]}</a></li>
                {/if}
            </ul>
        </div>
    </div>
    <figure class="banner">
    	<div class="swiper-container">
            <div class="swiper-wrapper">
                {sdcms:rs table="sd_ad" where="akey='mobile' and islock=1"}
                {php $adlist=str_replace(PHP_EOL,'\n',$rs[datalist])}
                {php $adlist=json_decode($adlist,true)}
                {if is_array($adlist)}
                {foreach $adlist as $num=>$val}
                <div class="swiper-slide"><a href="{$val['url']}"><img src="{$val['image']}" alt="{$val['desc']}" /></a></div>
                {/foreach}
                {/if}
                {/sdcms:rs}
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </figure>
    
    <article>
    	       
        <section>
        	<div class="subject">
                <span class="more"><a href="{cateurl(3)}">更多>></a></span><b>推荐产品</b>
            </div>
            <div class="clear"></div>
            <div class="home_pro">
            	<ul>
                	{php $sonid=get_sonid_all(3)}
                	{sdcms:rs top="4" table="sd_model_pro" join="left join sd_content on sd_model_pro.cid=sd_content.id" where="islock=1 and isnice=1 and classid in($sonid)" order="ontop desc,ordnum desc,id desc"}
                	<li><a href="{$rs[link]}" title="{$rs[title]}"><div><img src="{thumb($rs[pic],280,280)}" alt="{$rs[title]}"></div><p class="title">{$rs[title]}</p><p class="price"><span>人气：{$rs[hits]}</span>{if $rs[price]!=0}¥ {$rs[price]}{else}面议{/if}</p></a></li>
                    {/sdcms:rs}
                </ul>
                <div class="clear"></div>
            </div>
        </section>
        
        <section>
        	<div class="subject">
                <span class="more"><a href="{cateurl(2)}">更多>></a></span><b>新闻中心</b>
            </div>
            <div class="clear"></div>
            <ul class="home_news">
                {php $sonid=get_sonid_all(2)}
                {sdcms:rs top="6" table="sd_content" where="islock=1 and classid in($sonid)" order="ontop desc,ordnum desc,id desc"}
                <li><span class="date">{date('m-d',$rs[createdate])}</span><div class="right"><a href="{$rs[link]}" title="{$rs[title]}" class="text-hide">{$rs[title]}</a><p class="text-hide">{cutstr(nohtml($rs[intro]),200)}</p></div></li>
                {/sdcms:rs}
             </ul>
             <div class="clear"></div>
        </section>
        
        <section>
        	<div class="subject">
                <span class="more"><a href="{cateurl(4)}">更多>></a></span><b>客户案例</b>
            </div>
            <div class="clear"></div>
            <div class="home_case">
            	<ul>
                	{php $sonid=get_sonid_all(4)}
                    {sdcms:rs top="4" table="sd_content" where="islock=1 and classid in($sonid) and isnice=1" order="ontop desc,ordnum desc,id desc"}
                	<li><a href="{$rs[link]}" title="{$rs[title]}"><div><img src="{thumb($rs[pic],280,200)}" alt="{$rs[title]}"></div><p class="text-hide">{$rs[title]}</p></a></li>
                    {/sdcms:rs}
                </ul>
                <div class="clear"></div>
            </div>
        </section>
        
        <section>
            <div class="subject">
                <span class="more"><a href="{cateurl(1)}">更多>></a></span><b>关于我们</b>
            </div>
            <div class="clear"></div>
            <div class="about">
                {block("about")}
            </div>
        </section>

        <section>
        	<div class="subject">
                <span class="more"><a href="{cateurl(5)}">更多>></a></span><b>人才招聘</b>
            </div>
            <div class="clear"></div>
            <div class="job_list">
            	<ul>
                	{php $sonid=get_sonid_all(5)}
                    {sdcms:rs top="4" table="sd_model_job" join="left join sd_content on sd_model_job.cid=sd_content.id" where="islock=1 and classid in($sonid)" order="ontop desc,ordnum desc,id desc"}
                	<li><a href="{$rs[link]}" title="{$rs[title]}">{$rs[title]}</a><div class="money">{$rs[work_money]}<span>{$rs[work_address]}</span></div></li>
                    {/sdcms:rs}
                </ul>
                <div class="clear"></div>
            </div>
        </section>
        
    </article>
    {include file="mobile/foot.php"}
    <script src="{WEB_ROOT}theme/default/mobile/js/swipe.js"></script>
    <script>
    var swiper=new Swiper('.swiper-container',{
        pagination:'.swiper-pagination',
        paginationClickable:true,
        spaceBetween:30,
        centeredSlides:true,
        autoplay:5000,
        autoplayDisableOnInteraction:false,
		loop:true
    });
    </script>

</body>
</html>