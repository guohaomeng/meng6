<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>我的订单_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
<style>
.table_list{border:1px solid #eee;width:100%;}
.table_list th{padding:6px 10px;border:1px solid #eee;text-align:center;color:#333;background:#fafafa;font-family:microsoft yahei;font-weight:normal;}
.table_list td{padding:6px 10px;border:1px solid #eee;text-align:center;color:#666;font-family:microsoft yahei;font-size:14px;}
.table_list .textleft{text-align:left;}
.table_list .textleft span{color:#999;margin-left:10px;font-family:宋体;font-size:12px;}
.table_list .textleft span em{color:#06f;font-size:14px;padding:0 5px;}
.table_list td em{font-style:normal;color:#999;}
.table_list a{color:#06f;}
.table_list a:hover{color:#f30;}
</style>
</head>

<body>

    {include file="head.php"}
    
    <div class="bg_inner am-animation-scale-up am-animation-delay-1">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a>我的订单</a></li>
                </ul>
            </div>
        	<div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>
    
    <div class="width inner_container am-animation-slide-bottom am-animation-delay-1">
        <ol class="am-breadcrumb am-breadcrumb-slash am-animation-slide-top am-animation-delay-1">
            <li><a href="{WEB_ROOT}" class="am-icon-home">首页</a></li>
            <li><a href="{N('user')}">会员中心</a></li>
            <li class="am-active">我的订单</li>
            
        </ol>
        <div class="user_center">
            <div class="lefter">
            	{include file="user/nav.php"}
            </div>
            <div class="righter">
                
                <div class="subject m20 am-animation-slide-bottom">
                    <b>我的订单</b>
                </div>
                <div class="am-btn-group am-btn-group-sm am-btn-toolbar am-margin-left-xs am-margin-bottom">
                    <a class="am-btn am-btn-{if $type==0}warning{else}default{/if} am-radius" href="{N('myorder')}">全部</a>
                    <a class="am-btn am-btn-{if $type==1}warning{else}default{/if} am-radius" href="{N('myorder','','type=1')}">已支付</a>
                    <a class="am-btn am-btn-{if $type==2}warning{else}default{/if} am-radius" href="{N('myorder','','type=2')}">未支付</a>
                </div>
                <table class="table_list">
                    <thead>
                        <tr>
                        	<th width="120">订单号</th>
                            <th>产品名称</th>
                            <th width="70">数量</th>
                            <th width="80">金额</th>
                            <th width="70">付款</th>
                            <th width="70">状态</th>
                            <th width="160">日期</th>
                            <th width="100">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    {sdcms:rs pagesize="20" table="sd_order" where="$where" order="id desc"}
                    {rs:eof}
                    <tr>
                        <td colspan="8">暂无订单</td>
                    </tr>
                    {/rs:eof}
                    <tr>
                        <td>{$rs[orderid]}</td>
                        <td class="textleft">{$rs[pro_name]}</td>
                        <td>{$rs[pro_num]}</td>
                        <td>{$rs[pro_price]}</td>
                        <td>{iif($rs[ispay]==1,'已支付','<em>未支付</em>')}</td>
                        <td>{iif($rs[isover]==1,'已处理','<em>未处理</em>')}</td>
                        <td>{date('Y-m-d H:i:s',$rs[createdate])}</td>
                        <td><a href="{U('home/other/ordershow','orderid='.$rs[orderid].'')}" target="_blank">查看订单</a></td>
                    </tr>
                    {/sdcms:rs}
                    </tbody>
                </table>
                <div class="pagelist"><ul>{$showpage}</ul></div>
            </div>
        </div>
        
    </div>
    
    {include file="foot.php"}
</body>
</html>