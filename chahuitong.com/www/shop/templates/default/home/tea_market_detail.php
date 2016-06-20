<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/chashixq.css" rel="stylesheet">
<div class="chashi"></div>
<div class="mail">
<div class="xq">
<div class="xq_t">
<div class="xq_img">
<ul id="img">
    <?php $pic=$output['content'][0]['depic']; $pics=explode(",",$pic);foreach($pics as $v) {?>
<li><img src="<?php echo "/mobile/app/b2b/Public/upload/$v"; ?>"></li>
    <?php } ?>
</ul>
<ul id="ulLi"></ul>
</div>
<div class="xq_text">
<h4><?php echo $output['content'][0]['name']; ?></h4>
<P>品牌：<?php echo $output['content'][0]['brand']; ?></P>
<p>品名：<?php echo $output['content'][0]['name']; ?></p>
<p>年份：<?php echo $output['content'][0]['year']; ?></p>
<p>净含量：<?php echo $output['content'][0]['weight']; ?></p>
<p>所在地：<?php echo $output['content'][0]['localtion']; ?></p>
<p>供应数量：<?php echo $output['content'][0]['number']; ?></p>
<p>发布时间：<?php echo $output['content'][0]['addtime']; ?></p>
<div>
<a href="#">在线联系</a>
<p>发布价<span>￥<?php echo $output['content'][0]['price']; ?></span></p>
<span class="tel">联系电话：<?php echo $output['content'][0]['phone']; ?></span>
</div>
</div>
</div>
<div class="miaoshu">
<div>产品详情</div>
<?php echo $output['content'][0]['content']; ?>
</div>
</div>
<div class="hot">
<div><img src="<?php echo SHOP_TEMPLATES_URL;?>/hot.png">热门供应</div>
<ul>
    <?php foreach($output['hotProducts'] as $v) {?>
<li><a href="<?php echo urlShop('tea_market','tea_market_detail',array('content_id'=>$v['id']));?>"><img src="<?php echo "/mobile/app/b2b/Public/upload/".$v['pic']; ?>"><p><?php echo $v['name'];?></p></a></li>
    <?php } ?>
</ul>
</div>
</div>

<script src="<?php echo SHOP_TEMPLATES_URL;?>/js/move.js"></script>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/js/chashixq.js"></script>
