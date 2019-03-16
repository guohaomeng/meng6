<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>栏目管理</title>
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
    <div class="position">当前位置：<a href="{U('index')}">栏目管理</a>{$position}</div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a href="{U('add','fid='.$fid.'')}" class="am-btn am-btn-secondary am-radius am-text-sm am-margin-right-sm"><span class="am-icon-plus am-margin-right-sm"></span>添加栏目</a>
            {if $fid!=0}<a href="{U('index','fid='.$pid.'')}" class="am-btn am-btn-warning am-radius am-text-sm am-margin-right-sm"><span class="am-icon-angle-left am-margin-right-sm"></span>返回上级</a>{else}
            <a href="javascript:;" class="refresh am-btn am-btn-warning am-radius am-text-sm am-margin-right-sm"><span class="am-icon-circle-o-notch am-icon-spin am-margin-right-sm"></span>更新缓存</a>{/if}
        </div>
        
        <form method="post" id="form_name">
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                    <th width="80">排序</th>
                    <th width="80">栏目ID</th>
                    <th>栏目名称</th>
                    <th width="120">模型</th>
                    <th width="90">导航显示</th>
                    <th width="90">新窗口</th>
                    <th width="90">列表筛选</th>
                    <th width="360">操作</th>
                </tr>
            </thead>
            <tbody>
            {if empty($data)}
            <tr>
                <td colspan="8">暂无数据</td>
            </tr>
            {/if}
            {foreach $data as $rs}
            <tr>
                <td><input type="hidden" name="mid[]" value="{$rs['cateid']}"><input type="text" name="ordnum[]" id="ordnum_{$rs['cateid']}" value="{$rs['catenum']}" data-rule="required;int;"></td>
                <td>{$rs['cateid']}</td>
                <td>{$rs['catename']}</td>
                <td>{switch $rs['catetype']}{case -1}单页{/case}
                {case -2}外链{/case}
                {default}{if isset($model[$rs['catetype']]['title'])}{$model[$rs['catetype']]['title']}{/if}
                {/switch}</td>
                <td>{iif($rs['isshow']==1,'是','<em>否</em>')}</td>
                <td>{iif($rs['isblank']==1,'是','<em>否</em>')}</td>
                <td>{iif($rs['isfilter']==1,'是','<em>否</em>')}</td>
                <td><a href="{U('index',"fid=".$rs['cateid']."")}"><span class="am-icon-navicon"></span> 子栏目（{get_sonid_num($rs['cateid'])}）</a>　<a href="{cateurl($rs['cateid'])}" target="_blank"><span class="am-icon-file-o"></span> 访问</a>　<a href="{U('edit',"id=".$rs['cateid']."&fid=".$rs['followid']."")}"><span class="am-icon-edit"></span> 编辑</a>　<a href="{U('move',"id=".$rs['cateid']."")}"><span class="am-icon-edit"></span> 移动</a>　<a href="javascript:;" class="del" rel="{U('del','id='.$rs['cateid'].'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/foreach}
            </tbody>
        </table>{if !empty($data)}
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
	$(".refresh").click(function(){
		layer.confirm(
            '确定要更新栏目缓存？', 
            {
                btn: ['确定','取消']
            }, function()
            {
                $.ajax({
                    url:'{U("refresh")}',type:'post',dataType:'json',
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
