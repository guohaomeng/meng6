<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>主题管理</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/toastr.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<script src="{WEB_ROOT}public/admin/js/base.js"></script>
<script src="{WEB_ROOT}public/admin/js/toastr.min.js"></script>
<script src="{WEB_ROOT}public/validator/jquery.validator.min.js?local=zh-CN"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="position">当前位置：社区管理 > <a href="{THIS_LOCAL}">主题管理</a></div>
    <div class="border">
        <!---->
        <div class="am-btn-group">
            <a class="am-btn am-btn-secondary am-radius am-text-sm"><span class="am-icon-files-o am-margin-right-sm"></span>批量操作</a>
            <div class="am-dropdown" data-am-dropdown>
                <button class="am-btn am-btn-secondary am-dropdown-toggle am-text-sm" data-am-dropdown-toggle> <span class="am-icon-caret-down"></span></button>
                <ul class="am-dropdown-content">
                    <li><a href="javascript:;" class="btach" type="1">通过审核</a></li>
                    <li><a href="javascript:;" class="btach" type="2">取消审核</a></li>
                    <li class="am-divider"></li>
                    <li><a href="javascript:;" class="btach" type="3">设为置顶</a></li>
                    <li><a href="javascript:;" class="btach" type="4">取消置顶</a></li>
                    <li class="am-divider"></li>
                    <li><a href="javascript:;" class="btach" type="5">设为精华</a></li>
                    <li><a href="javascript:;" class="btach" type="6">取消精华</a></li>
                    <li class="am-divider"></li>
                </ul>
            </div>
        </div>
        <div class="am-btn-group am-btn-group-sm am-btn-toolbar am-margin-left-xs">
            <a class="am-btn am-btn-{if $type==0}warning{else}default{/if} am-radius" href="{U('index','type=0')}">全部</a>
            <a class="am-btn am-btn-{if $type==1}warning{else}default{/if} am-radius" href="{U('index','type=1')}">未审</a>
            <a class="am-btn am-btn-{if $type==2}warning{else}default{/if} am-radius" href="{U('index','type=2')}">已审</a>
            <a class="am-btn am-btn-{if $type==3}warning{else}default{/if} am-radius" href="{U('index','type=3')}">精华</a>
            <a class="am-btn am-btn-{if $type==4}warning{else}default{/if} am-radius" href="{U('index','type=4')}">置顶</a>
        </div>
        <form action="{THIS_LOCAL}" class="am-form am-form-inline am-fr">
        <div class="am-form-group am-form-icon">
            <i class="am-icon-search"></i>
            <input type="text" name="keyword" class="am-form-field am-input-sm" value="{$keyword}" placeholder="请输入关键字">
        </div>
        <input type="submit" value="搜索" class="am-btn am-btn-warning am-radius am-text-sm">
        </form>
        <form method="post" id="form_name">
        <table class="am-table am-table-hover am-margin-top">
            <thead>
                <tr>
                	<th width="30" height="30"><input type="checkbox" name="chkall" onClick="checkall(this.form)" title="全选/取消" style="width:auto;" /></th>
                    <th width="80">ID</th>
                    <th>标题</th>
                    <th width="180">用户名</th>
                    <th width="180">发帖日期</th>
                    <th width="80">回复</th>
                    <th width="80">人气</th>
                    <th width="60">精华</th>
                    <th width="60">置顶</th>
                    <th width="80">待审帖子</th>
                    <th width="80">状态</th>
                    <th width="210">操作</th>
                </tr>
            </thead>
            <tbody>
            {sdcms:rs pagesize="20" field="bbs_id,title,uface,userid,uname,replynum,createdate,hits,isnice,ontop,sd_bbs.islock,(select count(1) from sd_bbs_reply where bbsid=bbs_id and islock=0) as locknum" table="sd_bbs" join="left join sd_user on sd_bbs.userid=sd_user.id" where="$where" order="ontop desc,bbs_id desc" key="bbs_id"}
            {rs:eof}
            <tr>
                <td colspan="12">暂无资料</td>
            </tr>
            {/rs:eof}
            <tr>
            	<td><input type="checkbox" name="id" value="{$rs[bbs_id]}" style="width:auto;margin-top:8px;"></td>
                <td>{$rs[bbs_id]}</td>
                <td>{$rs[title]}</td>
                <td><a href="{if strlen($rs[uface])}{$rs[uface]}{else}{WEB_ROOT}upfile/noface.gif{/if}" target="_blank"><img src="{if strlen($rs[uface])}{$rs[uface]}{else}{WEB_ROOT}upfile/noface.gif{/if}" width="40" class="am-margin-right"></a><a href="{U('user/gouser',"id=".$rs[userid]."")}" target="_blank">{$rs[uname]}</a></td>
                <td>{date('Y-m-d H:i:s',$rs[createdate])}</td>
                <td>{$rs[replynum]}</td>
                <td>{$rs[hits]}</td>
                <td>{iif($rs[isnice]==1,'是','<em>否</em>')}</td>
                <td>{iif($rs[ontop]==1,'是','<em>否</em>')}</td>
                <td>{$rs[locknum]}</td>
                <td>{iif($rs[islock]==1,'启用','<em>锁定</em>')}</td>
                <td><a href="{U('topic',"bbsid=".$rs[bbs_id]."")}"><span class="am-icon-navicon"></span> 帖子管理</a>　<a href="{U('edit',"id=".$rs[bbs_id]."")}"><span class="am-icon-edit"></span> 编辑</a>　<a href="javascript:;" class="del" rel="{U('del','id='.$rs[bbs_id].'')}"><span class="am-icon-trash"></span> 删除</a></td>
            </tr>
            {/sdcms:rs}
        </table>
        {if $total_rs!=0}
        <div class="am-padding-sm border-top">
            <div class="pagelist"><ul>{$showpage}</ul></div>
            <div class="am-cf"></div>
        </div>
        {/if}
        </form>
        <!---->
    </div>

<script>
$(function(){
    toastr.options={"positionClass":"toast-top-center","timeOut":"3000","onclick":null,showMethod:"slideDown",hideMethod:"slideUp"};
    $(".btach").click(function(){
		var type=$(this).attr("type");
		var list="";
		$($("input[name='id']:checked")).each(function(){
			if(list==""){list+=this.value}else{list+=","+this.value}                   
		}); 
		if(list=="")
		{
			toastr.error('至少选择一条内容');
		}
		else
		{
			$.AMUI.progress.inc();
			$.ajax({
				type:'get',
				cache:false,
				dataType:'json',
				url:'{U("btach")}{iif(sdcms[url_mode]==1,"&","?")}id='+list+'&type='+type,
				data:"",
				error:function(e){alert(e.responseText);},
				success:function(d){
					$.AMUI.progress.set(1.0);
                    if(d.state=='success')
                    {
                        toastr.success(d.msg);
                        setTimeout(function(){location.href='{THIS_LOCAL}';},1500);
                    }
                    else
                    {
                        toastr.error(d.msg);
                    }
				}
			})
		}
	});
	$(".del").click(function(){
        var url=$(this).attr("rel");
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
