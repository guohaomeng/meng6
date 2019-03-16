<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>页面权限</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<link rel="stylesheet" href="{WEB_ROOT}public/css/zTreeStyle/zTreeStyle.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<script src="{WEB_ROOT}public/js/jquery.ztree.core-3.5.min.js"></script>
<script src="{WEB_ROOT}public/js/jquery.ztree.excheck-3.5.min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
<script>
var setting={check:{enable:true},data:{simpleData:{enable:true}}};
var zNodes=[
{id:-1,pId:0,name:"全选/取消",open:true}
{sdcms:rp top="0" table="sd_admin_menu" where="islock=1 and followid=0" order="ordnum,id"}
{php $classid=$rp[id]}
,{id:{$rp[id]},pId:-1,name:"{$rp[title]}",open:true{if in_array($rp[id],$page_list)},checked:true{/if}}
{sdcms:rs top="0" table="sd_admin_menu" where="islock=1 and followid=$classid" order="ordnum,id"}
,{id:{$rs[id]},pId:{$rs[followid]},name:"{$rs[title]}",open:true{if in_array($rs[id],$page_list)},checked:true{/if}}
{/sdcms:rs}
{/sdcms:rp}
]
$(function(){
	$.fn.zTree.init($("#tree"),setting,zNodes);
});
</script>
</head>

<body>
    <div class="position">当前位置：系统管理 > <a href="{U('index')}">部门管理</a> > <a href="{THIS_LOCAL}">页面权限</a></div>
    <div class="border">
        <!---->
        <legend>页面权限</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-1 am-form-label">页面权限</label>
                <div class="am-u-sm-11">
                    <ul id="tree" class="ztree"></ul>
                </div>
            </div>
            
            <div class="am-form-group">
                <div class="am-u-sm-11 am-u-sm-offset-1">
                    <button type="submit" class="am-btn am-btn-primary am-radius">保存</button>
                    <button type="button" class="am-btn am-radius am-back">返回</button>
                </div>
            </div>
        </form>
        <!---->
    </div>

<script>
$(function(){
    toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
    $('.am-form').validator({
        timely:2,
        stopOnError:true,
        focusCleanup:true,
        ignore:':hidden',
        theme:'yellow_right_effect',
        valid:function(form)
        {
			var treeObj=$.fn.zTree.getZTreeObj("tree");
			var nodes=treeObj.getCheckedNodes(true);
			var str="";
			for(var i=0;i<nodes.length;i++){
				if(str==""){str=nodes[i].id}else{str+=","+nodes[i].id}
			} 
			var d0=str.replace("-1,","");
            $.AMUI.progress.inc();
            $.ajax({
                type:'post',
                cache:false,
                dataType:'json',
                url:'{THIS_LOCAL}',
                data:"t0="+encodeURIComponent(d0),
                error:function(e){alert(e.responseText);},
                success:function(d)
                {
                    $.AMUI.progress.set(1.0);
                    if(d.state=='success')
                    {
                        toastr.success(d.msg);
                        setTimeout(function(){location.href='{U("index")}';},1500);
                    }
                    else
                    {
                        toastr.error(d.msg);
                    }
                    
                }
            })
        }
    });
})
</script>
</body>
</html>