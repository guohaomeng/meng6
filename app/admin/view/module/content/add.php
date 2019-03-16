<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>添加内容</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<link rel="stylesheet" href="{WEB_ROOT}public/date/amazeui.datetimepicker-se.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.tagsinput.css">
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
<script src="{WEB_ROOT}public/js/amazeui.tagsinput.min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
	
	<div class="am-progress am-progress-striped am-active" id="progress"><div class="am-progress-bar am-progress-bar-success" style="width:0%"></div></div>
    <div class="position">当前位置：<a href="{U('lists')}">内容管理</a>{get_content_postion($classid)} > <a href="{U('add','classid='.$classid.'')}">添加内容</a></div>
    <div class="border">
        <!---->
        <form class="am-form am-form-horizontal" method="post">
        <div class="am-tabs" data-am-tabs="{noSwipe: 1}">
            <ul class="am-tabs-nav am-nav am-nav-tabs">
            	{foreach $group as $index=>$key}
                {php $arr=explode("|",$key)}
                <li{if $index==0} class="am-active"{/if}><a href="javascript:void(0)">{$arr[0]}</a></li>
                {/foreach}
                {if count($edata)>0}
                <li><a href="javascript:void(0)">内容扩展</a></li>{/if}
            </ul>
            
            <div class="am-tabs-bd am-tabs-bd-ofv">
                
                {foreach $group as $index=>$key}
                {php list(,$num)=explode("|",$key)}
                <div class="am-tab-panel{if $index==0} am-active{/if}">
                    <!--aaa-->
                    {if $index==0}
                    <div class="am-form-group{if C('content_subid')==0} dis{/if}">
                        <label class="am-u-sm-2 am-form-label">发布到其他栏目</label>
                        <div class="am-u-sm-10">
                            <select name="subid[]" multiple data-am-selected>
                            {php $cate=C('category')}
                            {foreach $cate as $jc=>$rs}
                                {if get_admin_info('pid')!=0}
                                    {php $lever=explode(',',CATE_LEVER)}
                                    {if in_array($jc,$lever)}
                                        <option value="{$rs['cateid']}"{if $rs['catetype']<0||strpos($rs['sonid'],',')||$rs['cateid']==$classid} disabled{/if}>{str_repeat("　",$rs['depth'])}{$rs['catename']}</option>
                                    {/if}
                                {else}
                                    <option value="{$rs['cateid']}"{if $rs['catetype']<0||strpos($rs['sonid'],',')||$rs['cateid']==$classid} disabled{/if}>{str_repeat("　",$rs['depth'])}{$rs['catename']}</option>
                                {/if}
                            {/foreach}
                            </select>
                            {if $isbiz==0}<span class="am-margin-left input-tips">域名未授权，本功能无法使用。</span>{/if}
                        </div>
                    </div>
                    {/if}
                    {if isset($field[$num])}
                    {foreach $field[$num] as $rs}
                    {if $rs['field_key']=='createdate'}
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">定时发布</label>
                        <div class="am-u-sm-10">
                            <label class="am-radio-inline"><input type="radio" name="isauto" id="isauto_0" value="0"   checked><span for="isauto_0">否</span></label>
                            <label class="am-radio-inline"><input type="radio" name="isauto" id="isauto_1" value="1" ><span for="isauto_1">是</span></label>                                                        							
                            <span for="isauto" class="msg-box"></span>
                        </div>
                    </div>
                    {/if}
                    <div class="am-form-group"{if $rs['field_type']==7} style="display:none;"{/if}>
                        <label class="am-u-sm-2 am-form-label">{$rs['field_title']}</label>
                        <div class="am-u-sm-10">
                            {switch $rs['field_type']}
                            {case 1}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{if $rs['field_key']=='url'}　<span class="am-btn-group"><button type="button" class="am-btn am-btn-secondary dropzone" config="{$rs['field_key']}" url="{U('upload/upfile','type=3')}" maxsize="{C('upload_file_max')}" title="上传">上传</button><button type="button" class="am-btn am-btn-primary am-radius fm-choose" data-name="{$rs['field_key']}" data-url="{U('upload/imagelist','type=3&multiple=0')}" data-type="3" data-multiple="0" title="选择">选择</button></span>{/if}{if $rs['field_key']=='tags'}　<span class="am-btn-group"><button type="button" class="am-btn am-btn-primary am-radius fm-tags" data-name="{$rs['field_key']}" data-url="{U('taglist')}" title="选择">选择</button></span>{/if}{/case}
                            {case 2}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" class="my-datetimepicker-se" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                            {case 3}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                            {case 4}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                            {case 5}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>　<span class="am-btn-group"><button type="button" class="am-btn am-btn-secondary am-radius dropzone" config="{$rs['field_key']}" url="{U('upload/upfile','type='.$rs['field_upload_type'].'')}" maxsize="{if $rs['field_upload_type']==1}{C('upload_image_max')}{elseif $rs['field_upload_type']==2}{C('upload_video_max')}{else}{C('upload_file_max')}{/if}" title="上传">上传</button><button type="button" class="am-btn am-btn-primary am-radius fm-choose" data-name="{$rs['field_key']}" data-url="{U('upload/imagelist','type='.$rs['field_upload_type'].'&multiple=0')}" data-type="{$rs['field_upload_type']}" data-multiple="0" title="选择">选择</button><button type="button" class="am-btn am-btn-secondary am-radius pic-preview" data-name="{$rs['field_key']}" title="预览">预览</button></span>{/case}
                            {case 6}<input type="password" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
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
                            <option value="">请选择{$rs['field_title']}</option>
                            {php $arr=explode(",",$rs['field_list'])}
                            {foreach $arr as $j=>$key}
                            {php $data=explode("|",$key)}
                            <option value="{$data[1]}" {if $rs['field_default']=="".$data[1].""} selected{/if}>{$data[0]}</option>
                            {/foreach}
                            </select>
                            {/case}
                            {case 12}<script id="{$rs['field_key']}" name="{$rs['field_key']}" type="text/plain" style="height:260px;"></script>
                            <script>UE.getEditor('{$rs['field_key']}',{serverUrl:'{U('upload/index')}'{if $rs['field_editor']==1},toolbars:editorOption{/if}});</script>
							<input type="button" class="am-btn am-btn-secondary am-btn-sm editor_savepic" data-url="{U('upload/outimage')}" data-name="{$rs['field_key']}" value="保存编辑器中外部图片">
                            {if $rs['field_key']=='content'}<input type="checkbox" name="savepic" id="savepic" value="1"><label for="savepic" style="font-weight:normal;">提取正文中第1张图片为缩略图</label>{/if}
                            {/case}
							{case 13}
							<span class="am-btn-group"><button type="button" class="am-btn am-btn-secondary dropzone-more" config="{$rs['field_key']}" url="{U('upload/upfile','type=1&thumb=1&water='.C('water_piclist').'')}" maxsize="{C('upload_image_max')}" title="上传">上传</button><button type="button" class="am-btn am-btn-primary am-radius fm-choose" data-name="{$rs['field_key']}" data-url="{U('upload/imagelist','type=1&multiple=1')}" data-type="{$rs['field_upload_type']}" data-multiple="1" title="选择">选择</button></span>
							<div class="imagelist">
								<ul id="list_{$rs['field_key']}">
								</ul>
								<div class="am-cf"></div>
							</div>
							{/case}
							{case 14}
                            <select name="{$rs['field_key']}" id="{$rs['field_key']}" class="w420" {deal_rule($rs['field_rule'],$rs['field_title'])}>
                            {php $table=$rs['field_table']}
							{php $join=$rs['field_join']}
							{php $where=$rs['field_where']}
							{php $order=$rs['field_order']}
							{php $value=$rs['field_value']}
							{php $label=$rs['field_label']}
							{php $default=$rs['field_default']}
							{if $where==''}
							{php $where='1=1'}
							{/if}
							{if $order==''}
							{php $order="$value desc"}
							{/if}
							<option value="">请选择{$rs['field_title']}</option>
							{sdcms:ra top="0" table="$table" join="$join" where="$where" order="$order"}
                            <option value="{$ra['.$value.']}"{if $default==$ra['.$value.']} selected{/if}>{$ra['.$label.']}</option>
							{/sdcms:ra}
                            </select>
							{/case}
                            {/switch}
							{if $rs['field_key']=='showskin'}　<button type="button" class="am-btn am-btn-secondary template" data-name="{$rs['field_key']}" data-url="{U('theme/template')}" title="选择">选择</button>{/if}
                            {if $rs['field_tips']<>''}<span class="am-margin-left input-tips">{$rs['field_tips']}</span>{/if}
                            <span for="{$rs['field_key']}" class="msg-box"></span>
                        </div>
                    </div>
                    {/foreach}
                    {if $index==0}
                    <div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">阅读权限</label>
                        <div class="am-u-sm-10">
                            {sdcms:rs top="0" table="sd_user_group" order="ordnum,gid"}
                            <label class="am-checkbox-inline">
                                <input type="checkbox" name="view_lever[]" id="view_lever_{$rs[gid]}" value="{$rs[gid]}"><span for="view_lever_{$rs[gid]}">{$rs[gname]}</span>
                            </label>
                            {/sdcms:rs}
                        </div>
                    </div>
                    {/if}
                    {/if}
                    <!--aaa-->
                </div>
                {/foreach}
				{if count($edata)>0}
                <div class="am-tab-panel">
					{foreach $edata as $rs}
					<div class="am-form-group">
                        <label class="am-u-sm-2 am-form-label">{$rs['field_title']}</label>
                        <div class="am-u-sm-10">
							{switch $rs['field_type']}
                            {case 1}<input type="text" name="extend[{$rs['field_key']}]" id="{$rs['field_key']}" size="50" value="{deal_default($rs['field_default'])}" >{/case}
                            {case 2}
                            <select name="extend[{$rs['field_key']}]" id="{$rs['field_key']}" class="w420">
                            <option value="">请选择{$rs['field_title']}</option>
                            {php $arr=explode(",",$rs['field_list'])}
                            {foreach $arr as $j=>$key}
                            <option value="{$key}" {if $rs['field_default']=="".$key.""} selected{/if}>{$key}</option>
                            {/foreach}
                            </select>
                            {/case}
							{/switch}
						</div>
					</div>
					{/foreach}
				</div>
				{/if}
            </div>
        </div>
        <div class="am-form-group am-margin-top">
            <button type="submit" class="am-btn am-btn-primary am-radius">保存</button>
            <button type="button" class="am-btn am-radius am-back">返回</button>
        </div>
        </form>
        <!---->
    </div>
<script src="{WEB_ROOT}public/date/moment-with-locales.min.js"></script>
<script src="{WEB_ROOT}public/date/amazeui.datetimepicker-se.min.js"></script>
<script>
$(function(){
	$('.my-datetimepicker-se').datetimepicker();
	$('#tags').tagsinput({maxTags:5,maxChars:10,trimValue:true});
    toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
    $('.am-form').validator({
        timely:2,
        stopOnError:true,
        focusCleanup:true,
        ignore:':hidden',
        theme:'yellow_right_effect',
		//msgMaker:function(opt){if(opt.type=='error'){toastr.clear();toastr.error(opt.msg);}},
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
                        setTimeout(function(){location.href='{U('lists','classid='.$classid.'')}';},1500);
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
$(".dropzone-more").dropzone(
{
	maxFiles:50,
	success:function(file,data,that)
	{
		data=jQuery.parseJSON(data);
        this.removeFile(file);
		if(data.state=="success")
		{
			var name=$(that).attr("config");
			var num=1;
			$("#list_"+name+" li").each(function()
			{
				var max=parseInt($(this).attr("num"));
				if (max>=num)
				{
					num=max+1;
				}
			});
			var html='';
			html+='<li num="'+num+'">';
			html+='	<div class="preview">';
			html+='		<input type="hidden" name="'+name+'['+num+'][image]" value="'+data.msg+'">';
			html+='		<img src="'+data.msg+'" />';
			html+='	</div>';
			html+='	<div class="intro">';
			html+='		<textarea name="'+name+'['+num+'][desc]" placeholder="图片描述..."></textarea>';
			html+='	</div>';
			html+='	<div class="action"><a href="javascript:;" class="img-left"><i class="am-icon-angle-double-left am-icon-fw"></i>左移</a><a href="javascript:;" class="img-right"><i class="am-icon-angle-double-right am-icon-fw"></i>右移</a><a href="javascript:;" class="img-del"><i class="am-icon-close am-icon-fw"></i>删除</a></div>';
			html+='</li>';
			$("#list_"+name).append(html);
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