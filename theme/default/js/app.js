$(function(){
	//内页菜单
	var sname="";
	$("#subnav li").hover(function(){
		sname=$(this).attr("class");
		if(!sname){
			$(this).addClass("hover");
		}
		$("dl",this).show();
	},function(){
		$("dl",this).hide();
		if(!sname){
			$(this).removeClass("hover");
		}
	});
	//链接滚动
	if($("#link").length>0)
	{
		$('#link').liMarquee({runshort:false});
	}
	//赞一下、踩一下
	if($(".digs").length>0)
	{
		$(".digs").click(function()
		{
			var url=$(this).attr("data-url");
			var that=this;
			$.ajax({
				   type:"post",
				   url:url,
				   dataType:"json",
				   error:function(){alert("服务器错误")},
				   success:function(d)
				   {
					   if(d.state=='success')
					   {
						   $(that).find("em").html(d.msg);
					   }
					   else
					   {
						   alert(d.msg)
					   }
				   }
			})
			
		});
	}
	//产品组图点击
	if($(".thumb_pic").length>0&&$("#zoom_pic").length>0)
	{
		$(".thumb_pic ul li").click(function()
		{
			var src=$(this).find("img").attr("data-url");
			var alt=$(this).find("img").attr("alt");
			$("#zoom_pic img").attr("src",src);
			$("#zoom_pic img").attr("alt",alt);
			$(this).siblings().removeClass('hover').end().addClass('hover');
		})	
	}
	//付款方式
	if($("#orderpay").length>0)
	{
		$("#orderpay li").click(function()
		{
			var config=$(this).find("img").attr("data-config");
			$("#payway").val(config);
			$(this).siblings().removeClass('active').end().addClass('active');
		})	
	}
	//返回顶部
	var top=$("#backtop");
	$(window).scroll(function()
	{
		if($(window).scrollTop()>150)
		{
			top.slideDown();
		}
		else
		{
			top.slideUp();
		}
	});

})

function setTab(name,cursel,n){
	for(i=1;i<=n;i++){
		var menu=$('#'+name+i);
		var con=$("#con_"+name+"_"+i);
		menu[0].className=i==cursel?"hover":"";
		con[0].style.display=i==cursel?"block":"none";
	}
}