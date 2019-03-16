<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{if strlen($seotitle)>0}{$seotitle}_{/if}{$title}_{$catename}_{sdcms[web_name]}</title>
<meta name="keywords" content="{if strlen($seokey)>0}{$seokey}{else}{$title}{/if}">
<meta name="description" content="{if strlen($seodesc)>0}{$seodesc}{else}{$title}{/if}">
<link rel="stylesheet" href="{WEB_ROOT}theme/default/mobile/css/swiper.min.css">
{include file="mobile/wxshare.php"}
</head>

<body>
	{include file="mobile/head.php"}
    <article>
    	<section>
            <div class="pro_show">
                {php $piclist=str_replace(PHP_EOL,'\n',$piclist)}
       			{php $piclist=json_decode($piclist,true)}
                {if count($piclist)>0}                
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        {php $step=0}
                    	{foreach $piclist as $index=>$val}
                        {php $step++}
                        <div class="swiper-slide"><img src="{$val['image']}" alt="{$title}" /></div>
                        {/foreach}
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                {/if}
                <h1>{$title}</h1>
                {if $price!=0}
                <div class="price">价格：<span>{$price}</span><em>元</em></div>
                {else}
                <div class="price">价格：<span>面议</div>
                {/if}
                {if strlen($intro)>0}
                <div class="intro">
                {$intro}
                </div>
                {else}
                <hr>
                {/if}
                <ul class="attribute">
                    {foreach $field as $key=>$rs}
                    {if !empty($rs)}
                    <li><em>{$key}：</em>{$rs}</li>
                    {/if}
                    {/foreach}
                </ul>
            </div>
        </section>
        {if $price!=0}
        <section>
        	<div class="subject">
                <b>询价订购</b>
            </div>
            <div class="clear"></div>
            <div class="am-padding-top am-padding-bottom-sm am-text-center">
                <button class="am-btn am-btn-primary am-round" data-am-modal="{target:'#my-inquiry'}"><span class="am-icon-pencil-square-o"></span> 我要询价</button>
                <button class="am-btn am-btn-warning am-round am-margin-left" data-am-modal="{target:'#my-order'}"><span class="am-icon-cart-plus"></span> 我要订购</button>
            </div>
        </section>
        {/if}
        <section>
        	<div class="subject">
                <b>产品介绍</b>
            </div>
            <div class="clear"></div>
            <div class="news_show">
                <div class="intro">
                    {$content}
                    <div class="clear"></div>
                </div>
                {if count($tags)>0}
                <hr class="am-margin-top-lg">
                <div class="tags"><a href="{N('tags')}" class="hover">标签</a>{foreach $tags as $rs}<a href="{U('home/other/taglist/','tagname='.$rs.'')}" title="{$rs}">{$rs}</a>{/foreach}</div>
                {/if}
            </div>
        </section>
        {if count($edata)>0}
        <section>
        	<div class="subject">
                <b>规格参数</b>
            </div>
            <div class="clear"></div>
            <div class="pro_show">
                <ul class="extend">
                    {foreach $edata as $key=>$rs}
                    <li><em>{$rs['field_title']}：</em>{if isset($extend[$rs['field_key']])}{$extend[$rs['field_key']]}{/if}</li>
                    {/foreach}
                </ul>
            </div>
        </section>
        {/if}
        {if count($tags)>0}
        <section>
        	<div class="subject">
                <b>相关内容</b>
            </div>
            <div class="clear"></div>
            <div class="home_pro">
            <ul>
               {sdcms:rs top="6" table="sd_model_pro" join="left join sd_content on sd_model_pro.cid=sd_content.id" where="$like" order="ontop desc,ordnum desc,id desc"}
               {rs:eof}暂无资料{/rs:eof}
               <li><a href="{$rs[link]}" title="{$rs[title]}"><div><img src="{thumb($rs[pic],280,280)}" alt="{$rs[title]}"></div><p class="title">{$rs[title]}</p><p class="price"><span>人气：{$rs[hits]}</span>¥ {$rs[price]}</p></a></li>
               {/sdcms:rs}
             </ul>
             <div class="clear"></div>
        </section>
        {/if}
    </article>
    {if $price!=0}
    <div class="am-modal am-modal-no-btn" tabindex="-1" id="my-inquiry">
        <div class="am-modal-dialog">
        	<div class="am-modal-hd">我要询价
        		<a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        	</div>
            <div class="am-modal-bd">
                <form class="am-form am-margin-top am-margin" id="form_inquiry" method="post">
                    <div class="am-input-group am-form-group">
                        <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
                        <input type="text" name="truename" class="am-form-field" placeholder="请输入您的姓名" data-rule="姓名:required;">
                    </div>
                    <div class="am-input-group am-form-group">
                        <span class="am-input-group-label"><i class="am-icon-phone am-icon-fw"></i></span>
                        <input type="text" name="mobile" maxlength="11" class="am-form-field" placeholder="请输入您的手机号码" data-rule="手机号码:required;mobile;">
                    </div>
                    <div class="am-input-group am-form-group">
                        <span class="am-input-group-label"><i class="am-icon-comments-o am-icon-fw"></i></span>
                        <textarea name="remark" rows="5" placeholder="请输入询价内容" data-rule="询价内容:required;"></textarea>
                    </div>
                    <button type="submit" class="am-btn am-btn-primary">提交询价</button>
                    <button type="button" class="am-btn am-btn-default am-margin-left" onClick="$('#form_inquiry')[0].reset();$('#my-inquiry').modal('close');">取消</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="am-modal am-modal-no-btn" tabindex="-1" id="my-order">
        <div class="am-modal-dialog">
        	<div class="am-modal-hd">我要订购
        		<a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        	</div>
            <div class="am-modal-bd">
                <form class="am-form am-margin-top am-margin" id="form_order" method="post">
                    <div class="am-input-group am-form-group">
                        <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
                        <input type="text" name="truename" class="am-form-field" placeholder="请输入您的姓名" data-rule="姓名:required;">
                    </div>
                    <div class="am-input-group am-form-group">
                        <span class="am-input-group-label"><i class="am-icon-phone am-icon-fw"></i></span>
                        <input type="text" name="mobile" maxlength="11" class="am-form-field" placeholder="请输入您的手机号码" data-rule="手机号码:required;mobile;">
                    </div>
                    <div class="am-input-group am-form-group">
                        <span class="am-input-group-label"><i class="am-icon-opencart am-icon-fw"></i></span>
                        <input type="text" name="pronum" maxlength="6" class="am-form-field" placeholder="请输入订购数量" data-rule="订购数量:required;int;">
                    </div>
                    <div class="am-input-group am-form-group">
                        <span class="am-input-group-label"><i class="am-icon-map-marker am-icon-fw"></i></span>
                        <input type="text" name="address" maxlength="255" class="am-form-field" placeholder="请输入收货地址" data-rule="收货地址:required;">
                    </div>
                    <div class="am-input-group am-form-group">
                        <span class="am-input-group-label"><i class="am-icon-comments-o am-icon-fw"></i></span>
                        <textarea name="remark" rows="5" placeholder="请输入备注，可以为空"></textarea>
                    </div>
                    <button type="submit" class="am-btn am-btn-primary">提交订单</button>
                    <button type="button" class="am-btn am-btn-default am-margin-left" onClick="$('#form_order')[0].reset();$('#my-order').modal('close');">取消</button>
                </form>
            </div>
        </div>
    </div>
    {/if}
    {include file="mobile/foot.php"}
    {if $price!=0}
    <link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
    <script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
    <script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
    <script>
		$(function(){
			toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
			$('#form_inquiry').validator({
				timely:0,
				stopOnError:true,
				focusCleanup:true,
				ignore:':hidden',
				theme:'yellow_right_effect',
				msgMaker:function(opt){if(opt.type=='error'){toastr.clear();toastr.error(opt.msg);}},
				valid:function(form)
				{
					$.AMUI.progress.inc();
					$.ajax({
						type:'post',
						cache:false,
						dataType:'json',
						url:'{U("home/other/inquiry/","id=".$id."")}',
						data:$(form).serialize(),
						error:function(e){alert(e.responseText);},
						success:function(d)
						{
							$.AMUI.progress.set(1.0);
							if(d.state=='success')
							{
								toastr.success(d.msg);
								$("#form_inquiry")[0].reset();
								$("#my-inquiry").modal('close');
							}
							else
							{
								toastr.error(d.msg);
							}
							
						}
					})
				}
			});
			
			$('#form_order').validator({
				timely:0,
				stopOnError:true,
				focusCleanup:true,
				ignore:':hidden',
				theme:'yellow_right_effect',
				msgMaker:function(opt){if(opt.type=='error'){toastr.clear();toastr.error(opt.msg);}},
				valid:function(form)
				{
					$.AMUI.progress.inc();
					$.ajax({
						type:'post',
						cache:false,
						dataType:'json',
						url:'{U("home/other/order/","id=".$id."")}',
						data:$(form).serialize(),
						error:function(e){alert(e.responseText);},
						success:function(d)
						{
							$.AMUI.progress.set(1.0);
							if(d.state=='success')
							{
								location.href=d.msg;
								/*toastr.success(d.msg);
								$("#form_order")[0].reset();
								$("#my-order").modal('close');*/
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
    {/if}
    <script src="{WEB_ROOT}theme/default/mobile/js/swipe.js"></script>
    <script>
    var swiper=new Swiper('.swiper-container',{
        pagination:'.swiper-pagination',
        paginationClickable:true,
        spaceBetween:30,
        centeredSlides:true,
        autoplay:5000,
        autoplayDisableOnInteraction:false,
		loop:true
    });
    </script>
    
</body>
</html>