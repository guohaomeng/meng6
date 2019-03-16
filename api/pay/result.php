<?php
/**
 * 作用：付款成功提示
 * 官网：Http://www.sdcms.cn
 * 作者：IT平民
 * ===========================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 未经授权不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
**/

#加载核心文件
require 'api.php';
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>付款成功</title>
<style>
*{padding:0;margin:0;}
body{background:#fff;font-family:'微软雅黑';color:#333;font-size:16px;}
.system-message{padding:60px 48px;}
.system-message h1{font-size:38px;font-weight:normal;line-height:50px;margin-bottom:12px;}
.system-message .jump{padding-top: 10px}
.system-message .jump b{color:#f30;}
.system-message .jump a{color:#06f;}
.system-message .success,.system-message .error{line-height:2.8em;font-size:24px}
.system-message .detail{font-size:12px;line-height:20px;margin-top:12px; display:none}
</style>
</head>
<body>
<div class="system-message">
<h1>付款成功</h1>
<p class="error">您的订单已付款成功。</p>
<p class="detail"></p>
<p class="jump">
<b id="wait">10</b> 后页面自动跳转　<a id="href" href="<?php echo WEB_URL;?>">立即跳转</a>
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