<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>茶市_茶汇通</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link href="/ecshop/mobile/themes/default/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
</script>
</head>
<body>
<div id="page">
  <header id="header">
    <div class="header_l"> <a class="ico_10" href="javascript:history.go(-1)"> 返回 </a> </div>
    <h1> 进入茶市 </h1>
  </header>
</div>
<section class="wrap">
  <div id="leftTabBox" class="loginBox">
    <div class="hd">
      <ul>
        <li class="on"><a href="javascript:void(0)">登录</a></li>
        <li class="regist"><a href="javascript:void(0)">注册</a></li>
      </ul>
    </div>
    <div class="bd">
      <ul>
        <div class="table_box">
          <form name="formLogin" action="/mobile/app/b2b/index.php/Home/Index/checklogin" method="post">
            <dl>
              <dd>
                <input placeholder="用户名" name="username" type="text" class="inputBg" style="border:1px solid #ddd" id="username" />
              </dd>
            </dl>
            <dl>
              <dd style="margin-bottom:15px;display:block">
                <input placeholder="密码"  name="password" type="password" class="inputBg" style="border:1px solid #ddd" />
              </dd>
            </dl>
                        <dl>
              <dd>
                <input type="checkbox" value="1" name="remember" id="remember" style="vertical-align:middle; zoom:100%;" />
                <label for="remember"> 一个月内免登录</label>
              </dd>
              <dd> <a href="/mobile/user.php?act=get_password" class="f6 f6_1">忘记密码</a> </dd>
            </dl>
            <dl>
              <dd>
                <input type="hidden" name="act" value="act_login" />
                <input type="submit" name="submit"  value="立即进入" class="c-btn3" />
              </dd>	
            </dl>
          </form>
        </div>
      </ul>
    </div>
</section>
<script type="text/javascript" src="/mobile/themes/default/js/zepto.min.js"></script>
<script type="text/javascript">
$(function(){
	$(".regist").click(function(){
		alert("茶市内测中，敬请期待！");
	})
})
</script>
</body>
</HTML>