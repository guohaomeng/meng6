<?php if(!defined('IN_SDCMS')) exit;?><div class="bg_header">
    <div class="header width">
        <div class="logo"><img src="{sdcms[web_logo]}" alt="{sdcms[web_name]}"></div>
        <div class="nav" id="nav">
            <ul>
                <li><a href="{WEB_DOMAIN}" title="网站首页">网站首页</a></li>
                {sdcms:rp top="0" table="sd_category" where="followid=0 and isshow=1" order="catenum,cateid"}{php $head_sonid=$rp[cateid]}
                <li{is_active($rp[cateid],$parentid)}><a href="{cateurl($rp[cateid])}" title="{$rp[catename]}"{if $rp[isblank]==1} target="_blank"{/if}>{$rp[catename]}</a>
                {if get_sonid_num($rp[cateid])!=0}<ul class="subnav">
                    	{sdcms:rs top="0" table="sd_category" where="followid=$head_sonid and isshow=1" order="catenum,cateid"}
                    	<li><a href="{cateurl($rs[cateid])}" {if $rs[isblank]==1} target="_blank"{/if}>{$rs[catename]}</a></li>
                        {/sdcms:rs}
                    </ul>{/if}
                </li>
                {/sdcms:rp}
                {if C('bbs_open')==1}
                <li id="nav_bbs"><a href="{N('bbs')}" title="{sdcms[bbs_webname]}">{sdcms[bbs_webname]}</a></li>
                {/if}
            </ul>
        </div>
        
        <div class="usernav">
            {if USER_ID==0}<a href="{N('login')}">登录</a>　<a href="{N('reg')}">注册</a>{else}{get_user_info('uname')}　<a href="{N('user')}">会员中心</a>　<a href="{N('out')}">退出</a>{/if}
        </div>
    </div>
    <div class="clear"></div>
</div>