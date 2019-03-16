<?php if(!defined('IN_SDCMS')) exit;?>{if isweixin()&&C('weixin_appid')&&C('weixin_appsecret')}
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
wx.config({debug:false,appId:'{C('weixin_appid')}',timestamp:'{$timestamp}',nonceStr:'{$noncestr}',signature:'{$signature}',jsApiList:['onMenuShareTimeline','onMenuShareAppMessage','hideMenuItems']});
wx.ready(function()
{
    wx.onMenuShareTimeline({
        title:'{$share_title}',
        link:'{$share_link}',
        imgUrl:'{$share_imgurl}',
        success:function(){
            alert('已成功分享至朋友圈');
        }
    });
    wx.onMenuShareAppMessage({
        title:'{$share_title}',
        desc:'{$share_desc}',
        link:'{$share_link}',
        imgUrl:'{$share_imgurl}',
        type:'', 
        dataUrl:'', 
        success:function(){
            alert('已成功分享给朋友');
        }
    });
});
</script>
{/if}