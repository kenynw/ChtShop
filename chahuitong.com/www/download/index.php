<!DOCTYPE html>
<html>
<head>
    <title>茶汇通APP下载</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width;initial-scale=1.0"/>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        img {
            width: 100%;
        }
        .tip {
            top:0;
            display:none;
            position:fixed;
            background-color: black;
            height:100%;
            filter:alpha(opacity=70);
            -moz-opacity:0.7;
            opacity:0.7;
        }
    </style>

    <?php
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $iphone = (strpos($agent, 'iphone')) ? true : false;
        $ipad = (strpos($agent, 'ipad')) ? true : false;
        $android = (strpos($agent, 'android')) ? true : false;
        if($iphone || $ipad) {
            echo "<script type=\"text/javascript\">window.location.href='https://itunes.apple.com/cn/app/cha-hui-tong/id1024062041?mt=8'</script>";
        }
        if($android) {
            echo "<script type=\"text/javascript\">window.location.href='cht.apk'</script>";
        }
    ?>

    <script type="text/javascript">
        function show(){
            document.getElementById('tip').style.display="block";
            window.location="<?php echo $iphone || $ipad ? 'https://itunes.apple.com/cn/app/cha-hui-tong/id1024062041?mt=8' : 'cht.apk' ?>";
	    }
    </script>

</head>
<body>
    <div  onclick="show()"><a href="javascript:void(0)"><img src="download.jpg" /></a></div>
    <div id="tip" class="tip"><img src="weixin-tip.jpg"></div>

    <div style="display:none">
        <script type="text/javascript">
            var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
            document.write(unescape("%3Cspan id='cnzz_stat_icon_1255435809'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1255435809' type='text/javascript'%3E%3C/script%3E"));
        </script>
    </div>
    <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "//hm.baidu.com/hm.js?9a15ea23e7316c631085bb3ef722599a";
          var s = document.getElementsByTagName("script")[0];
          s.parentNode.insertBefore(hm, s);
        })();
    </script>
</body>
</html>