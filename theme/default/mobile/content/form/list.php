<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{if strlen($seotitle)>0}{$seotitle}_{/if}{$title}_{sdcms[web_name]}</title>
<meta name="keywords" content="{if strlen($seokey)>0}{$seokey}{else}{$title}{/if}">
<meta name="description" content="{if strlen($seodesc)>0}{$seodesc}{else}{$title}{/if}">
</head>

<body>
	{include file="mobile/head.php"}
    <article>
    	{if count($filter)>0}
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
                            <a href="{U('index','fid='.$fid.''.deal_filter($filter_data,$rs['field_key'],0).'')}"{if getint(F('get.'.$rs['field_key'].''),0)==0} class="hover"{/if}>全部</a>
                            {if $rs['field_type']==14}
                            {php $table_=$rs['field_table']}{php $join_=$rs['field_join']}{php $where_=$rs['field_where']}{php $order_=$rs['field_order']}{php $value=$rs['field_value']}{php $label=$rs['field_label']}
                            {if $where_==''}{php $where_='1=1'}{/if}
                            {if $order_==''}{php $order_="$value desc"}{/if}
                            {sdcms:ra top="0" table="$table_" join="$join_" where="$where_" order="$order_"}
                            <a href="{U('index','fid='.$fid.''.deal_filter($filter_data,$rs['field_key'],$ra['.$value.']).'')}"{if getint(F('get.'.$rs['field_key'].''),0)==$ra['.$value.']} class="hover"{/if}>{$ra['.$label.']}</a>
                            {/sdcms:ra}
                            {else}
                            {php $arr=explode(",",$rs['field_list'])}
                            {foreach $arr as $j=>$key}
                            {php $data=explode("|",$key)}
                            <a href="{U('index','fid='.$fid.''.deal_filter($filter_data,$rs['field_key'],$data[1]).'')}"{if getint(F('get.'.$rs['field_key'].''),0)==$data[1]} class="hover"{/if}>{$data[0]}</a>
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
                <b>{$title}</b>
            </div>
            <div class="clear"></div>
            <table class="am-table am-table-hover am-margin-top">
                <thead>
                    <tr>
                        {foreach $field as $key}
                        <th>{$key['field_title']}</th>
                        {/foreach}
                        <th width="120">发布日期</th>
                        <th width="100">操作</th>
                    </tr>
                </thead>
                <tbody>
                {sdcms:rs pagesize="20" table="$tablename" where="$where" order="ordnum desc,id desc"}
                {rs:eof}
                <tr>
                    <td colspan="{php echo count($field)+3}">暂无数据</td>
                </tr>
                {/rs:eof}
                <tr>
                    {foreach $field as $key}
                    {php $name=$key['field_key']}
                    <td>{$rs['.$name.']}</td>
                    {/foreach}
                    <td>{date('Y-m-d',$rs[createdate])}</td>
                    <td><a href="{U('home/form/show/','fid='.$fid.'&id='.$rs[id].'')}">查看明细</a></td>
                </tr>
                {/sdcms:rs}
                </tbody>
            </table>
    
             <div class="clear"></div>
             <div class="pagelist"><ul>{$showpage}</ul></div>
        </section>
    </article>
    {include file="mobile/foot.php"}

</body>
</html>