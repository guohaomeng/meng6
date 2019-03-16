<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>询价管理</title>
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
    <div class="position">当前位置：扩展管理 > <a href="{THIS_LOCAL}">询价管理</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-files-o am-margin-right-sm"></span>批量操作</a>
            <div class="am-dropdown" data-am-dropdown>
                <button class="am-btn am-btn-secondary am-dropdown-toggle am-text-sm" data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content">
                    <li><a href="javascript:;" class="btach" type="1">设为已处理</a></li>
                    <li><a href="javascript:;" class="btach" type="2">设为未处理</a></li>
                    <li class="am-divider"></li>
                    <li><a href="javascript:;" class="btach" type="3">批量删除</a></li>
                    <li class="am-divider"></li>
                </ul>
            </div>
        </div>
        <div class="am-btn-group am-btn-group-sm am-btn-toolbar am-margin-left-xs">
            <a class="am-btn am-btn-{if $type==0}warning{else}default{/if} am-radius" href="{U('index','type=0')}">全部</a>
            <a class="am-btn am-btn-{if $type==1}warning{else}default{/if} am-radius" href="{U('index','type=1')}">未处理</a>
            <a class="am-btn am-btn-{if $type==2}warning{else}default{/if} am-radius" href="{U('index','type=2')}">已处理</a>
        </div>
        <form action="{THIS_LOCAL}" class="am-form am-form-inline am-fr">
        {if sdcms[url_mode]==1}<input type="hidden" name="m" value="{C('ADMIN')}" /><input type="hidden" name="c" value="inquiry" /><input type="hidden" name="a" value="index" />{/if}
        <div class="am-form-group am-form-icon">
            <i class="am-icon-search"></i>
            <input type="text" name="keyword" class="am-form-field am-input-sm" value="{$keyword}" placeholder="请输入关键字">
        </div>
        <input type="submit" value="搜索" class="am-btn am-btn-warning am-radius am-text-sm">
        </form>
        <form method="post" id="form_name">
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                	<th width="30" height="30"><input type="checkbox" name="chkall" onClick="checkall(this.form)" title="全选/取消" style="width:auto;" /></th>
                    <th width="60">ID</th>
                    <th>询价产品</th>
                    <th width="100">姓名</th>
                    <th width="120">手机</th>
                    <th width="160">提交日期</th>
                    <th width="80">状态</th>
                    <th width="150">操作</th>
                </tr>
            </thead>
            <tbody>
            {sdcms:rs pagesize="20" table="sd_inquiry" where="$where" order="id desc"}
            {rs:eof}
            <tr>
                <td colspan="8">暂无资料</td>
            </tr>
            {/rs:eof}
            <tr>
            	<td><input type="checkbox" name="id" value="{$rs[id]}" style="width:auto;margin-top:8px;"></td>
                <td>{$rs[id]}</td>
                <td>{$rs[title]}</td>
                <td>{$rs[truename]}</td>
                <td>{$rs[mobile]}</td>
                <td>{date('Y-m-d H:i:s',$rs[createdate])}</td>
                <td>{iif($rs[isover]==1,'已处理','<em>未处理</em>')}</td>
                <td><a href="{U('edit',"id=".$rs[id]."")}"><span class="am-icon-edit"></span> 查看</a>　<a href="javascript:;" class="del" rel="{U('del','id='.$rs[id].'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/sdcms:rs}
            </tbody>
        </table>
        {if $total_rs!=0}
        <div class="am-padding-sm border-top">
            <div class="pagelist"><ul>{$showpage}</ul></div>
            <div class="am-cf"></div>
        </div>
        {/if}
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
				url:'{U("btach")}{iif(sdcms[url_mode]==1,"&","?")}id='+list+'&type='+type,
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
