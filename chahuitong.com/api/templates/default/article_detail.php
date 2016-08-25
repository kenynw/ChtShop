<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset= <?php echo CHARSET;?> " />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">

    <title><?php echo empty($output['seo_title'])?$output['html_title']:$output['seo_title'].'-'.$output['html_title'];?></title>
    <meta name="keywords" content="<?php echo empty($output['article_keyword'])?$output['seo_keywords']:$output['seo_keywords'].' '.$output['article_keyword']; ?>" />
    <meta name="description" content="<?php echo empty($output['article_description'])?$output['seo_description']:$output['article_description'].$output['seo_keywords']; ?>" />

    <link href="<?php echo API_TEMPLATES_URL; ?>/css/article.css" rel="stylesheet" type="text/css" >
</head>
<body>
<header class="article-header">
    <a href="<?php echo str_replace('http', 'com.cht.user', MOBILE_SITE_URL); ?>/index.php?act=member_sns_home&mid=<?php echo $output['article_detail']['article_publisher_id']; ?>">
        <img src="<?php echo getMemberAvatarForID($output['article_detail']['article_publisher_id']); ?>" alt="<?php echo $output['article_detail']['article_publisher_name']; ?>">
    </a>

    <div class="publisher">
        <h5><?php echo $output['article_detail']['article_publisher_name']; ?></h5>
        <h6><?php echo date('Y-m-d',$output['article_detail']['article_publish_time']); ?></h6>
    </div>
    <a class="attention"> +关注</a>
</header>
<div class="clearfix">
</div>
<hr>

<section class="article-content">
    <h4><?php echo $output['article_detail']['article_title'];?></h4>
    <p class="acticle-judge"><?php echo $output['article_detail']['article_click'] . '次阅 · ' . $output['article_detail']['article_comment_count'] . '评论';?></p>

    <p class="acticle-content"><?php echo $output['article_detail']['article_content'];?></p>
</section>

<div class="article-judge">
    <div class="judge-header">
        <p>评论</p>
    </div>
    <img src="images/茶汇通LOGO@2x.png" alt="">
    <div class="publisher">
        <h5>茶汇通</h5>
        <h6>2小时前</h6>
    </div> 
    <a class="attention">点赞</a>
</div>
<div class="clearfix">
</div>
<p class="judge-content">如果你是开发者，请选择homebrew，mac下最好的包管理工具，没有之一，用它可以安装php开发需要的所有相关。
    如果你喜欢使用源码安装，也可以不用homebrew，但是</p>
<hr>
</body>
