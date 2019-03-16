<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>区块管理</title>
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
    <div class="position">当前位置：内容管理 > <a href="{U('index')}">区块管理</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a href="{U('add')}" class="am-btn am-btn-secondary am-radius am-text-sm am-margin-right-sm"><span class="am-icon-plus am-margin-right-sm"></span>添加区块</a>
        </div>
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                    <th>区块说明</th>
                    <th width="300">关键字</th>
                    <th width="180">修改时间</th>
                    <th width="300">调用标签</th>
                    <th width="120">操作</th>
                </tr>
            </thead>
            <tbody>
            {if count($file)==0}
            <tr>
                <td colspan="5">暂无区块</td>
            </tr>
            {/if}
            {foreach $file as $key=>$val}
            {php $n=$dir.'/'.$val[0]}
            <tr>
                <td>{if isset($name[$n])}{$name[$n]}{/if}</td>
                <td>{str_replace('.php','',$val[0])}</td>
                <td>{date('Y-m-d H:i:s',$val[1])}</td>
                <td><input type="text" class="block" config="{str_replace('.php','',$val[0])}" value="" onFocus="this.select()"></td>
                <td><a href="{U('edit','root='.base64_encode($val[0]).'')}"><span class="am-icon-edit"></span> 编辑</a>　<a href="javascript:;" class="del" rel="{U('del','key='.base64_encode($val[0]).'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/foreach}
            </tbody>
        </table>
        <!---->
    </div>
<script>
$(function(){
    toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$(".block").each(function(e){
		var key=$(this).attr("config");
		var html='{';
		html+='block("';
		html+=key;
		html+='")}';
		$(this).attr("value",html);
	})
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
