<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>链接管理</title>
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
    <div class="position">当前位置：扩展管理 > <a href="{THIS_LOCAL}">链接管理</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a href="{U('add')}" class="am-btn am-btn-secondary am-radius am-text-sm am-margin-right-sm"><span class="am-icon-plus am-margin-right-sm"></span>添加链接</a>
            <a href="{U('config')}" class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-cog am-margin-right-sm"></span>链接配置</a>
        </div>
        <div class="am-btn-group">
            <a class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-files-o am-margin-right-sm"></span>批量操作</a>
            <div class="am-dropdown" data-am-dropdown>
                <button class="am-btn am-btn-secondary am-dropdown-toggle am-text-sm" data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content">
                    <li><a href="javascript:;" class="btach" type="1">批量启用</a></li>
                    <li class="am-divider"></li>
                    <li><a href="javascript:;" class="btach" type="2">批量锁定</a></li>
                    <li class="am-divider"></li>
                    <li><a href="javascript:;" class="btach" type="3">批量删除</a></li>
                </ul>
            </div>
        </div>
        <div class="am-btn-group am-btn-group-sm am-btn-toolbar am-margin-left-xs">
            <a class="am-btn am-btn-{if $type==0}warning{else}default{/if} am-radius" href="{U('index','type=0')}">全部</a>
            <a class="am-btn am-btn-{if $type==1}warning{else}default{/if} am-radius" href="{U('index','type=1')}">未审</a>
            <a class="am-btn am-btn-{if $type==2}warning{else}default{/if} am-radius" href="{U('index','type=2')}">已审</a>
            <a class="am-btn am-btn-{if $type==3}warning{else}default{/if} am-radius" href="{U('index','type=3')}">文字</a>
            <a class="am-btn am-btn-{if $type==4}warning{else}default{/if} am-radius" href="{U('index','type=4')}">Logo</a>
        </div>
        <form method="post" id="form_name">
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                	<th width="30" height="30"><input type="checkbox" name="chkall" onClick="checkall(this.form)" title="全选/取消" style="width:auto;" /></th>
                    <th width="80">排序</th>
                    <th width="80">ID</th>
                    <th>网站名称</th>
                    <th width="300">网址</th>
                    <th width="80">状态</th>
                    <th width="150">操作</th>
                </tr>
            </thead>
            <tbody>
            {sdcms:rs pagesize="20" table="sd_link" where="$where" order="ordnum,id"}
            {rs:eof}
            <tr>
                <td colspan="7">暂无资料</td>
            </tr>
            {/rs:eof}
            <tr>
            	 <td><input type="checkbox" name="id" value="{$rs[id]}" style="width:auto;margin-top:8px;"></td>
                <td><input type="hidden" name="mid[]" value="{$rs[id]}"><input type="text" name="ordnum[]" id="ordnum_{$rs[id]}" value="{$rs[ordnum]}" data-rule="required;int;"></td>
                <td>{$rs[id]}</td>
                <td>{$rs[webname]}</td>
                <td><a href="{$rs[weburl]}" target="_blank">{$rs[weburl]}</a></td>
                <td>{iif($rs[islock]==1,'启用','<em>锁定</em>')}</td>
                <td><a href="{U('edit',"id=".$rs[id]."")}"><span class="am-icon-edit"></span> 编辑</a>　<a href="javascript:;" class="del" rel="{U('del','id='.$rs[id].'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/sdcms:rs}
            </tbody>
        </table>
        {if $total_rs!=0}
            <div class="border-top am-padding">
                <div class="am-u-sm-2 am-padding-left-0"><button type="submit" class="am-btn am-btn-warning am-radius am-text-sm">保存排序</button></div>
                <div class="am-u-sm-10 pagelist"><ul>{$showpage}</ul></div>
                <div class="clear"></div>
            </div>
            {/if}
        </form>
        <!---->
    </div>

<script>
$(function(){
    toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	 $(".btach").click(function(){
        var type=$(this).attr("type");
        var list="";
        $($("input[name='id']:checked")).each(function(){
            if(list==""){list+=this.value}else{list+=","+this.value}                   
        }); 
        if(list=="")
        {
            toastr.error('至少选择一条内容');
        }
        else
        {
            $.AMUI.progress.inc();
            $.ajax({
                type:'get',
                cache:false,
                dataType:'json',
                url:'{U("btach")}{iif(sdcms[url_mode]==1,"&","?")}id='+list+'&type='+type,
                data:"",
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
