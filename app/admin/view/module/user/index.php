<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>会员管理</title>
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
    <div class="position">当前位置：会员管理 > <a href="{THIS_LOCAL}">会员管理</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a href="{U('add')}" class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-plus am-margin-right-sm"></span>添加会员</a>
        </div>
        <div class="am-btn-group am-margin-left-xs">
            <a class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-files-o am-margin-right-sm"></span>按会员组查看</a>
            <div class="am-dropdown" data-am-dropdown>
                <button class="am-btn am-btn-secondary am-dropdown-toggle am-text-sm" data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content">
                	<li><a href="{U('index','uid=0')}">全部会员</a></li>
                    <li class="am-divider"></li>
                	{sdcms:rs top="0" table="sd_user_group" where="1=1" order="ordnum,gid"}
                    <li><a href="{U('index','uid='.$rs[gid].'')}">{$rs[gname]}</a></li>
                    <li class="am-divider"></li>
                    {/sdcms:rs}
                </ul>
            </div>
        </div>
        <div class="am-btn-group am-btn-group-sm am-btn-toolbar am-margin-left-xs">
            <a class="am-btn am-btn-{if $type==0}warning{else}default{/if} am-radius" href="{U('index','type=0')}">全部</a>
            <a class="am-btn am-btn-{if $type==1}warning{else}default{/if} am-radius" href="{U('index','type=1')}">启用</a>
            <a class="am-btn am-btn-{if $type==2}warning{else}default{/if} am-radius" href="{U('index','type=2')}">锁定</a>
            <a class="am-btn am-btn-{if $type==3}warning{else}default{/if} am-radius" href="{U('index','type=3')}">有头像</a>
        </div>
        <form action="{THIS_LOCAL}" class="am-form am-form-inline am-fr">
        {if sdcms[url_mode]==1}<input type="hidden" name="m" value="{C('ADMIN')}" /><input type="hidden" name="c" value="user" /><input type="hidden" name="a" value="index" />{/if}
        <div class="am-form-group am-form-icon">
            <i class="am-icon-search"></i>
            <input type="text" name="keyword" class="am-form-field am-input-sm" value="{$keyword}" placeholder="请输入关键字">
        </div>
        <input type="submit" value="搜索" class="am-btn am-btn-warning am-radius am-text-sm">
        </form>
        <form method="post" id="form_name">
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th>用户名</th>
                    <th width="150">邮箱</th>
                    <th width="150">会员组</th>
                    <th width="100">登录次数</th>
                    <th width="180">注册日期</th>
                    <th width="180">最后登录日期</th>
                    <th width="80">状态</th>
                    <th width="250">操作</th>
                </tr>
            </thead>
            <tbody>
            {sdcms:rs pagesize="20" table="sd_user" join="left join sd_user_group on sd_user.uid=sd_user_group.gid" where="$where" order="id desc"}
            {rs:eof}
            <tr>
                <td colspan="9">暂无资料</td>
            </tr>
            {/rs:eof}
            <tr>
                <td>{$rs[id]}</td>
                <td><a href="{if strlen($rs[uface])}{$rs[uface]}{else}{WEB_ROOT}upfile/noface.gif{/if}" target="_blank"><img src="{if strlen($rs[uface])}{$rs[uface]}{else}{WEB_ROOT}upfile/noface.gif{/if}" width="40" class="am-margin-right"></a><a href="{U('gouser',"id=".$rs[id]."")}" target="_blank">{$rs[uname]}</a></td>
                <td>{$rs[uemail]}</td>
                <td><a href="{U('index','uid='.$rs[uid].'')}">{$rs[gname]}</a></td>
                <td>{$rs[logintimes]}</td>
                <td>{date('Y-m-d H:i:s',$rs[regdate])}</td>
                <td>{date('Y-m-d H:i:s',$rs[lastlogindate])}</td>
                <td>{iif($rs[islock]==1,'启用','<em>锁定</em>')}</td>
                <td><a href="javascript:;" class="clear" rel="{U('clear',"id=".$rs[id]."")}"><span class="am-icon-trash"></span> 清除头像</a>　<a href="{U('edit',"id=".$rs[id]."")}"><span class="am-icon-edit"></span> 编辑</a>　<a href="javascript:;" class="del" rel="{U('del','id='.$rs[id].'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/sdcms:rs}
        </table>
        {if $total_rs!=0}
        <div class="am-padding-sm border-top">
            <div class="pagelist"><ul>{$showpage}</ul></div>
            <div class="am-cf"></div>
        </div>
        {/if}
        </form>
        <!---->
    </div>

<script>
$(function(){
    toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
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
    $(".clear").click(function(){
        var url=$(this).attr("rel");
        layer.confirm(
            '确定要清除？不可恢复！', 
            {
                btn: ['确定','取消']
            }, function()
            {
                $.ajax({
                    url:url,type:'post',dataType:'json',
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
