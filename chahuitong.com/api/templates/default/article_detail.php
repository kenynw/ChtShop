<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php echo $output['article_detail']['article_content'];?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>专题</title>
    <link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL; ?>/wap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL; ?>/wap/css/articleStyle.css">
</head>
<body>
<header class="article-header">
    <div >

        <img src="images/1.png" alt="">
        <div class="publisher">
            <h5><?php echo $output['article_detail']['article_publisher_name'];?></h5>
            <h6><?php echo $output['article_detail']['article_publisher_time'];?></h6>
        </div>
        <a class="attention"> +关注</a>


    </div>
</header>
<hr>
<section class="content">
    <h4><?php echo $output['article_detail']['article_title'];?></h4>
    <p class="acticle-judge"><?php echo $output['article_detail']['article_click'];?></p>
    <p class="acticle-content"><?php echo $output['article_detail']['article_content'];?></p>
</section>
</body>
