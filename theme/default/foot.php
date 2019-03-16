<?php if(!defined('IN_SDCMS')) exit;?><div class="bg_foot" data-am-scrollspy="{animation:'slide-bottom',repeat:false}">
    	<div class="width footer">
        	{sdcms:rp top="4" table="sd_category" where="followid=0 and isshow=1" order="catenum,cateid"}
            {php $foot_sonid=$rp[cateid]}
        	<div class="left">
                <dl>
                    <dd>{$rp[catename]}</dd>
                    {sdcms:rs top="3" table="sd_category" where="followid=$foot_sonid and isshow=1" order="catenum,cateid"}
                    <dt><a href="{cateurl($rs[cateid])}" title="{$rs[catename]}"{if $rs[isblank]==1} target="_blank"{/if}>{$rs[catename]}</a></dt>
                    {/sdcms:rs}
                </dl>
            </div>
            {/sdcms:rp}
            <div class="left">
                <dl>
                    <dd>联系方式</dd>
                    <dt><p>客服电话：{sdcms[ct_tel]}<br>工作时间：9:00-18:00 (工作日)<br>意见建议：{sdcms[ct_email]}</p></dt>
                </dl>
            </div>
            <div class="search">
            	<form action="{N('search')}" method="get">
                	{if !isempty(sdcms[pathinfo])&&sdcms[url_mode]>1}<input type="hidden" name="s" value="search{sdcms[url_ext]}" />{/if}
                	{if sdcms[url_mode]==1}<input type="hidden" name="c" value="other" /><input type="hidden" name="a" value="search" />{/if}
                	<span>站内搜索：</span><input type="text" name="keyword" placeholder="请输入关键字" /><button type="submit">搜索</button>
                </form>
            </div>
            <div class="clear"></div>
        </div>
        <div class="copyright">{sdcms[ct_company]}　版权所有 © 2008-{date('Y')} Inc.　<a href="http://www.miitbeian.gov.cn" target="_blank">{sdcms[web_icp]}</a>　<a href="{N('sitemap')}">网站地图</a>　{sdcms[count_code]}<div>{runtime()}</div></div>
    </div>
    
    <div class="plug_service" data-am-scrollspy="{animation:'slide-bottom',repeat:false,delay:1000}">
        <ul>
        	{foreach $plug_service as $key=>$val}
        	<li><a href="http://wpa.qq.com/msgrd?v=3&uin={$val['qq']}&site=qq&menu=yes" target="_blank"><span class="am-icon-qq"></span>{$val['title']}</a></li>
            {/foreach}
            <li><a href="{N('book')}"><span class="am-icon-pencil-square-o"></span>在线留言</a></li>
            {if sdcms[mobile_open]==1&&!isempty(sdcms[mobile_domain])}
            <li><a href="http://{sdcms[mobile_domain]}" title="手机站" target="_blank"><span class="am-icon-mobile"></span>手机站</a></li>
            {/if}
            <li><a href="javascript:;"><span class="am-icon-phone"></span>客服热线</a><div class="hotline"><b>{sdcms[ct_tel]}</b>工作时间：8：00 - 18：00</div></li>
            {if strlen(sdcms[weixin_qrcode])}<li><a href="javascript:;"><span class="am-icon-wechat"></span>官方微信</a><div class="weixin_pic"><img src="{sdcms[weixin_qrcode]}" width="200"><p>微信号：<span>{sdcms[weixin_id]}</span></p></div></li>{/if}
            <li class="hover dis" id="backtop"><a href="javascript:;" data-am-smooth-scroll><span class="am-icon-chevron-up"></span>返回顶部</a></li>
        </ul>
    </div>
    
    <!--[if lt IE 9]>
    <div class="notsupport">
        <h1>:( 非常遗憾</h1>
        <h2>您的浏览器版本太低，请升级您的浏览器</h2>
    </div>
    <![endif]-->
    <script src="{WEB_ROOT}public/js/jquery.min.js"></script>
    <script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
    <script src="{WEB_ROOT}theme/default/js/app.js"></script>