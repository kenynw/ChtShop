<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/shequ.css" rel="stylesheet" type="text/css">
<style>
.save{width:100%;border-top:1px solid #c9c9c9;}
.save ul{width:1200px;margin:0 auto;}
.shai{width:830px;float:left;}
.shai .title span{background:none;padding:0;}
.shai li{height:290px;}
.shai .pic{float:none;text-align:left;}
.shai .pic img{margin-left:0;margin-right:10px;}
.shai .context{height:260px;}
.page li{height:36px;padding:0;}
</style>
<div class="shequ"></div>
<div class="mail">
<div class="huati">
<div class="shai">
<div class="title"><span>社区>茶趣分享</span></div>
<ul>
    <?php foreach($output['shareContents'] as $v) {?>
<li>
<div class="img"><img src="/data/upload/shop/avatar/<?php if($v['member_avatar']==null){ echo "nopic.jpg"; }else{ echo $v['member_avatar'];}  ?>"></div>
<div class="context">
<h3><a href="#"><?php echo $v['member_name']; ?></a><span>
        <?php
        $now=time();
        $oldTime=strtotime($v['time']);
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
        </span><span>来自iphone 6s </span></h3>
<p><?php echo $v['content']; ?></p>
<div class="pic"> <?php
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
<div class="share">
<a href=""><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/share.png"><?php echo $v['share'] ?></a>
<a href="<?php echo urlShop('tea_community','add_comments',array("conent_id"=>$v['content_id'])); ?>"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/bianji.png"><?php echo $v['comment'] ?></a>
<a href="<?php echo urlShop('tea_community','add_like',array("conent_id"=>$v['content_id']));?>"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/zan.png"><?php echo $v['view'] ?></a>
</div>
</div>
</li>
    <?php } ?>
</ul>
<div class="page">
<div class="num">
    <?php echo $output['page']; ?>
    <span class="tz">跳转到</span>
<input type="number" id="num"><input type="button" value="GO" id="btn"></div>
</div>
</div>
<div class="paihang">
<div class="p_t">
<span></span>社区排行
</div>
<ul>
    <?php if(isset($output['hotContents'])){
        foreach($output['hotContents'] as $key=>$v){
        ?>
<li <?php if($key==1) echo "class='on'"; ?>>
<div class="p_p"><p><?php echo $v['content']; ?><a href="#">更多></a></p></div>
<div class="p_h"><h3><a href="#"><?php echo $v['title']; ?></a></h3>
<p>话题主理人：<?php echo $v['member_name']; ?></p></div>
</li>
    <?php }} ?>
</ul>
</div>
</div>
</div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"1","bdPos":"right","bdTop":"183.5"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>