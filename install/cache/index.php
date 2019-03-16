<?php defined('IN_SDCMS') or die();?><?php defined('IN_SDCMS') or die();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp"/>
<title><?php echo $webname;?>安装协议</title>
<link rel="stylesheet" href="../public/css/amazeui.min.css">
<link rel="stylesheet" href="../public/admin/css/toastr.css">
<link rel="stylesheet" href="css/app.css">
<script src="../public/js/jquery.min.js"></script>
<script src="../public/js/amazeui.min.js"></script>
<script src="../public/admin/js/toastr.min.js"></script>
<script src="../public/validator/jquery.validator.min.js?local=zh-CN"></script>
</head>

<body>
    <div class="bg_header">
        <div class="header width">
        	<div class="logo"></div>
            <div class="nav">
                <ul>
                	<li class="hover"><a href="javascript:;">安装协议</a></li>
                    <li><a href="javascript:;">环境检测</a></li>
                    <li><a href="javascript:;">参数配置</a></li>
                    <li><a href="javascript:;">安装结果</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="bg_inner"></div>
    <form class="am-form am-form-horizontal" id="agree" method="post">
    <div class="width inner_container">
        <div class="install">
            <div class="subject">
                <b>安装协议</b>
            </div>
            <p>1、本授权协议适用于 sdcms 任何版本，sdcms开发团队拥有对本授权协议的最终解释权和修改权。</p>
            <p>2、所有用户均可根据自己的需要对 sdcms 进行修改。但无论何种情况，即：无论用途如何、是否经过修改或美化、修改程度如何，只要您使用 sdcms 的任何整体或部分程序算法，都必须保留页脚处的 sdcms 名称和 www.sdcms.cn 的链接地址，且修改后的程序版权依然归 sdcms开发团队所有。</p>
            <p>3、无论您从何处获得 sdcms，只要未经商业授权，不得将本软件用于商业用途（企业网站或以盈利为目的经营性网站），否则我们将保留追究的权力。有关 sdcms 授权包含的服务范围，技术支持等，请参看 www.sdcms.cn。对于违反以上条款，我们将依法追究其责任。</p>
            <p>4、您可以免费使用本程序用于非商业用途，并允许传播给其他人。但您不能将本软件出售或变相出售、搭售（包括但不限于出售其他产品赠送本软件等形式），这将被视为将本软件用于商业用途，需要经过我们的商业授权。</p>
            <p><b>免责声明</b></p>
            <p>1、利用本软件构建的网站的任何信息内容以及导致的任何版权纠纷和法律争议及后果，我们不承担任何责任。</p>
            <p>2、程序的使用（或无法再使用）中所有一般化、特殊化、偶然性或必然性的损坏（包括但不限于数据的丢失，自己或第三方所维护数据的不正确修改，和其他程序协作过程中程序的崩溃等），我们不承担任何责任。</p>
            <div class="am-text-center am-margin-top-lg"><button type="submit" class="am-btn am-btn-primary">同意安装协议并继续</button></div>
        </div>
    </div>
    </form>
    
    <div class="am-text-center am-text-xs am-padding-bottom">版权所有 @  苏州烟火网络科技有限公司　<a href="http://www.sdcms.cn" target="_blank">Powered By Sdcms.Cn</a></div>

    <!--[if lt IE 9]>
    <div class="notsupport">
        <h1>:( 非常遗憾</h1>
        <h2>您的浏览器版本太低，请升级您的浏览器</h2>
    </div>
    <![endif]-->
    <script>
		$(function(){
			$('#agree').validator({
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
						url:'<?php echo THIS_LOCAL;?>',
						data:$(form).serialize(),
						error:function(e){alert(e.responseText);},
						success:function(d)
						{
							$.AMUI.progress.set(1.0);
							if(d.state=='success')
							{
								setTimeout(function(){location.href='?act=check';},1500);
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