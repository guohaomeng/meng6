<?php if(!defined('IN_SDCMS')) exit;?>{include file="mobile/top.php"}
<title>会员中心_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>
	{include file="mobile/head.php"}

    <article class="user_center">
    	{sdcms:rs top="1" table="sd_user left join sd_user_group on sd_user.uid=sd_user_group.gid" where="id=$userid"}
        <div class="user_info">
            <div class="face"><img src="{if strlen($rs[uface])}{$rs[uface]}{else}{WEB_ROOT}upfile/noface.gif{/if}" class="dropzone" id="uface" config="uface" url="{U('face','','',1)}" maxsize="{sdcms[upload_image_max]}" title="修改头像"></div>
            <div class="info">
                <p><span>{get_user_info('uname')}</span>{$welcome}</p>
            </div>
        </div>
        {/sdcms:rs}
        <div class="am-clear"></div>
    </article>
    
    <article class="user_nav">
        <ul class="am-list am-list-border">
        	{if C('bbs_open')==1}
			<li><a href="{U('home/bbs/mytopic','uid='.$userid.'')}"><i class="am-icon-pencil am-icon-fw am-margin-right"></i>我的主题</a></li>
            <li><a href="{U('home/bbs/myreply','uid='.$userid.'')}"><i class="am-icon-reply am-icon-fw am-margin-right"></i>我的帖子</a></li>
            {/if}
            <li><a href="{N('myorder')}"><i class="am-icon-shopping-bag am-icon-fw am-margin-right"></i>我的订单</a></li>
            <li><a href="{N('editemail')}"><i class="am-icon-envelope-o am-icon-fw am-margin-right"></i>修改邮箱</a></li>
            <li><a href="{N('editpass')}"><i class="am-icon-key am-icon-fw am-margin-right"></i>修改密码</a></li>
            <li><a href="{N('out')}"><i class="am-icon-sign-out am-icon-fw am-margin-right"></i>退出登录</a></li>
        </ul>
    </article>
    {include file="mobile/foot.php"}
    <link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
    <script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
    <script src="{WEB_ROOT}public/js/dropzone.js"></script>
    <script>
	toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$(".dropzone").dropzone(
	{
		maxFiles:1,
		acceptedFiles: ".jpg,.gif,.png",
		success:function(file,data,that)
		{
			data=jQuery.parseJSON(data);
			this.removeFile(file);
			if(data.state=="success")
			{
				toastr.success("上传成功");
				$("#"+$(that).attr("src",data.msg));
			}
			else
			{
				toastr.error("上传失败："+data.msg);
			}
		},
		error:function(file,msg)
		{
			toastr.error(msg);
		}
	});
	</script>

</body>
</html>