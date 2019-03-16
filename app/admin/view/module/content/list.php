<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>内容管理</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<script src="{WEB_ROOT}public/dialog/dialog-min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：<a href="{U('lists')}">内容管理</a>{if $classid>0}{get_content_postion($classid)}{/if}</div>
    <div class="border">
        <!---->
        {if $classid>0}
        <div class="am-btn-group">
            <a href="{U('add','classid='.$classid.'')}" class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-plus am-margin-right-sm"></span>添加内容</a>
        </div>
        {/if}
        <div class="am-btn-group">
            <a class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-files-o am-margin-right-sm"></span>批量操作</a>
            <div class="am-dropdown" data-am-dropdown>
                <button class="am-btn am-btn-secondary am-dropdown-toggle am-text-sm" data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content">
                    <li><a href="javascript:;" class="btach" type="1">设为发布</a></li>
                    <li><a href="javascript:;" class="btach" type="2">设为草稿</a></li>
                    <li class="am-divider"></li>
                    <li><a href="javascript:;" class="btach" type="3">设为推荐</a></li>
                    <li><a href="javascript:;" class="btach" type="4">取消推荐</a></li>
                    <li class="am-divider"></li>
                    <li><a href="javascript:;" class="btach" type="5">设为置顶</a></li>
                    <li><a href="javascript:;" class="btach" type="6">取消置顶</a></li>
                    <li class="am-divider"></li>
                    {if $classid>0}<li><a href="javascript:;" class="move">批量移动</a></li>{/if}
                    <li><a href="javascript:;" class="btach" type="7">批量删除</a></li>
                </ul>
            </div>
        </div>
        <div class="am-btn-group am-btn-group-sm am-btn-toolbar am-margin-left-xs">
            <a class="am-btn am-btn-{if $type==0}warning{else}default{/if} am-radius" href="{U('lists','classid='.$classid.'&type=0')}">全部</a>
            <a class="am-btn am-btn-{if $type==1}warning{else}default{/if} am-radius" href="{U('lists','classid='.$classid.'&type=1')}">草稿</a>
            <a class="am-btn am-btn-{if $type==2}warning{else}default{/if} am-radius" href="{U('lists','classid='.$classid.'&type=2')}">已发</a>
        </div>
        <form action="{THIS_LOCAL}" class="am-form am-form-inline am-fr">
        {if sdcms[url_mode]==1}<input type="hidden" name="m" value="{C('ADMIN')}" /><input type="hidden" name="c" value="content" /><input type="hidden" name="a" value="lists" />{/if}
        <div class="am-form-group am-form-icon">
            <i class="am-icon-search"></i>
            <input type="text" name="keyword" class="am-form-field am-input-sm" value="{$keyword}" placeholder="请输入关键字">
        </div>
        <input type="submit" value="搜索" class="am-btn am-btn-warning am-radius am-text-sm">
        </form>
        <div class="am-cf"></div>
       <form method="post" id="form_name" class="am-margin-top">
       <div class="am-panel am-panel-default am-margin-top">
       <div class="am-panel-hd">
           <h3 class="am-panel-title">{if $classid>0}{get_catename($classid)}{else}内容列表{/if}</h3>
       </div>
       <table class="am-table am-table-hover">
            <thead>
                <tr>
                    <th width="30" height="30"><input type="checkbox" name="chkall" onClick="checkall(this.form)" title="全选/取消" style="width:auto;" /></th>
                    <th width="80">排序</th>
                    <th>标题</th>
                    <th width="150">栏目名称</th>
                    <th width="50">人气</th>
                    <th width="50">缩图</th>
                    <th width="50">外链</th>
                    <th width="50">置顶</th>
                    <th width="50">推荐</th>
                    <th width="50">状态</th>
                    <th width="100">操作</th>
                </tr>
            </thead>
            <tbody>
            {sdcms:rs pagesize="20" table="sd_content" where="$where" order="ontop desc,ordnum desc,id desc"}
            {rs:eof}
            <tr>
                <td colspan="11">暂无数据</td>
            </tr>
            {/rs:eof}
            <tr>
                <td><input type="checkbox" name="id" value="{$rs[id]}" style="width:auto;margin-top:8px;"></td>
                <td><input type="hidden" name="mid[]" value="{$rs[id]}"><input type="text" name="ordnum[]" id="ordnum_{$rs[id]}" value="{$rs[ordnum]}" data-rule="required;int;"></td>
                <td><a href="{$rs[link]}" target="_blank" title="查看">{$rs[title]}</a> {if $rs[isauto]==1}<span class="am-icon-clock-o am-text-warning" title="定时发布：{date('Y-m-d H:i:s',$rs[createdate])}"></span>{/if}</td>
                <td><a href="{geturl($rs[classid],0)}">{get_catename($rs[classid])}</a></td>
                <td>{$rs[hits]}</td>
                <td>{iif($rs[ispic]==1,"是","<em>否</em>")}</td>
                <td>{iif($rs[isurl]==1,"是","<em>否</em>")}</td>
                <td>{iif($rs[ontop]==1,"是","<em>否</em>")}</td>
                <td>{iif($rs[isnice]==1,"是","<em>否</em>")}</td>
                <td>{iif($rs[islock]==1,"已发","<em>草稿</em>")}</td>
                <td><a href="javascript:;" class="copy" data-url="{U('copy',"classid=".$rs[classid]."&id=".$rs[id]."")}" title="复制"><span class="am-icon-copy"></span></a>　<a href="{U('edit',"classid=".$rs[classid]."&id=".$rs[id]."")}" title="编辑"><span class="am-icon-edit"></span></a>　<a href="javascript:;" class="del" data-url="{U('del','classid='.$classid.'&id='.$rs[id].'')}" title="删除"><span class="am-icon-trash"></span></a></td>
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
        </div>
        </form>
        <!---->
    </div>
    
<script>
$(function(){
    toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
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
    $(".move").click(function(){
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
            dialog({
                title:'批量移动',
                content:"<iframe id='treedata' src='{U('tree','classid='.$classid.'')}' scrolling='no' frameborder='0' width='450' height='350'></iframe>",
                ok:function()
                {
                    var t0=$('#go',document.getElementById('treedata').contentWindow.document).val();
                    if(t0=='')
                    {
                        toastr.error('请选择目标栏目');
                        return false;
                    }
                    $.AMUI.progress.inc();
                    $.ajax({
                         type:'post',
                         url:'{U("move")}',
                         dataType:'json',
                         data:'id='+list+'&go='+t0,
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
                    });
                    return false;
                },
                okValue:'确定',
            }).showModal();
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
                url:'{U("order","classid=".$classid."")}',
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
    $(".copy").click(function(){
        var url=$(this).attr("data-url");
        layer.confirm(
            '确定要复制此内容?', 
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