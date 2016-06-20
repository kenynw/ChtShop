<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/class.css" rel="stylesheet">
<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/zixun.css" rel="stylesheet">
<div class="zixun">
<div>
<a href="<?php echo "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?act=tea_news&class_id=88"; ?>">综合资讯</a>|
<a href="<?php echo "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?act=tea_news&class_id=89"; ?>"">行业政策</a>|
<a href="<?php echo "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?act=tea_news&class_id=90"; ?>"">品牌新闻</a>|
<a href="<?php echo "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?act=tea_news&class_id=91"; ?>"">产业动向</a>|
<a href="<?php echo "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?act=tea_news&class_id=92"; ?>"">茶汇通新闻</a>
</div>
</div>
<div class="mail">
<div class="context">
<div class="title">
<span>
    <?php echo $output['menuArray'][$output['class_id']]; ?>
</span>
</div>
<ul>
<?php if(isset($output['news'])){ foreach($output['news'] as $v){?>
<li>
    <a href="<?php echo "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?act=tea_news&op=article_detail&class_id={$output['class_id']}&article_id={$v['article_id']}"; ?>" >
<img class="pic" src="<?php $array=unserialize($v['article_image']);echo '/data/upload/cms/article/'.$array['path'].'/'.$array['name'] ; ?>"></a>
    <a href="<?php echo "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?act=tea_news&op=article_detail&class_id={$output['class_id']}&article_id={$v['article_id']}"; ?>" >

    <div>
<h3><?php echo $v['article_title']; ?></h3>
<p><span class="time"><?php echo date("Y-m-d H:i:s",$v['article_publish_time']); ?></span><span class="share"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/weixin1.png"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/weibo.png"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/qzone.png"></span></p>
<p class="text"><?php echo $v['article_abstract']; ?>.....</p>
    </div>
    </a>

</li>

 <?php }} ?>
</ul>
</div>
<div class="tuijian">
<div class="title">
<span>今日推荐</span><img src="<?php echo SHOP_TEMPLATES_URL; ?>/images/hot.png">
</div>
<ul class="t_ul">
 <?php if(isset($output['recommends'])){ foreach($output['recommends'] as $v){?>
<li>
    <a href="<?php echo "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?act=tea_news&op=article_detail&class_id={$output['class_id']}&article_id={$v['article_id']}"; ?>" >
    <img src="<?php $array=unserialize($v['article_image']);echo '/data/upload/cms/article/'.$array['path'].'/'.$array['name'];  ?>" width="360" height="187" >
<div><p><?php echo $v['article_title']; ?></p></div>
    </a>
</li>
    <?php } } ?>
</ul>
</div>
<div class="page">
<div class="num">
<?php echo $output['page']; ?><span class="tz">跳转到</span>
<input type="number" id="num"><input type="button" value="GO" id="btn"></div>
</div>
</div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"1","bdPos":"right","bdTop":"183.5"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>