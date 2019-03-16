<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>订单详情_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>

    {include file="head.php"}
    
    <div class="bg_inner am-animation-scale-up am-animation-delay-1">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a>订单详情</a></li>
                </ul>
            </div>
        	<div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>
    
    <div class="width inner_container am-animation-slide-bottom am-animation-delay-1">
    	
        <ol class="am-breadcrumb am-breadcrumb-slash am-animation-slide-top am-animation-delay-1">
            <li><a href="{WEB_DOMAIN}" class="am-icon-home">首页</a></li>
            <li class="am-active">订单详情</li>
        </ol>
                
        <div class="ordershow">
        	<div class="tips">
            	<div>订单金额：<em>{$pro_price}</em> 元</div>
            	<h3><span class="am-icon-check am-margin-right am-success am-icon-btn"></span>{if $ispay==0}订单提交成功{else}订单付款成功{/if}</h3>
                <p>订单号：<em>{$orderid}</em></p>
            </div>
            <h5>订单明细</h5>
        	<ul class="info">
                <li><span>订购产品：</span>{$pro_name}</li>
                <li><span>订购数量：</span>{$pro_num}</li>
                <li><span>姓名：</span>{$truename}</li>
                <li><span>手机号：</span>{$mobile}</li>
                <li><span>地址：</span>{$address}</li>
                <li><span>备注：</span>{$remark}</li>
            </ul>
            {if C('pay_open')==1&&$ispay==0}
            <form method="post" id="form_order">
            <h5>支付方式</h5>
            <ul class="pay" id="orderpay">
            	{if C('pay_alipay_open')==1}
            	<li><div><img src="{WEB_ROOT}api/pay/alipay/images/pay.png" data-config="alipay"><em></em></div></li>
                {/if}
                {if C('pay_wxpay_open')==1}
                <li><div><img src="{WEB_ROOT}api/pay/wxpay/images/pay.png" data-config="wxpay"><em></em></div></li>
                {/if}
            </ul>
            <input type="hidden" name="payway" id="payway" value="" data-rule="支付方式:required;">
            <div class="bottom"><button type="submit" class="am-btn-default">在线支付</button></div>
            </form>
            {/if}
        </div>
        
    </div>
    
    {include file="foot.php"}
    <link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
    <script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
    <script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
    <script src="{WEB_ROOT}public/layer/layer.js"></script>
    <script>
		$(function(){
			toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
			$('#form_order').validator({
				timely:0,
				stopOnError:true,
				focusCleanup:true,
				theme:'yellow_top',
				msgMaker:function(opt){if(opt.type=='error'){
					$(".msg-box").remove();toastr.clear();toastr.error(opt.msg);
					}},
				valid:function(form)
				{
					var payway=($(form).serialize()).substring(7);
					if(payway=='wxpay')
					{
						$.ajax({
							type:'get',
							dataType:'json',
							url:'{WEB_ROOT}api/pay/wxpay/p/api.php?orderid={$orderid}',
							error:function(e){alert(e.responseText);},
							success:function(d){
								if(d.state=='success')
								{
									layer.open({type:1,anim:4,scrollbar:false,title:'微信支付',content:'<div style="padding:15px;font-size:15px;line-height:30px;text-align:center"><img src="'+d.msg+'" width="300" height="300"><p>请打开微信，使用扫一扫完成付款。</p></div>'});
									var timer=window.setInterval(freshorder,1000);
								}
								else
								{
									toastr.error(d.msg[0]);
								}
							}
						});
					}
					else
					{
						location.href='{WEB_DOMAIN}api/pay/'+payway+'/p/api.php?orderid={$orderid}';
					}
				}
			});
		})
		function freshorder()
		{
			$.ajax({
				type:"post",
				cache:"false",
				url:"{THIS_LOCAL}",
				success:function(d){
					if(d==1)
					{
						location.href='{THIS_LOCAL}';
						clearInterval(timer);
					}
				}
			})
		}
	</script>
</body>
</html>