<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/class.css" rel="stylesheet">
<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/zixun.css" rel="stylesheet">
<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/lingxiu.css" rel="stylesheet">
<style>
    .mail{margin-top:30px;}
    .text{background:#efefef;padding:0 15px;}
    form{padding:20px;}
    form textarea{width:590px;height:115px;float:left;padding:20px 10px 5px 100px;}
    form input{background:#1b8b80 url(img/shequ/fabiao.png) no-repeat center;width:55px;height:142px;border:none;}
    .xq .text{padding-bottom:182px;}
    .xq .text img{width:236px;height:134px;float:left;margin-right:3%;}
</style>
<div class="mail">
<div class="contexter xq">
<h1><?php echo $output['detail']['title']; ?></h1>
<div class="text">
<p><?php echo $output['detail']['content']; ?></p>
    <?php $images=explode(',',$output['detail']['image']); foreach($images as $value){?>
<img src="/data/upload/qunzi/<?php echo $value; ?>">
    <?php } ?>
</div>
    <br style="clear:both">
<div id="img"><img src=""></div>
<div class="sharer" id="share">
<a href="#"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/share.png"><?php echo $output['detail']['share']; ?></a>
<a class="alink" href="#"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/bianji.png"><?php echo $output['detail']['comment']; ?></a>
<a href="<?php echo urlShop('tea_community','add_like',array('content_id'=>$output['detail']['content_id']));?>"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/zan.png"><?php echo $output['detail']['view']; ?></a>
</div>
<div class="huifu">
<div class="sanjiao" style="left:358px;"></div>
<form action="<?php echo urlShop('tea_community','add_comments');?>" method="post">
<textarea name="comments" style="background:url(img/shequ/lx05.png) no-repeat;background-size:64px 64px;background-position:16px 16px" placeholder="输入你想说的话。"></textarea>
 <input type="hidden" name="content_id" value="<?php echo $output['detail']['content_id']; ?>">
<input class="fabiao" type="submit" value=" ">

</form>
<ul class="huifu_l">
    <?php foreach($output['comments'] as $v) {?>
<li>
<div class="huifu_i"><img src="<?php if($v['member_avatar']){

        echo $v['member_avatar'];
    }else{
        echo "nopic.jpg";
    }

    ?>"></div>
<div class="huifu_t">
<h4><?php echo $v['member_name']; ?>
    <span class="timer">
        <?php
        $now=time();
        $oldTime=strtotime($v['comment_time']);
        $spacing=$now-$oldTime;
        switch($spacing){
            case $spacing>(60*60*60*365):
                echo floor($spacing/(60*60*60*365))."年前";
                break;
            case $spacing>(60*60*60*30):
                echo floor($spacing/(60*60*60*30))."个月前";
                break;
            case $spacing>(60*60*60*7):
                echo floor($spacing/(60*60*60*7))."周前";
                break;
            case $spacing>(60*60*60):
                echo floor($spacing/(60*60*60))."天前";
                break;
            case $spacing>(60*60):
                echo floor($spacing/(60*60))."小时前";
                break;
            case $spacing>60:
                echo floor($spacing/60)."分前";
                break;
            case $spacing<60:
                echo $spacing."秒前";
                break;
        }

        ?>
    </span>
</h4>
<p><?php echo $v['comment']; ?></p>
</div>
</li>
    <?php } ?>
</ul>
</div>
<div id="sharer" style="display:none;"><div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script></div>
</div>
<div class="tuijian">
<div class="title">
<span>热文</span><a class="right" href="<?php echo urlShop('tea_community','today_news');?>">更多></a>
</div>
 <?php foreach ($output['hotNews'] as $key=>$v) {
  if($key==0){
 ?>
<div class="rewen">
<h3><a href="<?php echo urlShop('tea_community','news_detail',array("content_id"=>$v['content_id']));?>"><?php echo $v['title']; ?></a></h3>
<img src="/data/upload/qunzi/<?php $img=explode(',',$v['image']);echo $img[0]; ?>">
<p><?php echo $v['content']; ?>......</p></div>
    <?php }else{ ?>
    <ul class="r_ul">
<li><a href="<?php echo urlShop('tea_community','news_detail',array("content_id"=>$v['content_id']));?>"><?php echo $v['title']; ?></a></li>
 <?php }} ?>
</ul>
</div>
</div>

<script>
    (function(){
        if(!document.getElementsByClassName){
            document.getElementsByClassName = function(className){
                var childs = document.getElementsByTagName('*');
                var e = new Array();
                for(var i = 0;i < childs.length;i++){
                    var classN = childs[i].getAttribute('class');
                    if(classN == className){
                        e.push(childs[i]);
                    }
                }
                return e;
            };
        }
        var alink = document.getElementsByClassName('alink');
        for(var i = 0;i < alink.length;i++){
            huifu(alink[i]);
        }
        function huifu(obj){
            obj.onclick = function(e){
                if(ifIe()){e.preventDefault();}
                else{window.event.returnValue = false;}
                var a = obj.parentNode;
                var b = get_nextSibling(a);
                if(b.getAttribute('name') == 'open'){
                    b.removeAttribute('name');
                    b.style.display = 'none';
                }else{
                    b.setAttribute('name','open');
                    b.style.display = 'block';
                }
            }
        }
        function get_nextSibling(n){
            var x = n.nextSibling;
            if(x && x.nodeType != 1){
                x = x.nextSibling;
            }
            return x;
        }
        function ifIe(){
            if(window.navigator.userAgent.indexOf("IE") == -1){
                return true;
            }else{
                return false;//ie
            }
        }
        var img = document.getElementById('img');
        var textImg = document.getElementsByClassName('text')[0].getElementsByTagName('img');
        var num = Math.ceil(textImg.length/3);
        document.getElementsByClassName('text')[0].style.paddingBottom = num * 172 + 'px';
        for(var i = 0;i < textImg.length;i++){
            imgClick(textImg[i]);
        }
        function imgClick(obj){
            obj.onclick = function(){
                img.getElementsByTagName('img')[0].src = obj.src;
                img.style.display = 'block';
            }
        }
        img.onclick = function(){
            img.style.display = 'none';
        }
		var share = document.getElementById('share');
		var sharer = document.getElementById('sharer');
		var j = 0;
		share.getElementsByTagName('a')[0].onclick = function(e){
			if(ifIe()){e.preventDefault();}
            else{window.event.returnValue = false;}
			if(j%2 == 0){
				sharer.style.display = 'block';
			}else{
				sharer.style.display = 'none';
			}
			j++;
		}
    })();
</script>