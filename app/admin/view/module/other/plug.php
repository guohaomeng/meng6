<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>插件管理</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：插件管理 > <a href="{THIS_LOCAL}">插件列表</a></div>
    <div class="border">
        <!---->
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                    <th>插件名称</th>
                    <th width="300">作者</th>
                    <th width="120">状态</th>
                    <th width="180">管理</th>
                </tr>
            </thead>
            <tbody>
            {if count($folder)==0}
            <tr>
                <td colspan="4">暂无插件</td>
            </tr>
            {/if}
            {foreach $folder as $key=>$val}
            {php list($name,$info)=$val}
            <tr>
                <td>{$info['title']}</td>
                <td><a href="{$info['url']}" target="_blank">{$info['author']}</a></td>
                <td>{if C('plug_'.$name)}已安装{else}<em>未安装</em>{/if}</td>
                <td>{if C('plug_'.$name)}{if $info['admin']}<a href="{U("plug/".$name."/admin")}">管理</a>　{/if}<a href="javascript:;" class="delete" rel="{U('delete','name='.$name.'')}">卸载</a>{else}<a href="javascript:;" class="install" rel="{U('install','name='.$name.'')}">安装</a>{/if}</td>
            </tr>
            {/foreach}
            </tbody>
        </table>
        <!---->
    </div>
<script>
$(function(){
	toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$(".install").click(function(){
		var url=$(this).attr("rel");
		layer.confirm(
            '确定要安装此插件？', 
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
	$(".delete").click(function(){
		var url=$(this).attr("rel");
		layer.confirm(
            '确定要卸载此插件？', 
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
