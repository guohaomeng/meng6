<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{if strlen($catetitle)>0}{$catetitle}_{/if}{$catename}_{if $page>1}第{$page}页_{/if}{sdcms[web_name]}</title>
<meta name="keywords" content="{if strlen($catekey)>0}{$catekey}{else}{$catename}{/if}">
<meta name="description" content="{if strlen($catedesc)>0}{$catedesc}{else}{$catename}{/if}">
{include file="mobile/wxshare.php"}
</head>

<body>
	{include file="mobile/head.php"}
    {include file="mobile/bar.php"}
      <article>
    	<section>
        	<div class="subject">
                {if get_sonid_num($topid)!=0}<span class="more"><a href="javascript:;" class="am-icon-bars am-icon-sm" data-am-offcanvas="{target:'#nav'}"></a></span>{/if}<b>{$catename}</b>
            </div>
            <div class="clear"></div>
            <div class="about">
            	{if is_array($piclist)}
                <ul id="gallery" data-am-widget="gallery" data-am-gallery="{ pureview: true }" >
                    {foreach $piclist as $key=>$rs}
                    <li><a href="{$rs['image']}" title="{$rs['desc']}"><img src="{$rs['image']}" alt="{$rs['desc']}" /><p>{$rs['desc']}</p></a></li>
                    {/foreach}
                </ul>
                <div class="clear"></div>
                {/if}
            	{$content}
        		<div class="pagelist"><ul>{pagelist($page,$pagenum,3)}</ul></div>
            </div>
        </section>
    </article>
    {include file="mobile/foot.php"}

</body>
</html>