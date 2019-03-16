<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>错误日志</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<script src="{WEB_ROOT}public/dialog/dialog-min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：<a href="{THIS_LOCAL}">错误日志</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a class="am-btn am-btn-secondary am-radius am-text-sm clear" href="javascript:;" type="5"><span class="am-icon-trash am-margin-right-sm"></span>一键清理</a>
        </div>
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                    <th>日志名称</th>
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
                <td><a href="javascript:;" class="view" data-name="{base64_encode($rs[0])}"><span class="am-icon-file-o"></span> 查看</a>　<a href="javascript:;" class="del" data-url="{U('del','key='.base64_encode($rs[0]).'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/foreach}
            </tbody>
        </table>
        <!---->
    </div>

<script>
$(function(){
	toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$(".view").click(function(){
		var name=$(this).attr("data-name");
		$.AMUI.progress.inc();
		$.ajax({
			type:'post',
			cache:false,
			url:'{U("view")}',
			data:'key='+name,
			error:function(e){alert(e.responseText);},
			success:function(data){
				$.AMUI.progress.set(1.0);
				var d=dialog({
				title:'错误日志',
				content:data
				});
				d.show();
			}
		})
	});
    $(".clear").click(function(){
        layer.confirm(
            '确定要清理？', 
            {
                btn: ['确定','取消']
            }, function()
            {
                $.ajax({
                    url:'{U('clear')}',type:'post',dataType:'json',
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