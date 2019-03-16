<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>缓存管理</title>
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
    <div class="position">当前位置：<a href="{THIS_LOCAL}">缓存管理</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a class="am-btn am-btn-secondary am-radius am-text-sm clear am-margin-right-sm" href="javascript:;" type="5"><span class="am-icon-trash am-margin-right-sm"></span>一键清理</a>
            <a class="am-btn am-btn-secondary am-radius am-text-sm weixin" href="javascript:;"><span class="am-icon-weixin am-margin-right-sm"></span>微信缓存清理</a>
        </div>
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                    <th>项目</th>
                    <th width="250">路径</th>
                    <th width="100">操作</th>
                </tr>
            </thead>
            <tbody>
            {if count($data)==0}
            <tr>
                <td colspan="3">暂无缓存</td>
            </tr>
            {/if}
            {foreach $data as $rs}
            <tr>
                <td>{$rs['title']}</td>
                <td>{$rs['path']}</td>
                <td><a href="javascript:;" class="del" data-url="{U('del','id='.$rs['id'].'')}"><span class="am-icon-trash"></span> 清理</a></td>
            </tr>
            {/foreach}
            </tbody>
        </table>
        <!---->
    </div>

<script>
$(function(){
    toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
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
		});
    });
	$(".weixin").click(function(){
        layer.confirm(
		'确定要清理？', 
		{
			btn: ['确定','取消']
		}, function()
		{
			$.ajax({
				url:'{U('weixin')}',type:'post',dataType:'json',
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
		});
    });
	$(".del").click(function(){
        var url=$(this).attr("data-url");
        layer.confirm(
            '确定要清理？', 
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