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
    <div class="position">当前位置：系统管理 > <a href="{U('configgroup/index')}">设置分组</a> > <a href="{U('index',"gid=".$gid."")}">字段管理</a> > <a href="{THIS_LOCAL}">编辑字段</a></div>
    <div class="border">
        <!---->
        <legend>编辑字段</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段名称</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t0" size="50" value="{$ctitle}" placeholder="请输入字段名称" data-rule="字段名称:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段Key</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t1" size="50" value="{$ckey}" disabled placeholder="字母和数字的组合，长度3-50个字符" data-rule="字段Key:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段类型</label>
                <div class="am-u-sm-10">
                    <select name="t2" id="t2" class="w420" data-rule="字段类型:required;">
                        <option value="">请选择字段类型</option>
                        <option value="1"{if $ctype==1} selected{/if}>普通文本</option>
                        <option value="2"{if $ctype==2} selected{/if}>普通文本-密码</option>
                        <option value="4"{if $ctype==4} selected{/if}>普通文本-上传</option>
                        <option value="5"{if $ctype==5} selected{/if}>多行文本框</option>
                        <option value="6"{if $ctype==6} selected{/if}>单选按钮</option>
                        <option value="7"{if $ctype==7} selected{/if}>复选框</option>
                        <option value="8"{if $ctype==8} selected{/if}>下拉列表</option>
                        <option value="9"{if $ctype==9} selected{/if}>间隔标题</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group dis" id="list">
                <label class="am-u-sm-2 am-form-label">候选值</label>
                <div class="am-u-sm-10">
                    <textarea name="t3" rows="5" cols="50">{$dvalue}</textarea>
                    <span class="am-margin-left input-tips"><br>示范：项目名称1|项目值1<br>　　　项目名称2|项目值2</span>
                </div>
            </div>
            <div class="am-form-group dis" id="upload_type">
                <label class="am-u-sm-2 am-form-label">上传类型</label>
                <div class="am-u-sm-10">
                    <select name="t8" class="w420" data-rule="上传类型:required;">
                        <option value="">请选择上传类型</option>
                        <option value="1"{if $utype==1} selected{/if}>只能上传图片</option>
                        <option value="2"{if $utype==2} selected{/if}>只能上传视频</option>
                        <option value="3"{if $utype==3} selected{/if}>全部都可以上传</option>
                    </select>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">提示文字</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t4" size="50" value="{$dtext}">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">字段排序</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t5" size="30" value="{$ordnum}">
                    <span class="am-margin-left input-tips">数字越小越靠前</span>
                </div>
            </div>
            <div class="am-form-group dis" id="showway">
                <label class="am-u-sm-2 am-form-label">排列方式</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t6" id="t6_1" value="1"{if $rtype==1} checked{/if}><span for="t6_1">横排</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t6" id="t6_2" value="2"{if $rtype==2} checked{/if}><span for="t6_2">竖排</span>
                    </label>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">状态</label>
                <div class="am-u-sm-10">
                    <label class="am-radio-inline">
                        <input type="radio" name="t7" id="t7_1" value="1"{if $islock==1} checked{/if}><span for="t7_1">正常</span>
                    </label>
                    <label class="am-radio-inline">
                        <input type="radio" name="t7" id="t7_2" value="0"{if $islock==0} checked{/if}><span for="t7_2">锁定</span>
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
			case "4":
				$("#upload_type").css("display","block");
				$("#list,#showway").css("display","none");
				break;
			case "7":
			case "8":
			 	$("#list").css("display","block");
				$("#showway,#upload_type").css("display","none");
                break;
            case "6":
                $("#list,#showway").css("display","block");
				$("#upload_type").css("display","none");
                break;
            default:
                $("#list,#showway,#upload_type").css("display","none");
                break;
        }
    });
	{if $ctype==4}
	$("#upload_type").css("display","block");
	$("#list,#showway").css("display","none");
	{elseif $ctype==7||$ctype==8}
	$("#list").css("display","block");
	$("#showway,#upload_type").css("display","none");
	{elseif $ctype==6}
	$("#list,#showway").css("display","block");
	$("#upload_type").css("display","none");
	{else}
	$("#list,#showway,#upload_type").css("display","none");
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
                        setTimeout(function(){location.href='{U("index","gid=".$gid."")}';},1500);
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