<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>添加字段</title>
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
    <div class="position">当前位置：系统管理 > <a href="{U('index')}">栏目扩展</a> > <a href="{THIS_LOCAL}">添加字段</a></div>
    <div class="border">
        <!---->
        <legend>添加字段</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段名称</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t0" size="50" placeholder="请输入字段名称" data-rule="字段名称:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段Key</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t1" size="50" placeholder="字母和数字的组合，长度3-50个字符" data-rule="字段Key:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段类型</label>
                <div class="am-u-sm-10">
                    <select name="t2" id="t2" class="w420" data-rule="字段类型:required;">
                        <option value="">请选择字段类型</option>
                        <option value="1">普通文本</option>
                        <option value="2">普通文本-日期</option>
                        <option value="3">普通文本-整数</option>
                        <option value="4">普通文本-价格</option>
                        <option value="5">普通文本-上传</option>
                        <option value="6">普通文本-密码</option>
                        <option value="7">普通文本-隐藏域</option>
                        <option value="8">多行文本框</option>
                        <option value="9">单选按钮</option>
                        <option value="10">复选框</option>
                        <option value="11">下拉列表</option>
                        <option value="12">编辑器</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段定义</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t13" id="t13" size="50" data-rule="字段定义:required;">
                    <select id="t15">
                        <option value="">可选参数</option>
                        <option value="varchar(255) NOT NULL">varchar(255) NOT NULL</option>
                        <option value="int(10) NOT NULL">int(10) NOT NULL</option>
                        <option value="decimal(10,2) NOT NULL">decimal(10,2) NOT NULL</option>
                        <option value="text NOT NULL">text NOT NULL</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group dis" id="upload_type">
                <label class="am-u-sm-2 am-form-label">上传类型</label>
                <div class="am-u-sm-10">
                    <select name="t3" class="w420" data-rule="上传类型:required;">
                        <option value="">请选择上传类型</option>
                        <option value="1">只能上传图片</option>
                        <option value="2">只能上传视频</option>
                        <option value="3">全部都可以上传</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group dis" id="editor_type">
                <label class="am-u-sm-2 am-form-label">编辑器模式</label>
                <div class="am-u-sm-10">
                    <select name="t4" class="w420" data-rule="编辑器模式:required;">
                        <option value="">请选择编辑器模式</option>
                        <option value="1">精简模式</option>
                        <option value="2">全功能模式</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group dis" id="listval">
                <label class="am-u-sm-2 am-form-label">候选值</label>
                <div class="am-u-sm-10">
                    <textarea name="t5" rows="5" cols="50" data-rule="候选值:required;"></textarea>
                    <span class="gray"><br>示范：项目名称1|项目值1<br>　　　项目名称2|项目值2</span>
                </div>
            </div>
             <div class="am-form-group dis" id="field_radio">
                <label class="am-u-sm-2 am-form-label">排列方式</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t6" id="t6_1" value="1" checked><span for="t6_1">横排</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t6" id="t6_2" value="2"><span for="t6_2">竖排</span>
                    </label>
                </div>
            </div>
            <div class="am-form-group dis" id="maxlength">
                <label class="am-u-sm-2 am-form-label">最大输入长度</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t7" size="50" value="0"><span class="am-margin-left input-tips">0-255，为0时表示不限制</span>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">默认值</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t8" size="50">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">提示文字</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t9" size="50">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">验证规则</label>
                <div class="am-u-sm-10">
                    <select name="t10" class="w420" >
                        <option value="0">不验证</option>
                        <option value="1">不能为空</option>
                        <option value="2">日期格式</option>
                        <option value="3">整数格式</option>
                        <option value="4">小数格式</option>
                        <option value="5">电话格式</option>
                        <option value="6">手机格式</option>
                        <option value="7">邮箱</option>
                        <option value="8">邮编格式</option>
                        <option value="9">QQ号码格式</option>
                        <option value="10">网址格式</option>
                        <option value="11">用户名</option>
                        <option value="12">密码</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段排序</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t11" size="50" value="0">
                    <span class="am-margin-left input-tips">数字越小越靠前</span>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">状态</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t12" id="t12_1" value="1" checked><span for="t12_1">正常</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t12" id="t12_2" value="0"><span for="t12_2">锁定</span>
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
    $("#t2").change(function(){
        switch ($(this).val())
        {
            case "1":
            case "6":
            case "7":
                $("#upload_type,#listval,#field_radio,#editor_type").css("display","none");
                $("#maxlength").css("display","block");
                $("#t13").val("varchar(255) NOT NULL");
                break;
            case "2":
            case "3":
                $("#upload_type,#listval,#field_radio,#editor_type").css("display","none");
                $("#maxlength").css("display","block");
                $("#t13").val("int(10) NOT NULL");
                break;
            case "4":
                $("#upload_type,#listval,#field_radio,#editor_type").css("display","none");
                $("#maxlength").css("display","block");
                $("#t13").val("decimal(10,2) NOT NULL");
                break;
            case "5":
                $("#listval,#field_radio,#editor_type").css("display","none");
                $("#upload_type,#maxlength").css("display","block");
                $("#t13").val("varchar(255) NOT NULL");
                break;
            case "8":
			case "13":
                $("#upload_type,#maxlength,#listval,#field_radio,#editor_type").css("display","none");
                $("#t13").val("text NOT NULL");
                break;
            case "9":
                $("#upload_type,#maxlength,#editor_type").css("display","none");
                $("#listval,#field_radio").css("display","block");
                $("#t13").val("varchar(255) NOT NULL");
                break;
            case "10":
            case "11":
                $("#upload_type,#maxlength,#field_radio,#editor_type").css("display","none");
                $("#listval").css("display","block");
                $("#t13").val("varchar(255) NOT NULL");
                break;
            case "12":
                $("#upload_type,#maxlength,#field_radio,#listval").css("display","none");
                $("#editor_type").css("display","block");
                $("#t13").val("text NOT NULL");
                break;
            default:
                $("#upload_type,#maxlength,#listval,#field_radio,#editor_type").css("display","none");
                $("#t13").val("");
                break;
        }
    });
    $("#t15").change(function(){
		if($(this).val()!='')
		{
			$("#t13").val($(this).val());
		} 
    })
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