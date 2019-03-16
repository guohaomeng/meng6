<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>新增素材</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script>var ue_url="{U('upload/imagelist','type=1&multiple=1')}";</script>
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/js/dropzone.js"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<script src="{WEB_ROOT}public/ueditor/ueditor.config.js"></script>
<script src="{WEB_ROOT}public/ueditor/ueditor.all.min.js"></script>
<script src="{WEB_ROOT}public/dialog/dialog-min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
	<div class="am-progress am-progress-striped am-active" id="progress"><div class="am-progress-bar am-progress-bar-success" style="width:0%"></div></div>
    <div class="position">当前位置：微信管理 > <a href="{U('index')}">素材管理</a> > <a href="{THIS_LOCAL}">新增素材</a></div>
    <div class="border">
        <!---->
        <legend>新增素材</legend>
        <div id="master_add">
             <div class="left">
                 <div id="left_master">
                     {sdcms:rs top="10" table="sd_mater_data" where="cid=$classid" order="ordnum,id"}
                     {if $i==1}
                     <div class="header{if $cid==$rs[id]} top{/if}">
                         <div class="img frist_pic_{$rs[id]}">{if strlen($rs[pic])==0}封面图片{else}<img src="{$rs[pic]}">{/if}</div>
                         <a href="" class="frist_title_{$rs[id]}">{if strlen($rs[title])==0}标题{else}{$rs[title]}{/if}</a>
                         <div class="hover"><a href="{U('down','cid='.$rs[id].'&lc='.$i.'')}"><span>下移</span></a>　<a href="{U('add','classid='.$classid.'&cid='.$rs[id].'&f=1&lc='.$i.'')}"><span>编辑</span></a></div>
                     </div>
                     {else}
                     <a name="last_{$rs[id]}"></a>
                     <div class="item{if $cid==$rs[id]} active{/if}">
                         <div class="img frist_pic_{$rs[id]}">{if strlen($rs[pic])==0}缩略图{else}<img src="{$rs[pic]}">{/if}</div>
                         <a href="" class="frist_title_{$rs[id]}">{if strlen($rs[title])==0}标题{else}{$rs[title]}{/if}</a>
                         <div class="hover"><a href="{U('up','cid='.$rs[id].'&lc='.$i.'')}"><span>上移</span></a>　<a href="{U('down','cid='.$rs[id].'&lc='.$i.'')}"><span>下移</span></a>　<a href="{U('add','classid='.$classid.'&cid='.$rs[id].'&f=0&lc='.$i.'')}"><span>编辑</span></a>　<a href="javascript:;" class="del" data-url="{U('del','id='.$rs[id].'')}"><span>删除</span></a></div>
                     </div>
                     {/if}
                     {/sdcms:rs}
                     {if $i<8}
                     <div class="more"><a href="javascript:;" class="addone" title="新增一条">+</a><a href="javascript:;" class="choose" title="选择内容">□</a></div>
                     {/if}             
                 </div>
             </div>
             <div class="right">
                <!---->
                <div class="table_form">
                    <form class="am-form am-form-horizontal" method="post">
                    	<div id="arraw-left"><span></span></div>
                        
                        <div class="am-form-group">
                            <label class="am-u-sm-2 am-form-label">标题</label>
                            <div class="am-u-sm-10">
                                <input type="text" name="t0" id="t0" size="50" value="{$title}" data-rule="标题:required;">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label class="am-u-sm-2 am-form-label">{if $ordnum==1}封面{else}缩略图{/if}</label>
                            <div class="am-u-sm-10">
                                <input type="text" name="t1" id="t1" size="50" value="{$pic}" data-rule="{if $ordnum==1}封面{else}缩略图{/if}:required;">
                                <span class="am-btn-group"><button type="button" class="am-btn am-btn-secondary am-radius dropzone" config="t1" url="{U('upload/upfile','type=1')}" maxsize="{C('upload_image_max')}" title="上传">上传</button><button type="button" class="am-btn am-btn-primary am-radius fm-choose" data-name="t1" data-url="{U('upload/imagelist','type=1&multiple=0')}" data-type="1" data-multiple="0"  data-replace="frist_pic_{$cid}" title="选择">选择</button><button type="button" class="am-btn am-btn-secondary am-radius pic-preview" data-name="t1" title="预览">预览</button></span>
                                <span class="msg-box" for="t1"></span>
                                <span class="am-margin-left input-tips"><br>{if $ordnum==1}建议尺寸：360像素 * 200像素{else}建议尺寸：200像素 * 200像素{/if}</span>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label class="am-u-sm-2 am-form-label">正文</label>
                            <div class="am-u-sm-10">
                                 <script id="t2" name="t2" type="text/plain" style="height:260px;">{$content}</script>
								 <script>UE.getEditor('t2',{toolbars:editorMaster,serverUrl :'{U('upload/index')}'});</script>
                                 <input type="button" class="am-btn am-btn-secondary am-btn-sm editor_savepic" data-url="{U('upload/outimage')}" data-name="t2" value="保存编辑器中外部图片">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label class="am-u-sm-2 am-form-label">摘要</label>
                            <div class="am-u-sm-10">
                                 <textarea name="t3" rows="3" cols="50">{$intro}</textarea>
								 <span class="am-margin-left input-tips"><br>长度100个字符</span>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label class="am-u-sm-2 am-form-label">原文链接</label>
                            <div class="am-u-sm-10">
                                <input type="text" name="t4" size="50" value="{$url}">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <div class="am-u-sm-10 am-u-sm-offset-2">
                                <button type="submit" class="am-btn am-btn-primary am-radius">保存素材</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!---->
             </div>
         </div>
        <!---->
    </div>
<script>
$(function(){
    toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$("#t0").keyup(function(){
		var v=$(this).val();
		$('.frist_title_{$cid}').html(v);
	});
	$("#t1").keyup(function(){
		var v=$(this).val();
		if(v=='')
		{
			$('.frist_pic_{$cid}').html('{if $f==1}封面图片{else}缩略图{/if}');
		}
		else
		{
			$('.frist_pic_{$cid}').html('<img src='+v+'>');
		}
	});
	$(".addone").click(function(){
		$.ajax({
			   type:"post",
			   url:"{U('one','classid='.$classid.'')}",
			   success:function(e){
					if(e=="0")
					{
						alert("最多只能添加8条")
					}
					else
					{
						var arr=e.split(":");
						var cid=arr[0];
						var lc=arr[1];
						location.href='{U("add")}{if C('url_mode')==1}&{else}?{/if}classid={$classid}&cid='+cid+'&f=0&lc='+lc+'#last_'+cid+'';
					}
			   }
		})
	});
	$(".choose").click(function(){
		var d=dialog({
			title:'内容选择',
			content:'<iframe id="contentdata" src="{U('choose')}" scrolling="auto" frameborder="0" width="800" height="400"></iframe>',
			ok:function()
			{
				var val=$('#go',document.getElementById('contentdata').contentWindow.document).val();
				if(val.length==0)
				{
					toastr.error('请选择内容');
					return false;
				}
				else
				{
					var s=val.split(":");
					//获取到内容ID后，添加进数据库
					$.ajax({
					   type:"post",
					   url:"{U('two','classid='.$classid.'')}",
					   data:'id='+s[0]+'&m='+s[1],
					   success:function(e){
							if(e=="0")
							{
								alert("最多只能添加8条");
							}
							else if(e=="1")
							{
								alert("内容错误");
							}
							else
							{
								var arr=e.split(":");
								var cid=arr[0];
								var lc=arr[1];
								location.href='{U("add")}{if C('url_mode')==1}&{else}?{/if}classid={$classid}&cid='+cid+'&f=0&lc='+lc+'#last_'+cid+'';
							}
					   }
					})
					d.remove();
					d.close();
				}
				return false;
			},
			okValue:'确定',
		}).showModal();
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
                            setTimeout(function(){location.href='{U('add','classid='.$classid.'')}';},1000);
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

	$(".table_form").css("margin-top","{$lc}px");
	
    $('.am-form').validator({
        timely:2,
        stopOnError:true,
        focusCleanup:true,
        ignore:':hidden',
        theme:'yellow_right_effect',
        valid:function(form)
        {
			UE.getEditor('t2').sync();
			$("#t2").val(UE.getEditor('t2').getContent());
            $.AMUI.progress.inc();
            $.ajax({
                type:'post',
                cache:false,
                dataType:'json',
                url:'{U('edit','id='.$cid.'&classid='.$classid.'')}',
                data:$(form).serialize(),
                error:function(e){alert(e.responseText);},
                success:function(d)
                {
                    $.AMUI.progress.set(1.0);
                    if(d.state=='success')
                    {
                        toastr.success(d.msg);
                        setTimeout(function(){location.href='{U('add','classid='.$classid.'')}';},1500);
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
$(".dropzone").dropzone(
{
	maxFiles: 1,
	acceptedFiles: ".jpg,.gif,.png",
	success:function(file,data,that)
	{
		data=jQuery.parseJSON(data);
        this.removeFile(file);
		if(data.state=="success")
		{
			toastr.success("上传成功");
			$("#"+$(that).attr("config")).val(data.msg);
			$('.frist_pic_{$cid}').html('<img src='+data.msg+'>');
		}
		else
		{
			toastr.error("上传失败："+data.msg);
		}
	},
	sending:function(file){
		$("#progress").css("display","block");
	},
	totaluploadprogress:function(progress){
		progress=Math.round(progress*100)/100;
        $("#progress .am-progress-bar").css("width",progress+"%");
		$("#progress .am-progress-bar").html(progress+"%");
    },
	queuecomplete:function(progress){
		setTimeout(function(){
			$("#progress").css("display","none");
		},1000);
		
	},
	error:function(file,msg)
	{
		toastr.error(msg);
	}
});
</script>
</body>
</html>