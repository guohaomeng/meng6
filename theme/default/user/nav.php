<?php if(!defined('IN_SDCMS')) exit;?><ul>
    <li><div class="title"><span class="am-icon-user am-icon-fw"></span>会员中心</div></li>
    <li{if ACTION_NAME=='index'} class="hover"{/if}><a href="{N('user')}">个人中心</a></li>
    <li{if ACTION_NAME=='myorder'} class="hover"{/if}><a href="{N('myorder')}">我的订单</a></li>
    <li{if ACTION_NAME=='editemail'} class="hover"{/if}><a href="{N('editemail')}">修改邮箱</a></li>
    <li{if ACTION_NAME=='editpass'} class="hover"{/if}><a href="{N('editpass')}">修改密码</a></li>
    <li><a href="{N('out')}">退出登录</a></li>
</ul>