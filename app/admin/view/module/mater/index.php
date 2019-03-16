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
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：微信管理 > <a href="{THIS_LOCAL}">素材管理</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a href="{U('add')}" class="am-btn am-btn-secondary am-radius am-text-sm am-margin-right-sm"><span class="am-icon-plus am-margin-right-sm"></span>新增素材</a>
        </div>
        <div id="master">
            {sdcms:rp pagesize="10" field="id,title" table="sd_mater" where="islock=1" order="id desc" auto="j"}
            {php $cid=$rp[id]}
            <div class="list-loop">
                <div class="info"><a href="javascript:;" config="{$rp[id]}" defaultval="{$rp[title]}" class="remark"><span class="am-icon-pencil"></span> 重命名</a>{$rp[title]}</div>
                {sdcms:rs top="0" field="id,title,pic" table="sd_mater_data" where="cid=$cid and islock=1" order="ordnum,id"}
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
                <div class="admin">
                    <ul>
                        <li><a href="{U('add','classid='.$rp[id].'')}"><span class="am-icon-edit"></span> 编辑</a></li>
                        <li><a href="javascript:;" class="del" rel="{U('delcate','id='.$rp[id].'')}"><span class="am-icon-trash"></span> 删除</a></li>
                    </ul>
                </div>
            </div>
            {/sdcms:rp}
        </div>
        {if $total_rp!=0}
        <div class="am-cf">
        	<div class="pagelist"><ul>{$showpage}</ul></div>
        </div>
        {/if}
        <!---->
    </div>

<script>
$(function(){
    toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
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
    });
	$(".remark").click(function(){
		var id=$(this).attr("config");
		var defaultval=$(this).attr("defaultval");
		var html="";
			html+='<dl>'
			html+='  <dt><input id="master_remark" maxlength="15" value="'+defaultval+'"></dt>'
			html+='</dl>'
			dialog({
			title:'重命名',
			content:html,
			ok:function(){
				var t1=document.getElementById("master_remark").value;
				if(t1=='')
				{
					toastr.error('不能为空');
					return;
				}
				$.ajax({
					url:"{U('remark')}{if C('url_mode')==1}&{else}?{/if}t0="+encodeURIComponent(id)+"&t1="+encodeURIComponent(t1)+"",
					type:"post",
					success:function(data){
						if(data=="1")
						{
							toastr.success('设置成功');
							setTimeout('location.href="{THIS_LOCAL}"',1000);
						}
						else
						{
							toastr.error(data);
						}
					}
				})			
			},
			okValue:'保存',
			cancelValue:'取消',
			cancel:true 
		}).showModal();
	});
})
</script>
</body>
</html>