<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{if strlen($catetitle)>0}{$catetitle}_{/if}{$catename}{$filter_key}_{if $page>1}第{$page}页_{/if}{sdcms[web_name]}</title>
<meta name="keywords" content="{if strlen($catekey)>0}{$catekey}{else}{$catename}{/if}">
<meta name="description" content="{if strlen($catedesc)>0}{$catedesc}{else}{$catename}{/if}">
{include file="mobile/wxshare.php"}
</head>

<body>
	{include file="mobile/head.php"}
    {include file="mobile/bar.php"}

    <article>
    	{if count($filter)>0&&$isfilter==1}
    	<section>
        	<div class="subject">
                <b>筛选</b>
            </div>
            <div class="clear"></div>
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
        </section>
        {/if}
        
    	<section>
        	<div class="subject">
                {if get_sonid_num($topid)!=0}<span class="more"><a href="javascript:;" class="am-icon-bars am-icon-sm" data-am-offcanvas="{target:'#nav'}"></a></span>{/if}<b>{$catename}</b>
            </div>
            <div class="clear"></div>
            <div class="home_pro">
            	<ul>
                	{sdcms:rs pagesize="$catepage" num="3" table="sd_content" join="$join" where="$where" order="ontop desc,ordnum desc,id desc"}
                	<li><a href="{$rs[link]}" title="{$rs[title]}"><div><img src="{thumb($rs[pic],280,280)}" alt="{$rs[title]}"></div><p class="title">{$rs[title]}</p><p class="price"><span>人气：{$rs[hits]}</span>{if $rs[price]!=0}¥ {$rs[price]}{else}面议{/if}</p></a></li>
                    {/sdcms:rs}
                </ul>
                <div class="clear"></div>
            </div>
             <div class="pagelist"><ul>{$showpage}</ul></div>
        </section>
    </article>
    {include file="mobile/foot.php"}

</body>
</html>