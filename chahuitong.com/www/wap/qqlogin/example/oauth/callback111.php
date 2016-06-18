<?php
define("connect",true);
require_once("../../API/conn.php");
require_once("../../API/qqConnectAPI.php");
$qc = new QC();
echo $qc->qq_callback();
//echo "<br>";
echo $openid=$qc->get_openid();
//echo "<br>";
$arr = $qc->get_user_info();
$sql="select * from shopnc_member where `member_qqopenid`='$openid'";

$res=mysql_query($sql);

$row=mysql_num_rows($res);
if($row==0){	
	/*$number=rand(100,999);	
	$member_name=$arr["nickname"].$number;
	$member_sex=$arr['gender'];
	$member_passwd=123456;
	$member_qqopenid=$openid;
	$member_qqinfo=serialize($arr);
	$sql="insert into shopnc_member (`member_name`,`member_sex`,`member_passwd`,`member_qqopenid`,`member_qqinfo`) values ($member_name,$member_sex,{md5($member_passwd)},$member_qqopenid,$member_qqinfo)";
	$result=mysql_query($sql);
	if(!$result){echo "插入数据失败";}	
	$url="/mobile/index.php?act=login";
	$data=array("username"=>$member_name,"password"=>"123456","client"=>"wap");	
	$ch = curl_init();	
	curl_setopt($ch, CURLOPT_URL, $url);	
	curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	curl_close($ch);
    print_r($output);	*/
		}

