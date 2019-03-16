<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>模板管理</title>
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
    <div class="position">当前位置：系统管理 > <a href="{U('index')}">模板管理</a>{$position} > <a href="{THIS_LOCAL}">模板列表</a></div>
    <div class="border">
        <!---->
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                	<th width="20"></th>
                    <th>名称</th>
                    <th width="300">说明</th>
                    <th width="120">大小</th>
                    <th width="180">修改时间</th>
                </tr>
            </thead>
            <tbody>
            {foreach $folder as $key=>$val}
            {if !(in_array($val[0],['block']))}
            <tr>
                <td><span class="am-icon-folder-o am-text-primary"></span></td>
                <td class="am-text-primary"><a href="{U('lists','root='.base64_encode($dir.'/'.$val[0]).'')}">{$val[0]}</a></td>
                <td></td>
                <td></td>
                <td>{date('Y-m-d H:i:s',$val[1])}</td>
            </tr>
            {/if}
            {/foreach}
            {foreach $file as $key=>$val}
            {php $n=$dir.'/'.$val[0]}
            {php $a=$note.$val[0]}
            {if !(in_array($val[0],['_config.php','_note.php','_theme.php']))}
            <tr>
                <td></td>
                <td><a href="{U('edit','root='.base64_encode($n).'')}">{$val[0]}</a></td>
                <td>{if isset($name[$a])}{$name[$a]}{/if}</td>
                <td>{$val[2]}</td>
                <td>{date('Y-m-d H:i:s',$val[1])}</td>
            </tr>
            {/if}
            {/foreach}
            </tbody>
        </table>
        <!---->
    </div>

</body>
</html>
