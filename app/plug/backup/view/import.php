<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>数据还原</title>
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
    <div class="position">当前位置：插件管理 > <a href="{U('index')}">数据备份</a> > <a href="{THIS_LOCAL}">数据还原</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a href="{U('index')}" class="am-btn am-btn-secondary am-radius am-text-sm am-margin-left-sm"><span class="am-icon-database am-margin-right-sm"></span>数据备份</a>
        </div>
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                    <th>文件名称</th>
                    <th width="150">大小</th>
                    <th width="200">创建时间</th>
                    <th width="150">操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach $db as $rs}
            <tr>
                <td>{$rs[0]}</td>
                <td>{$rs[2]}</td>
                <td>{date('Y-m-d H:i:s',$rs[1])}</td>
                <td><a href="javascript:;" class="import" data-name="{$rs[0]}"><span class="am-icon-history"></span> 还原</a>　<a href="javascript:;" class="del" data-url="{U('del','key='.base64_encode($rs[0]).'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/foreach}
            </tbody>
        </table>
        <!---->
    </div>

<script>
$(function(){
	toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$(".import").click(function(){
		var name=$(this).attr("data-name");
		$.AMUI.progress.inc();
		$.ajax({
			type:'post',
			cache:false,
			dataType:'json',
			url:'{U("import")}',
			data:'key='+name,
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
	});
	$(".del").click(function(){
        var url=$(this).attr("data-url");
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
    });
})
</script>
</body>
</html>