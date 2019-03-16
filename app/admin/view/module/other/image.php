<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>管理页面</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/iframe.css">
<link rel="stylesheet" href="{WEB_ROOT}public/css/zTreeStyle/zTreeStyle.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/jquery-ui.min.js"></script>
<script src="{WEB_ROOT}public/admin/js/jquery.layout-latest.min.js"></script>
<script src="{WEB_ROOT}public/js/jquery.ztree.core-3.5.min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
<script>
var myLayout;
$(document).ready(function () {
	myLayout = $("body").layout({
	/*	全局配置 */
		closable:					true	/* 是否显示点击关闭隐藏按钮*/
	,	resizable:					true	/* 是否允许拉动*/
	,   maskContents:               true    /* 加入此参数，框架内容页就可以拖动了*/
	/*	顶部配置 */
	,	north__spacing_open:		0		/* 顶部边框大小*/
	/*  底部配置 */
	,	south__spacing_open:		0		/* 底部边框大小*/
	/*	some pane-size settings*/
	,	west__minSize:				200     /*左侧最小宽度*/
	,   west__maxSize:				500     /*左侧最大宽度*/
	/*	左侧配置 */
	,   west__slidable:	            false
	,	west__animatePaneSizing:	false
	,	west__fxSpeed_size:			"slow"	/* 'fast' animation when resizing west-pane*/
	,	west__fxSpeed_open:			1000	/* 1-second animation when opening west-pane*/
	,	west__fxSettings_open:		{ easing: "easeOutBounce" } // 'bounce' effect when opening*/
	,	west__fxName_close:			"none"	/* NO animation when closing west-pane*/
	,	stateManagement__enabled:	false   /*是否读取cookies*/
	,	showDebugMessages:			false 
	}); 
});

var zNodes=[{$tree}]
	var setting={view:{dblClickExpand:false,showLine:true},data:{simpleData:{enable:true}},callback:{beforeExpand:beforeExpand,onExpand:onExpand,onClick:onClick}};
	var curExpandNode=null;
	function beforeExpand(treeId,treeNode) {
		var pNode=curExpandNode?curExpandNode.getParentNode():null;
		var treeNodeP=treeNode.parentTId?treeNode.getParentNode():null;
		var zTree=$.fn.zTree.getZTreeObj("tree");
		for(var i=0,l=!treeNodeP?0:treeNodeP.children.length;i<l; i++){
			if(treeNode!==treeNodeP.children[i]){zTree.expandNode(treeNodeP.children[i],false);}
		};
		while (pNode){
			if(pNode===treeNode){break;}
			pNode=pNode.getParentNode();
		};
		if(!pNode){singlePath(treeNode);}
	};
	function singlePath(newNode) {
		if (newNode === curExpandNode) return;
		if (curExpandNode && curExpandNode.open==true) {
			var zTree = $.fn.zTree.getZTreeObj("tree");
			if (newNode.parentTId === curExpandNode.parentTId) {
				zTree.expandNode(curExpandNode, false);
			} else {
				var newParents = [];
				while (newNode) {
					newNode = newNode.getParentNode();
					if (newNode === curExpandNode) {
						newParents = null;
						break;
					} else if (newNode) {
						newParents.push(newNode);
					}
				}
				if (newParents!=null) {
					var oldNode = curExpandNode;
					var oldParents = [];
					while (oldNode) {
						oldNode = oldNode.getParentNode();
						if (oldNode) {
							oldParents.push(oldNode);
						}
					}
					if (newParents.length>0) {
						zTree.expandNode(oldParents[Math.abs(oldParents.length-newParents.length)-1], false);
					} else {
						zTree.expandNode(oldParents[oldParents.length-1], false);
					}
				}
			}
		}
		curExpandNode = newNode;
	};
	
	function onExpand(event,treeId,treeNode){curExpandNode=treeNode;};
	
	function onClick(e,treeId,treeNode){
		var zTree=$.fn.zTree.getZTreeObj("tree");
		zTree.expandNode(treeNode,null,null,null,true);
	}
$(function(){
	$.fn.zTree.init($("#tree"),setting,zNodes);
	$(".ui-layout-north li:first-child").click();
});
</script>
</head>
<body>
<div class="ui-layout-west"><div id="tree" class="ztree"></div></div>
<div class="ui-layout-center"><input type="hidden" id="piclist"><iframe name="content_body" id="content_body" src="{U('imagelists','type='.$type.'&multiple='.$multiple.'')}" width="100%" height="100%" frameborder="0"></iframe></div>
</body>
</html>