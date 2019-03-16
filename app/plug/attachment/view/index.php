<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>附件管理</title>
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
    <div class="position">当前位置：插件管理 > <a href="{U('index')}">附件管理</a>{$position}</div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a class="am-btn am-btn-secondary am-radius am-text-sm clear" href="javascript:;" type="5"><span class="am-icon-trash am-margin-right-sm"></span>一键清理缩略图</a>
        </div>
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                	<th width="20"></th>
                    <th>名称</th>
                    <th width="150">预览</th>
                    <th width="120">大小</th>
                    <th width="180">修改时间</th>
                    <th width="60">操作</th>
                </tr>
            </thead>
            <tbody>
            {foreach $folder as $key=>$val}
            <tr>
                <td><span class="am-icon-folder-o am-text-primary"></span></td>
                <td class="am-text-primary"><a href="{U('index','root='.base64_encode($dir.'/'.$val[0]).'')}">{$val[0]}</a></td>
                <td></td>
                <td>-</td>
                <td>{date('Y-m-d H:i:s',$val[1])}</td>
                <td><em><span class="am-icon-trash"></span> 删除</em></td>
            </tr>
            {/foreach}
            {foreach $file as $key=>$val}
            <tr>
                <td></td>
                <td><a href="{WEB_ROOT}{$dir.'/'.$val[0]}" target="_blank">{$val[0]}</a></td>
                <td>{if $val[4]==1}<a href="javascript:;"><img src="{WEB_ROOT}{$dir.'/'.$val[0]}" width="100" style="max-height:100px;" class="am-img-thumbnail am-radius preview" data-url="{WEB_ROOT}{$dir.'/'.$val[0]}"></a>{/if}</td>
                <td>{$val[2]}</td>
                <td>{date('Y-m-d H:i:s',$val[1])}</td>
                <td><a href="javascript:;" class="del" config="{U('del','root='.base64_encode($dir.'/'.$val[0]).'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/foreach}
            </tbody>
        </table>
        <!---->
    </div>
<script>
$(function(){
    toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
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
        var url=$(this).attr("config");
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
	$(".preview").click(function(){
		var url=$(this).attr("data-url");
		layer.open({
		type: 1,
		title:false,
		closeBtn: 0,
		shadeClose: true,
		content:'<img src="'+url+'" style="max-width:360px;">'
		});
	});
})
</script>
</body>
</html>