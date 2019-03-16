<?php if(!defined('IN_SDCMS')) exit;?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="renderer" content="webkit">
<title>管理首页</title>
<link rel="stylesheet" href="{WEB_ROOT}public/css/amazeui.min.css">
<link rel="stylesheet" href="{WEB_ROOT}public/admin/css/layout.css">
<script src="{WEB_ROOT}public/js/jquery.min.js"></script>
<script src="{WEB_ROOT}public/js/amazeui.min.js"></script>
<script src="{WEB_ROOT}public/layer/layer.js"></script>
<!--[if lt IE 9]>
<script src="{WEB_ROOT}public/js/html5shiv.js"></script>
<script src="{WEB_ROOT}public/js/respond.min.js"></script>
<![endif]-->
<base target="iframe_body">
</head>

<body>

    <div class="ui-north">
        <div class="logo"><img src="data:image/gif;base64,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"></div>
        <div class="user_base">{get_admin_info('penname')}<span class="am-icon-angle-down"></span>
            <ul>
                <li><a href="{U('pass')}">密码修改</a></li>
                <li><a href="{U('out')}" target="_parent">退出登录</a></li>
            </ul>
        </div>
        <div class="other_link">
            <ul>
                <li><a href="{WEB_ROOT}" target="_blank">预览网站</a></li>
                <li><a href="https://www.sdcms.cn" target="_blank">官方网站</a></li>
                <li><a href="javascript:;" class="bizcode">录入授权码</a></li>
            </ul>
        </div>
    </div>
    
    <div class="ui-body">
        <div class="ui-west">
            <ul class="accordion">
                <li class="active">
                    <div class="title"><a href="{THIS_LOCAL}" target="_parent">管理首页</a></div>
                </li>
                {sdcms:rp top="0" table="sd_admin_menu" where="islock=1 and followid=0 $where" order="ordnum,id"}
                {php $classid=$rp[id]}
                <li>
                    <div class="title"><a href="javascript:;">{$rp[title]}<span class="am-icon-chevron-right"></span></a></div>
                    <ul class="sub_nav">
                        {sdcms:rs top="0" table="sd_admin_menu" where="islock=1 and followid=$classid $where" order="ordnum,id"}
                        <li><a href="{get_admin_menu_url($rs[cname],$rs[aname],$rs[dname])}">{$rs[title]}</a></li>
                        {/sdcms:rs}
                    </ul>
                </li>
                {/sdcms:rp}
            </ul>

        </div>
        
        <div class="ui-center{if isipad()} ipad{/if}"></div>
    </div>

    <script>
    $(function(){
		{if $isbiz==0}
		layer.open({type:1,anim:4,skin:'layui-layer-lan',offset:'rb',title:'授权提示',content:'<div style="padding:30px;font-size:15px;line-height:30px;"><b style="color:#f30;">友情提示：</b>您的域名暂未授权。</div>',shade:0,btn:['录入授权码'],btnAlign:'c',success:function(layero) {
      var btn=layero.find('.layui-layer-btn');
      btn.css('text-align','center');
  },yes:function(index){layer.close(index);
		$(".bizcode").click();
		}});
		{/if}
		$(".bizcode").click(function(){
			layer.alert('<textarea id="bizcode" style="width:100%;height:200px;border:1px solid #ddd;padding:10px;">{C("BIZ_ID")}</textarea>',{title:'录入授权码',area:'650px',anim:4,skin:'layui-layer-lan',scrollbar:false,btn:['保存授权码','购买授权码'],success:function(layero) {
      var btn=layero.find('.layui-layer-btn');
      btn.css('text-align','center');
  },yes:function(){
				var code=$("#bizcode").val();
				if(code=='')
				{
					return layer.alert('请输入授权码',{title:'信息提示',yes:function(){
					$(".bizcode").click();}});
				}
				else
				{
					$.ajax({
						type:'post',
						cache:false,
						dataType:'json',
						url:'{THIS_LOCAL}',
						data:'code='+code,
						error:function(e){alert(e.responseText);},
						success:function(d)
						{
							layer.msg(d.msg);
							if(d.state=='success')
							{
								setTimeout(function(){location.href='{THIS_LOCAL}';},1500);
							}
						}
					})
				}
			},btn2:function(){
                window.open('https://www.sdcms.cn');
            }});
		});
		
        $(".user_base").hover(function(){
            $("ul",this).css("display","block");},
            function(){$("ul",this).css("display","none");
        });
        var Accordion=function(el,multiple)
        {
            this.el=el||{};
            this.multiple=multiple||false;
            var links=this.el.find('.title');
            links.on('click',{el:this.el,multiple:this.multiple},this.dropdown)
        }
        Accordion.prototype.dropdown = function(e)
        {
            var $el=e.data.el;
                $this=$(this),
                $next=$this.next();
                $next.slideToggle();
                $this.parent().toggleClass('active');
                $this.parent().siblings(".active").removeClass("active");
                if (!e.data.multiple)
                {
                    $el.find('.sub_nav').not($next).slideUp().parent().removeClass('open');
                };
        }
        var accordion = new Accordion($('.accordion'), false);
        $('.sub_nav li').bind('click', function(){
            $('.sub_nav li').removeClass('hover');
            $(this).addClass('hover');
        });
        $(".ui-center").html('<iframe name="iframe_body" src="{U('right')}" width="100%" height="100%" frameborder="0"></iframe>');
    })
    </script>
</body>
</html>