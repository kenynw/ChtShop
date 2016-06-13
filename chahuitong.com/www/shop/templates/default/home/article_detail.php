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
<div class="context xq">
<h1><?php echo $output['articleInfo']['article_title']; ?></h1>
<h5><span class="lanmu"><?php echo $output['menuArray'][$output['class_id']]; ?></span><span class="time"><?php echo date("Y-m-d H:i:s",$output['articleInfo']['article_publish_time']); ?></span><span class="link"><a href="#">普洱茶</a><a href="#">云南</a><a href="#">纯料拼配</a><a href="#">班章</a></span></h5>
<div class="text">
<p>
 <?php echo $output['articleInfo']['article_content']; ?>
</p></div>
<div class="share">
<img src="<?php echo SHOP_TEMPLATES_URL;?>/images/weixin1.png">|<img src="<?php echo SHOP_TEMPLATES_URL;?>/images/weibo.png">|<img src="<?php echo SHOP_TEMPLATES_URL;?>/images/qzone.png"></div>
</div>
<div class="tuijian">
<div class="title">
<span>热文</span><a class="right" href="#">更多></a>
</div>
<div class="rewen">
<?php if(isset($output['hotNews'])){ foreach($output['hotNews'] as $key=>$v) { if($key==0){ ?>
<h3><a href="<?php echo "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?act=tea_news&op=article_detail&class_id={$output['class_id']}&article_id={$v['article_id']}"; ?>" ><?php echo $v['article_title']; ?></a></h3>
    <a href="<?php echo "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?act=tea_news&op=article_detail&class_id={$output['class_id']}&article_id={$v['article_id']}"; ?>" ><img class="pic" src="<?php $array=unserialize($v['article_image']);echo '/data/upload/cms/article/'.$array['path'].'/'.$array['name'] ; ?>"></a>

    <p><?php echo $v['article_abstract']; ?>......</p></a></div>
<ul class="r_ul">
 <?php }else{ ?>
<li><a href="<?php echo "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?act=tea_news&op=article_detail&class_id={$output['class_id']}&article_id={$v['article_id']}"; ?>" ><?php echo $v['article_title']; ?></a></li>
 <?php } } } ?>
</ul>
</div>
</div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"1","bdPos":"right","bdTop":"183.5"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
