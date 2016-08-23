<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset= <?php echo CHARSET;?> " />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">

    <title><?php echo empty($output['seo_title'])?$output['html_title']:$output['seo_title'].'-'.$output['html_title'];?></title>
    <meta name="keywords" content="<?php echo empty($output['article_keyword'])?$output['seo_keywords']:$output['seo_keywords'].' '.$output['article_keyword']; ?>" />
    <meta name="description" content="<?php echo empty($output['article_description'])?$output['seo_description']:$output['article_description'].$output['seo_keywords']; ?>" />

    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" >
    <link href="<?php echo API_TEMPLATES_URL; ?>/css/layout.css" rel="stylesheet" type="text/css" >
    <link href="<?php echo API_TEMPLATES_URL; ?>/css/article.css" rel="stylesheet" type="text/css" >
</head>
<body>
<header class="article-header">
    <div >

        <span class="thumb">
            <a href="<?php echo MOBILE_SITE_URL; ?>/index.php?act=member_sns_home&mid=<?php echo $output['article_detail']['article_publisher_id']; ?>">
                <img src="<?php echo getMemberAvatarForID($output['article_detail']['article_publisher_id']); ?>" alt="<?php echo $output['article_detail']['article_publisher_name']; ?>">
            </a>
        </span>

        <div class="publisher">
            <h5><?php echo $output['article_detail']['article_publisher_name']; ?></h5>
            <h6><?php echo $output['article_detail']['article_publisher_time']; ?></h6>
        </div>
        <a class="attention"> +关注</a>


    </div>
</header>
<hr>
<section class="content">
    <h4><?php echo $output['article_detail']['article_title'];?></h4>
    <p class="acticle-judge"><?php echo $output['article_detail']['article_click'] . '次阅 · ' . $output['article_detail']['article_comment_count'] . '评论';?></p>

    <p class="acticle-content"><?php echo $output['article_detail']['article_content'];?></p>
</section>
</body>
