<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>我的订单_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	<section>
        	<div class="subject">
                <b>我的订单</b>
            </div>
            <div class="clear"></div>
            <div class="am-padding-top">
            	
                <div class="am-btn-group am-btn-group-justify am-btn-group-sm am-margin-left-xs am-margin-bottom">
                    <a class="am-btn am-btn-{if $type==0}warning{else}default{/if} am-radius" href="{N('myorder')}">全部</a>
                    <a class="am-btn am-btn-{if $type==1}warning{else}default{/if} am-radius" href="{N('myorder','','type=1')}">已支付</a>
                    <a class="am-btn am-btn-{if $type==2}warning{else}default{/if} am-radius" href="{N('myorder','','type=2')}">未支付</a>
                </div>
                {sdcms:rs pagesize="10" num="3" table="sd_order" where="$where" order="id desc"}
                {rs:eof}
                <p>暂无订单</p>
                {/rs:eof}
                <div class="am-panel am-panel-default am-margin-bottom">
                    <div class="am-panel-hd">
                        <h3 class="am-panel-title">{$rs[orderid]}</h3>
                    </div>
                  
                    <ul class="am-list am-list-static">
                        <li>产品名称：{$rs[pro_name]}</li>
                        <li>购买数量：{$rs[pro_num]}</li>
                        <li>订单金额：{$rs[pro_price]}</li>
                        <li>订单支付：{iif($rs[ispay]==1,'已支付','<em>未支付</em>')}</li>
                        <li>订单状态：{iif($rs[isover]==1,'已处理','<em>未处理</em>')}</li>
                    </ul>
                	<div class="am-panel-footer"><a href="{U('home/other/ordershow','orderid='.$rs[orderid].'')}" target="_blank" style="color:#f30;">查看订单</a></div>
                </div>
                {/sdcms:rs}
                <div class="pagelist"><ul>{$showpage}</ul></div>

            </div>
        </section>
        
    </article>
    {include file="mobile/foot.php"}
	
</body>
</html>