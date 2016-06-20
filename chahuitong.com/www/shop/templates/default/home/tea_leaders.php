<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/class.css" rel="stylesheet">
<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/index.css" rel="stylesheet">
<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/shequ.css" rel="stylesheet">
<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/lingxiu.css" rel="stylesheet">
<div class="shequ"></div>
<div class="mail">
<div class="lx">
<div class="title"><span>社区>领袖榜单</span></div>
<div class="search">
<form action="<?php echo urlShop('tea_community','leader_search');?>" method="post">
<input type="text" name="member_name" id="text" placeholder="输入你要找的人">
<input type="submit" id="butn">
</form>
</div>

<ul class="bangdan">
    <?php  foreach($output['members'] as $v) {?>
<li>
<div class="bd_t">
<img src="/data/upload/shop/avatar/<?php if($v['member_avatar']==null){ echo "nopic.jpg"; }else{ echo $v['member_avatar'];}  ?>">
<h6><?php echo $v['member_name']; ?><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/n.png"></h6>
<span class="guanzhu"><?php echo $v['guanzhu'];   ?>关注</span>
<?php echo $v['rank']; ?>
<div class="cons">
<h6><a href="#"><?php echo $v['member_name']; ?></a></h6>
    <?php echo $v['rank']; ?>
</div>
</div>
<div class="gz_jia"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/guanzhu.png"><a href="<?php echo urlShop('tea_community','add_follow',array("member_id"=>$v['member_id'])); ?>">加关注</a></div>
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
<span></span>人气领袖
</div>
<ul class="renqi">
    <?php foreach($output['topTen'] as $key=>$v) {?>
<li>
<a href="#"><img src="/data/upload/shop/avatar/<?php if($v['member_avatar']==null){ echo "nopic.jpg"; }else{ echo $v['member_avatar'];}  ?>"><p><?php echo $v['member_name']; ?><img src="<?php echo SHOP_TEMPLATES_URL;?>/n.png"></p><p>中国茶学院院长</p></a>
<div <?php if($key<=2) echo "class='on'"; ?>><?php echo $v['rank']; ?>关注</div>
</li>
    <?php } ?>
</ul>
</div>
</div>
