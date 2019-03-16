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
            <li class="am-active">列表</li>
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
        {if count($filter)>0&&$isfilter==1}
        <div class="filter">
            {foreach $filter as $rs}
                <dl>
                    <dd>{$rs['field_title']}：</dd>
                    <dt>
                        <a href="{filter_url($cateurl,$classid,deal_filter($filter_data,$rs['field_key'],0))}"{if getint(F('get.'.$rs['field_key'].''),0)==0} class="hover"{/if}>全部</a>
                        {if $rs['field_type']==14}
                        {php $table_=$rs['field_table']}{php $join_=$rs['field_join']}{php $where_=$rs['field_where']}{php $order_=$rs['field_order']}{php $value=$rs['field_value']}{php $label=$rs['field_label']}
						{if $where_==''}{php $where_='1=1'}{/if}
						{if $order_==''}{php $order_="$value desc"}{/if}
                        {sdcms:ra top="0" table="$table_" join="$join_" where="$where_" order="$order_"}
                        <a href="{filter_url($cateurl,$classid,''.deal_filter($filter_data,$rs['field_key'],$ra['.$value.']))}"{if getint(F('get.'.$rs['field_key'].''),0)==$ra['.$value.']} class="hover"{/if}>{$ra['.$label.']}</a>
                        {/sdcms:ra}
                        {else}
                        {php $arr=explode(",",$rs['field_list'])}
                        {foreach $arr as $j=>$key}
                        {php $data=explode("|",$key)}
                        <a href="{filter_url($cateurl,$classid,deal_filter($filter_data,$rs['field_key'],$data[1]))}"{if getint(F('get.'.$rs['field_key'].''),0)==$data[1]} class="hover"{/if}>{$data[0]}</a>
                        {/foreach}
                        {/if}
                    </dt>
                    <div class="clear"></div>
                </dl>
            {/foreach}
        </div>
        {/if}
        <div class="list_pic">
            <ul>
            	{sdcms:rs pagesize="$catepage" table="sd_content" join="$join" where="$where" pagewhere="$pagewhere" order="ontop desc,ordnum desc,id desc"}
                {rs:eof}暂时没有资料{/rs:eof}
                <li><a href="{$rs[link]}" title="{$rs[title]}" target="_blank"><div><img src="{thumb($rs[pic],280,200)}" alt="{$rs[title]}" height="200"></div><p class="title">{cutstr($rs[title],60,1)}</p></a></li>
                {/sdcms:rs}
            </ul>
            <div class="clear"></div>
        </div>
        <div class="pagelist"><ul>{$showpage}</ul></div>
        
    </div>
    
    {include file="foot.php"}
    
</body>
</html>