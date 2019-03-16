<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>字段管理</title>
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
    <div class="position">当前位置：系统管理 > <a href="{U('form/index')}">表单管理</a> > <a href="{THIS_LOCAL}">{$ftitle}</a> > 字段管理</div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a href="{U('add',"fid=".$fid."")}" class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-plus am-margin-right-sm"></span>添加字段</a>
        </div>
        <form method="post" id="form_name">
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                    <th width="80">排序</th>
                    <th width="80">字段ID</th>
                    <th>字段名称</th>
                    <th width="120">Key</th>
                    <th width="120">类型</th>
                    <th width="100">列表显示</th>
                    <th width="80">状态</th>
                    <th width="220">操作</th>
                </tr>
            </thead>
            <tbody>
            {sdcms:rs top="0" table="sd_form_field" where="form_id=$fid" order="ordnum,id"}
            {rs:eof}<tr>
                <td colspan="8">暂无资料</td>
            </tr>
            {/rs:eof}
            <tr>
                <td><input type="hidden" name="mid[]" value="{$rs[id]}"><input type="text" name="ordnum[]" id="ordnum_{$rs[id]}" value="{$rs[ordnum]}" data-rule="required;int;"></td>
                <td>{$rs[id]}</td>
                <td>{$rs[field_title]}</td>
                <td>{$rs[field_key]}</td>
                <td>
                {switch $rs[field_type]}
                {case 1}普通文本{/case}
                {case 2}普通文本-日期{/case}
                {case 3}普通文本-整数{/case}
                {case 4}普通文本-价格{/case}
                {case 5}普通文本-上传{/case}
                {case 6}普通文本-密码{/case}
                {case 7}普通文本-隐藏域{/case}
                {case 8}多行文本框{/case}
                {case 9}单选按钮{/case}
                {case 10}复选框{/case}
                {case 11}下拉菜单{/case}
                {case 12}编辑器{/case}
                {case 13}图集{/case}
                {case 14}数据集{/case}
                {/switch}</td>
                <td>{iif($rs[islist]==1,'是','<em>否</em>')}</td>
                <td>{iif($rs[islock]==1,'启用','<em>锁定</em>')}</td>
                <td><a href="{U('edit',"id=".$rs[id]."")}"><span class="am-icon-edit"></span> 编辑</a>　<a href="javascript:;" class="del" rel="{U('del','id='.$rs[id].'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/sdcms:rs}
            </tbody>
        </table>
        {if $total_rs>0}
        <button type="submit" class="am-btn am-btn-warning am-radius am-text-sm">保存排序</button>
        {/if}
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
    })
})
</script>
</body>
</html>
