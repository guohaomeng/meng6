<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>{$title}_{sdcms[web_name]}</title>
<meta name="keywords" content="{if strlen($seokey)>0}{$seokey}{else}{$title}{/if}">
<meta name="description" content="{if strlen($seodesc)>0}{$seodesc}{else}{$title}{/if}">
</head>

<body>
	{include file="mobile/head.php"}
    <article>
    	<section>
            <div class="news_show">
                <h1>{$title}</h1>
                <div class="info">微信号：{sdcms[weixin_id]}</div>
                <div class="intro">
                    {$content}
                    <div class="clear"></div>
                </div>
            </div>
        </section>
        

        <section>
        	<div class="subject">
                <b>关注我们</b>
            </div>
            <div class="clear"></div>
            <div class="news_show">
                <div class="intro">
                    <img src="{sdcms[weixin_qrcode]}" width="100%">
                </div>
            </div>
        </section>
    </article>
    {include file="mobile/foot.php"}

</body>
</html>