<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{if strlen($seotitle)>0}{$seotitle}_{/if}{$title}_{sdcms[web_name]}</title>
<meta name="keywords" content="{if strlen($seokey)>0}{$seokey}{else}{$title}{/if}">
<meta name="description" content="{if strlen($seodesc)>0}{$seodesc}{else}{$title}{/if}">
<script src="{WEB_ROOT}public/ueditor/ueditor.config.js"></script>
<script src="{WEB_ROOT}public/ueditor/ueditor.all.min.js"></script>
</head>

<body>
	{include file="mobile/head.php"}

    <article>
    	<section>
        	<div class="subject">
                <b>在线提交</b>
            </div>
            <div class="clear"></div>
            <div class="am-padding"></div>
            <form class="am-form am-form-horizontal form-add" method="post">
            {foreach $field as $rs}
            <div class="am-form-group"{if $rs['field_type']==7} style="display:none;"{/if}>
                <label class="am-u-sm-3 am-form-label">{$rs['field_title']}</label>
                <div class="am-u-sm-9">
                    {switch $rs['field_type']}
                        {case 1}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="20"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                        {case 2}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="20"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" data-am-datepicker readonly {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                        {case 3}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="20"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                        {case 4}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="20"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                        {case 5}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="20"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>　<span class="am-btn-group"><input type="button" class="am-btn am-btn-secondary am-radius dropzone" config="{$rs['field_key']}" url="{U('home/upload/upfile','type='.$rs['field_upload_type'].'')}" maxsize="{if $rs['field_upload_type']==1}{C('upload_image_max')}{elseif $rs['field_upload_type']==2}{C('upload_video_max')}{else}{C('upload_file_max')}{/if}" value="上传">{/case}
                        {case 6}<input type="password" name="{$rs['field_key']}" id="{$rs['field_key']}" size="20" value="{deal_default($rs['field_default'])}" {deal_rule($rs['field_rule'],$rs['field_title'])}>{/case}
                        {case 7}<input type="text" name="{$rs['field_key']}" id="{$rs['field_key']}" size="20"{if $rs['field_length']!=0} maxlength="{$rs['field_length']}"{/if} value="{deal_default($rs['field_default'])}">{/case}
                        {case 8}<textarea name="{$rs['field_key']}" id="{$rs['field_key']}" rows="3" cols="22" {deal_rule($rs['field_rule'],$rs['field_title'])}>{deal_default($rs['field_default'])}</textarea>{/case}
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
                        <script>UE.getEditor('{$rs['field_key']}',{serverUrl:'{U('home/upload/index')}'{if $rs['field_editor']==1},toolbars:editorOption{/if}});</script>
                        {/case}
                        {case 13}
                        <span class="am-btn-group"><input type="button" class="am-btn am-btn-secondary dropzone-more" config="{$rs['field_key']}" url="{U('upload/upfile','type=1')}" maxsize="{C('upload_image_max')}" value="上传"></span>
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
                        {if $rs['field_tips']<>''}<span class="am-margin-left input-tips">{$rs['field_tips']}</span>{/if}
                        <span for="{$rs['field_key']}" class="msg-box"></span>
                </div>
            </div>
            {/foreach}
            {if $iscode==1}
            <div class="am-form-group">
                <label class="am-u-sm-3 am-form-label">验证码</label>
                <div class="am-u-sm-9">
                    <input type="text" name="code" id="code" size="10" data-rule="验证码:required;">
                    <span class="am-margin-left input-tips"><img src="{U('code')}" height="40" id="verify" title="点击更换验证码"></span><span for="code" class="msg-box"></span>
                </div>
            </div>
            {/if}
            <div class="am-form-group">
                <div class="am-u-sm-9 am-u-sm-offset-3">
                    <button type="submit" class="am-btn am-btn-primary am-radius">提交</button>
                </div>
            </div>
        </form>
            
        </section>
    </article>
    {include file="mobile/foot.php"}
	<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
	<script src="{WEB_ROOT}public/js/dropzone.js"></script>
	<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
	<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
	<script>
	$(function(){
		$("#verify").click(function(){
			var img=$(this).attr("src");
			if(img.indexOf('?')>0)
			{
				$(this).attr("src",img+'&random='+Math.random());
			}
			else
			{
				$(this).attr("src",img.replace(/\?.*$/,'')+'?'+Math.random());
			}
			$("#code").val("");
		});
		$(document).on("click",".imagelist .img-left",function(){
			var $li=$(this).parent().parent();
			var $pre=$li.prev("li");
			$pre.insertAfter($li)
		})
		$(document).on("click",".imagelist .img-right",function(){
			var $li=$(this).parent().parent();
			var $next=$li.next("li");
			$next.insertBefore($li);
		});
		$(document).on("click",".imagelist .img-del",function(){
			$(this).parent().parent().remove();
		});
		toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
		$('.am-form').validator({
			timely:0,
			stopOnError:true,
			focusCleanup:true,
			ignore:':hidden',
			theme:'yellow_right_effect',
			msgMaker:function(opt){if(opt.type=='error'){toastr.clear();toastr.error(opt.msg);}},
			valid:function(form)
			{
				$.AMUI.progress.inc();
				$.ajax({
					type:'post',
					cache:false,
					dataType:'json',
					url:'{U('add','fid='.$fid.'','',1)}',
					data:$(form).serialize(),
					error:function(e){alert(e.responseText);},
					success:function(d)
					{
						$.AMUI.progress.set(1.0);
						if(d.state=='success')
						{
							toastr.success(d.msg);
							setTimeout(function(){location.href='{if $backway==1}{U('index','fid='.$fid.'','',1)}{else}{U('add','fid='.$fid.'','',1)}{/if}';},1500);
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
		error:function(file,msg)
		{
			toastr.error(msg);
		}
	});
	</script>

</body>
</html>