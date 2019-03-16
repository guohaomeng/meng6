<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>编辑{$title}</title>
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
    <div class="position">当前位置：系统管理 > <a href="{U('form/index')}">表单管理</a> > <a href="{U('index',"fid=".$fid."")}">{$title}管理</a> > <a href="{THIS_LOCAL}">编辑{$title}</a></div>
    <div class="border">
        <!---->
        <legend>编辑{$title}</legend>
        <form class="am-form am-form-horizontal" method="post">
            {foreach $field as $rs}
            <div class="am-form-group"{if $rs['field_type']==7} style="display:none;"{/if}>
                <label class="am-u-sm-2 am-form-label">{$rs['field_title']}</label>
                <div class="am-u-sm-10">
                    {switch $rs['field_type']}
                        {case 1}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{$record[$rs['field_key']]}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                        {case 2}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{date('Y-m-d',$record[$rs['field_key']])}" data-am-datepicker readonly {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                        {case 3}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{$record[$rs['field_key']]}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                        {case 4}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{$record[$rs['field_key']]}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                        {case 5}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="50"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{$record[$rs['field_key']]}" {deal_rule($rs['field_rule'],$rs['field_title'])}>　<span class="am-btn-group"><button type="button" class="am-btn am-btn-secondary am-radius dropzone" config="{$rs['field_key']}" url="{U('upload/upfile','type='.$rs['field_upload_type'].'')}" maxsize="{if $rs['field_upload_type']==1}{C('upload_image_max')}{elseif $rs['field_upload_type']==2}{C('upload_video_max')}{else}{C('upload_file_max')}{/if}" title="上传">上传</button><button type="button" class="am-btn am-btn-primary am-radius fm-choose" data-name="{$rs['field_key']}" data-url="{U('upload/imagelist','type='.$rs['field_upload_type'].'&multiple=0')}" data-type="{$rs['field_upload_type']}" data-multiple="0" title="选择">选择</button><button type="button" class="am-btn am-btn-secondary am-radius pic-preview" data-name="{$rs['field_key']}" title="预览">预览</button></span>{/case}
                        {case 6}<input type="password" name="{$rs['field_key']}" id="{$rs['field_key']}"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} size="50" value="{$record[$rs['field_key']]}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                        {case 7}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} size="50" value="{$record[$rs['field_key']]}">{/case}
                        {case 8}<textarea name="{$rs['field_key']}" id="{$rs['field_key']}" rows="3" cols="50" {deal_rule($rs['field_rule'],$rs['field_title'])}>{$record[$rs['field_key']]}</textarea>{/case}
                        {case 9}
                        {php $arr=explode(",",$rs['field_list'])}
                        {foreach $arr as $j=>$key}
                        {php $data=explode("|",$key)}
                        {if $rs['field_radio']==1}<label class="am-radio-inline">{else}<div class="am-radio">{/if}
                            <input type="radio" name="{$rs['field_key']}" id="{$rs['field_key']}_{$j}" value="{$data[1]}"{if $j==0} {deal_rule($rs['field_rule'],$rs['field_title'])}{/if} {if $record[$rs['field_key']]=="".$data[1].""} checked{/if}>
                            {if $rs['field_radio']==1}<span for="{$rs['field_key']}_{$j}">{$data[0]}</span>{else}<label for="{$rs['field_key']}_{$j}">{$data[0]}</label>{/if}
                            {if $rs['field_radio']==1}</label>{else}</div>{/if}
                        {/foreach}
                        {/case}
                        {case 10}
                        {php $arr=explode(",",$rs['field_list'])}
                        {foreach $arr as $j=>$key}
                        {php $data=explode("|",$key)}
                        <label class="am-checkbox-inline">
                            <input type="checkbox" name="{$rs['field_key']}[]" id="{$rs['field_key']}_{$j}" value="{$data[1]}" {if $j==0} {deal_rule($rs['field_rule'],$rs['field_title'])}{/if} {if stristr(",".$record[$rs['field_key']].",",",".$data[1].",")} checked{/if}><span for="{$rs['field_key']}_{$j}">{$data[0]}</span>
                        </label>
                        {/foreach}
                        {/case}
                        {case 11}
                        <select name="{$rs['field_key']}" id="{$rs['field_key']}" class="w420" {deal_rule($rs['field_rule'],$rs['field_title'])}>
                        <option value="">请选择{$rs['field_title']}</option>
                        {php $arr=explode(",",$rs['field_list'])}
                        {foreach $arr as $j=>$key}
                        {php $data=explode("|",$key)}
                        <option value="{$data[1]}" {if $record[$rs['field_key']]=="".$data[1].""} selected{/if}>{$data[0]}</option>
                        {/foreach}
                        </select>
                        {/case}
                        {case 12}<script id="{$rs['field_key']}" name="{$rs['field_key']}" type="text/plain" style="height:260px;">{$record[$rs['field_key']]}</script>
                        <script>UE.getEditor('{$rs['field_key']}',{serverUrl:'{U('upload/index')}'{if $rs['field_editor']==1},toolbars:editorOption{/if}});</script>
                        {/case}
                        {case 13}
                        {php $data=str_replace(PHP_EOL,'\n',$record[$rs['field_key']])}
                        {php $data=json_decode($data,true)}
                        <span class="am-btn-group"><button type="button" class="am-btn am-btn-secondary dropzone-more" config="{$rs['field_key']}" url="{U('upload/upfile','type=1&thumb=1&water='.C('water_piclist').'')}" maxsize="{C('upload_image_max')}" title="上传">上传</button><button type="button" class="am-btn am-btn-primary am-radius fm-choose" data-name="{$rs['field_key']}" data-url="{U('upload/imagelist','type=1&multiple=1')}" data-type="{$rs['field_upload_type']}" data-multiple="1" title="选择">选择</button></span>
                        <div class="imagelist">
                            <ul id="list_{$rs['field_key']}">
                                {if is_array($data)}
                                {foreach $data as $num=>$val}
                                <li num="{$num}">
                                    <div class="preview">
                                        <input type="hidden" name="{$rs['field_key']}[{$num}][image]" value="{$val['image']}">
                                        <img src="{$val['image']}" />
                                    </div>
                                    <div class="intro">
                                        <textarea name="{$rs['field_key']}[{$num}][desc]" placeholder="图片描述...">{deal_strip($val['desc'])}</textarea>
                                    </div>
                                    <div class="action"><a href="javascript:;" class="img-left"><i class="am-icon-angle-double-left am-icon-fw"></i>左移</a><a href="javascript:;" class="img-right"><i class="am-icon-angle-double-right am-icon-fw"></i>右移</a><a href="javascript:;" class="img-del"><i class="am-icon-close am-icon-fw"></i>删除</a></div>
                                </li>
                                {/foreach}
                                {/if}
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
						{php $default=$record[$rs['field_key']]}
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
                        {if $rs['field_tips']<>''}<span class="am-margin-left input-tips">{$rs['field_tips']}</span>{/if}
                        <span for="{$rs['field_key']}" class="msg-box"></span>
                </div>
            </div>
            {/foreach}
            
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段排序</label>
                <div class="am-u-sm-10">
                    <input type="text" name="ordnum" size="50" value="{$ordnum}">
                    <span class="am-margin-left input-tips">数字越大越靠前</span>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">状态</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="islock" id="islock_1" value="1"{if $islock==1} checked{/if}><span for="islock_1">已审</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="islock" id="islock_2" value="0"{if $islock==0} checked{/if}><span for="islock_2">未审</span>
                    </label>
                </div>
            </div>
            <div class="am-form-group">
                <div class="am-u-sm-10 am-u-sm-offset-2">
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
                        setTimeout(function(){location.href='{U('index','fid='.$fid.'')}';},1500);
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