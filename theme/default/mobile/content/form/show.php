<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{if strlen($seotitle)>0}{$seotitle}_{/if}{$title}_{sdcms[web_name]}</title>
<meta name="keywords" content="{if strlen($seokey)>0}{$seokey}{else}{$title}{/if}">
<meta name="description" content="{if strlen($seodesc)>0}{$seodesc}{else}{$title}{/if}">
</head>

<body>
	{include file="mobile/head.php"}
    <article>
        
    	<section>
        	<div class="subject">
                <b>{$title}</b>
            </div>
            <div class="clear"></div>
            
            <div class="formshow">
                {foreach $field as $key=>$rs}
                <div class="item"><div class="lefter">{$key}：</div><div class="righter">{$rs}</div></div>
                {/foreach}
            </div>
            
        </section>
    </article>
    {include file="mobile/foot.php"}

</body>
</html>