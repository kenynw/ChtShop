<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/index.css" rel="stylesheet">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/class.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/shequ.css" rel="stylesheet" type="text/css">
<div class="shequ"></div>
<div class="mail">
<div class="juju">
<div class="title">
<span>茶客聚聚</span><a href="<?php echo urlShop('tea_community','teaer_together');?>" class="right">更多></a>
</div>
<ul class="left">
<?php for($i=0;$i<2;$i++){ ?>
<li class="leftli">
<img src="/data/upload/qunzi/<?php $pics=explode(",",$output['actives'][$i]['pics']);echo $pics[0]; ?>">
<h3><a href="#"><?php echo $output['actives'][$i]["active_title"]; ?></a></h3>
<ul>
<li>行程天数:  <?php  echo floor(((strtotime($output['actives'][$i]['join_time'])-strtotime($output['actives'][$i]['last_time']))/(60*60*24)));

    ?>天</li>
<li><span class="on">时</span>间:<?php echo date("m/d",strtotime($output['actives'][$i]['join_time'])).'-'.date("m/d",strtotime($output['actives'][$i]['last_time']));  ?></li>
<li><span class="on">地</span>点:<?php echo $output['actives'][$i]['location']; ?></li>
<li><span class="on">状</span>态:即将出发</li>
<li><span class="on">费</span>用:<span class="color"><?php if($output['actives'][$i]['free']==0){ echo "免费"; }else{
            echo $output['actives'][$i]['free'];
        } ?></span></li>
</ul>
</li>
<?php } ?>
</ul>
<div class="huodong">
<ul>
    <?php for($i=2;$i<5;$i++){ ?>
<li><h3><?php  echo $output['actives'][$i]['active_title']; ?><a href="#">[详细]</a></h3>
<p><span class="on">时</span>间:<?php echo date("m/d",strtotime($output['actives'][$i]['join_time'])).'-'.date("m/d",strtotime($output['actives'][$i]['last_time']));  ?></p>
<p><span class="on">地</span>点:<?php echo $output['actives'][$i]['location'];  ?></p>
<p><span class="on">费</span>用：<span class="color"><span class="font">￥</span><?php echo $output['actives'][$i]['free']; ?></span></p>
<p class="text"><?php echo $output['actives'][$i]['content']; ?></p>
</li>
    <?php } ?>
</ul>
</div>
</div>
<div class="huati">
<div class="xinsheng">
<div class="title"><span>今日新声</span>
<a href="<?php echo urlShop('tea_community','today_news');?>" class="right">更多></a></div>
<ul>
<?php foreach($output['todayNews'] as $key=>$v) {?>
<li>
<span <?php if($key==0){ echo 'class="ul_t"'; }else{ echo 'class="ul_d"'; } ?>><?php if($key==0){echo "今日新声";}else{echo
    "往期话题";}

    ?></span><span><img width="150" height="150" src="/data/upload/qunzi/<?php $pics=explode(",",$v['image']);echo $pics[0]; ?>""></span>
<div class="context">
<h3><a href="#"><?php echo $v['content_title'] ; ?></a><span class="right">话题主理人：茶汇通</span></h3>
<p style="height:75px;overflow: hidden"><?php echo $v['content'] ; ?></p>
<div class="share">
<a href="<?php echo urlShop('tea_community','news_detail',array('content_id'=>$v['content_id']));?>"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/share.png"><?php echo $v['share'] ; ?></a>
<a href="<?php echo urlShop('tea_community','news_detail',array('content_id'=>$v['content_id']));?>"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/bianji.png"><?php echo $v['comment'] ; ?></a>
<a href="<?php echo urlShop('tea_community','news_detail',array('content_id'=>$v['content_id']));?>"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/zan.png"><?php echo $v['view'] ; ?></a>
</div>
</div>
</li>
 <?php } ?>
</ul>
</div>
<div class="lingxiu">
<div class="title">
<span>茶行领袖</span><a href="<?php echo urlShop('tea_community','tea_leaders');?>" class="right">更多></a>
</div>
<ul id="lingxiu">
 <?php foreach($output['members'] as $v) {?>
<li><a href="lingxiu.html"><img src="/data/upload/shop/avatar/<?php if($v['member_avatar']==null){ echo "nopic.jpg"; }else{ echo $v['member_avatar'];}  ?>"><p><?php echo $v['member_name']; ?><p><p><?php echo $v['rank']; ?></p></a></li>
 <?php } ?>
</ul>
</div>
</div>
<div class="shai">
<div class="title"><span>茶趣分享</span><a href="<?php echo urlShop('tea_community','tea_share');?>" class="right">更多></a></div>
<ul>
 <?php foreach($output['teaShare'] as $v){ ?>
<li>
<div class="img"><img src="/data/upload/shop/avatar/<?php if($v['member_avatar']==null){ echo "nopic.jpg"; }else{ echo $v['member_avatar'];}  ?>"></div>
<div class="context">
<h3><a href="#s"><?php echo $v['member_name']; ?></a><span>56分钟前</span><span>来自iphone 6s</span></h3>
<p><a href="<?php echo urlShop('tea_community','tea_share');?>"><?php  echo $v['content']; ?></a></p>
<div class="share">
<a href="<?php echo urlShop('tea_community','tea_share');?>"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/share.png"><?php echo $v['share']; ?></a>
<a href="<?php echo urlShop('tea_community','tea_share');?>"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/bianji.png"><?php echo $v['comment']; ?></a>
<a href="<?php echo urlShop('tea_community','tea_share');?>"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/zan.png"><?php echo $v['view']; ?></a>
</div>
</div>
<div class="pic">
    <?php
    if($v['image']==''){
        echo "<img src='/data/upload/qunzi/nopic.jpg'>";
    }else {
        $pics = explode(",", $v['image']);
        $length = (count($pics) > 3) ? 3 : count($pics);
        for ($i = 0; $i < $length; $i++) {
            echo "<img src='/data/upload/qunzi/{$pics[$i]}'>";
        }
    }
    ?></div>
</li>
 <?php } ?>
</ul>
</div>
</div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"1","bdPos":"right","bdTop":"183.5"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
