$(function(){
	$('.am-back').click(function(){
		history.go(-1);
	});
	$(document).on("click",".imagelist .img-left",function(){
		var $li=$(this).parent().parent();
		var $pre=$li.prev("li");
		$pre.insertAfter($li)
	})
	$(document).on("click",".imagelist .img-right",function(){
		var $li=$(this).parent().parent();
		var $next=$li.next("li");
		$next.insertBefore($li);
	});
	$(document).on("click",".imagelist .img-del",function(){
		$(this).parent().parent().remove();
	});
	$(".fm-choose").click(function(){
		var name=$(this).attr("data-name");
		var url=$(this).attr("data-url");
		var type=$(this).attr("data-type");
		var multiple=$(this).attr("data-multiple");
		var placeholer=$(this).attr("data-replace");
		layer.open({
			type:2,
			title:'附件选择',
			skin:'layui-layer-lan',
			area:['80%','80%'],
			fixed:false,
			content:url,
			btn:['确定','取消'],
			yes:function(index,layero)
			{
				var data=layero.find('iframe').contents().find("#piclist").val();
				if(data=='')
				{
					layer.msg('请至少选择一个文件',{'icon':5});
					return false;
				}
				else
				{
					if(multiple==0)
					{
						$("#"+name).val(data);
						if(placeholer!='undefined')
						{
							$("."+placeholer).html('<img src='+data+'>');
						}
					}
					else
					{
						var pic=data.split("|");
						for(i=0;i<pic.length;i++)
						{
							var url=pic[i];
							var num=1;
							$("#list_"+name+" li").each(function()
							{
								var maxnum=parseInt($(this).attr("num"));
								if (maxnum>=num)
								{
									num=maxnum+1;
								}
							});
							var html='';
							html+='<li num="'+num+'">';
							html+='	<div class="preview">';
							html+='		<input type="hidden" name="'+name+'['+num+'][image]" value="'+url+'">';
							html+='		<img src="'+url+'" />';
							html+='	</div>';
							html+='	<div class="intro">';
							html+='		<textarea name="'+name+'['+num+'][desc]" placeholder="图片描述..."></textarea>';
							html+='	</div>';
							html+='	<div class="action"><a href="javascript:;" class="img-left"><i class="am-icon-angle-double-left am-icon-fw"></i>左移</a><a href="javascript:;" class="img-right"><i class="am-icon-angle-double-right am-icon-fw"></i>右移</a><a href="javascript:;" class="img-del"><i class="am-icon-close am-icon-fw"></i>删除</a></div>';
							html+='</li>';
							$("#list_"+name).append(html);
						}
						
					}
					layer.closeAll();
				}
			}
		});
	});
	$(".fm-choose-ad").click(function(){
		var name=$(this).attr("data-name");
		var url=$(this).attr("data-url");
		var type=$(this).attr("data-type");
		var multiple=$(this).attr("data-multiple");
		layer.open({
			type:2,
			title:'附件选择',
			skin:'layui-layer-lan',
			area:['80%','80%'],
			fixed:false,
			content:url,
			btn:['确定','取消'],
			yes:function(index,layero)
			{
				var data=layero.find('iframe').contents().find("#piclist").val();
				if(data=='')
				{
					layer.msg('请至少选择一个文件',{'icon':5});
					return false;
				}
				else
				{
					if(multiple==0)
					{
						$("#"+name).val(data);
						if(placeholer!='undefined')
						{
							$("."+placeholer).html('<img src='+data+'>');
						}
					}
					else
					{
						var pic=data.split("|");
						for(i=0;i<pic.length;i++)
						{
							var url=pic[i];
							var num=1;
							$("#list_"+name+" li").each(function()
							{
								var maxnum=parseInt($(this).attr("num"));
								if(maxnum>=num)
								{
									num=maxnum+1;
								}
							});
							var html='';
							html+='<li num="'+num+'">';
							html+='	<div class="preview">';
							html+='		<input type="hidden" name="'+name+'['+num+'][image]" value="'+url+'">';
							html+='		<img src="'+url+'" />';
							html+='	</div>';
							html+='	<div class="intro">';
							html+='		<textarea name="'+name+'['+num+'][desc]" placeholder="请输入描述..."></textarea>';
							html+='	</div>';
							html+='	<div class="intro">';
							html+='		<textarea name="'+name+'['+num+'][url]" placeholder="请输入链接网址..."></textarea>';
							html+='	</div>';
							html+='	<div class="action"><a href="javascript:;" class="img-left"><i class="am-icon-angle-double-left am-icon-fw"></i>左移</a><a href="javascript:;" class="img-right"><i class="am-icon-angle-double-right am-icon-fw"></i>右移</a><a href="javascript:;" class="img-del"><i class="am-icon-close am-icon-fw"></i>删除</a></div>';
							html+='</li>';
							$("#list_"+name).append(html);
						}
					}
					layer.closeAll();
				}
			}
		});
	});
	$(".template").click(function(){
		var name=$(this).attr("data-name");
		var url=$(this).attr("data-url");
		var d=dialog({
			title:'模板选择',
			content:'<iframe id="treedata" src="'+url+'" scrolling="auto" frameborder="0" width="650" height="350"></iframe>',
			ok:function()
			{
				var val=$('#go',document.getElementById('treedata').contentWindow.document).val();
				if(val=='')
				{
					toastr.error('请选择模板');
					return false;
				}
				else
				{
					$("#"+name).val(val);
					d.remove();
					d.close();
				}
				return false;
			},
			okValue:'确定',
		}).showModal();
	});
	$(".pic-preview").click(function(){
		var name=$(this).attr("data-name");
		if($("#"+name).val()=='')
		{
			toastr.error("没有图片可预览");
		}
		else
		{
			layer.open({
			type:1,
			title:false,
			closeBtn:0,
			shadeClose:true,
			content:'<img src="'+$("#"+name).val()+'" style="max-width:360px;">'
			});
		}
	});
	$("#select_master").click(function(){
		var config=$(this).attr("data-name");
		var url=$(this).attr("data-url");
		dialog({
			title:"素材选择",
			content:"<iframe src='"+url+"' width='950' height='500' frameborder='0' id='masterlist'></iframe>",
			padding:'10px',
			ok:function(){
				var id=$('#filelist',document.getElementById('masterlist').contentWindow.document).html();
				var html=$('#master_box',document.getElementById('masterlist').contentWindow.document).html();
				if(id!=null)
				{
					$("input[name="+config+"]").attr("value",id);
					$(".master_box").html(html);
					
				}
				},
			okValue:'确定',
			}).showModal();
	});
	$(".editor_savepic").click(function(){
		var name=$(this).attr("data-name");
		var url=$(this).attr("data-url");
		var ue=UE.getEditor(name);
		var data=ue.getContent();
		var that=this;
		$(this).val("处理中...");
		$.ajax({
			url:url,
			type:"post",
			data:"content="+encodeURIComponent(data),
			error:function(){alert(e.responseText)},
			success:function(d)
			{
				console.log(d);
				ue.setContent(d);
				$(that).val("处理完成");
				setTimeout(function(){$(that).val("保存编辑器中外部图片")},3000)
			}
		});
	});
	$(".fm-tags").click(function(){
		var name=$(this).attr("data-name");
		var url=$(this).attr("data-url");
		layer.open({
			type:2,
			title:'标签选择',
			skin:'layui-layer-lan',
			area:['60%','65%'],
			fixed:false,
			content:url,
			btn:['确定','取消'],
			yes:function(index,layero)
			{
				var data=layero.find('iframe').contents().find("#taglist").val();
				if(data=='')
				{
					layer.msg('请至少选择一个标签',{'icon':5});
					return false;
				}
				else
				{
					var tags=data.split(",");
					for(i=0;i<tags.length;i++)
					{
						$("#"+name).tagsinput('add',tags[i]);
					}
					layer.closeAll();
				}
			}
		});
	});
})

//全选取消
function checkall(form)
{
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.Name!="chkall")
       e.checked=form.chkall.checked;
    }
}

function ueditorimage(editor,url)
{
	layer.open({
		type:2,
		title:'附件选择',
		skin:'layui-layer-lan',
		area:['80%','80%'],
		fixed:false,
		content:url,
		btn:['确定','取消'],
		yes:function(index,layero)
		{
			var data=layero.find('iframe').contents().find("#piclist").val();
			editor.focus();
			if(data!='')
			{
				var html='';
				var pic=data.split("|");
				for(i=0;i<pic.length;i++)
				{
					var type=pic[i].substr(pic[i].lastIndexOf('.') + 1);
					var name=pic[i].substr(pic[i].lastIndexOf('/') + 1);
					if("png|jpg|jpeg|gif|bmp".indexOf(type)!=-1)
					{
						html+='<img src="'+pic[i]+'">';
					}
					else if("mp4".indexOf(type)!=-1)
					{
						html+='<video width="550" height="400" src="'+pic[i]+'" controls="controls"></video>';
					}
					else
					{
						html+='<a href="'+pic[i]+'" target="_blank">'+name+'</a>';
					}
				}
				editor.execCommand('inserthtml',html);
			}
			layer.closeAll();
		}
	});
}