<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>{if strlen(sdcms[seo_title])>0}{sdcms[seo_title]}_{/if}{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
<link rel="shortcut icon" href="/favicon.ico"/>
<link rel="bookmark" href="/favicon.ico"/>
<link rel="stylesheet" href="{WEB_ROOT}theme/default/css/skitter.css">
</head>

<body>

    {include file="head.php"}

    <div class="banner">
    	<div class="skitter" id="banner">
            <ul>
                {sdcms:rs table="sd_ad" where="akey='pc' and islock=1"}
                {php $adlist=str_replace(PHP_EOL,'\n',$rs[datalist])}
                {php $adlist=json_decode($adlist,true)}
                {if is_array($adlist)}
                {foreach $adlist as $num=>$val}
                <li><a href="{$val['url']}" target="_blank"><img src="{$val['image']}" alt="{$val['desc']}" class="random" /></a></li>
                {/foreach}
                {/if}
                {/sdcms:rs}
            </ul>
        </div>
    </div>
    <div class="width">
        <div class="subject m20 am-animation-slide-bottom">
        	<span class="more"><a href="{cateurl(1)}">更多>></a></span><b>关于我们</b>
        </div>
        <div class="home_about">
            <div class="left">
            	<video src="{sdcms[home_video]}" width="410" height="260" controls="controls"></video>
            </div>
            <div class="right am-animation-slide-right am-animation-delay-1">
                {block("about")}
            </div>
        </div>
    </div>
    
    <div class="bg_gray">
        <div class="width">
            <div class="subject" data-am-scrollspy="{animation:'slide-bottom',repeat:false}">
                <span class="more"><a href="{cateurl(3)}">更多>></a></span><b>推荐产品</b>
            </div>
            <div class="home_nav mt30" data-am-scrollspy="{animation:'slide-bottom',repeat:false,delay:300}">
                <ul>
                	{sdcms:rs top="5" table="sd_category" where="followid=3" order="catenum,cateid"}
                    <li{if $i==1} class="hover"{/if} id="one{$i}" onmouseover="setTab('one',{$i},{$total_rs})"><a href="{cateurl($rs[cateid])}" title="{$rs[catename]}">{$rs[catename]}</a></li>
                    {/sdcms:rs}
                </ul>
                <div class="clear"></div>
            </div>
            <div class="home_pro" data-am-scrollspy="{animation:'slide-bottom',repeat:false}">
            	{sdcms:rp top="5" table="sd_category" where="followid=3" order="catenum,cateid" auto="j"}
                {php $sonid=get_sonid_all($rp[cateid])}
                <ul id="con_one_{$j}"{if $j>1} class="dis"{/if}>
                	{sdcms:rs top="8" table="sd_model_pro" join="left join sd_content on sd_model_pro.cid=sd_content.id" where="islock=1 and isnice=1 and classid in($sonid)" order="ontop desc,ordnum desc,id desc"}
                	<li><a href="{$rs[link]}" title="{$rs[title]}"><div><img src="{thumb($rs[pic],280,280)}" alt="{$rs[title]}" height="280"></div><p class="title">{cutstr($rs[title],90,1)}</p><p class="price"><span>人气：{$rs[hits]}</span>{if $rs[price]!=0}¥ {$rs[price]}{else}面议{/if}</p></a></li>
                    {/sdcms:rs}
                </ul>
                <div class="clear"></div>
                {/sdcms:rp}
            </div>
        </div>
    </div>
    
    <div class="width">
        <div class="subject m20" data-am-scrollspy="{animation:'slide-bottom',repeat:false}">
        	<span class="more"><a href="{cateurl(2)}">更多>></a></span><b>新闻中心</b>
        </div>
        <div class="home_news" data-am-scrollspy="{animation:'slide-bottom',repeat:false,delay:300}">
             <ul class="home_news_list">
				{php $sonid=get_sonid_all(2)}
                {php $subid=deal_subid($sonid)}
                {sdcms:rs top="8" table="sd_content" where="islock=1 and classid in($sonid)" sub="$subid" order="ontop desc,ordnum desc,id desc"}
                <li><span class="date">{date('m-d',$rs[createdate])}</span><div><a href="{$rs[link]}" title="{$rs[title]}">{cutstr($rs[title],80,1)}</a>{cutstr(nohtml($rs[intro]),220,1)}</div></li>
                {/sdcms:rs}
             </ul>
             <div class="clear"></div>
        </div>
    </div>
    
    <div class="bg_gray">
        <div class="width">
            <div class="subject" data-am-scrollspy="{animation:'slide-bottom',repeat:false}">
                <span class="more"><a href="{cateurl(4)}">更多>></a></span><b>客户案例</b>
            </div>
            <div class="list_pic" data-am-scrollspy="{animation:'slide-bottom',repeat:false,delay:300}">
                <ul>
                	{php $sonid=get_sonid_all(4)}
                    {sdcms:rs top="4" table="sd_content" where="islock=1 and classid in($sonid) and isnice=1" order="ontop desc,ordnum desc,id desc"}
                    <li><a href="{$rs[link]}" title="{$rs[title]}"><div><img src="{thumb($rs[pic],280,200)}" alt="{$rs[title]}" height="200"></div><p class="title">{cutstr($rs[title],46,1)}</p></a></li>
                    {/sdcms:rs}
                </ul>
                <div class="clear"></div>
            </div>
            
        </div>
    </div>
    
    <div class="width">
        <div class="subject m20" data-am-scrollspy="{animation:'slide-bottom',repeat:false}">
        	<b>合作客户</b>
        </div>
        <div class="home_logo" data-am-scrollspy="{animation:'slide-bottom',repeat:false,delay:300}">
              <ul>
              	{sdcms:rs top="0" table="sd_link" where="islogo=1 and islock=1" order="ordnum,id"}
              	<li><a href="{$rs[weburl]}" title="{$rs[webname]}" target="_blank"><img src="{$rs[weblogo]}"></a></li>
                {/sdcms:rs}
              </ul>
              <div class="clear"></div>
        </div>
    </div>
    
    <div class="bg_link">
        <div class="width link" data-am-scrollspy="{animation:'slide-top',repeat:false}">
            <!--<div class="link_title">友情链接：</div>-->
            <div class="link_list" id="link">
            {sdcms:rs top="0" table="sd_link" where="islogo=0 and islock=1" order="ordnum,id"}
            <a href="{$rs[weburl]}" title="{$rs[webname]}" target="_blank">{$rs[webname]}</a>
            {/sdcms:rs}
            </div>
            <div class="clear"></div>
        </div>
    </div>
    {include file="foot.php"}
    <script src="{WEB_ROOT}theme/default/js/jquery.easing.1.3.js"></script>
    <script src="{WEB_ROOT}theme/default/js/jquery.skitter.js"></script>
    <script src="{WEB_ROOT}theme/default/js/jquery.liMarquee.js"></script>
    <script>
	$(function(){
		//首页链接添加选中效果
		$("#nav ul li:first-child").addClass("hover");
		//Banner切换
		$('#banner').skitter({dots:true,interval:5000});
	})
	</script>
</body>
</html>