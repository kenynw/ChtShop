<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/chashi.css" rel="stylesheet">
<div class="chashi"></div>
<div class="mail">
<div class="mai">
<a href="<?php echo urlShop('tea_market','index',array('sale_way'=>1));?>">
<div id="sale" style="background:url('./templates/default/images/sale0<?php if($output['saleWay']==1){echo 1;}else{echo 2;}?>.png') no-repeat">
    <p>共享一款稀有好茶，</p>
<p>结识可遇不可求的茶客。</p>
</div>
</a>
<a href="<?php echo urlShop('tea_market','index',array('sale_way'=>2));?>">
<div id="buy" style="background:url('./templates/default/images/buy0<?php if($output['saleWay']==1){echo 2;}else{echo 1;}?>.png') no-repeat;">
<p>寻求一款有心做的好茶，</p>
<p>不可多得的稀世珍宝。</p>
</div>
</a>
</div>
<div class="context">
<div id="paixu">
<span>综合排序</span>
<span id="time">发布时间<img src="<?php echo SHOP_TEMPLATES_URL;?>/images/xia.png"></span>
<span id="brand">品牌<img src="<?php echo SHOP_TEMPLATES_URL;?>/images/xia.png"></span>
<span id="chandi">产地<img src="<?php echo SHOP_TEMPLATES_URL;?>/images/xia.png"></span>
<span id="jiage">价格<img src="<?php echo SHOP_TEMPLATES_URL;?>/images/xia.png"></span>
<span id="leixing">类型<img src="<?php echo SHOP_TEMPLATES_URL;?>/images/xia.png"><select size="7">
<option>普洱茶</option><option>乌龙茶</option><option>红茶</option>
<option>绿茶</option><option>黑茶</option><option>花茶</option><option>白茶</option>
</select></span>
<span id="year">年份<img src="<?php echo SHOP_TEMPLATES_URL;?>/images/xia.png"></span>
</div>
<ul id="list">
<?php if(isset($output['teas'])){ foreach($output['teas'] as $v){?>
<li>
    <a href="<?php echo urlShop('tea_market','tea_market_detail',array('content_id'=>$v['id']));?>">
<span class="pic"><img src="/mobile/app/b2b/Public/upload/<?php  echo $v['pic']; ?>"></span>
<span class="time"><?php echo date("Y-m",strtotime($v["addtime"])); ?></span>
<span class="brand"><?php echo $v["name"]; ?></span>
<span class="chandi"><?php  if($v["address"]){echo $v["address"];}else{echo "未设置";} ?></span>
<span class="jiage"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/m.png"><?php if($v["price"]){echo $v["price"];}else{ echo "未设置";} ?></span>
<span class="leixing" style="display:block;overflow:hidden"><?php  if($v["brand"]){ echo $v["brand"];}else{ echo "未设置";} ?></span>
<span class="year"><?php if($v["year"]){echo $v["year"];}else{echo "未设置";} ?>年</span>
    </a>
</li>
<?php } } ?>
<br style="clear:both">
</ul>
    <div class="page"><div class="num"><div class="pagination"> <?php echo $output['page'];?> </div><span class="tz">跳转到</span><input type="number" id="num" ><input type="button" value="GO" id="btn"></div><a class="fabu" href="<?php echo urlShop('tea_market','tea_market_public');?>">我要发布需求</a></div>
</div>
</div>

