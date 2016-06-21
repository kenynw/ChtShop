<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
<title>社区</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="Keywords" content="茶汇通,茶叶网购,茶叶电商,茶叶商城,普洱茶">
<meta name="Description" content="茶汇通，茶叶电子商务综合服务平台，最大的茶叶网购专业平台">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<script type="text/javascript" src="/wap/Public/Home/js/TouchSlide.js"></script>
<script type="text/javascript" src="/wap/Public/Home/js/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/shequ/share.css" />
    <link rel="stylesheet" type="text/css" href="/wap/Public/Home/css/shequ/shequ.css" />
    <script type="text/javascript" src="/wap/Public/Home/js/jquery.cookie.js"></script>

    <script>

        $(document).ready(function () {

            var username = $.cookie('username');

            var key = $.cookie('key');

            init();

            last_news();

            get_active();

            shai();

            $(".zan").live("click", function () {

                var content_id = $(this).attr("data-id");

                var username = $.cookie("username");

                var key = $.cookie("key");

                $.ajax({

                    url: "/wap/index.php/Home/Discuz/add_zan_api",

                    type: "post",

                    dataType: "json",

                    data: {content_id: content_id, username: username, key: key},

                    success: function (data) {

                        if (data.code == 200) {

                            var zan = $("#" + content_id + ".zhan").text();

                            zan = zan * 1 + 1 * 1;

                            $(".showmsg").html(data.content);

                            $(".showmsg").show();

                            $(".ming").css("opacity", "0.3");

                            $(".xin").css("opacity", "0.3");

                            $(".jv").css("opacity", "0.3");

                            $(".ling").css("opacity", "0.3");

                            setTimeout(function () {

                                $(".showmsg").hide();

                                $(".ming").css("opacity", "1");

                                $(".xin").css("opacity", "1");

                                $(".jv").css("opacity", "1");

                                $(".ling").css("opacity", "1");

                            }, 3000)

                            $("." + content_id + " .zhan").text(zan);

                        } else {

                            $(".showmsg").html(data.content);

                            $(".showmsg").show();

                            $(".ming").css("opacity", "0.3");

                            $(".xin").css("opacity", "0.3");

                            $(".jv").css("opacity", "0.3");

                            $(".ling").css("opacity", "0.3");

                            setTimeout(function () {

                                $(".showmsg").hide();

                                $(".ming").css("opacity", "1");

                                $(".xin").css("opacity", "1");

                                $(".jv").css("opacity", "1");

                                $(".ling").css("opacity", "1");

                            }, 3000)


                        }

                    }

                })


            });
            /*分享*/
            $(".share").live("click", function () {

                var content_id = $(this).attr("data-id");

                var username = $.cookie("username");

                var key = $.cookie("key");

                $.ajax({

                    url: "/wap/index.php/Home/Discuz/add_share_api",

                    type: "post",

                    dataType: "json",

                    data: {content_id: content_id, username: username, key: key},

                    success: function (data) {

                        $(".fenxiang").css("display", "block");

                        if (data.code == 200) {

                            var zan = $("#" + content_id + ".homeshare").text();

                            zan = zan * 1 + 1 * 1;


                            $("." + content_id + " .homeshare").text(zan);

                        }

                    }

                })


            });

            $(".comment").live("click", function () {

                var content_id = $(this).attr("data-id");

                $(this).removeClass("comment");

                $(this).addClass("finished")

                $.ajax({

                    url: "/wap/index.php/Home/Discuz/get_content_comment_api",

                    type: "post",

                    dataType: "json",

                    data: {content_id: content_id},

                    success: function (data) {

                        $("." + content_id + " .pic").after('<div class="form"><div id="' + content_id + '"><input type="hidden" name="reply_to" value=""><span class="reply_to" style="display: block;"></span></div><textarea style="width:100%;height:50px;" class="text"></textarea><br><div style="width:20%;margin:0 auto;padding:10px 0;" class="post" data-id="34">发表</div></div>');

                        if (data.code == 200) {

                            var string = '<div style="clear:both;width:100%;height:auto" class="pinglun">';

                            for (var i = 0; i < data.content.length; i++) {

                                string += '<div style="clear:both;padding:10px 0"  class="comment">';

                                var img = '';

                                if (data.content[i].memberInfo.member_avatar != null) {

                                    img = '<img style="width:15%;float:left" src="/data/upload/shop/avatar/' + data.content[i].memberInfo.member_avatar + '">';

                                } else {

                                    img = '<img style="width:15%;float:left" src="/data/upload/shop/avatar/nopic.jpg">';
                                }

                                string += img + '<div style="width:80%;padding-left:20%;"><span class="member_name">' + data.content[i].memberInfo.member_name + '</span> ';

                                if (data.content[i].reply_to != '') {

                                    string += '@' + data.content[i].reply_to + " ";

                                }

                                string += data.content[i].comment_time + '<br><p>' + data.content[i].comment + '</p></div></div>';

                            }

                            $("." + content_id + " .pic").after(string);

                        }


                    }

                })

            })


            $(".finished").live("click", function () {

                var content_id = $(this).attr("data-id");

                if ($("." + content_id + " .form").css("display") == "none") {

                    $("." + content_id + " .form").css("display", "block");

                    $("." + content_id + " .pinglun").css("display", "block");

                } else {

                    $("." + content_id + " .form").css("display", "none");

                    $("." + content_id + " .pinglun").css("display", "none");

                }

            })

            $(".ming .post").live("click", function () {

                var content_id = $(this).parent().parent().attr("class");

                var comment = $(this).parent().find(".text").val();


                $.ajax({

                    url: "/wap/index.php/Home/Discuz/add_content_comment_api",

                    type: "post",

                    dataType: "json",

                    data: {username: username, key: key, content_id: content_id, comment: comment},

                    success: function (data) {

                        if (data.code == 200) {

                            var view = $("." + content_id + " .view").text();

                            view = view * 1 + 1;

                            $("#" + content_id + " .view").text(view);

                            var img = '';

                            if (data.content.memberInfo.member_avatar != '') {

                                img = data.content.memberInfo.member_avatar;

                            } else {

                                img = "nopic.jpg"

                            }

                            var name = '';

                            if (data.reply_to != undefined) {

                                name = data.content.memberInfo.member_name + ' @' + data.reply_to;

                            } else {

                                name = data.content.memberInfo.member_name;
                            }

                            var string = '<div style="clear:both;padding:10px 0" class="comment"><img style="width:15%;float:left" src="/data/upload/shop/avatar/' + img + '"><div style="width:80%;padding-left:20%;"><span class="member_name">';

                            $("." + content_id + " .pic").after(string + name + '</span>' + data.time + '<br><p>' + data.comment + '</p></div></div>');

                        }

                    }

                })


            })


            function init() {


                $.ajax({

                    url: "/wap/index.php/Home/Discuz/home_page_leader_api",

                    type: "post",

                    dataType: "json",

                    data: {username: username, key: key},

                    success: function (data) {

                        if (data.code == 200) {

                            var str = '';

                            var i = 0;

                            for (i = 0; i < 4; i++) {

                                str = '<li id="' + data.content[i].member_id + '"><a href="/wap/index.php/Home/Discuz/memberContent/id/' + data.content[i].member_id + '">';

                                if (data.content[i].member_avatar != null) {


                                    str += '<img src="http://img.chahuitong.com/shop/avatar/' + data.content[i].member_avatar + '"><h5>' + data.content[i].member_name + '</h5><p>';


                                } else {

                                    str += '<img src="http://img.chahuitong.com/shop/avatar/nopic.jpg"><h5>' + data.content[i].member_name + '</h5><p>';

                                }

                                if (data.content[i].rank == '') {

                                    str += '<p>人气明星</p><p>茶汇通高级会员</p>';

                                } else {

                                    str += data.content[i].rank;

                                }

                                str += '</p></a><div class="guanzhu" data-id="' + data.content[i].member_id + '">';

                                if ((data.status == 1) && (data.content[i].beInstered)) {

                                    str += '<img src="/wap/Public/Home/img/xinl.png"><br>已关注</div></li>';

                                } else {

                                    str += '<img class="insterst" src="/wap/Public/Home/img/xinb.png"><br>关注他</div></li>';

                                }

                                $("#leader1").append(str);

                            }

                            for (i = 4; i < 8; i++) {

                                str = '<li id="' + data.content[i].member_id + '"><a href="/wap/index.php/Home/Discuz/memberContent/id/' + data.content[i].member_id + '">';

                                if (data.content[i].member_avatar != null) {


                                    str += '<img src="/data/upload/shop/avatar/' + data.content[i].member_avatar + '"><h5>' + data.content[i].member_name + '</h5><p>';


                                } else {

                                    str += '<img src="/data/upload/shop/avatar/nopic.jpg"><h5>' + data.content[i].member_name + '</h5><p>';

                                }

                                if (data.content[i].rank == '') {

                                    str += '<p>人气明星</p><p>茶汇通高级会员</p>';

                                } else {

                                    str += data.content[i].rank;

                                }

                                str += '</p></a><div class="guanzhu" data-id="' + data.content[i].member_id + '">';

                                if ((data.status == 1) && (data.content[i].beInstered)) {

                                    str += '<img src="/wap/Public/Home/img/xinl.png"><br>已关注</div></li>';

                                } else {

                                    str += '<img class="insterst" src="/wap/Public/Home/img/xinb.png"><br>关注他</div></li>';

                                }

                                $("#leader2").append(str);


                            }

                            for (i = 8; i < 12; i++) {

                                str = '<li id="' + data.content[i].member_id + '"><a href="/wap/index.php/Home/Discuz/memberContent/id/' + data.content[i].member_id + '">';

                                if (data.content[i].member_avatar != null) {


                                    str += '<img src="/data/upload/shop/avatar/' + data.content[i].member_avatar + '"><h5>' + data.content[i].member_name + '</h5><p>';


                                } else {

                                    str += '<img src="/data/upload/shop/avatar/nopic.jpg"><h5>' + data.content[i].member_name + '</h5><p>';

                                }

                                if (data.content[i].rank == '') {

                                    str += '<p>人气明星</p><p>茶汇通高级会员</p>';

                                } else {

                                    str += data.content[i].rank;

                                }

                                str += '</p></a><div class="guanzhu" data-id="' + data.content[i].member_id + '">';

                                if ((data.status == 1) && (data.content[i].beInstered)) {

                                    str += '<img src="/wap/Public/Home/img/xinl.png" <br>已关注</div></li>';

                                } else {

                                    str += '<img class="insterst" src="/wap/Public/Home/img/xinb.png" ><br>关注他</div></li>';

                                }

                                $("#leader3").append(str);


                            }

                        }

                        /*success*/

                        $(".guanzhu").click(add_insterst);

                        /**/

                    }


                })


            }

            /*今日新声*/
            function last_news() {

                $.ajax({

                    url: "/wap/index.php/Home/Discuz/last_news_api",

                    dataType: "json",

                    type: "post",

                    data: {},

                    success: function (data) {

                        //alert("ssss")

                        if (data.code == 200) {


                            var imagearray = new Array();

                            imagearray = data.content.image.split(",");

                            $(".xin .title img").attr("src", "/data/upload/qunzi/" + imagearray[0]);

                            $(".xin .title h5").html(data.content.title);

                            $(".xin .title p").html(data.content.content);

                            $(".xin .zhuli").html("话题主理人:" + data.memberInfo.member_name + "<span>已有" + data.content.view + "参与</span>");


                        }

                    }


                })


            }

            /*添加关注*/

            function add_insterst() {

                var member_id = $(this).attr("data-id");

                //alert(member_id)

                $.ajax({

                    url: "/wap/index.php/Home/Discuz/add_insterst_api",

                    type: "post",

                    dataType: "json",

                    data: {username: username, key: key, member_id: member_id},

                    success: function (data) {

                        //alert(data.content);
                        if (data.code == 200) {

                            $("#" + member_id + " .insterst").attr("src", "/wap/Public/Home//wap/Public/Home/img/xinl.png");

                        }

                    }

                })

            }

            /*活动*/

            function get_active() {

                var page = 1;

                $.ajax({

                    url: "/wap/index.php/Home/Discuz/get_allperson_active_api",

                    type: "post",

                    dataType: "json",

                    data: {},

                    success: function (data) {

                        if (data.code == 200) {

                            //alert(data.content.length);

                            for (var j = 0; j < 4; j++) {

                                var imgarray = new Array();

                                imagearray = data.content[j].pics.split(",");

                                $(".first").append('<li><a href="#"><img src="/data/upload/qunzi/' + imagearray[0] + '"></a><div class="head"><h4>' + data.content[j].active_title + '</h4><p>行程时间:' + data.content[j].join_time + '</p><p>行程天数：5天</p><a href="/wap/index.php/Home/Discuz/activeDetail/id/' + data.content[j].active_id + '">了解更多</a></div><h5>' + data.content[j].active_title + '</h5></li>');

                            }

                            for (var i = 4; i < data.content.length; i++) {

                                var img = '';

                                if (data.content[i].memberInfo.member_avatar == '') {

                                    img = "nopic.jpg";

                                } else {

                                    img = data.content[i].memberInfo.member_avatar;

                                }

                                $(".word ul").append('<li><h5><a href="/wap/index.php/Home/Discuz/activeDetail/id/' + data.content[i].active_id + '">' + data.content[i].active_title + '<img src="/wap/Public/Home/img/jing.png"></a></h5><a href="/wap/index.php/Home/Discuz/activeDetail/id/' + data.content[i].active_id + '"><p style="height:36px;overflow:hidden;color:black;">' + data.content[i].content + '</p></a><h5 class="name"><img src="/data/upload/shop/avatar/' + img + '">' + data.content[i].memberInfo.member_name + '<span>最后更新:5分钟</span></h5></li>');
                            }

                            TouchSlide({
                                slideCell: "#box",
                                titCell: ".hd ul",
                                mainCell: ".bd ul",
                                effect: "leftLoop",
                                autoPage: true
                            });
                        }

                    }


                })

            }

            /*晒一晒*/
            function shai() {

                $.ajax({

                    url: "/wap/index.php/Home/Discuz/get_allperson_content_api",

                    type: "post",

                    dataType: "json",

                    data: {page: 1},

                    success: function (data) {

                        if (data.code == 200) {

                            if (data.content[0].memberInfo.member_avatar == '' || data.content[0].memberInfo.member_avatar == null) {

                                image1 = "nopic.jpg";

                            } else {

                                image1 = data.content[0].memberInfo.member_avatar;

                            }


                            if (data.content[1].memberInfo.member_avatar == '') {

                                image2 = "nopic.jpg";

                            } else {

                                image2 = data.content[1].memberInfo.member_avatar;

                            }

                            image = new Array();

                            image = data.content[0].image.split(",");

                            if (image[0] == '') {

                                image[0] = "2.jpg";


                            }


                            /*var string='<li class="'+data.content[0].content_id+'"><div class="header"><img src="/data/upload/shop/avatar/'+image1+'"><a href="#">'+data.content[0].memberInfo.member_name+'</a><p>28分钟前<span>来自iphone 6 Plus</span></p></div><p>'+data.content[0].title+'</p><img src="/data/upload/qunzi/'+image[0]+'"><div class="pic"><span class="share" data-id="'+data.content[0].content_id+'"><img src="/wap/Public/Home/img/share.png"><time class="homeshare">'+data.content[0].share+'</time></span><span class="comment" data-id="'+data.content[0].content_id+'"><img src="/wap/Public/Home/img/bi.png"><time class="view">'+data.content[0].comment+'</time></span><span class="zan" data-id="'+data.content[0].content_id+'"><img src="/wap/Public/Home/img/zhan.png"><time class="zhan">'+data.content[0].view+'</time></span></div></li><li class="'+data.content[1].content_id+'"><div class="header"><img src="/data/upload/shop/avatar/'+image2+'"><a href="#">'+data.content[1].memberInfo.member_name+'</a><p>28分钟前<span>来自iphone 6 Plus</span></p></div><p>'+data.content[1].title+'</p><div class="pic"><span class="share" data-id="'+data.content[1].content_id+'"><img src="/wap/Public/Home/img/share.png"><time class="homeshare">'+data.content[1].share+'</time></span><span class="comment" data-id="'+data.content[1].content_id+'"><img src="/wap/Public/Home/img/bi.png"><time class="view">'+data.content[1].comment+'</time></span><span class="zan" data-id="'+data.content[1].content_id+'"><img src="/wap/Public/Home/img/zhan.png"><time class="zhan">'+data.content[1].view+'</time></span></div></li>';*/

                            //alert(data.content.length)

                            for (var i = 0; i < data.content.length; i++) {

                                if (i == 0) {

                                    var string = '<li class="' + data.content[0].content_id + '"><div class="header"><img src="/data/upload/shop/avatar/' + image1 + '"><a href="#">' + data.content[0].memberInfo.member_name + '</a><p>28分钟前<span>来自iphone 6 Plus</span></p></div><p>' + data.content[0].title + '</p><img src="/data/upload/qunzi/' + image[0] + '"><div class="pic"><span class="share" data-id="' + data.content[0].content_id + '"><img src="/wap/Public/Home/img/share.png"><time class="homeshare">' + data.content[0].share + '</time></span><span class="comment" data-id="' + data.content[0].content_id + '"><img src="/wap/Public/Home/img/bi.png"><time class="view">' + data.content[0].comment + '</time></span><span class="zan" data-id="' + data.content[0].content_id + '"><img src="/wap/Public/Home/img/zhan.png"><time class="zhan">' + data.content[0].view + '</time></span></div></li>';
                                } else {

                                    var string = '<li class="' + data.content[i].content_id + '"><div class="header"><img src="/data/upload/shop/avatar/' + image2 + '"><a href="#">' + data.content[i].memberInfo.member_name + '</a><p>28分钟前<span>来自iphone 6 Plus</span></p></div><p>' + data.content[i].title + '</p><div class="pic"><span class="share" data-id="' + data.content[i].content_id + '"><img src="/wap/Public/Home/img/share.png"><time class="homeshare">' + data.content[i].share + '</time></span><span class="comment" data-id="' + data.content[i].content_id + '"><img src="/wap/Public/Home/img/bi.png"><time class="view">' + data.content[i].comment + '</time></span><span class="zan" data-id="' + data.content[i].content_id + '"><img src="/wap/Public/Home/img/zhan.png"><time class="zhan">' + data.content[i].view + '</time></span></div></li>';

                                }

                                $(".ming ul").append(string);

                            }


                        }

                    }


                })

            }


        })

    </script>
</head>
<body>
<header>
    <a href="javaScript:window.history.back();"><img src="/wap/Public/Home/img/fanhui.png"></a>
    社区<a href="/wap"><img src="/wap/Public/Home/img/home.png"></a>
</header>
<div class="ling">
    <h4>魅力领袖<a href="/wap/index.php/Home/Discuz/lingxiu">更多</a></h4>
    <div id="top">
        <div class="bd">
            <ul id="leader1">

            </ul>
            <ul id="leader2">

            </ul>
            <ul id="leader3">

            </ul>
        </div>
        <div class="hd" id="yuan">
            <li class="on"></li>
            <li></li>
            <li></li>
        </div>
    </div>
    <script type="text/javascript">TouchSlide({slideCell: "#top"});</script>

</div>
<div class="xin">
    <h4>今日新声<a href="/wap/index.php/Home/Discuz/memberContent/id/1">更多</a></h4>
    <div class="title"><a href="#"><img src="/wap/Public/Home/img/she07.png">
        <h5>当今普洱茶收藏价值怎么样？</h5>
        <p style="height:36px;overflow:hidden;">近几年来普洱茶越来越被大家所熟知与接受，普洱茶的收藏也被大家纷纷提出。其实普洱茶在很早之前就已经被各大收藏家收藏，现如今...</p></a>
    </div>
    <p class="zhuli">话题主理人：杨丞琳<span>已有1002人参与</span></p>
</div>
<div class="jv">
    <h4>茶客聚聚<a href="/wap/index.php/Home/Discuz/active">更多</a></h4>
    <div class="tu">
        <div id="box">
            <div class="bd">
                <ul class="first"></ul>
            </div>
            <div class="hd">
                <ul></ul>
            </div>
            <span><mark class="on"></mark><mark></mark><mark></mark></span>
        </div>
        <script type="text/javascript"></script>
        <div class="word">
            <ul></ul>
        </div>
    </div>
</div>
<div class="ming">
    <h4>晒一晒<a href="/wap/index.php/Home/Discuz/shai">更多</a></h4>
    <ul>

    </ul>
</div>
</div>
<div id="ding"><img src="/wap/Public/Home/img/top.png"></div>
<script>
    window.onload = function () {
        var top = document.getElementById('top');
        var topImg = top.getElementsByTagName('img');
        var imgWidth = topImg[0].width;
        for (var i = 0; i < topImg.length; i += 2) {
            topImg[i].style.width = imgWidth + 'px';
            topImg[i].style.height = imgWidth + 'px';
        }

        var ding = document.getElementById('ding');
        window.onscroll = function () {
            var scrollTop = document.body.scrollTop;
            if (scrollTop > 360) {
                ding.style.display = 'block';
            } else {
                ding.style.display = 'none';
            }
            ding.onclick = function () {
                document.body.scrollTop = 0
            };
        };
    };
</script>
<div id="bianji"><a href="/wap/index.php/Home/Discuz/addContent"><img src="/wap/Public/Home/img/bianji02.png"></div>
<div class="showmsg"
     style="position: fixed; top: 40%; left: 0px; height: 30px; line-height: 30px; color: white; width: 100%; text-align: center; display: none; background: red;"></div>
<div class="fenxiang" style="display:none">
    <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone"
                                                                                      data-cmd="qzone"
                                                                                      title="分享到QQ空间"></a><a href="#"
                                                                                                             class="bds_tsina"
                                                                                                             data-cmd="tsina"
                                                                                                             title="分享到新浪微博"></a><a
            href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren"
                                                                           title="分享到人人网"></a><a href="#"
                                                                                                 class="bds_weixin"
                                                                                                 data-cmd="weixin"
                                                                                                 title="分享到微信"></a>
    </div>
    <script>window._bd_share_config = {
        "common": {
            "bdSnsKey": {},
            "bdText": "",
            "bdMini": "2",
            "bdMiniList": false,
            "bdPic": "",
            "bdStyle": "0",
            "bdSize": "24"
        },
        "share": {},
        "image": {"viewList": ["qzone", "tsina", "tqq", "renren", "weixin"], "viewText": "分享到：", "viewSize": "16"},
        "selectShare": {"bdContainerClass": null, "bdSelectMiniList": ["qzone", "tsina", "tqq", "renren", "weixin"]}
    };
    with (document)0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
    </script>
</div>
</body>
</html>