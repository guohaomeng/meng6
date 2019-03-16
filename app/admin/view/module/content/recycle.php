<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>回收站</title>
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
    <div class="position">当前位置：<a href="{U('index')}">内容管理</a> > <a href="{U('recycle')}">回收站</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-files-o am-margin-right-sm"></span>批量操作</a>
            <div class="am-dropdown" data-am-dropdown>
                <button class="am-btn am-btn-secondary am-dropdown-toggle am-text-sm" data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content">
                    <li><a href="javascript:;" class="btach" type="1">批量恢复</a></li>
                    <li class="am-divider"></li>
                    <li><a href="javascript:;" class="btach" type="8">批量删除</a></li>
                    <li class="am-divider"></li>
                </ul>
            </div>
        </div>
        <form action="{THIS_LOCAL}" class="am-form am-form-inline am-fr">
        {if sdcms[url_mode]==1}<input type="hidden" name="m" value="{C('ADMIN')}" /><input type="hidden" name="c" value="content" /><input type="hidden" name="a" value="recycle" />{/if}
        <div class="am-form-group am-form-icon">
            <i class="am-icon-search"></i>
            <input type="text" name="keyword" class="am-form-field am-input-sm" value="{$keyword}" placeholder="请输入关键字">
        </div>
        <input type="submit" value="搜索" class="am-btn am-btn-warning am-radius am-text-sm">
        </form>
       <form method="post" id="form_name" class="am-margin-top">
       <div class="am-panel am-panel-default am-margin-top">
       <div class="am-panel-hd">
           <h3 class="am-panel-title">回收站</h3>
       </div>
       <table class="am-table am-table-hover">
            <thead>
                <tr>
                    <th width="30" height="30"><input type="checkbox" name="chkall" onClick="checkall(this.form)" title="全选/取消" style="width:auto;" /></th>
                    <th>标题</th>
                    <th width="150">栏目名称</th>
                    <th width="50">人气</th>
                    <th width="50">缩图</th>
                    <th width="50">置顶</th>
                    <th width="50">推荐</th>
                    <th width="150">操作</th>
                </tr>
            </thead>
            <tbody>
            {sdcms:rs pagesize="20" table="sd_content" where="$where" order="ontop desc,ordnum desc,id desc"}
            {rs:eof}
            <tr>
                <td colspan="8">暂无数据</td>
            </tr>
            {/rs:eof}
            <tr>
            	<td><input type="checkbox" name="id" value="{$rs[id]}" style="width:auto;margin-top:8px;"></td>
                <td>{$rs[title]}</td>
                <td>{get_catename($rs[classid])}</td>
                <td>{$rs[hits]}</td>
                <td>{iif($rs[ispic]==1,"是","<em>否</em>")}</td>
                <td>{iif($rs[ontop]==1,"是","<em>否</em>")}</td>
                <td>{iif($rs[isnice]==1,"是","<em>否</em>")}</td>
                <td><a href="{U('edit',"classid=".$rs[classid]."&id=".$rs[id]."")}"><span class="am-icon-edit"></span> 编辑</a>　<a href="javascript:;" class="del" rel="{U('clear','id='.$rs[id].'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/sdcms:rs}
            </tbody>
        </table>
        	{if $total_rs!=0}
            <div class="border-top am-padding">
                <div class="pagelist"><ul>{$showpage}</ul></div>
            </div>
            {/if}
        </div>
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
