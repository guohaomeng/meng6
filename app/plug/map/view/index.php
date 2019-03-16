<?php if(!defined('IN_SDCMS')) exit;?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<title>百度地图</title>
<style>
body,html{width:100%;height:100%;margin:0;font-family:"微软雅黑";font-size:14px;}
*{margin:0;padding:0;}
#sdcms-map{min-height:{$height}px;width:100%;}
p{margin:0;padding:5px 0;}
</style>
<script src="https://api.map.baidu.com/api?v=2.0&ak={$mapkey}"></script>
</head>
<body>
<div id="sdcms-map">地图加载中...</div>
<script>
var map=new BMap.Map("sdcms-map");
var point=new BMap.Point({$point_x},{$point_y});
var marker=new BMap.Marker(point);
var infoWindow=new BMap.InfoWindow("{$remark}");
map.centerAndZoom(point,15);
map.enableScrollWheelZoom(true);
map.addOverlay(marker);
marker.openInfoWindow(infoWindow,point);
marker.setAnimation(BMAP_ANIMATION_BOUNCE);
marker.addEventListener("click",function(){this.openInfoWindow(infoWindow);});
</script>
</body>
</html>