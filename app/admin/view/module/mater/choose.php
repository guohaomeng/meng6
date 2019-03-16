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

<body style="background:#fff;padding:10px;">
	<input type="hidden" name="go" id="go" value="">
    <form action="{THIS_LOCAL}" class="am-form am-form-inline">
    	{if sdcms[url_mode]==1}
        <input type="hidden" name="m" value="{C('ADMIN')}" />
        <input type="hidden" name="c" value="mater" />
        <input type="hidden" name="a" value="choose" />
        {/if}
        <div class="am-form-group am-form-icon">
            <i class="am-icon-search"></i>
            <input type="text" name="keyword" class="am-form-field am-input-sm" value="{$keyword}" placeholder="请输入关键字">
        </div>
        <input type="submit" value="搜索" class="am-btn am-btn-warning am-radius am-text-sm">
        <span class="am-padding-left am-fr am-text-danger">提示：点选标题后按确定即可</span>
    </form>
    <form method="post" id="form_name" class="am-margin-top">
       <div class="am-panel am-panel-default am-margin-top">
           <table class="am-table am-table-hover">
                <thead>
                    <tr>
                    	<th>编号</th>
                        <th>标题</th>
                    </tr>
                </thead>
                <tbody>
                {sdcms:rs pagesize="20" table="sd_content" join="left join sd_category on sd_content.classid=sd_category.cateid" where="$where" order="ordnum desc,id desc"}
                {rs:eof}
                <tr>
                    <td colspan="2">暂无数据</td>
                </tr>
                {/rs:eof}
                <tr config="{$rs[id]}:{$rs[catetype]}" class="choose" title="点击选择此内容" style="cursor:pointer;">
                    <td>{$rs[id]}</td>
                    <td>{$rs[title]}</td>
                </tr>
                {/sdcms:rs}
                </tbody>
            </table>
        </div>
    </form>
    {if $total_rs!=0}
    <div class="am-padding">
        <div class="pagelist"><ul>{$showpage}</ul></div>
    </div>
    {/if}
	<script>
    $(".choose").click(function(){
        var val=$(this).attr("config");
        $("table tr").each(function(){
            $(this).removeClass("am-active");
        })
        $(this).addClass("am-active");
        $("#go").val(val);
    })
    </script>
</body>
</html>
