<?php if(!defined('IN_SDCMS')) exit;?><div class="nav am-offcanvas" id="nav">
    <div class="am-offcanvas-bar am-offcanvas-bar-flip">
        <ul id="collapase-nav">
            {sdcms:rp top="0" table="sd_category" where="followid=$topid and isshow=1" order="catenum,cateid"}{php $sub_sonid=$rp[cateid]}
            <li class="am-panel">{if get_sonid_num($rp[cateid])!=0}
            <span class="am-icon-angle-right" data-am-collapse="{parent:'#collapase-nav', target:'#nav_{$rp[cateid]}'}"></span>
            {/if}<a href="{cateurl($rp[cateid])}" title="{$rp[catename]}">{$rp[catename]}</a>
            <ul class="am-collapse" id="nav_{$rp[cateid]}">
                {sdcms:rs top="0" table="sd_category" where="followid=$sub_sonid and isshow=1" order="catenum,cateid"}
                <li><a href="{cateurl($rs[cateid])}" title="{$rs[catename]}">{$rs[catename]}</a></li>
                {/sdcms:rs}
            </ul></li>
            {/sdcms:rp}
        </ul>
    </div>
</div>