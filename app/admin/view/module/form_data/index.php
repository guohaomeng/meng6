<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>内容管理</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：系统管理 > <a href="{U('form/index')}">表单管理</a> > <a href="{THIS_LOCAL}">{$title}管理</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a href="{U('add','fid='.$fid.'')}" class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-plus am-margin-right-sm"></span>添加内容</a>
        </div>
        <div class="am-btn-group">
            <a class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-files-o am-margin-right-sm"></span>批量操作</a>
            <div class="am-dropdown" data-am-dropdown>
                <button class="am-btn am-btn-secondary am-dropdown-toggle am-text-sm" data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content">
                    <li><a href="javascript:;" class="btach" type="1">设为已审</a></li>
                    <li><a href="javascript:;" class="btach" type="2">设为未审</a></li>
                    <li class="am-divider"></li>
                    <li><a href="javascript:;" class="btach" type="3">批量删除</a></li>
                </ul>
            </div>
        </div>
        <div class="am-btn-group am-btn-group-sm am-btn-toolbar am-margin-left-xs">
            <a class="am-btn am-btn-{if $type==0}warning{else}default{/if} am-radius" href="{U('index','fid='.$fid.'&type=0')}">全部</a>
            <a class="am-btn am-btn-{if $type==1}warning{else}default{/if} am-radius" href="{U('index','fid='.$fid.'&type=1')}">未审</a>
            <a class="am-btn am-btn-{if $type==2}warning{else}default{/if} am-radius" href="{U('index','fid='.$fid.'&type=2')}">已审</a>
        </div>
       <div class="am-cf">
            {foreach $filter as $rs}
            <div class="filter">
                <dl>
                    <dd>{$rs['field_title']}：</dd>
                    <dt>
                        <a href="{U('index','fid='.$fid.'&type='.$type.''.deal_filter($filter_data,$rs['field_key'],0).'')}"{if getint(F('get.'.$rs['field_key'].''),0)==0} class="hover"{/if}>全部</a>
                        {if $rs['field_type']==14}
                        {php $table_=$rs['field_table']}{php $join_=$rs['field_join']}{php $where_=$rs['field_where']}{php $order_=$rs['field_order']}{php $value=$rs['field_value']}{php $label=$rs['field_label']}
						{if $where_==''}{php $where_='1=1'}{/if}
						{if $order_==''}{php $order_="$value desc"}{/if}
                        {sdcms:ra top="0" table="$table_" join="$join_" where="$where_" order="$order_"}
                        <a href="{U('index','fid='.$fid.'&type='.$type.''.deal_filter($filter_data,$rs['field_key'],$ra['.$value.']).'')}"{if getint(F('get.'.$rs['field_key'].''),0)==$ra['.$value.']} class="hover"{/if}>{$ra['.$label.']}</a>
                        {/sdcms:ra}
                        {else}
                        {php $arr=explode(",",$rs['field_list'])}
                        {foreach $arr as $j=>$key}
                        {php $data=explode("|",$key)}
                        <a href="{U('index','fid='.$fid.'&type='.$type.''.deal_filter($filter_data,$rs['field_key'],$data[1]).'')}"{if getint(F('get.'.$rs['field_key'].''),0)==$data[1]} class="hover"{/if}>{$data[0]}</a>
                        {/foreach}
                        {/if}
                    </dt>
                </dl>
            </div>
            {/foreach}
       </div>
       <form method="post" id="form_name" class="am-margin-top">
       <div class="am-panel am-panel-default am-margin-top">
       <div class="am-panel-hd">
           <h3 class="am-panel-title">{$title}列表</h3>
       </div>
       <table class="am-table am-table-hover">
            <thead>
                <tr>
                    <th width="30" height="30"><input type="checkbox" name="chkall" onClick="checkall(this.form)" title="全选/取消" style="width:auto;" /></th>
                    <th width="80">排序</th>
                    {foreach $field as $key}
                    <th>{$key['field_title']}</th>
                    {/foreach}
                    <th width="120">发布日期</th>
                    <th width="130">发布IP</th>
                    <th width="50">状态</th>
                    <th width="150">操作</th>
                </tr>
            </thead>
            <tbody>
            {sdcms:rs pagesize="20" table="$tablename" where="$where" order="ordnum desc,id desc"}
            {rs:eof}
            <tr>
                <td colspan="{php echo count($field)+6}">暂无数据</td>
            </tr>
            {/rs:eof}
            <tr>
            	<td><input type="checkbox" name="id" value="{$rs[id]}" style="width:auto;margin-top:8px;"></td>
                <td><input type="hidden" name="mid[]" value="{$rs[id]}"><input type="text" name="ordnum[]" id="ordnum_{$rs[id]}" value="{$rs[ordnum]}" data-rule="required;int;"></td>
                {foreach $field as $key}
                {php $name=$key['field_key']}
                <td>{$rs['.$name.']}</td>
                {/foreach}
                <td>{date('Y-m-d',$rs[createdate])}</td>
                <td>{$rs[postip]}</td>
                <td>{iif($rs[islock]==1,"已审","<em>未审</em>")}</td>
                <td><a href="{U('edit',"fid=".$fid."&id=".$rs[id]."")}"><span class="am-icon-edit"></span> 编辑</a>　<a href="javascript:;" class="del" rel="{U('del','fid='.$fid.'&id='.$rs[id].'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/sdcms:rs}
            </tbody>
        </table>
        	{if $total_rs!=0}
            <div class="border-top am-padding">
                <div class="am-u-sm-2 am-padding-left-0"><button type="submit" class="am-btn am-btn-warning am-radius am-text-sm">保存排序</button></div>
                <div class="am-u-sm-10 pagelist"><ul>{$showpage}</ul></div>
                <div class="clear"></div>
            </div>
            {/if}
        </div>
        </form>
        <!---->
    </div>
    
<script>
$(function(){
	toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$(".btach").click(function(){
		var type=$(this).attr("type");
		var list="";
		$($("input[name='id']:checked")).each(function(){
			if(list==""){list+=this.value}else{list+=","+this.value}                   
		}); 
		if(list=="")
		{
			toastr.error('至少选择一条内容');
		}
		else
		{
			$.AMUI.progress.inc();
			$.ajax({
				type:'get',
				cache:false,
				dataType:'json',
				url:'{U("btach","fid=".$fid."")}{iif(sdcms[url_mode]==1,"&","?")}id='+list+'&type='+type,
				data:"",
				error:function(e){alert(e.responseText);},
				success:function(d){
					$.AMUI.progress.set(1.0);
                    if(d.state=='success')
                    {
                        toastr.success(d.msg);
                        setTimeout(function(){location.href='{THIS_LOCAL}';},1500);
                    }
                    else
                    {
                        toastr.error(d.msg);
                    }
				}
			})
		}
	});
    $('#form_name').validator({
        timely:2,
        stopOnError:true,
        focusCleanup:true,
        ignore:':hidden',
        theme:'yellow_right',
        valid:function(form)
        {
            $.AMUI.progress.inc();
            $.ajax({
                type:'post',
                cache:false,
                dataType:'json',
                url:'{U("order","fid=".$fid."")}',
                data:$(form).serialize(),
                error:function(e){alert(e.responseText);},
                success:function(d)
                {
                    $.AMUI.progress.set(1.0);
                    if(d.state=='success')
                    {
                        toastr.success(d.msg);
                        setTimeout(function(){location.href='{THIS_LOCAL}';},1500);
                    }
                    else
                    {
                        toastr.error(d.msg);
                    }
                }
            })
        }
    });
    $(".del").click(function(){
		var url=$(this).attr("rel");
        layer.confirm(
           '确定要删除？不可恢复！', 
            {
                btn: ['确定','取消']
            }, function()
            {
                $.ajax({
                    url:url,type:'post',dataType:'json',
					error:function(e){alert(e.responseText);},
                    success:function(d)
                    {
                        layer.closeAll();
                        if(d.state=='success')
                        {
                            toastr.success(d.msg);
                            setTimeout(function(){location.href='{THIS_LOCAL}';},1000);
                        }
                        else
                        {
                            toastr.error(d.msg);
                        }
                    }
                })
            }, function()
            {
               
            });
    })
})
</script>
</body>
</html>
