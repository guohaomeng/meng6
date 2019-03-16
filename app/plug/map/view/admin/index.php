<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>电子地图</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<script src="{WEB_ROOT}public/ueditor/ueditor.config.js"></script>
<script src="{WEB_ROOT}public/ueditor/ueditor.all.min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
<style>
    .code{padding:15px;}
    .code p{margin:0;padding:0;line-height:40px;font-weight:600;font-size:16px;}
    .code textarea{width:350px;height:100px;border:1px style #eee;padding:10px;}
</style>
</head>

<body>
    <div class="position">当前位置：插件管理 > <a href="{U('index')}">电子地图</a></div>
    <div class="border">
        <!---->
        <legend>电子地图</legend>
        <form class="am-form am-form-horizontal" method="post">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">地点选择</label>
                <div class="am-u-sm-10">
                    <div id="container" style="width:800px;height:{$height}px;" class="am-img-thumbnail am-radius">地图加载中...</div>
                    <div class="input-tips">通过地图找到您单位所在的位置，然后鼠标单击即可获取相应坐标</div>
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">坐标</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t0" id="t0" size="20" value="{$point_x}"> - <input type="text" name="t1" id="t1" size="20" value="{$point_y}">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">密钥</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t3" size="50" maxlength="255" value="{$mapkey}" data-rule="密钥:required;">
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">地图高度</label>
                <div class="am-u-sm-10">
                    <input type="text" name="t4" size="16" maxlength="4" value="{$height}" data-rule="高:required;int;">px
                </div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">简介</label>
                <div class="am-u-sm-10">
                    <script id="t2" name="t2" type="text/plain" style="height:120px;">{$remark}</script>
                    <script>UE.getEditor('t2',{toolbars:editorSimple});</script>
                </div>
            </div>
            <div class="am-form-group">
                <div class="am-u-sm-10 am-u-sm-offset-2">
                    <button type="submit" class="am-btn am-btn-primary am-radius">保存</button>
                    <button type="button" class="view am-btn am-btn-warning am-radius">预览</button>
                    <button type="button" class="getcode am-btn am-btn-default am-radius">获取调用代码</button>
                </div>
            </div>
        </form>
        <!---->
    </div>
<script src="https://api.map.baidu.com/api?v=2.0&callback=initialize"></script>
<script>
function setValue(point){
	$("#t0").val(point.lng);$("#t1").val(point.lat);
}
var cityName="";
var mapinfo="";
var map="";
var localCity="";
var opts="{width:auto,height:auto}";
function initialize()
{
	map = new BMap.Map("container");
	localCity = new BMap.LocalCity();
	map.enableScrollWheelZoom(); 
	map.addControl(new BMap.NavigationControl());  
	map.addControl(new BMap.ScaleControl());  
	map.addControl(new BMap.OverviewMapControl()); 
	localCity.get(function(cityResult){
	  if (cityResult) {
	  	var level = cityResult.level;
	  	if (level < 13) level = 13;
	    map.centerAndZoom(cityResult.center, level);
	    //setValue(cityResult.center); 
	    map.addEventListener("click", function(e){
	    	setPoint(e.point);
	    	setValue(e.point);
			});
	    cityResultName = cityResult.name;
	    if (cityResultName.indexOf(cityName) >= 0) cityName = cityResult.name;
	    	var store_point = new BMap.Point({$point_x},{$point_y});
	    	setPoint(store_point);
	    	  }
	});
}
function getPoint(){
	var myGeo = new BMap.Geocoder();
	myGeo.getPoint(address, function(point){
	  if (point) {
	    setPoint(point);
	  }
	}, cityName);
}
function setPoint(point){
	  if (point) {
	    map.centerAndZoom(point,16);
	    map.clearOverlays();
	    var marker = new BMap.Marker(point);
	    marker.enableDragging(true);
	    var infoWindow = new BMap.InfoWindow(mapinfo, opts);  
			marker.addEventListener("click", function(){          
			   this.openInfoWindow(infoWindow);  
			});
	    marker.addEventListener("dragend", function(e){  
			 setValue(e.point);  
			});  
	    map.addOverlay(marker);
	  }
}
$(function(){
	$(".view").click(function(){
		layer.open({
			type: 2,
			title: false,
			area: ['800px', '{$height}px'],
			shade: 0.6,
			closeBtn: 0,
			shadeClose: true,
			content: '{U('index/index')}'
		});
	});
    $(".getcode").click(function(){
        layer.open({
          type: 1,
          title: false,
          closeBtn: 0,
          shadeClose: true,
          skin: 'code',
          content: '<p>请将下面代码复制到内容或模板中</p><textarea onFocus="this.select()"><iframe src="{U('index/index')}" frameborder="0" width="100%" height="{$height}" scrolling="no"></iframe></textarea>'
        });

    });
    toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
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
})
</script>
</body>
</html>