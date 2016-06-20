<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/chashi.css" rel="stylesheet">
<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/chashifabu.css" rel="stylesheet">
<div class="chashi"></div>
<div class="mail">
<div class="title">茶市>发布</div>
<form action="<?php echo urlShop('tea_market','tea_market_public_save');?>" method="post" enctype="multipart/form-data">
<ul>
<li>
<ul class="list">
<li><label>标题</label><input type="text" name="title"></li>
<li><label>品牌</label><input type="text" name="brand"></li>
<li><label>品名</label><input type="text" name="name"></li>
<li><label>年份</label><input type="text" name="year"></li>
<li><label>净含量</label><input type="text" name="weight"></li>
<li><label>所在地</label><input type="text" name="location"></li>
<li><label>供应数量</label><input type="text" name="unit"></li>
<li><label>发布时间</label><input type="date" name="public_time"></li>
<li><label>发布价格</label><input type="text"name="price"></li>
<li><label>联系电话</label><input type="tel" name="phone"></li>
<li><label>发布需求</label><select nane="saleway"><option value="1">求购</option><option value="2">出售</option></select></li>
</ul></li>
<li id="img"><label>产品图片</label><input id="files" type="file" name="image[]" multiple>
<P>一次最多上传3张图片（建议尺寸：488*448px）。不要在图片上放置商业推广信息。</P></li>
<li id="xq"><label>产品详情</label><textarea name="content"></textarea></li>
</ul>
<input id="fabu" type="submit" value="发布">
</form>
</div>
