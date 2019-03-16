<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>数据备份</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：插件管理 > <a href="{THIS_LOCAL}">数据备份</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-files-o am-margin-right-sm"></span>批量操作</a>
            <div class="am-dropdown" data-am-dropdown>
                <button class="am-btn am-btn-secondary am-dropdown-toggle am-text-sm" data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content">
                    <li><a href="javascript:;" class="btach" type="1">备份数据</a></li>
                    <li><a href="javascript:;" class="btach" type="2">优化数据</a></li>
                    <li><a href="javascript:;" class="btach" type="3">修复数据</a></li>
                </ul>
            </div>
            <a href="{U('import')}" class="am-btn am-btn-secondary am-radius am-text-sm am-margin-left-sm"><span class="am-icon-history am-margin-right-sm"></span>数据还原</a>
        </div>
        <form method="post" id="form_name">
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                    <th width="30" height="30"><input type="checkbox" name="chkall" onClick="checkall(this.form)" title="全选/取消" checked style="width:auto;" /></th>
                    <th>表名</th>
                    <th width="150">数量</th>
                    <th width="150">大小</th>
                    <th width="200">创建时间</th>
                    <th width="150">操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach $db as $rs}
            <tr>
                <td><input type="checkbox" name="id" value="{$rs['Name']}" checked style="width:auto;margin-top:8px;"></td>
                <td>{$rs['Name']}</td>
                <td>{$rs['Rows']}</td>
                <td>{formatBytes($rs['Data_length'])}</td>
                <td>{$rs['Create_time']}</td>
                <td><a href="javascript:;" class="do" type="2" data-name="{$rs['Name']}"><span class="am-icon-bolt"></span> 优化表</a>　<a href="javascript:;" class="do" type="3" data-name="{$rs['Name']}"><span class="am-icon-wrench"></span> 修复表</a></td>
            </tr>
            {/foreach}
            </tbody>
        </table>
        </form>
        <!---->
    </div>

<script>
$(function(){
	toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$(".btach").click(function(){
		var type=$(this).attr("type");
		var list="";
		$($("input[name='id']:checked")).each(function(){
			if(list==""){list+=this.value}else{list+=","+this.value}                   
		}); 
		if(list=="")
		{
			toastr.error('至少选择一个表');
		}
		else
		{
			$.AMUI.progress.inc();
			$.ajax({
				type:'post',
				cache:false,
				dataType:'json',
				url:'{U("btach")}',
				data:'id='+list+'&type='+type,
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
	$(".do").click(function(){
		var type=$(this).attr("type");
		var list=$(this).attr("data-name");
		if(list=="")
		{
			toastr.error('至少选择一个表');
		}
		else
		{
			$.AMUI.progress.inc();
			$.ajax({
				type:'post',
				cache:false,
				dataType:'json',
				url:'{U("btach")}',
				data:'id='+list+'&type='+type,
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
})
</script>
</body>
</html>