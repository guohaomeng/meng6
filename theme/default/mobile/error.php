<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>错误提示</title>
<style>
*{padding:0;margin:0;}
body{background:#fff;font-family:'微软雅黑';color:#333;font-size:16px;}
.system-message{padding:24px 48px;}
.system-message h1{font-size:30px;font-weight:normal;line-height:50px;margin-bottom:12px;}
.system-message .jump{padding-top: 10px}
.system-message .jump b{color:#f30;}
.system-message .jump a{color:#06f;}
.system-message .success,.system-message .error{line-height:2.8em;font-size:18px}
.system-message .detail{font-size:12px;line-height:20px;margin-top:12px; display:none}
</style>
</head>
<body>
<div class="system-message">
<h1>抱歉，出错拉！</h1>
<p class="error">{$data['msg']}</p>
<p class="detail"></p>
<p class="jump">
<b id="wait">5</b> 后页面自动跳转　<a id="href" href="{if $data['url']==''}javascript:history.back(-1);{else}{$data['url']}{/if}">立即跳转</a>
</p>
</div>
<script>
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
    var time = --wait.innerHTML;
    if(time <= 0) {
        location.href = href;
        clearInterval(interval);
    };
}, 1000);
})();
</script>
</body>
</html>