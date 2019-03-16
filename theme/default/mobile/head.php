<?php if(!defined('IN_SDCMS')) exit;?><header class="header">
    <div class="am-fr"><a href="javascript:history.go(-1)" class="am-icon-chevron-left am-icon-sm"></a></div>
    <div class="am-fl"><a href="javascript:;" class="am-icon-bars am-icon-sm" data-am-offcanvas="{target:'#nav_top'}"></a></div>
    <div class="logo"><a href="{WEB_ROOT}"><img src="{sdcms[mobile_logo]}" alt="{sdcms[web_name]}" /></a></div>
    <div class="clear"></div>
</header>
<div class="nav am-offcanvas" id="nav_top">
    <div class="am-offcanvas-bar">
        <ul id="collapase-nav">
            <li><a href="{WEB_ROOT}">网站首页</a></li>
            {sdcms:rp top="0" table="sd_category" where="followid=0 and isshow=1" order="catenum,cateid"}{php $sub_sonid=$rp[cateid]}
            <li class="am-panel">{if get_sonid_num($rp[cateid])!=0}
            <span class="am-icon-angle-right" data-am-collapse="{parent:'#collapase-nav', target:'#nav_{$rp[cateid]}'}"></span>
            {/if}<a href="{cateurl($rp[cateid])}" title="{$rp[catename]}">{$rp[catename]}</a>
            <ul class="am-collapse" id="nav_{$rp[cateid]}">
                {sdcms:rs top="0" table="sd_category" where="followid=$sub_sonid and isshow=1" order="catenum,cateid"}
                <li><a href="{cateurl($rs[cateid])}" title="{$rs[catename]}">{$rs[catename]}</a></li>
                {/sdcms:rs}
            </ul></li>
            {/sdcms:rp}
            {if C('bbs_open')==1}
            <li id="nav_bbs"><a href="{N('bbs')}" title="{sdcms[bbs_webname]}">{sdcms[bbs_webname]}</a></li>
            {/if}
        </ul>
    </div>
</div>