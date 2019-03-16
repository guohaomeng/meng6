<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{if strlen(sdcms[seo_title])>0}{sdcms[seo_title]}_{/if}{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>
	{include file="mobile/head.php"}
  
    <article>
    	<section>
        	<div class="subject">
                <b>订单详情</b>
            </div>
            <div class="clear"></div>
            <!---->
            <div class="ordershow">
                <div class="tips">
                    <h3><span class="am-icon-check am-margin-right am-success am-icon-btn"></span>{if $ispay==0}订单提交成功{else}订单付款成功{/if}</h3>
                    <p>订单号：<em>{$orderid}</em></p>
                    <p>订单金额：<em>{$pro_price}</em> 元</p>
                </div>
                <h5>订单明细</h5>
                <ul class="info">
                    <li><span>产品：</span>{$pro_name}</li>
                    <li><span>数量：</span>{$pro_num}</li>
                    <li><span>姓名：</span>{$truename}</li>
                    <li><span>手机：</span>{$mobile}</li>
                    <li><span>地址：</span>{$address}</li>
                    <li><span>备注：</span>{$remark}</li>
                </ul>
                {if C('pay_open')==1&&$ispay==0}
                <form method="post" id="form_order">
                <h5>支付方式</h5>
                <ul class="pay" id="orderpay">
                    {if C('pay_alipay_open')==1&&isweixin()==0}
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
            <!---->
        </section>

        
    </article>
    {include file="mobile/foot.php"}
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
                    var root='m';
                    {if isweixin()}
                    if(payway=='wxpay')
                    {
                        var root='w';
                    }
                    {/if}
                    location.href='{WEB_DOMAIN}api/pay/'+payway+'/'+root+'/api.php?orderid={$orderid}';
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