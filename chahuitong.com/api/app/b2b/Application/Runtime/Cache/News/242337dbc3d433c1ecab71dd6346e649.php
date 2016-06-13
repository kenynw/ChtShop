<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>茶汇通--
<?php if($typeid == 75): ?>印象茶园
<?php elseif($typeid == 76): ?>印象版纳
<?php elseif($typeid == 77): ?>印象勐海
<?php else: ?>印象茶山<?php endif; ?>
</title>
<link rel="stylesheet" type="text/css" href="/mobile/app/b2b/Public/News/css/news.css" />
<style type="text/css">
.slide{
	height:280px;
}
.slide li img{
	height:auto;
}
</style>
</head>
<body>
<!-- 头部 -->
<?php if($headinfo == 0): ?><div class="head">
<a class="backButton himg" href="javascript:history.go(-1)"><img src="/mobile/app/b2b/Public/News/img/back.png"/></a>
<img src="/mobile/app/b2b/Public/News/img/hill_logo.png" style="width:80px;margin-top:8px;"/>
<!-- <a class="queryButton himg"><img src="/mobile/app/b2b/Public/News/img/search.png"/></a> -->
</div>
<div style="height:50px;"></div>	
<?php else: endif; ?>
<div style="width: 100%;height: 60px;background: #f5f1e7;line-height: 45px;text-align: center;font-size: 16px;font-weight: bold;">
<?php if($typeid == 75): ?>印象茶园
<?php elseif($typeid == 76): ?>印象版纳
<?php elseif($typeid == 78): ?>印象勐海
<?php else: ?>印象茶山<?php endif; ?>
</div>
<div class="body_detail">
<!-- 文字描述 -->
<div class="decri">
<?php if($typeid == 75): ?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;云南省拥有迄今为止世界上古茶园保存面积最大、古茶树保存数量最多的地区。许多珍稀的野生型、过渡型古茶树和珍贵的栽培型古茶树群落在这里天然地生长孕育。这里有历史悠久的古茶园面积大约有100多万亩，其中较为连片的古茶园大约有30多万亩。这些古茶园分布在滇南、滇西茶区，澜沧江中下游地区的西双版纳、思茅、临沧、保山、德宏、红河、文山等地州，生长年限都在百年以上，许多稀有古茶树，其生长年限已在千年以上。<br>
&nbsp; &nbsp; &nbsp; &nbsp; 这些古茶园、古茶树是世界茶文化的“根”和“源”，它们证明了云南作为茶树原产地、茶树驯化和规模化种植发祥地的“历史见证”和“活化石”。<br>
&nbsp; &nbsp; &nbsp; &nbsp; 地处澜沧江西岸的白莺山古茶园不仅是当地规模最大、科研价值最高、历史价值最为珍贵的古茶树资源，也是云南古茶树种质资源系全、种多的有力见证，它对进一步确立茶树原产于我国以及研究茶树的起源、演变、分类和种质创新都具有重要的价值。<br>
&nbsp; &nbsp; &nbsp; &nbsp; 位于西双版纳州勐海县勐混镇贺开村的贺开古茶山，距勐海县城40公里，与著名的产茶区老班章、南糯山毗邻。这里的古茶园集中连片，树龄达200—1400多年的栽培型古茶树有16200多亩，数量多达200多万株。这是目前世界上已发现的连片面积最大、密度最高、保护最完好的古茶园，也是全国唯一一家以古茶园为特色的景观茶园。<br>
&nbsp; &nbsp; &nbsp; &nbsp; 或风光秀丽，或狂野奔放，这些茶园在年年岁岁的生长中，与自然生生相惜。氲着茶香，袅袅青烟，似乎离云南越来越近。<br>
<?php elseif($typeid == 76): ?>
&nbsp; &nbsp; &nbsp; &nbsp; 西双版纳，一个停在天边的梦境。位于云南省最南端的傣族自治州，是“没有冬天的热土”， 是世界上北回归线附近保存最为完好、面积最大的热带雨林。素有“动植物王国”美誉和“茶树摇篮”的美称。<br>
&nbsp; &nbsp; &nbsp; &nbsp; 版纳是世界公认的茶树原产地、普洱茶发祥地和茶马古道的源头，植茶、用茶、贸茶的历史悠久，始于东汉，兴于唐宋，盛于明清，距今已达2000年。千百年来，世居在西双版纳这片神奇美丽土地上的13个民族，在长期的种茶、饮茶、贸茶活动中，各民族的制茶工艺、饮茶习俗彼此渗透、相互交融，形成了独特而又多姿多彩的民族茶文化，蕴育了积淀丰厚、博大精深的普洱茶文化，并沿袭至今。<br>
&nbsp; &nbsp; &nbsp; &nbsp; 这几年来，“普洱茶热”正在云南各地兴起，并迅速向全国各地推进。对野生茶资源、栽培型古茶园及茶叶发展历史的考察研究，以及普洱茶爱好者们对茶乡民族文化的追根溯源行动，也为探秘西双版纳带来更多精彩纷呈的理由。<br>
&nbsp; &nbsp; &nbsp; &nbsp; 版纳被定义为大自然的馈赠，这里极富民族氛围，也有着原生态丛林的靓丽地域名片。可在某个暖春时节，探寻深山密林里隐藏的那些有千年历史的古村落，看著名的茶山星罗棋布。也可去到原始部落，体验热带民族骨子里乐观奔放的天性......<br>
&nbsp; &nbsp; &nbsp; &nbsp; 花光人影惹人留连，风花雪月把茶言欢。慢节奏是版纳生活的体现，让我们一同去驻足那一片，神秘的生机盎然的土地。<br>
<?php elseif($typeid == 78): ?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;勐海县位于西双版纳傣族自治州西部，西部和南部与缅甸接壤，拥有长达146.556公里的国境线，地跨东经99°56′—100°41′，北纬21°28′—22°28′之间。这里是地处横断山系纵谷区的南段，同时也是怒江山脉向南延伸的余脉部。境内地势四周高俊，中部平缓，山峰、丘陵、平坝相互交错。勐海境内大小河流159条，属于澜沧江水系。这里面积5511平方公里，人口30万余人。勐海茶区地形复杂，各自形成一些小范围的生态系统，是良种的"百花园"。得天独厚的生态环境，使得勐海成为云南普洱茶最著名的原产地之一。<br>
&nbsp; &nbsp; &nbsp; &nbsp; 勐海县全县植茶面积高达17.4万亩，年产干茶7万担。遍植于各生态系统中的茶树，通过自然杂交，自然选择和人工选择，形成许多具有独特的植物学特征的地方品种。既可以从中选取良种推广，又可以作进一步选育良种的种质资源。这一优势，为全国其他茶区所望尘莫及。<br>
&nbsp; &nbsp; &nbsp; &nbsp; 位于勐海县境内的勐海茶厂生产普洱茶，历史悠久，享誉国内外。&nbsp;1938年，为振兴中华茶产业，受当时中国茶叶进出口总公司委派，毕业于法国巴黎大学的范和钧先生与毕业于清华大学的张石城先生带领90多位茶叶技术工作者赴勐海县筹建茶厂。1940年，勐海茶厂（原名佛海茶厂）正式建成投产，从此揭开了中国普洱茶历史的新篇章，孕育了一个与勐海息息相关的中国普洱茶帝国。<br>
<?php else: ?>&nbsp; &nbsp; &nbsp; &nbsp; 云南产茶历史悠久，文献记载最早的是见于唐朝咸通五年(864年)樊(绰)的《蛮书》卷七：“茶出银生城界诸山，散收无采造法。”银生城即今云南景东县城。普洱茶生产的明确记载是明朝万历四十七年(1619年)方志学家谢(綮洔)的《滇略》：“土(蔗)所用，皆普茶也。”普茶即普洱茶。<br>
&nbsp; &nbsp; &nbsp; &nbsp; 云南省的茶山主要分布在云南省的四大产茶区，即保山、临沧、普洱、西双版纳州。在每个产茶区中，都有很多的山头，而每个山头的滋味也都不尽相同。<br>
&nbsp; &nbsp; &nbsp; &nbsp; 西双版纳，作为现今产茶最多的茶区，集聚古今知名的大茶山。以澜沧江为界，北部的以易武为中心的地区称为“江内”，南以佛海为中心的地区称为“江外”，江内江外各占据六大茶山。境内的古六大茶山是清代普洱茶的重要产区，也是当时内地了解普洱茶的窗口。　　　<br>
&nbsp; &nbsp; &nbsp; &nbsp; 因着云南的地理位置分布区域大、地形复杂的因素，整体气候呈现：区域性差异分明，垂直变化十分明显、年温差小、日温差大跟雨量充沛、旱雨季分明，降雨量北少南多，分布不均等特点。在这些条件下，加上部分茶种跟生长型态的不一样，就导致各个茶山的茶质出现了明显不同的特质。如果以相同茶种、生长型态、制程等相同的客观条件之下，云南茶区就会出现「北苦南涩」、「东柔西刚」的特质。<br>
　　除却大家耳熟能详的知名茶山，云南还有诸多具有优质古树的茶山不为人们所知，这些茶山或许由于面积比较小，或许由于较少有外人进出，越发显得更加的隐蔽。但，这样的茶山却更加让人期待，而他们，也正等待着人们的探访……<br><?php endif; ?>
</div>

<!-- 相关文章 -->
<div style="margin:20px 0px 10px 0px"><img src="/mobile/app/b2b/Public/News/img/about.png" style="width:25%;margin-left:10px"/></div>
<div class="about">
<ul>
<?php if(is_array($about)): $i = 0; $__LIST__ = $about;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="/mobile/app/b2b/index.php/News/Index/detail/aid/<?php echo ($vo["id"]); ?>" target="_self"><?php echo ($vo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
</div>
<div class="bottom"><img src="/mobile/app/b2b/Public/News/img/backtop.png" width="50px"/></div>
<script src="/mobile/app/b2b/Public/News/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript">
$.noConflict();
</script>
<script src="/mobile/app/b2b/Public/News/js/zepto.min.js" type="text/javascript"></script>
<script src="/mobile/app/b2b/Public/News/js/swipeSlide.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
		jQuery(".bottom").click(function(){
    		jQuery("body,html").animate({
    	   		 scrollTop: "0"
    		}, 1000)
   	 })
	})
</script>
</body>
</HTML>