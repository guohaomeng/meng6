<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>素材管理</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<script src="{WEB_ROOT}public/dialog/dialog-min.js"></script>
<script src="{WEB_ROOT}public/js/jquery.masonry.min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
<script>
$(function(){
	 $(".list-loop").click(function(){
		var that=this;
		var id=$(that).attr("config");
		$(".list-loop").each(function(){
			$(this).removeClass("bg");		  
		});
		$(that).addClass("bg");
		$("#filelist").html(id);
		$("#master_box").html('<div class="list-loop">'+$(that).html()+'</div>');
	 })
})
</script>
</head>

<body class="bg_tree">
    <div id="filelist" style="display:none;"></div>
        <div id="master_box" style="display:none;"></div>
        <div id="master">
            {sdcms:rp pagesize="10" field="id,title" table="sd_mater" where="islock=1" order="id desc" auto="j"}
            {php $cid=$rp[id]}
            <div class="list-loop" config="{$rp[id]}">
                <div class="info">{$rp[title]}</div>
                {sdcms:rs field="id,title,pic" table="sd_mater_data" where="cid=$cid and islock=1" order="ordnum,id"}
                {if $i==1}
                <div class="hover">
                    <img src="{$rs[pic]}" width="267" >
                    <a href="javascript:;">{$rs[title]}</a>
                </div>
                {else}
                <div class="item">
                    <img src="{$rs[pic]}">
                    <a href="javascript:;">{$rs[title]}</a>
                </div>
                {/if}
                {/sdcms:rs}
                <div class="add"></div>
            </div>
            {/sdcms:rp}
        </div>
        
        {if $total_rp!=0}
        <div class="am-cf">
        	<div class="pagelist"><ul>{$showpage}</ul></div>
        </div>
        {/if}

<script>
$(function() {
	$('#master img').load(function(){
		$('#master').masonry({
			itemSelector:'.list-loop'});
		});
	$('#master').masonry({
			itemSelector:'.list-loop'
		});
});
</script>
</body>
</html>