<?php if(!defined('IN_SDCMS')) exit;?><footer><p>版权所有 © 2008-{date('Y')} {sdcms[ct_company]}　<a href="{N('sitemap')}" class="am-icon-map-marker am-icon-sm" title="网站地图"></a></p></footer>
<figure class="footnav">
    <div class="search">
        <form action="{N('search')}" method="get">
        	{if !isempty(sdcms[pathinfo])&&sdcms[url_mode]>1}<input type="hidden" name="s" value="search{sdcms[url_ext]}" />{/if}
        	{if sdcms[url_mode]==1}<input type="hidden" name="c" value="other" /><input type="hidden" name="a" value="search" />{/if}
            <span><a href="javascript:;" onclick="$('.search').toggle()" class="am-close">&times;</a>站内搜索：</span><input type="text" name="keyword" placeholder="请输入关键字" /><button type="submit">搜索</button>
        </form>
    </div>
    <ul>
        <li><a href="{WEB_ROOT}"><span class="am-icon-home"></span>首页</a></li>
        <li><a href="tel:{sdcms[ct_tel]}"><span class="am-icon-phone"></span>电话</a></li>
        <li><a href="{N('book')}"><span class="am-icon-comment-o"></span>留言</a></li>
        <li><a href="javascript:;" onclick="$('.search').toggle()"><span class="am-icon-search"></span>搜索</a></li>
    </ul>
</figure>
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}theme/default/mobile/js/app.js"></script>