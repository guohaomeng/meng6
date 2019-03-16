<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>管理首页</title>
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：<a href="{THIS_LOCAL}">管理首页</a></div>
    <div class="main_body">
        <div class="col_right">
            <div class="main_bg">
                <div class="subject">官方通知</div>
                <ul class="topnews" id="notice">
                </ul>
            </div>
            <div class="main_bg mt15">
                <div class="subject"><a href="{U('loginlog/index')}">更多>></a>登录日志</div>
                <div class="log">
                	{sdcms:rs top="20" table="sd_admin_login_log" where="$where" order="id desc"}
                    <p><strong><span>{date('Y-m-d H:i:s',$rs[logindate])}</span>{$rs[loginname]}</strong>{$rs[loginip]}<span>{$rs[loginmsg]}</span></p>
                    {/sdcms:rs}
                </div>
            </div>
        </div>
        
        <div class="col_left">
            <div class="main_bg">
                <div class="subject">数据统计</div>
                <ul class="count">
                	{foreach $data as $key=>$val}
                    <li>{$key}<span>{$val}</span></li>
                    {/foreach}
                </ul>
            </div>
            
            <div class="main_bg mt15">
                <div class="subject">服务器环境</div>
                <ul class="help">
                    {foreach $info as $key=>$val}
                    <li><span>{$key}：</span>{$val}</li>
                    {/foreach}
                </ul>
            </div>
        </div>
    </div>
    <div class="copyright">Powered By <a href="http://www.sdcms.cn" target="_blank">Sdcms.Cn</a> @ 2008-{date('Y')} Sdcms.Cn Inc.</div>
    <script src="https://www.sdcms.cn/home/index/notice/"></script>
</body>
</html>
