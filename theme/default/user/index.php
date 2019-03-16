<?php if(!defined('IN_SDCMS')) exit;?>{include file="top.php"}
<title>会员中心_{sdcms[web_name]}</title>
<meta name="keywords" content="{sdcms[seo_key]}">
<meta name="description" content="{sdcms[seo_desc]}">
</head>

<body>

    {include file="head.php"}
    
    <div class="bg_inner am-animation-scale-up am-animation-delay-1">
        <div class="width banner_inner">
            <div class="left">
                <ul>
                    <li class="hover"><a>会员中心</a></li>
                </ul>
            </div>
        	<div class="right"><span class="am-icon-phone am-icon-fw"></span>{sdcms[ct_tel]}{block("inner_text")}</div>
        </div>
    </div>
    
    <div class="width inner_container am-animation-slide-bottom am-animation-delay-1">
        <ol class="am-breadcrumb am-breadcrumb-slash am-animation-slide-top am-animation-delay-1">
            <li><a href="{WEB_ROOT}" class="am-icon-home">首页</a></li>
            <li class="am-active">会员中心</li>
        </ol>
        <div class="user_center">
            <div class="lefter">
            	{include file="user/nav.php"}
            </div>
            <div class="righter">
            	
                <div class="subject m20 am-animation-slide-bottom">
                    <b>个人中心</b>
                </div>
                <div class="user_info">
                	{sdcms:rs top="1" table="sd_user left join sd_user_group on sd_user.uid=sd_user_group.gid" where="id=$userid"}
                    <div class="face"><img src="{if strlen($rs[uface])}{$rs[uface]}{else}{WEB_ROOT}upfile/noface.gif{/if}" width="120" height="120" class="dropzone" id="uface" config="uface" url="{U('face','','',1)}" maxsize="{sdcms[upload_image_max]}"></div>
                    <div class="info">
                        <p><span>{get_user_info('uname')}</span>　{$welcome}</p>
                        <ul>
                            <li><em>级别：</em>{$rs[gname]}</li>
                            <li><em>登录：</em><span>{$rs[logintimes]}</span> 次</li>
                            <li><em>邮箱：</em>{$rs[uemail]}</li>
                        </ul>
                    </div>
                    {/sdcms:rs}
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        
    </div>
    
    {include file="foot.php"}
    <link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
    <script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
    <script src="{WEB_ROOT}public/js/dropzone.js"></script>
    <script>
	toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$(".dropzone").dropzone(
	{
		maxFiles: 1,
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