<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0,maximum-scale=1.0, user-scalable=no" name="viewport">
<title>投票</title>
<link type="text/css" href="/wap/Public/Home/css/voteclass.css" rel="stylesheet">
<link type="text/css" href="/wap/Public/Home/css/votedetails.css" rel="stylesheet">
<link type="text/css" href="/wap/Public/Home/css/vote.css" rel="stylesheet">
</head>
<body>
<header><a href="javaScript:window.history.back();"><img src="http://www.chahuitong.com/wap/Public/Home/img/arrow.png"></a>投票<a href="#"><img style="width:25px;" src="http://www.chahuitong.com/wap/Public/Home/img/share.png"></a></header>
<div class="vote">
<img src="http://www.chahuitong.com/wap/Public/Home/img/vote/huodong.jpg">
<div class="toupiao">
<h5><span></span>投票说明：</h5>
<ul>
<li>每个用户每天可投票一次，每次投票可选择3个参赛者。</li>
<li id="time">投票截止时间：2016.2.20 24:00</li>
<li>注：一个手机登录不同账号默认是同一个用户。</li>
</ul>
</div>
</div>
<div id="toupiao">
<ul>
</ul>
<p id="load_more">上滑加载更多</p>
</div>
<nav>
<form action="#">
    <input type="hidden" name="members" value="">
<input type="search" placeholder="输入号数/姓名" name="search">

</form>
    <button id="search">搜索</button>
<a id="tou">投票</a>
</nav>
<div id="success">
<div id="msses"><h5>投票成功！</h5><p id="queding">确定</p></div>
</div>
<div id="msg" style="display:none;width:100%;height:10%;position:fixed;top:80%;background:red;color:#ffffff;text-align:center;vertical-align: middle;
padding-top:10%">
<script src="/wap/Public/Home/js/config.js"></script>
<script src="/wap/Public/Home/js/jquery-1.7.1.min.js"></script>
    <script src="/wap/Public/Home/js/jquery.cookie.js"></script>
<script>
    $(document).ready(function(){
        var activity_id=<?php echo ($activity_id); ?>;
        var members = new Array();
        var page=1;
        init();
        get_competitor();
        choose_competitor();
        sumit_vote();
        search_competitor();
        //add 解决load_more 多次 <<
        jQuery(window).scroll(function(){
            if(parseInt(jQuery(document).scrollTop())>=parseInt(jQuery(document).height())-parseInt(jQuery(window).height())){
                get_competitor()
            }
        })
       //end  >>
        //初始化函数
        function init() {
            $.ajax({
                url: ApiUrl + "/index.php?act=vote_activity&op=get_activity",
                type: "post",
                data: {activity_id: activity_id},
                dataType: "json",
                success: function (data) {
                    if (data.code == 1) {
                        //alert(data.data.activity_image);
                        $(".vote img").attr("src", data.data.activity_image);
                        //报名时间
                        var vote_start_time = get_date(data.data.activity_vote_start_time);
                        var vote_end_time = get_date(data.data.activity_vote_end_time);
                        var vote_time = "投票时间：<span>" +vote_start_time + "--" +vote_end_time + "</span>";
                        $("#time").html(vote_time);
                    }
                }
            })
        }
        //获取报名人数
        function get_competitor(){
            //alert(page);
            $.ajax({
                url: ApiUrl + "/index.php?act=vote_activity&op=get_competitor",
                type: "post",
                data: {activity_id: activity_id,page:page},
                dataType: "json",
                success: function (data) {
                    if(data.code==1) {
                        for (var i = 0; i < data.data.length; i++) {
                            var html = '<li id="' + data.data[i].enroll_member_id + '" class="choose" ><img class="img" src="' + data.data[i].enroll_member_avatar + '"><p class="xingming">';
                            html +=data.data[i].enroll_id+'号'+data.data[i].enroll_member_name + '</p><p class="piaoshu">' + data.data[i].enroll_member_name + '<span><mark>';
                            html += data.data[i].enroll_vote_number + '</mark>票</span></p><div class="checkbox1" did="' + data.data[i].enroll_member_id + '"><input id="a' + data.data[i].enroll_member_id + '" type="checkbox" name="vote"><label for="a' + data.data[i].enroll_member_id + '" ><span></span></label></div></li>';
                            $("#toupiao ul").append(html);
                        }
                        page++;
                        //jQuery(window).scroll(load_more);
                    }else{
                        $("#load_more").css("display","none");
                        $("#msses").text("已经没有参与选手了");
                        $("#success").css("display","block");
                        setTimeout(hide,3000);
                    }
                }
            })
			$('.img').height($('.img').eq(0).width() * 1.08);
        }
        //查找选手
        function search_competitor(){
            $("#search").click(function(){
               var value=$("input[name='search']").val();
                //alert(value);

                $.ajax({
                    url: ApiUrl + "/index.php?act=vote_activity&op=get_competitor",
                    type: "post",
                    data: {activity_id: activity_id,search:value},
                    dataType: "json",
                    success: function (data) {
                        if(data.code==1) {
                            $("#toupiao ul").html('');
                            for (var i = 0; i < data.data.length; i++) {
                                var html = '<li id="' + data.data[i].enroll_member_id + '" class="choose" ><img class="img" src="' + data.data[i].enroll_member_avatar + '"><p class="xingming">';
                                html += data.data[i].enroll_member_name + '</p><p class="piaoshu">' + data.data[i].enroll_id+'号'+data.data[i].enroll_member_name + '<span><mark>';
                                html += data.data[i].enroll_vote_number + '</mark>票</span></p><div class="checkbox1" did="' + data.data[i].enroll_member_id + '"><input id="a' + data.data[i].enroll_member_id + '" type="checkbox" name="vote"><label for="a' + data.data[i].enroll_member_id + '" ><span></span></label></div></li>';
                                $("#toupiao ul").append(html);

                            }
                            page=100;
                        }else{
                            $("#msses").text("没有你想要的选手");
                            $("#success").css("display","block");
                            setTimeout(hide,3000 );
                        }
                    }
                })
            })
        }
        //点击获取报名人id
        function choose_competitor(){
            $(".checkbox1").live("click",function(){
               var id=$(this).attr("did");
               //alert(id)
               if(!(members.in_array(id))){
                   members.push(id)
               }else{
                   members.remove(id)
               }

            });
        }
        function sumit_vote(){
            $("#tou").click(function(){
                var number=members.length;
                //alert(number)
                var key= $.cookie('key');
                if(number==0){
                    $("#msses").text("你还未选择选手");
                    $("#success").css("display","block");
                    setTimeout(hide,3000 );
                    return false;
                }
                if(number>3){
                    $("#msses").text("最多只能选择三个");
                    $("#success").css("display","block");
                    setTimeout(hide,3000 );
                    return false;
                }
                if(!$.cookie('key')){
                    $("#msses h5").text("");
                    $("#msses h5").text("您还未登陆");
                    $("#queding").html("<a href='/wap/index.php/Home/Index/login'>确定</a>")
                    $("#success").css("display","block");
                    /*
					setTimeout(function(){
						window.location = '/wap/index.php/Home/Index/login';
					},2000);
					*/
                    setTimeout(hide,3000 );
                    return false;
                }
                    var member_id='';
                    for(var i=0;i<members.length;i++){
                        member_id+=members[i]+'/';
                    }

                    $.ajax({
                        url:ApiUrl + "/index.php?act=vote_activity&op=vote_member",
                        type:"post",
                        data:{key:key,member_id:member_id},
                        dataType:"json",
                        success:function(data){
                            if(data.code==1){
                                $("#msses").html("投票成功");
                                $("#success").css("display","block");
								setTimeout(function(){
									window.location = '/wap/index.php/Home/Index/activity_list';
								},3000);
                                setTimeout(hide,3000 );
                                //location.href="/wap/index.php/Home/Index/activity_list"
                            }else{
                                $("#mses").text(data.msg);
                                $("#success").css("display","block");
                                setTimeout(hide,3000 );
                            }

                        }

                    })
            })
        }
        function get_date(seconds){
            var d = new Date(seconds*1000);
            var start='';
            var year=d.getFullYear();
            var month=d.getMonth()+1;
            var day=d.getDate();
            var h=d.getHours();
            var mins=d.getMinutes();
            var s=d.getSeconds();
            if(month<10) month="0" + month
            if(day<10) month="0" + day
            if(h<10) h="0" + h
            if(mins<10) mins="0" + mins
            if(s<10) s="0" + s;
            start=start+year+".";
            start=start+month+".";
            start=start+day+" ";
            start=start+h+":";
            start=start+mins+":";
            start=start+s;
            return start;
        }
        function hide(){
            $("#success").css("display","none");
        }
        //下滑加载更多
        function load_more(){
            if(parseInt(jQuery(document).scrollTop())>=parseInt(jQuery(document).height())-parseInt(jQuery(window).height())){
                get_competitor()
            }
        }
        //定义in_array 属性
        Array.prototype.in_array = function(e)
        {
            for(i=0;i<this.length;i++)
            {
                if(this[i] == e)
                    return true;
            }
            return false;
        }
        //定义删除属性 js 还真麻烦
        Array.prototype.remove = function(val) {
            var index = this.indexOf(val);
            if (index > -1) {
                this.splice(index, 1);
            }
        };
    })
</script>
</body>
</html>