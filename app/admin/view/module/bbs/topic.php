<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>帖子管理</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/js/dropzone.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<script src="{WEB_ROOT}public/dialog/dialog-min.js"></script>
<script src="{WEB_ROOT}public/dialog/dialog-min.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：社区管理 > <a href="{U('index')}">主题管理</a> > <a href="{U('topic','bbsid='.$bbsid.'&type=0')}">帖子管理</a></div>
    <div class="border">
        <!---->
        <legend>帖子管理</legend>
        <div class="am-btn-group am-btn-group-sm am-btn-toolbar am-margin-left-xs">
            <a class="am-btn am-btn-{if $type==0}warning{else}default{/if} am-radius" href="{U('topic','bbsid='.$bbsid.'&type=0')}">全部</a>
            <a class="am-btn am-btn-{if $type==1}warning{else}default{/if} am-radius" href="{U('topic','bbsid='.$bbsid.'&type=1')}">未审</a>
            <a class="am-btn am-btn-{if $type==2}warning{else}default{/if} am-radius" href="{U('topic','bbsid='.$bbsid.'&type=2')}">已审</a>
        </div>
        <form action="{THIS_LOCAL}" class="am-form am-form-inline am-fr">
        <div class="am-form-group am-form-icon">
            <i class="am-icon-search"></i>
            <input type="text" name="keyword" class="am-form-field am-input-sm" value="{$keyword}" placeholder="请输入关键字">
        </div>
        <input type="submit" value="搜索" class="am-btn am-btn-warning am-radius am-text-sm">
        </form>
        {sdcms:rs pagesize="15" field="bbsid,uface,uname,createdate,sd_bbs_reply.islock,replyid,content,reply" table="sd_bbs_reply" join="left join sd_user on sd_bbs_reply.userid=sd_user.id" where="bbsid=$bbsid and istopic=0 $where" order="replyid desc" key="replyid"}
        <article class="am-comment am-margin-top">
        	<a ><img width="48" height="48" class="am-comment-avatar" src="{if strlen($rs[uface])}{$rs[uface]}{else}{WEB_ROOT}upfile/noface.gif{/if}"></a>
            <div class="am-comment-main">
                <header class="am-comment-hd">
                    <div class="am-comment-meta">
                        <a class="am-comment-author" href="#link-to-user">{$rs[uname]}</a> 发表于 <time>{date('Y-m-d H:i:s',$rs[createdate])}</time>　{if $rs[islock]==0}<span style="color:#f30;">【未审】</span>{/if}
                    </div>
                    <div class="am-comment-actions"><a href="{U('edittopic',"id=".$rs[replyid]."")}"><i class="am-icon-pencil"></i></a> <a href="javascript:;" class="del" data-id="{U('deltopic','id='.$rs[replyid].'')}"><i class="am-icon-close"></i></a></div>
                </header>
                <div class="am-comment-bd">
                    {$rs[content]}
                    {if $rs[reply]<>''}<blockquote>{$rs[reply]}</blockquote>{/if}
                </div>
            </div>
        </article>
        {/sdcms:rs}
        {if $total_rs!=0}
        <div class="am-padding-sm am-margin-top">
            <div class="pagelist"><ul>{$showpage}</ul></div>
            <div class="am-cf"></div>
        </div>
        {/if}
        <!---->
    </div>
<script>
$(function(){
    toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
	$(".del").click(function(){
        var url=$(this).attr("data-id");
        layer.confirm(
            '确定要删除？不可恢复！', 
            {
                btn: ['确定','取消']
            }, function()
            {
                $.ajax({
                    url:url,type:'post',dataType:'json',
                    success:function(d)
                    {
                        layer.closeAll();
                        if(d.state=='success')
                        {
                            toastr.success(d.msg);
                            setTimeout(function(){location.href='{THIS_LOCAL}';},1000);
                        }
                        else
                        {
                            toastr.error(d.msg);
                        }
                    }
                })
            }, function()
            {
               
            });
    });
	
})
</script>
</body>
</html>