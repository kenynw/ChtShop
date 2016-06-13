<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0,maximum-scale=1.0, user-scalable=no" name="viewport">
<title>活动详情</title>
<link type="text/css" href="/wap/Public/Home/css/voteclass.css" rel="stylesheet">
<link type="text/css" href="/wap/Public/Home/css/votedetails.css" rel="stylesheet">
<link type="text/css" href="/wap/Public/Home/css/vote.css" rel="stylesheet">
<script>
    function readFile(obj){
        var file = obj.files[0];
        //判断类型是不是图片
        if(!/image\/\w+/.test(file.type)){
            alert("请确保文件为图像类型");
            return false;
        }
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e){
            //alert(this.result);
            //就是base64
           document.getElementById("image11").value=this.result;
            document.getElementById("image333").src=this.result;
            document.getElementById("image333").style.display="block";
        }
    }
</script>
</head>
<body>
<header><a href="javaScript:window.history.back();"><img src="http://www.chahuitong.com/wap/Public/Home/img/arrow.png"></a>活动详情<a href="#"><img style="width:25px;" src="http://www.chahuitong.com/wap/Public/Home/img/share.png"></a></header>
<div class="vote">
<img src="">
<h4 id="list"><a class="on"><span>活动详情</span></a><a><span>报名</span></a></h4>
<div class="huodong">
<p id="enroll_time"></p>
<p id="vote_time"></p>
<div id="desc"></div>
</div>
<div class="baoming">
<h5><span></span>报名流程</h5>
<ul id="notice">
<li>1、未注册茶汇通的用户请先<a href="/wap/index.php/Home/Index/register">注册</a></li>
<li>2、老用户请先<a href="/wap/index.php/Home/Index/login">登录</a></li>
<li>3、用户登录后，按以下格式报名</li>
</ul>
<form>
<ul>
<li><label>泡茶人</label><input type="text" placeholder="输入昵称或姓名" required name="name"></li>
<li><label>手机号</label><input type="tel" placeholder="输入手机号" required name="mobile"></li>
    <!--
    <li><label>地&nbsp;&nbsp;&nbsp;址</label><span><select id="area_1"></select>省<select id="area_2"></select>市<select id="area_3"></select>区</span></li>
<li><label>街&nbsp;&nbsp;&nbsp;道</label><input type="text" required name="address"></li>
    -->
    <input type="hidden" name="province" value="">
    <input type="hidden" name="city" value="">
    <input type="hidden" name="country" value="">
    <input type="hidden" id="image11" name="image" value="1111">

</ul>

<div class="file"><input id="file" type="file"  name="avatar" onchange="readFile(this)"><label for="file" id="show"><img id="image333" style="display:none"src="" width="100%;" height="100%"></label></div>
</form>
    <button style="background: #1b8b80;
  color: #fff;
  font-size: 1.1em;
  letter-spacing: 0.4em;
  width: 100%;
  line-height: 36px;
  border: none;
  border-radius: 5px;">提交报名</button>
</div>
</div>
<div id="success">
<div id="msses"></div>
</div>

<div id="msg" style="display:none;width:100%;height:10%;position:fixed;top:40%;background:red;color:#ffffff;text-align:center;vertical-align: middle;
padding-top:10%">
</div>
<script src="/wap/Public/Home/js/config.js"></script>
<script src="/wap/Public/Home/js/jquery-1.4.4.min.js"></script>
<script src="/wap/Public/Home/js/jquery.cookie.js"></script>
<script src="/wap/Public/Home/js/mj.js"></script>
<script>
    $(document).ready(function(){
        var activity_id=<?php echo ($activity_id); ?>;
        init();
        submit();
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
                        $("#desc").html(data.data.activity_description);
                        //报名时间
                        var enroll_start_time = get_date(data.data.activity_enroll_start_time);
                        var enroll_end_time = get_date(data.data.activity_enroll_end_time);
                        var enroll_time = "报名时间：<span>" + enroll_start_time + "--" + enroll_end_time + "</span>";
                        $("#enroll_time").html(enroll_time);
                        //投票时间
                        var vote_start_time = get_date(data.data.activity_vote_start_time);
                        var vote_end_time = get_date(data.data.activity_vote_end_time);
                        var vote_time = "投票时间：<span>" + vote_start_time + "--" + vote_end_time + "</span>";
                        $("#vote_time").html(vote_time);
                        //是否登陆判断
                        if($.cookie("key")){
                            $("#notice").css("display","none");
                        }

                    }
                }
            })
        }
        //格式化时间函数
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
        //获取省份地址函数
        function get_area_id(area_id,deep_id){
            if(area_id=='') area_id=0;
            $.ajax({
                url:ApiUrl + "/index.php?act=vote_activity&op=get_area",
                type:"post",
                dataType:"json",
                data:{parent_id:area_id},
                success:function(data){
                    var option='<option value="-1">选择区域</option>';
                    for(var value in data.data){
                        option+='<option value="'+data.data[value].area_id+'">'+data.data[value].area_name+'</option>';
                    }
                    //alert(option);
                    $("#area_"+deep_id).html(option);
                }
            })
        }
        //点击省份获取城市
        function get_city(){
            $("#area_1").change(function(){
                var area_id=$("#area_1  option:selected").val();
                var area_text=$("#area_1  option:selected").text();
                $("input[name='province']").val(area_text);
                get_area_id(area_id,2);
                get_country();
            })
        }
        //点击城市获取县
        function get_country(){
            $("#area_2").change(function(){
                var area_id=$("#area_2  option:selected").val();
                var area_text=$("#area_2  option:selected").text();
                $("input[name='city']").val(area_text);
                get_area_id(area_id,3);
                save_contry();
            })
        }
        //点击县保存
        function save_contry(){
            $("#area_3").change(function() {
                var area_text = $("#area_3  option:selected").text();
                $("input[name='country']").val(area_text);
            })
        }
        //提交表单报名
        function submit(){
            $("button").click(function(){
                if(!$.cookie("key")){
                    $("#msses").html("您还未登陆<br><br><a href='/wap/index.php/Home/Index/login'>登陆</a>");
                    $("#success").css("display","block");
                    setTimeout(hide,3000 );

                }else{
                    var key=$.cookie("key")
                    var province=$("input[name='province']").val();
                    var city=$("input[name='city']").val();
                    var country=$("input[name='country']").val();
                    var name=$("input[name='name']").val();
                    var mobile=$("input[name='mobile']").val();
                    var address=$("input[name='address']").val();
                    var image=$("input[name='image']").val()

                    $.ajax({
                        url:ApiUrl+"/index.php?act=vote_activity&op=activity_vote_api",
                        type:"post",
                        data:{key:key,province:province,city:city,country:country,name:name,address:address,mobile:mobile,activity_id:activity_id,image:image},
                        dataType:"json",
                        success:function(data){
                           if(data.code==1){
                               $("#msses").html("报名完成查看选手<br><br><a href='/wap/index.php/Home/Index/activity_vote'>查看</a>");
                               $("#success").css("display","block");
                               setTimeout(hide,8000 );
                           }else{
                               $("#msses").text(data.msg);
                               $("#success").css("display","block");
                               setTimeout(hide,3000 );
                           }
                        }
                    })
                }

            })
        }
        function hide(){
            $("#success").css("display","none");
        }

        var list = id('list');
        var listA = tag('a',list);
        listA[0].addEventListener('click',function(e){
            e.preventDefault();
            listC(listA);
            listA[0].className = 'on';
            cN('huodong')[0].style.display = 'block';
            cN('baoming')[0].style.display = 'none';
        },false);
        listA[1].addEventListener('click',function(e){
            e.preventDefault();
            listC(listA);
            listA[1].className = 'on';
            cN('huodong')[0].style.display = 'none';
            cN('baoming')[0].style.display = 'block';
            get_area_id(0,1);
            get_city();
        },false);

    })
</script>

</body>
</html>