<?php defined('IN_SDCMS') or die();?><?php defined('IN_SDCMS') or die();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<title><?php echo $webname;?>环境检测</title>
<link rel="stylesheet" href="../public/css/amazeui.min.css">
<link rel="stylesheet" href="css/app.css">
<script src="../public/js/jquery.min.js"></script>
<script src="../public/js/amazeui.min.js"></script>
</head>

<body>
    <div class="bg_header">
        <div class="header width">
        	<div class="logo"></div>
            <div class="nav">
                <ul>
                	<li><a href="javascript:;">安装协议</a></li>
                    <li class="hover"><a href="javascript:;">环境检测</a></li>
                    <li><a href="javascript:;">参数配置</a></li>
                    <li><a href="javascript:;">安装结果</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="bg_inner"></div>
    
    <div class="width inner_container">
        <div class="install">
            <div class="subject">
                <b>服务器环境</b>
            </div>
            <table class="am-table">
                <thead>
                    <tr>
                        <th>项目名称</th>
                        <th width="40%">结果</th>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach($data as $key=>$val) { ?>
                    <tr>
                        <td><?php echo $key;?></td>
                        <td><?php echo $val;?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="subject">
                <b>目录和文件权限</b>
            </div>
            <table class="am-table">
                <thead>
                    <tr>
                        <th>项目名称</th>
                        <th width="40%">结果</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($file as $key=>$val) { ?>
                    <tr>
                        <td><?php echo $key;?></td>
                        <td><?php echo $val;?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="am-text-center am-margin-top-lg"><button class="am-btn am-btn-default am-margin-right" onClick="location.href='./'">上一步</button><button class="am-btn am-btn-primary" onClick="location.href='?act=config'" <?php if (!$result) { ?>disabled<?php }?>><?php if (!$result) { ?>请检查不符合的项目<?php } else { ?>下一步<?php }?></button></div>
        </div>
        
    </div>
    
    <div class="am-text-center am-text-xs am-padding-bottom">版权所有 @  苏州烟火网络科技有限公司　<a href="http://www.sdcms.cn" target="_blank">Powered By Sdcms.Cn</a></div>

    
    <!--[if lt IE 9]>
    <div class="notsupport">
        <h1>:( 非常遗憾</h1>
        <h2>您的浏览器版本太低，请升级您的浏览器</h2>
    </div>
    <![endif]-->
</body>
</html>