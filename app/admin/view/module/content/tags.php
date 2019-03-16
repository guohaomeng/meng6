<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>标签选择</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="border">
    	<input id="taglist" type="hidden" value="">
        <ul class="tags">
        	{sdcms:rs top="0" table="sd_tags" order="hits desc,id desc"}
        	{rs:eof}暂无标签可选{/rs:eof}
        	<li data-tags="{$rs[title]}">{$rs[title]}</li>
        	{/sdcms:rs}
        </ul>
    </div>
    
    <script>
	$(function(){
		$(".tags li").click(function(){
			if($(this).hasClass("hover"))
			{
				$(this).removeClass("hover");
			}
			else
			{
				$(this).addClass("hover");
			}
			gettag();
		});
	})
	function gettag()
	{
		var i=0;
		var str='';
		$(".tags li").each(function(){
			if($(this).hasClass("hover"))
			{
				var tags=$(this).attr("data-tags");
				if(i==0)
				{
					str=tags;
				}
				else
				{
					str=str+','+tags;
				}
				i=i+1;
			}
		})
		$("#taglist").val(str);
	}
	</script>
</body>
</html>