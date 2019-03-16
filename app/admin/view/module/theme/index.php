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
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：系统管理 > <a href="{THIS_LOCAL}">模板管理</a></div>
    <div class="border">
        <!---->
        <legend>模板管理</legend>
        <ul class="am-gallery am-avg-sm-2 am-avg-md-3 am-avg-lg-4 am-gallery-bordered">
        	{foreach $folder as $key=>$val}
            {php list($name,$info)=$val}
            <li>
                <div class="am-gallery-item">
                    <img src="{WEB_ROOT}theme/{$val[0]}/{$info['image']}" alt="{$info['title']}"/>
                    <div class="am-g am-cf">
                        <div class="am-fl">
                            <h3 class="am-gallery-title">{$info['title']}</h3>
                            <div class="am-gallery-desc">作者：<a href="{$info['url']}" target="_blank">{$info['author']}</a></div>
                        </div>
                        <div class="am-fr">
                        	<button config="{$name}" type="button" class="action am-btn am-btn-{if $name==C('theme_dir')}success{else}warning{/if} am-round am-btn-xs am-margin-top am-margin-right-xs"{if $name==C('theme_dir')} disabled="disabled"{/if}>{if $name==C('theme_dir')}使用中{else}使用此模板{/if}</button>
                            <a href="{U('lists','root='.base64_encode($name).'')}" class="am-btn am-btn-primary am-round am-btn-xs am-margin-top am-margin-right-xs">管理模板</a>
                        </div>
                    </div>
                </div>
            </li>
            {/foreach}
            <li>
                <div class="am-gallery-item">
                	<a href="http://www.sdcms.cn/template.html" target="_blank"><img src="{WEB_ROOT}public/admin/images/more.gif" /></a>
                    <div class="am-g">
                        <div class="am-fl">
                            <h3 class="am-gallery-title">　</h3>
                            <div class="am-gallery-desc">　</div>
                        </div>
                        <div class="am-fr">
                            <a href="http://www.sdcms.cn/template.html" target="_blank" class="am-btn am-btn-warning am-round am-btn-xs am-margin-top am-margin-right-xs">点击查看更多模板 →</a>
                        </div>
                    </div>
                
                </div>
            </li>
        </ul>

        <!---->
    </div>
<script>
$(function(){
	toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$(".action").click(function(){
		var config=$(this).attr("config");
		layer.confirm(
            '确定要使用此模板？', 
            {
                btn: ['确定','取消']
            }, function()
            {
                $.ajax({
                    url:'{U("config")}',data:'config='+encodeURIComponent(config),type:'post',dataType:'json',
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