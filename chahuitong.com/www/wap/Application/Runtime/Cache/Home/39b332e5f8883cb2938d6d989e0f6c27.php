<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
<title>茶汇通-茶品,茶市,茶资讯,茶百科,普洱茶,铁观音,红茶,乌龙茶,绿茶,黑茶,白茶,茶具一站式网上购物商城-最大的茶叶网购专业平台</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="Keywords" content="茶汇通,茶叶网购,茶叶电商,茶叶商城,普洱茶">
<meta name="Description" content="茶汇通，茶叶电子商务综合服务平台，最大的茶叶网购专业平台">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<script type="text/javascript" src="/wap/Public/Home/js/TouchSlide.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/sharehome.css" />
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/home.css" />
    <script type="text/javascript" src="/wap/Public/Home/js/home.js"></script>

    <style>
        #app {
            width: 100%;
            text-align: left;
            position: fixed;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            color: #fff;
        }

        #logo {
            width: 12%;
            float: left;
            margin: 3px 3%;
        }

        #app div {
            width: 50%;
            float: left;
            font-size: 0.8em;
            line-height: 30px;
            margin-top: 10px;
        }

        #app a {
            display: block;
            width: 20%;
            float: right;
            margin-right: 30px;
            margin-top: 10px;
            background: #1b8b80;
            text-align: center;
            color: #fff;
            line-height: 30px;
        }

        #close {
            width: 20px;
            position: absolute;
            top: 0;
            right: 3px;
        }
    </style>
</head>
<body>
<header><img src="/wap/Public/Home/img/logo02.png"></header>
<div id="focus" class="focus">
    <div class="hd">
        <ul>
        </ul>
    </div>
    <div class="bd">
        <ul>
            <?php if(is_array($pics)): $i = 0; $__LIST__ = $pics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($value["link"]); ?>"><img src="<?php echo ($value["image"]); ?>"/></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</div>
<div id="nav">
    <div class="navL"><a href="http://api.chahuitong.com/app/b2b/index.php/Home/index/sale"><img src="/wap/Public/Home/img/chashi.png">
        <p>茶市</p></a></div>
    <div class="navR"><a href="/wap/index.php/Home/discuz"><img src="/wap/Public/Home/img/bbs.png">
        <p>社区</p></a></div>
    <div class="navL" style="border-bottom: 1px solid #acabab;"><a href="/wap/index.php/Home/news"><img
            src="/wap/Public/Home/img/zixun.png">
        <p>资讯</p></a></div>
    <div class="navR"><a href="<?php echo U('brandLoad');?>"><img src="/wap/Public/Home/img/shopping.png">
        <p>商城</p></a></div>
    <div id="user"><a href="/wap/index.php/Home/Index/member">个人中心</a></div>
</div>
<div class="list">
    <ul>
        <?php if(is_array($xianshigoods)): $i = 0; $__LIST__ = $xianshigoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
                <div class="pic"><a href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($v["goods_id"]); ?>">
                    <img src="http://img.chahuitong.com/shop/store/goods/<?php echo ($v["store_id"]); ?>/<?php echo ($v["goods_image"]); ?>" >
                </a></div>
                <div name="text" class="text">
                    <h5><a href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($v["goods_id"]); ?>"><?php echo (subtext($v["goods_name"],11)); ?></a><span class="score"
                                                                                                           id="<?php echo ($v["goods_id"]); ?>"><img
                            src="/wap/Public/Home/img/xin01.png"><mark>5454</mark></span></h5>
                    <p><?php echo ($v["xianshi_explain"]); ?></p>
                    <div class="shop">￥<?php echo ($v["xianshi_price"]); ?><span><a
                            href="/wap/index.php/Home/Index/goods?goods_id=<?php echo ($v["goods_id"]); ?>">查看详情</a></span></div>
                </div>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</div>
<div id="imagehide" style="display:none">
</div>
<div id="app">
    <img id="logo" src="/wap/Public/Home/img/logo.jpg">
    <div><p>茶汇通-茶品 茶市 茶事 茶百科</p></div>
    <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.damenghai.chahuitong">下载APP</a>
    <img id="close"
         src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAABBElEQVRIS7XXXRKEIAgAYDjptifbOik7trpDBgikvmTTzzeUiCIREfzajojv2l9yIKIPAGzl5cjgpThHG7wDwIuFOD3yHgWAAwtIRMtwEUXcTngVrqHnp+ajaGbkFnqDZ0U+QkX4Ke5BVTiLe1ETjuIRdAh78Sjqgkd4BnXDGl5T8Zx7azsQkZ/zbL30L3ms3qVPMvwRNxqKuAnCJFMuhdAs/C9tLNxwYYl+agltfgh3w9LorWKqpLpgK2WyhWUIe/I0g5uwBzVGu/nPVTiCZnARzqBR/AY/QSN4v/Tp8zQ8I3lxvtibhnrwtrydjo7wspNYhpp4t4VJ/9NoSeV7p2WoFPkX2aMLV14y0BkAAAAASUVORK5CYII=">
</div>
<script>
    var cookies = document.cookie;
    var app = document.getElementById('app');
    var closes = document.getElementById('close');
    if (cookies.search(/close/i) > 0) {
        app.style.display = 'none';
    } else {
        app.style.display = 'block';
    }
    closes.onclick = function () {
        app.style.display = 'none';
        setcookie('zhuangtai', 'close', 12);
    }
    function setcookie(name, value, days) {
        var cookie = name + "=" + value;
        if (typeof days === "number") {
            cookie += ";max-age=" + days * 60 * 60;
        }
        document.cookie = cookie;
    }
</script>
<script>
    var _hmt = _hmt || [];
    (function () {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?9a15ea23e7316c631085bb3ef722599a";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
</body>
</html>