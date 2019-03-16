<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>编辑字段</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：系统管理 > <a href="{U('model/index')}">模型管理</a> > <a href="{U('index',"mid=".$mid."")}">{$mtitle}</a> > <a href="{U('index',"mid=".$mid."")}">字段管理</a> > <a href="{THIS_LOCAL}">编辑字段</a></div>
    <div class="border">
        <!---->
        <legend>编辑字段</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段名称</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t0" size="50" value="{$field_title}" placeholder="请输入字段名称" data-rule="字段名称:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段Key</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t1" size="50" value="{$field_key}" disabled="disabled">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段类型</label>
                <div class="am-u-sm-10">
                    <select name="t2" class="w420" data-rule="字段类型:required;" disabled>
                        <option value="">请选择字段类型</option>
                        <option value="1"{if $field_type==1} selected{/if}>普通文本</option>
                        <option value="2"{if $field_type==2} selected{/if}>普通文本-日期</option>
                        <option value="3"{if $field_type==3} selected{/if}>普通文本-整数</option>
                        <option value="4"{if $field_type==4} selected{/if}>普通文本-价格</option>
                        <option value="5"{if $field_type==5} selected{/if}>普通文本-上传</option>
                        <option value="6"{if $field_type==6} selected{/if}>普通文本-密码</option>
                        <option value="7"{if $field_type==7} selected{/if}>普通文本-隐藏域</option>
                        <option value="8"{if $field_type==8} selected{/if}>多行文本框</option>
                        <option value="9"{if $field_type==9} selected{/if}>单选按钮</option>
                        <option value="10"{if $field_type==10} selected{/if}>复选框</option>
                        <option value="11"{if $field_type==11} selected{/if}>下拉列表</option>
                        <option value="12"{if $field_type==12} selected{/if}>编辑器</option>
                        <option value="13"{if $field_type==13} selected{/if}>图集</option>
                        <option value="14"{if $field_type==14} selected{/if}>数据集</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group dis" id="upload_type">
                <label class="am-u-sm-2 am-form-label">上传类型</label>
                <div class="am-u-sm-10">
                    <select name="t3" class="w420" data-rule="上传类型:required;">
                        <option value="">请选择上传类型</option>
                        <option value="1"{if $field_upload_type==1} selected{/if}>只能上传图片</option>
                        <option value="2"{if $field_upload_type==2} selected{/if}>只能上传视频</option>
                        <option value="3"{if $field_upload_type==3} selected{/if}>全部都可以上传</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group dis" id="editor_type">
                <label class="am-u-sm-2 am-form-label">编辑器模式</label>
                <div class="am-u-sm-10">
                    <select name="t4" class="w420" data-rule="编辑器模式:required;">
                        <option value="">请选择编辑器模式</option>
                        <option value="1"{if $field_editor==1} selected{/if}>精简模式</option>
                        <option value="2"{if $field_editor==2} selected{/if}>全功能模式</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group dis" id="listval">
                <label class="am-u-sm-2 am-form-label">候选值</label>
                <div class="am-u-sm-10">
                    <textarea name="t5" rows="5" cols="50" data-rule="候选值:required;">{$field_list}</textarea>
                    <span class="gray"><br>示范：项目名称1|项目值1<br>　　　项目名称2|项目值2</span>
                </div>
            </div>
            <div class="am-form-group dis" id="field_select">
                <label class="am-u-sm-2 am-form-label">作为筛选字段</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t14" id="t14_1" value="1" {if $field_filter==1} checked{/if}><span for="t14_1">是</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t14" id="t14_0" value="0" {if $field_filter==0} checked{/if}><span for="t14_0">否</span>
                    </label>
                </div>
            </div>
            <div class="am-form-group dis" id="field_radio">
                <label class="am-u-sm-2 am-form-label">排列方式</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t6" id="t6_1" value="1" {if $field_radio==1} checked{/if}><span for="t6_1">横排</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t6" id="t6_2" value="2" {if $field_radio==2} checked{/if}><span for="t6_2">竖排</span>
                    </label>
                </div>
            </div>
            <div class="am-form-group field_data dis">
                <label class="am-u-sm-2 am-form-label">数据表</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t15" size="50" value="{$field_table}" data-rule="数据表:required;"><span class="am-margin-left input-tips">示范：sd_content</span>
                </div>
            </div>
            <div class="am-form-group field_data dis">
                <label class="am-u-sm-2 am-form-label">Join参数</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t16" size="50" value="{$field_join}"><span class="am-margin-left input-tips">可以为空，示范：left join sd_content on sd_model_news.cid=sd_content.id</span>
                </div>
            </div>
            <div class="am-form-group field_data dis">
                <label class="am-u-sm-2 am-form-label">Where参数</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t17" size="50" value="{$field_where}"><span class="am-margin-left input-tips">可以为空，示范：islock=1</span>
                </div>
            </div>
            <div class="am-form-group field_data dis">
                <label class="am-u-sm-2 am-form-label">Order参数</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t18" size="50" value="{$field_order}"><span class="am-margin-left input-tips">可以为空，示范：id desc</span>
                </div>
            </div>
            <div class="am-form-group field_data dis">
                <label class="am-u-sm-2 am-form-label">项目值</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t19" size="50" value="{$field_value}" data-rule="项目值:required;"><span class="am-margin-left input-tips">示范：id</span>
                </div>
            </div>
            <div class="am-form-group field_data dis">
                <label class="am-u-sm-2 am-form-label">项目标签</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t20" size="50" value="{$field_label}" data-rule="项目标签:required;"><span class="am-margin-left input-tips">示范：title</span>
                </div>
            </div>
            <div class="am-form-group dis" id="maxlength">
                <label class="am-u-sm-2 am-form-label">最大输入长度</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t7" size="50" value="{$field_length}"><span class="am-margin-left input-tips">0-255，为0时表示不限制</span>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">默认值</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t8" size="50" value="{$field_default}">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">提示文字</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t9" size="50" value="{$field_tips}">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">验证规则</label>
                <div class="am-u-sm-10">
                    <select name="t10" class="w420" >
                        <option value="0"{if $field_rule==0} selected{/if}>不验证</option>
                        <option value="1"{if $field_rule==1} selected{/if}>不能为空</option>
                        <option value="2"{if $field_rule==2} selected{/if}>日期格式</option>
                        <option value="3"{if $field_rule==3} selected{/if}>整数格式</option>
                        <option value="4"{if $field_rule==4} selected{/if}>小数格式</option>
                        <option value="5"{if $field_rule==5} selected{/if}>电话格式</option>
                        <option value="6"{if $field_rule==6} selected{/if}>手机格式</option>
                        <option value="7"{if $field_rule==7} selected{/if}>邮箱</option>
                        <option value="8"{if $field_rule==8} selected{/if}>邮编格式</option>
                        <option value="9"{if $field_rule==9} selected{/if}>QQ号码格式</option>
                        <option value="10"{if $field_rule==10} selected{/if}>网址格式</option>
                        <option value="11"{if $field_rule==11} selected{/if}>用户名</option>
                        <option value="12"{if $field_rule==12} selected{/if}>密码</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">表单分组</label>
                <div class="am-u-sm-10">
                    <select name="t13" class="w420" data-rule="表单分组:required;">
                        <option value="">请选择表单分组</option>
                        {foreach $group as $key}
                        {php $arr=explode("|",$key)}
                        <option value="{$arr[1]}"{if $field_group==$arr[1]} selected{/if}>{$arr[0]}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段排序</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t11" size="50" value="{$ordnum}">
                    <span class="am-margin-left input-tips">数字越小越靠前</span>
                </div>
            </div>
            <div class="am-form-group{if $issys==1} dis{/if}">
                <label class="am-u-sm-2 am-form-label">类型转换</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t21" id="t21_1" value="1" {if $issys==1} checked{/if}><span for="t21_1">系统字段</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t21" id="t21_2" value="0" {if $issys==0} checked{/if}><span for="t21_2">用户字段</span>
                    </label>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">状态</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t12" id="t12_1" value="1" {if $islock==1} checked{/if}><span for="t12_1">正常</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t12" id="t12_2" value="0" {if $islock==0} checked{/if}><span for="t12_2">锁定</span>
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
    {if $field_type==1||$field_type==2||$field_type==3||$field_type==4||$field_type==6||$field_type==7}
    $("#upload_type,#listval,#field_radio,#editor_type,#field_select,.field_data").css("display","none");
    $("#maxlength").css("display","block");
    {elseif $field_type==5}
    $("#listval,#field_radio,#editor_type,#field_select,.field_data").css("display","none");
    $("#upload_type,#maxlength").css("display","block");
    {elseif $field_type==9}
    $("#upload_type,#maxlength,#editor_type,#field_select,.field_data").css("display","none");
    $("#listval,#field_radio").css("display","block");
    {elseif $field_type==10}
    $("#upload_type,#maxlength,#field_radio,#editor_type,#field_select,.field_data").css("display","none");
    $("#listval").css("display","block");
	{elseif $field_type==11}
    $("#upload_type,#maxlength,#field_radio,#editor_type,.field_data").css("display","none");
    $("#listval,#field_select").css("display","block");
    {elseif $field_type==12}
    $("#upload_type,#maxlength,#field_radio,#listval,#field_select,.field_data").css("display","none");
    $("#editor_type").css("display","block");
	{elseif $field_type==14}
	$("#upload_type,#listval,#field_radio,#editor_type,#maxlength").css("display","none");
	$(".field_data,#field_select").css("display","block");
    {else}
    $("#upload_type,#maxlength,#listval,#field_radio,#editor_type,#field_select,.field_data").css("display","none");
    {/if}
    toastr.options={"positionClass":"toast-bottom-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
    $('.am-form').validator({
        timely:2,
        stopOnError:true,
        focusCleanup:true,
        ignore:':hidden',
        theme:'yellow_right_effect',
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
                        setTimeout(function(){location.href='{U("index","mid=".$model_id."")}';},1500);
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