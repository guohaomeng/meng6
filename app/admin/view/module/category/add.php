<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>添加栏目</title>
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
<script>
$(function(){
	$("#t1").change(function(){
		switch ($(this).val())
		{
			case "-1":
				$("#skins,#seo,#domain").css("display","block");
				$("#listskin,#pagenum").css("display","none");
				$("#cateurl").html("别名");
				break;
			case "-2":
				$("#skins,#seo,#pagenum,#listskin,#domain").css("display","none");
				$("#cateurl").html("链接网址");
				break;
			default:
				$("#skins,#seo,#pagenum,#listskin,#domain").css("display","block");
				$("#cateurl").html("别名");
			break;
		}
		if($('input[name="way"]:checked ').val()==2)
		{
			$("#domain").css("display","none");
		}
	});
	$("#way_1").click(function(){
		$("#alias,#domain").css("display","block");
		$("#catename").html('<input type="text" name="t0" size="50" data-rule="栏目名称:required;">');
		if($('#t1').val()==-2)
		{
			$("#domain").css("display","none");
		}
	});
	$("#way_2").click(function(){
		$("#alias,#domain").css("display","none");
		$("#catename").html('<textarea name="t0" rows="5" cols="50" data-rule="栏目名称:required;"></textarea>                    <span class="gray"><br>示范：栏目名称1<br>　　　栏目名称2</span>');
		
	});
})
</script>
</head>

<body>
	<div class="am-progress am-progress-striped am-active" id="progress"><div class="am-progress-bar am-progress-bar-success" style="width:0%"></div></div>
    <div class="position">当前位置：<a href="{U('index')}">栏目管理</a>{$position} > <a href="{THIS_LOCAL}">添加栏目</a></div>
    <div class="border">
        <!---->
        <form class="am-form am-form-horizontal" method="post">
        <div class="am-tabs" data-am-tabs="{noSwipe: 1}">
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                <li class="am-active"><a href="javascript:void(0)">基本设置</a></li>
                <li id="seo"><a href="javascript:void(0)">SEO设置</a></li>
                <li id="skins"><a href="javascript:void(0)">模板设置</a></li>
                <li id="extend"><a href="javascript:void(0)">栏目扩展</a></li>
            </ul>
            
            <div class="am-tabs-bd am-tabs-bd-ofv">
                
                <div class="am-tab-panel am-active">
                    <!--aaa-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">添加方式</label>
                        <div class="am-u-sm-10">
                            <label class="am-radio-inline">
                                <input type="radio" name="way" id="way_1" value="1" checked><span for="way_1">单个添加</span>
                            </label>
                            <label class="am-radio-inline">
                                <input type="radio" name="way" id="way_2" value="2"><span for="way_2">批量添加</span>
                            </label>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">栏目名称</label>
                        <div class="am-u-sm-10" id="catename">
                            <input type="text" name="t0" size="50" data-rule="栏目名称:required;">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">栏目类型</label>
                        <div class="am-u-sm-10">
                            <select class="w420" name="t1" id="t1" data-rule="栏目类型:required;">
                                <option value="">请选择栏目类型</option>
                                <option value="-1">单页</option>
                                <option value="-2">外链</option>
                                {sdcms:rs top="0" table="sd_model" where="islock=1" order="ordnum,id"}
                                <option value="{$rs[id]}">{$rs[title]}</option>
                                {/sdcms:rs}
                            </select>
                        </div>
                    </div>
                    <div class="am-form-group" id="alias">
                        <label class="am-u-sm-2 am-form-label" id="cateurl">别名</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t2" size="50">
                        </div>
                    </div>
                    <div class="am-form-group" id="domain">
                        <label class="am-u-sm-2 am-form-label">绑定域名</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t14" size="50" ><span class="am-margin-left input-tips">例：news.sdcms.cn{if $isbiz==0}，域名未授权，本功能无法使用。{/if}</span>
                        </div>
                    </div>
                    <div class="am-form-group" id="pagenum">
                        <label class="am-u-sm-2 am-form-label">分页数量</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t3" size="50" value="20">
                            <span class="am-margin-left input-tips">每页显示的数量</span>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">排序</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t4" size="50" value="0">
                            <span class="am-margin-left input-tips">数字越小越靠前</span>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">属性设置</label>
                        <div class="am-u-sm-10">
                            <label class="am-checkbox-inline">
                                <input type="checkbox" name="t5[]" id="t5" value="1" checked><span for="t5">导航显示</span>
                            </label>
                            <label class="am-checkbox-inline">
                                <input type="checkbox" name="t12[]" id="t12" value="1"><span for="t12">新窗口</span>
                            </label>
                            <label class="am-checkbox-inline">
                                <input type="checkbox" name="t13[]" id="t13" value="1"><span for="t13">列表筛选</span>
                            </label>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">内容扩展</label>
                        <div class="am-u-sm-10">
                            <select class="w420" name="t11">
                                <option value="0">请选择内容扩展</option>
                                {sdcms:rs top="0" table="sd_extend" where="islock=1" order="ordnum,id"}
                                <option value="{$rs[id]}">{$rs[title]}</option>
                                {/sdcms:rs}
                            </select>
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">阅读权限</label>
                        <div class="am-u-sm-10">
                            {sdcms:rs top="0" table="sd_user_group" order="ordnum,gid"}
                            <label class="am-checkbox-inline">
                                <input type="checkbox" name="t15[]" id="t15_{$rs[gid]}" value="{$rs[gid]}"><span for="t15_{$rs[gid]}">{$rs[gname]}</span>
                            </label>
                            {/sdcms:rs}
                        </div>
                    </div>
                    <!--aaa-->
                </div>
                <div class="am-tab-panel">
                    <!--bbb-->
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">优化标题</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t6" size="50">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">关键字</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t7" size="50">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">描述</label>
                        <div class="am-u-sm-10">
                            <textarea name="t8" rows="5" cols="50"></textarea>
                        </div>
                    </div>
                    <!--bbb-->
                </div>
                <div class="am-tab-panel">
                    <!--ccc-->
                    <div class="am-form-group" id="listskin">
                        <label class="am-u-sm-2 am-form-label">列表模板</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t9" id="t9" size="50">　<input type="button" class="am-btn am-btn-secondary template" data-name="t9" data-url="{U('theme/template')}" value="选择">
                        </div>
                    </div>
                    <div class="am-form-group" id="showskin">
                        <label class="am-u-sm-2 am-form-label">内容模板</label>
                        <div class="am-u-sm-10">
                            <input type="text" name="t10" id="t10" size="50">　<input type="button" class="am-btn am-btn-secondary template" data-name="t10" data-url="{U('theme/template')}" value="选择">
                        </div>
                    </div>
                    <!--ccc-->
                </div>
                <div class="am-tab-panel">
                    <!--ddd-->
                    {foreach $field as $rs}
                    <div class="am-form-group" {if $rs['field_type']==7} style="display:none;"{/if}>
                        <label class="am-u-sm-2 am-form-label">{$rs['field_title']}</label>
                        <div class="am-u-sm-10">
                            {switch $rs['field_type']}
                                {case 1}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                                {case 2}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" data-am-datepicker readonly {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                                {case 3}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                                {case 4}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                                {case 5}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>　<span class="am-btn-group"><button type="button" class="am-btn am-btn-secondary am-radius dropzone" config="{$rs['field_key']}" url="{U('upload/upfile','type='.$rs['field_upload_type'].'')}" maxsize="{if $rs['field_upload_type']==1}{C('upload_image_max')}{elseif $rs['field_upload_type']==2}{C('upload_video_max')}{else}{C('upload_file_max')}{/if}" title="上传">上传</button><button type="button" class="am-btn am-btn-primary am-radius fm-choose" data-name="{$rs['field_key']}" data-url="{U('upload/imagelist','type='.$rs['field_upload_type'].'&multiple=0')}" data-type="{$rs['field_upload_type']}" data-multiple="0" title="选择">选择</button><button type="button" class="am-btn am-btn-secondary am-radius pic-preview" data-name="{$rs['field_key']}" title="预览">预览</button></span>{/case}
                                {case 6}<input type="password" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50" value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                                {case 7}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}">{/case}
                                {case 8}<textarea name="{$rs['field_key']}" id="{$rs['field_key']}" rows="3" cols="50" {deal_rule($rs['field_rule'],$rs['field_title'])}>{deal_default($rs['field_default'])}</textarea>{/case}
                                {case 9}
                                {php $arr=explode(",",$rs['field_list'])}
                                {foreach $arr as $j=>$key}
                                {php $data=explode("|",$key)}
                                {if $rs['field_radio']==1}<label class="am-radio-inline">{else}<div class="am-radio">{/if}
                                    <input type="radio" name="{$rs['field_key']}" id="{$rs['field_key']}_{$j}" value="{$data[1]}"{if $j==0} {deal_rule($rs['field_rule'],$rs['field_title'])}{/if} {if $rs['field_default']=="".$data[1].""} checked{/if}>
                                    {if $rs['field_radio']==1}<span for="{$rs['field_key']}_{$j}">{$data[0]}</span>{else}<label for="{$rs['field_key']}_{$j}">{$data[0]}</label>{/if}
                                    {if $rs['field_radio']==1}</label>{else}</div>{/if}
                                {/foreach}
                                {/case}
                                {case 10}
                                {php $arr=explode(",",$rs['field_list'])}
                                {foreach $arr as $j=>$key}
                                {php $data=explode("|",$key)}
                                <label class="am-checkbox-inline">
                                    <input type="checkbox" name="{$rs['field_key']}[]" id="{$rs['field_key']}_{$j}" value="{$data[1]}" {if $j==0} {deal_rule($rs['field_rule'],$rs['field_title'])}{/if} {if stristr(",".$rs['field_default'].",",",".$data[1].",")} checked{/if}><span for="{$rs['field_key']}_{$j}">{$data[0]}</span>
                                </label>
                                {/foreach}
                                {/case}
                                {case 11}
                                <select name="{$rs['field_key']}" id="{$rs['field_key']}" class="w420" {deal_rule($rs['field_rule'],$rs['field_title'])}>
                                {php $arr=explode(",",$rs['field_list'])}
                                {foreach $arr as $j=>$key}
                                {php $data=explode("|",$key)}
                                <option value="{$data[1]}" {if $rs['field_default']=="".$data[1].""} selected{/if}>{$data[0]}</option>
                                {/foreach}
                                </select>
                                {/case}
                                {case 12}<script id="{$rs['field_key']}" name="{$rs['field_key']}" type="text/plain" style="height:260px;"></script>
                                <script>UE.getEditor('{$rs['field_key']}',{serverUrl:'{U('upload/index')}'{if $rs['field_editor']==1},toolbars:editorOption{/if}});</script>
                                {/case}
                            {/switch}
                            {if $rs['field_tips']<>''}<span class="am-margin-left input-tips">{$rs['field_tips']}</span>{/if}
                            <span for="{$rs['field_key']}" class="msg-box"></span>
                        </div>
                    </div>
                    {/foreach}
                    <!--ddd-->
                </div>
                                
            </div>
        </div>
        <div class="am-form-group am-margin-top">
            <button type="submit" class="am-btn am-btn-primary am-radius">保存</button>
            <button type="button" class="am-btn am-radius am-back">返回</button>
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
			{foreach $editor as $key=>$val}
			UE.getEditor('{$val}').sync();
			$("#{$val}").val(UE.getEditor('{$val}').getContent());
			{/foreach}
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
                        setTimeout(function(){location.href='{U("index","fid=".$fid."")}';},1500);
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
	maxFiles:1,
	success:function(file,data,that)
	{
		data=jQuery.parseJSON(data);
        this.removeFile(file);
		if(data.state=="success")
		{
			toastr.success("上传成功");
			$("#"+$(that).attr("config")).val(data.msg);
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