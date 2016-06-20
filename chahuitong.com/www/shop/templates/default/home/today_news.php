<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/class.css" rel="stylesheet">
<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/index.css" rel="stylesheet">
<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/shequ.css" rel="stylesheet">
<style>
    .save{width:100%;border-top:1px solid #c9c9c9;}
    .save ul{width:1200px;margin:0 auto;}
    .xinsheng .title span{background:none;padding:0;}
</style>
<div class="shequ"></div>
<div class="mail">
<div class="huati">
<div class="xinsheng">
<div class="title"><span>社区>今日新声</span></div>
<ul>
   <?php foreach($output['news'] as $key=>$v){ ?>

<li>
<span class="ul_<?php $class=($key==0)?"t":"d";echo $class; ?>"><?php
    $title=($key==0)? "今日新声":"往期话题";
    echo $title;
    ?></span><span><img src="/data/upload/qunzi/<?php
        $image=explode(",",$v['image']);
        echo $image[0];

        ?>"></span>
<div class="context">

<h3><a href="<?php echo urlShop('tea_community','news_detail',array("content_id"=>$v['content_id']));?>"><?php echo $v["title"]; ?></a><span class="right">话题主理人：茶汇通</span></h3>
<p style="height:80px;overflow:hidden;"> <a href="<?php echo urlShop('tea_community','news_detail',array("content_id"=>$v['content_id']));?>"><?php  echo $v["content"];  ?></a></p>
<div class="share">
<a href="<?php echo urlShop('tea_community','news_detail',array("content_id"=>$v['content_id']));?>"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/share.png"><?php echo $v['share']; ?></a>
<a href="<?php echo urlShop('tea_community','news_detail',array("content_id"=>$v['content_id']));?>"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/bianji.png"><?php echo $v['comment']; ?></a>
<a href="<?php echo urlShop('tea_community','news_detail',array("content_id"=>$v['content_id']));?>"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/zan.png"><?php echo $v['view']; ?></a>
</div>
</div>
</li>

    <?php } ?>
</ul>
<div class="page">
<div class="num">
    <?php echo $output["page"]; ?>
    <span class="tz">跳转到</span>
<input type="number" id="num"><input type="button" value="GO" id="btn"></div>
</div>
</div>
<div class="paihang">
<div class="p_t">
<span></span>社区排行
</div>
<ul>
    <?php  foreach($output['hotNews'] as $key=>$v) {?>
<li <?php  if($key==1) echo "class=on";  ?> >
<div class="p_p" style="height:110px;overflow:hidden"><p><?php echo $v['content']; ?><a href="<?php echo urlShop('tea_community','news_detail',array("content_id"=>$v['content_id']));?>">更多></a></p>
    <?php  if($key==1) echo '<img src="../images/hot.png">';  ?>
</div>
<div class="p_h"><h3><a href="<?php echo urlShop('tea_community','news_detail',array("content_id"=>$v['content_id']));?>"><?php  echo $v['title']; ?></a></h3>
<p>话题主理人：茶汇通</p></div>
</li>

    <?php } ?>
</ul>
</div>
</div>
</div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"1","bdPos":"right","bdTop":"183.5"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>