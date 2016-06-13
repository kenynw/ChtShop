<script type="text/javascript" src="<?php echo SHOP_TEMPLATES_URL; ?>/js/jquery.min.js"></script>
<script>
  $(document).ready(function(){
      $(".jiaru  a").click(function(){
         var activeId=$(this).attr("id")
          $.ajax({
              url:"<?php echo urlShop('tea_community','active_join');?>",
              type:"POST",
              data:{active:activeId},
              dataType:"json",
              success:function(data){
                if(data.state==0){
                    window.location.href="<?php echo urlShop('login','index');?>&ref_url=%2Fshop%2Findex.php%3Fact%3Dtea_community%26op%3Dteaer_together"
                }else{
                    alert(data.msg);
                }
              }

          })
      })
  })
</script>
<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/index.css" rel="stylesheet">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/class.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/huodong.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/shequ.css" rel="stylesheet" type="text/css">
<style>
    .save{width:100%;border-top:1px solid #c9c9c9;}
    .save ul{width:1200px;margin:0 auto;}
</style>
<div class="shequ"></div>
<div class="mail">
<div class="huodong">
<ul>
  <?php if(isset($output['actives'])){ foreach($output['actives'] as $key=>$v){
      if($key%2==1){
      ?>
<li class="<?php echo $v["active_id"]; ?>">
<div class="left pics"><img src="/data/upload/qunzi/<?php $pics=explode(',',$v['pics']);echo $pics[0]; ?>"></div>
<div class="right body">
<h4><?php echo $v['active_title']; ?></h4>
<div class="texts">
<p><?php echo $v['content']; ?></p>
</div>
<p><span></span>活动人数：<?php echo $v['number']; ?>人</p>
<p><span></span>活动时间：<?php echo $v['last_time']; ?></p>
<p><span></span>活动地址：<?php echo $v['location']; ?></p>
<p><span></span>活动费用：<a>￥<?php echo $v['free']; ?></a></p>
<div class="jiaru">
<span class="left">
<a href="#"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/weibo.png"></a>|<a href="#"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/weixin.png"></a>|<a href="#"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/qzone.png"></a></span>
<a class="zt right" href="#" id="<?php echo $v["active_id"]; ?>">立即加入</a>
</div>
<div class="sanjiao" ></div>
</div>
</li>
    <?php }else{ ?>
<li class="<?php echo $v["active_id"]; ?>">
<div class="right pics"><img src="/data/upload/qunzi/<?php $pics=explode(',',$v['pics']);echo $pics[0]; ?>"></div>
<div class="left body">
    <h4><?php echo $v['active_title']; ?></h4>
    <div class="texts">
        <p><?php echo $v['content']; ?></p>

    </div>

    <p><span></span>活动人数：<?php echo $v['number']; ?>人</p>
    <p><span></span>活动时间：<?php echo $v['last_time']; ?></p>
    <p><span></span>活动地址：<?php echo $v['location']; ?></p>
    <p><span></span>活动费用：<a>￥<?php echo $v['free']; ?></a></p>
<div class="jiaru">
<span class="right">
<a href="#"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/weibo.png"></a>|<a href="#"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/weixin.png"></a>|<a href="#"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/qzone.png"></a></span>
<a class="zt left" href="#" id="<?php echo $v["active_id"]; ?>">立即加入</a>
</div>
<div class="sanjiao" ></div>
</div>
</li>
<?php } } } ?>
</ul>
</div>
    <div class="page">
        <div class="num">
<?php echo $output['page']; ?>
        </div><span class="tz">跳转到</span><input type="number" id="num"><input type="button" value="GO" id="btn">
    </div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"1","bdPos":"right","bdTop":"183.5"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>