<?php
require_once "getSdk.php";
$jssdk = new JSSDK("", "");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
  TEST..
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
//alert("<?php echo $signPackage["rawString"]?>");
  wx.config({
	  debug:true,
	  appId: '<?php echo $signPackage["appId"];?>',
	    timestamp: <?php echo $signPackage["timestamp"];?>,
	    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
	    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
        'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
      ]
  });
	  wx.ready(function () {
		  var shareData = {
		  title: '测试',
		  desc: '测试',
		  link: 'http://www.lanrenmb.com',
		  imgUrl: 'http://www.lanrenmb.com/templets/lanrenmb/img/logo.png'
		  };
		  wx.onMenuShareAppMessage(shareData);
		  wx.onMenuShareTimeline(shareData);
		  });
		  wx.error(function (res) {
		  console.log(res.errMsg);
  });
</script>



<?php print_r ($signPackage);?>






</html>
