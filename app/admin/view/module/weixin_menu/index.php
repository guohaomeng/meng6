<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>菜单管理</title>
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
    <div class="position">当前位置：微信管理 > <a href="{THIS_LOCAL}">菜单管理</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a href="{U('add')}" class="am-btn am-btn-secondary am-radius am-text-sm am-margin-right-sm"><span class="am-icon-plus am-margin-right-sm"></span>添加菜单</a>
            <a href="javascript:;" class="am-btn am-btn-secondary am-radius am-text-sm am-margin-right-sm publish"><span class="am-icon-file-o am-margin-right-sm"></span>发布菜单</a>
            <a href="javascript:;" class="am-btn am-btn-secondary am-radius am-text-sm delete"><span class="am-icon-trash am-margin-right-sm"></span>删除菜单</a>
        </div>
        <form method="post" id="form_name">
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                    <th width="80">排序</th>
                    <th width="80">菜单ID</th>
                    <th>菜单名称</th>
                    <th width="120">类型</th>
                    <th width="220">操作</th>
                </tr>
            </thead>
            <tbody>
            {sdcms:rp top="0" table="sd_wx_menu" where="followid=0" order="ordnum,id"}
            {php $classid=$rp[id]}
            <tr>
                <td><input type="hidden" name="mid[]" value="{$rp[id]}"><input type="text" name="ordnum[]" id="ordnum_{$rp[id]}" value="{$rp[ordnum]}" data-rule="required;int;"></td>
                <td>{$rp[id]}</td>
                <td>{$rp[title]}</td>
                <td>{switch $rp[reply_type]}{case 0}一级菜单{/case}{case 1}文本消息{/case}{case 2}图文素材{/case}{case 3}外链{/case}{case 4}小程序{/case}{/switch}</td>
                <td>{if $rp[followid]==0}<a href="{U('add',"fid=".$rp[id]."")}"><span class="am-icon-plus-circle"></span> 添加子菜单</a>　{/if}<a href="{U('edit',"id=".$rp[id]."")}"><span class="am-icon-edit"></span> 编辑</a>　<a href="javascript:;" class="del" rel="{U('del','id='.$rp[id].'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {sdcms:rs top="0" table="sd_wx_menu" where="followid=$classid" order="ordnum,id"}
            <tr>
                <td><input type="hidden" name="mid[]" value="{$rs[id]}"><input type="text" name="ordnum[]" id="ordnum_{$rs[id]}" value="{$rs[ordnum]}" data-rule="required;int;"></td>
                <td>{$rs[id]}</td>
                <td>　　{$rs[title]}</td>
                <td>{switch $rs[reply_type]}{case 0}一级菜单{/case}{case 1}文本消息{/case}{case 2}图文素材{/case}{case 3}外链{/case}{case 4}小程序{/case}{/switch}</td>
                <td>　　　　　　　<a href="{U('edit',"id=".$rs[id]."")}"><span class="am-icon-edit"></span> 编辑</a>　<a href="javascript:;" class="del" rel="{U('del','id='.$rs[id].'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/sdcms:rs}
            {/sdcms:rp}
            </tbody>
        </table>
        {if $total_rp!=0}
        <button type="submit" class="am-btn am-btn-warning am-radius am-text-sm">保存排序</button>{/if}
        </form>
        <!---->
    </div>

<script>
$(function(){
    toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
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
                url:'{THIS_LOCAL}',
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
    });
	$(".delete").click(function(){
        var url=$(this).attr("rel");
        layer.confirm(
            '确定要删除已发布的菜单？', 
            {
                btn: ['确定','取消']
            }, function()
            {
                $.ajax({
				type:"post",
				dataType:'json',
				url:"{U('delete')}",
				success:function(d)
				{
					layer.closeAll();
					if(d.state=='success')
					{
						toastr.success(d.msg);
						setTimeout("location.href='?'",1000);
					}
					else
					{
						toastr.error(d.msg);
					}
				}
				});
            }, function()
            {
               
            });
    });
	$(".publish").click(function(){
		var url=$(this).attr("data-url");
		$.ajax({
			url:"{U('publish')}",
			type:"post",
			dataType:'json',
			success:function(d){
				if(d.state=='success')
				{
					toastr.success(d.msg);
				}
				else
				{
					toastr.error(d.msg);
				}
			}
		})
	});
})
</script>
</body>
</html>