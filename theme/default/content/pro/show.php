<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>{if strlen($seotitle)>0}{$seotitle}_{/if}{$title}_{$catename}_{sdcms[web_name]}</title>
<meta name="keywords" content="{if strlen($seokey)>0}{$seokey}{else}{$title}{/if}">
<meta name="description" content="{if strlen($seodesc)>0}{$seodesc}{else}{$title}{/if}">
</head>

<body>

    {include file="head.php"}

    <div class="bg_inner am-animation-scale-up am-animation-delay-1">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a>{get_catename($topid)}</a></li>
                </ul>
            </div>
        	<div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>
    
    <div class="width inner_container am-animation-slide-bottom am-animation-delay-1">
    	
        <ol class="am-breadcrumb am-breadcrumb-slash am-animation-slide-top am-animation-delay-1">
            <li><a href="{WEB_DOMAIN}" class="am-icon-home">首页</a></li>
            {foreach $position as $rs}
            <li><a href="{cateurl($rs)}" title="{get_catename($rs)}">{get_catename($rs)}</a></li>
            {/foreach}
            <li class="am-active">内容</li>
        </ol>
        {php $piclist=str_replace(PHP_EOL,'\n',$piclist)}
        {php $piclist=json_decode($piclist,true)}
        <div class="pro_show am-animation-slide-bottom am-animation-delay-1">
            <div class="left">
            	{if count($piclist)>0}
                {php $big=reset($piclist)}
            	<div id="zoom_pic" class="zoom"><img src="{$big['image']}" alt="{$big['desc']}" width="500" id="zoom"></div>
                <div class="thumb_pic">
                    <ul>
                    	{php $step=0}
                    	{foreach $piclist as $index=>$val}
                        {php $step++}
                    	<li{if $step==1} class="hover"{/if}><img src="{thumb($val['image'],60,60)}" data-url="{$val['image']}" alt="{$val['desc']}" width="60" height="60"></li>
                        {/foreach}
                    </ul>
                </div>
                {/if}
            </div>
            <div class="right">
            	<h1>{$title}</h1>
                <hr>
                {if strlen($intro)>0}
                <h5>{$intro}</h5>
                <hr>
                {/if}
                <ul class="attribute">
                    {foreach $field as $key=>$rs}
                    {if !empty($rs)}
                    <li><em>{$key}：</em>{$rs}</li>
                    {/if}
                    {/foreach}
                </ul>
                {if $price==0}
                <div class="price">价格：<span>面议</span></div>
                {else}
                <div class="price">价格：<span>{$price}</span><em>元</em></div>
                <div class="action">
                    <button class="am-btn am-btn-primary am-round" data-am-modal="{target:'#my-inquiry'}"><span class="am-icon-pencil-square-o"></span> 我要询价</button>
                    <button class="am-btn am-btn-warning am-round am-margin-left" data-am-modal="{target:'#my-order'}"><span class="am-icon-cart-plus"></span> 我要订购</button>
                </div>
                {/if}
                {if count($tags)>0}
                <div class="tags"><span class="am-icon-tags"></span> {foreach $tags as $rs}<a href="{U('home/other/taglist/','tagname='.$rs.'')}" title="{$rs}" target="_blank">{$rs}</a>{/foreach}</div>
                {/if}
            </div>
            <div class="clear"></div>
        </div>
        
        <div class="pro_intro am-animation-slide-bottom am-animation-delay-2">
            <div class="left">
            	<div class="tabs">
                    <ul>
                        <li class="hover"><a href="">推荐产品</a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="plist">
                    <ul>
                        {sdcms:rs top="6" table="sd_model_pro" join="left join sd_content on sd_model_pro.cid=sd_content.id" where="islock=1 and isnice=1" order="ontop desc,ordnum desc,id desc"}
                    	{rs:eof}暂无资料{/rs:eof}
                        <li><a href="{$rs[link]}" title="{$rs[title]}"><div><img src="{thumb($rs[pic],280,280)}" alt="{$rs[title]}"></div><p>{cutstr($rs[title],20,0)}</p></a></li>
                        {/sdcms:rs}
                    </ul>
                    <div class="clear"></div>
                </div>
                {if count($tags)>0}
                <div class="tabs">
                    <ul>
                        <li class="hover"><a href="">相关产品</a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="plist">
                    <ul>
                    	{sdcms:rs top="6" table="sd_model_pro" join="left join sd_content on sd_model_pro.cid=sd_content.id" where="$like" order="ontop desc,ordnum desc,id desc"}
                    	{rs:eof}暂无资料{/rs:eof}
                        <li><a href="{$rs[link]}" title="{$rs[title]}"><div><img src="{thumb($rs[pic],280,280)}" alt="{$rs[title]}"></div><p>{cutstr($rs[title],20,0)}</p></a></li>
                        {/sdcms:rs}
                    </ul>
                    <div class="clear"></div>
                </div>
                {/if}
            </div>
            <div class="right">
            	<div class="tabs">
                    <ul>
                        <li class="hover"{if count($edata)>0} id="one1" onClick="setTab('one',1,2)"{/if}><a href="javascript:;">产品介绍</a></li>
                        {if count($edata)>0}
                        <li id="one2" onClick="setTab('one',2,2)"><a href="javascript:;">规格参数</a></li>{/if}
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="intro" id="con_one_1">
                    {$content}
                </div>
                <div class="intro dis" id="con_one_2">
                    <ul class="extend">
                        {foreach $edata as $key=>$rs}
                        <li><em>{$rs['field_title']}：</em>{if isset($extend[$rs['field_key']])}{$extend[$rs['field_key']]}{/if}</li>
                        {/foreach}
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        
    </div>
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
    {include file="foot.php"}
    <script src="{WEB_ROOT}theme/default/js/jquery.zoombie.js"></script>
    <link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
    <script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
    <script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
    <script>
		$(function(){
			//$('#zoom_pic').zoombie();
			{if $price!=0}
			toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
			$('#form_inquiry').validator({
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
						url:'{U("home/other/inquiry/","id=".$id."","",1)}',
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
						url:'{U("home/other/order/","id=".$id."","",1)}',
						data:$(form).serialize(),
						error:function(e){alert(e.responseText);},
						success:function(d)
						{
							$.AMUI.progress.set(1.0);
							if(d.state=='success')
							{
								location.href=d.msg;
							}
							else
							{
								toastr.error(d.msg);
							}
							
						}
					})
				}
			});
			{/if}
		})
	</script>
</body>
</html>