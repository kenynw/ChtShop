<?php defined('InShopNC') or exit('Access Invalid!'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset= <?php echo CHARSET; ?> "/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">

    <title><?php echo empty($output['seo_title']) ? $output['html_title'] : $output['seo_title'] . '-' . $output['html_title']; ?></title>
    <meta name="keywords" content="<?php echo empty($output['article_keyword']) ? $output['seo_keywords'] : $output['seo_keywords'] . ' ' . $output['article_keyword']; ?>"/>
    <meta name="description" content="<?php echo empty($output['article_description']) ? $output['seo_description'] : $output['article_description'] . $output['seo_keywords']; ?>"/>

    <!--    <link href="-->
    <?php //echo API_TEMPLATES_URL; ?><!--/css/article.css" rel="stylesheet" type="text/css" >-->
    <link href="templates/default/css/article.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
    <script id="dialog_js" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo CMS_SITE_URL;?>/resource/js/common.js" charset="utf-8"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#comment_list').on('click', '[nctype="comment_up"]', function() {
                var comment_id = $(this).attr('comment_id');
                var $count = $(this).find('em');
                $.post("<?php echo CMS_SITE_URL.DS.'index.php?act=comment&op=comment_up';?>", {comment_id:comment_id},
                    function(data){
                        if(data.result == 'true') {
                            var old_count = parseInt($count.text());
                            $count.text(old_count + 1);
                        } else {
                            showError(data.message);
                        }
                    }, "json");
            });
        });
    </script>

</head>
<body>

<div class="article-detail">

    <div class="article-header clearfix">
        <a href="<?php echo str_replace(
            'http', 'com.cht.user', MOBILE_SITE_URL
        ); ?>/index.php?act=member_sns_home&mid=<?php echo $output['article_detail']['article_publisher_id']; ?>"
           class="avatar-link">
            <img src="<?php echo getMemberAvatarForID(
                $output['article_detail']['article_publisher_id']
            ); ?>"
                 alt="<?php echo $output['article_detail']['article_publisher_name']; ?>">
        </a>
        <div class="publisher">
            <p class="name"><?php echo $output['article_detail']['article_publisher_name']; ?></p>

            <span class="time"><?php echo date(
                    'Y-m-d', $output['article_detail']['article_publish_time']
                ); ?></span>
        </div>

        <div class="follow"><a>+关注</a></div>
    </div>

    <hr>

    <h1 class="title"><?php echo $output['article_detail']['article_title']; ?></h1>

    <div class="article-content">
        <span
            class="article-heat"><?php echo $output['article_detail']['article_click']
                . '次阅 · ' . $output['article_detail']['article_comment_count']
                . '评论'; ?></span>

        <?php echo $output['article_detail']['article_content']; ?>
    </div>


    <?php if (!empty($output['comment_list']) && is_array($output['comment_list'])) { ?>
        <div id="comment_list" class="comment-list">
            <div class="title"><h5>评论</h5></div>

            <?php foreach ($output['comment_list'] as $value) { ?>
                <dl>
                    <dt>
                        <a class="avatar-link" href="com.cht.user://api.chahuitong.com?act=member_snshome&mid=<?php echo $value['member_id']; ?>" target="_blank">
                            <img src="<?php echo getMemberAvatar($value['member_avatar']); ?>" alt="<?php echo $value['member_name']; ?>">
                        </a>
                    </dt>
                    <dd>
                        <p class="comment-name">
                            <a href="com.cht.user://api.chahuitong.com?act=member_snshome&mid=<?php echo $value['member_id']; ?>" target="_blank"><?php echo $value['member_name']; ?></a>
                            <a nctype="comment_up" comment_id="<?php echo $value['comment_id'];?>" href="javascript:void(0)" class="like-btn"><em><?php echo $value['comment_up']; ?></em></a>
                        </p>
                        <p class="comment-time"><?php echo date('Y-m-d H:i', $value['comment_time']); ?></p>
                        <p class="comment-content"><?php echo $value['comment_message'];?></p>
                    </dd>
                </dl>
            <?php } ?>
        </div>

    <?php } ?>

</div>

</body>
