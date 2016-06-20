<?php
define("ctoken",true);
require_once("../../API/comm/conn.php");
require_once("../../API/qqConnectAPI.php");
$qc = new QC();
$acs=$qc->qq_callback();
if(!isset($acs)){
	
	echo '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>正在进入</title>
</head>
<body>
<form name=loading> 
　<p align=center> <font color="#0066ff" size="2">密码错误</font><font color="#0066ff" size="2" face="Arial">...</font>
　　<input type=text name=chart size=46 style="font-family:Arial; font-weight:bolder; color:#0066ff; background-color:#fef4d9; padding:0px; border-style:none;"> 
　　
　　<input type=text name=percent size=47 style="color:#0066ff; text-align:center; border-width:medium; border-style:none;"> 
　　<script>　 
var bar=0　 
var line="||"　 
var amount="||"　 
count()　 
function count(){　 
bar=bar+2　 
amount =amount + line　 
document.loading.chart.value=amount　 
document.loading.percent.value=bar+"%"　 
if (bar<99)　 
{setTimeout("count()",100);}　 
else　 
{window.location = "http://www.chahuitong.com/wap/index.php/Home/Index/login";}　 
}</script> 
　</p> 
</form> 
<p align="center"> 如果您的浏览器不支持跳转,<a style="text-decoration: none" href="http://www.chahuitong.com/wap/index.php/Home/Index/login"><font color="#FF0000">请点这里</font></a>.</p>
</body>
</html>
';
	
die();	
	}
$openid=$qc->get_openid();

//echo "<br>";
$qc = new QC($acs,$openid);
$arr = $qc->get_user_info();
$sql="select * from shopnc_member where `member_qqopenid`='$openid'";

$res=mysql_query($sql);

$row=mysql_num_rows($res);
if($row==0){	
	$number=rand(100,999);	
	$member_name=$arr["nickname"].$number;
	$member_sex=$arr['gender'];
	$member_passwd=123456;
	$member_qqopenid=$openid;
	$member_qqinfo=serialize($arr);
	$sql="insert into shopnc_member (`member_name`,`member_sex`,`member_passwd`,`member_qqopenid`,`member_qqinfo`) values ('$member_name','$member_sex','".md5($member_passwd)."','$member_qqopenid','$member_qqinfo')";
	//echo "<br>";
	//echo $sql;
	$result=mysql_query($sql);
	if(!$result){echo "插入数据失败";}	
	$url="http://www.chahuitong.com/mobile/index.php?act=login";
	$post_data=array("username"=>$member_name,"password"=>"123456","client"=>"wap");	
	$ch = curl_init();	
	curl_setopt($ch, CURLOPT_URL, $url);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	curl_close($ch); 
	$array=json_decode($output,true);
	if(isset($array['datas']['key'])){
		
		setcookie("username",$array['datas']['username'],time()+3600,'/');
		
		setcookie("key",$array['datas']['key'],time()+3600,'/');
		
		header("Location:http://www.chahuitong.com/wap/index.php/Home/Index/member");	
		
		}
	
	
		}else{
			
		$row=mysql_fetch_array($res);	
		
		$openid=$row['member_qqopenid'];
		
		
		$url="http://www.chahuitong.com/mobile/index.php?act=login";
		
	   $post_data=array("member_qqopenid"=>$openid,"client"=>"wap");	
	   
	   $ch = curl_init();	
	   
	   curl_setopt($ch, CURLOPT_URL, $url);	
	   
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	  
	   curl_setopt($ch, CURLOPT_POST, 1);
	   
       curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	   
	   $output = curl_exec($ch);
	   
	   
	   
	    curl_close($ch); 
		
		//echo $output;
		
	   $array=json_decode($output,true);
	   
	   if($array['code']=='200'){
		
		setcookie("username",$array['datas']['username'],time()+3600,'/');
		
		setcookie("key",$array['datas']['key'],time()+3600,'/');
		
		header("Location:http://www.chahuitong.com/wap/index.php/Home/Index/member");	
		
		}
	
	
		
		
		
		
			
			
			
			
			
			
			}