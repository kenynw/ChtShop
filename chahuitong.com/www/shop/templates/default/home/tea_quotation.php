<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/class.css" rel="stylesheet">
<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/index.css" rel="stylesheet">
<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/hangqing.css" rel="stylesheet">
<div class="mail">
<div class="paixu">
<ul id="paixu">
<li class="pinpai">
<label>品牌：</label>
<div class="list" style="height:50px;">
    <?php if(isset($output['brandNames'])){ foreach($output['brandNames'] as $v ){  ?>
<span><a id="<?php echo $v['brand_id']; ?>" class="brand"><?php echo $v['brand_name']; ?></a></span>
    <?php }} ?>
  <input type="hidden" name="brand_id" value="">
<div id="img"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/top03.png"></div>
</div>
</li>
<li>
<label>茶区：</label>
<div class="list">
<span><a class="area" id="1">勐海茶区</a></span><span><a class="area" id="2">普洱茶区</a></span><span><a class="area" id="3">临沧茶区</a></span><span><a class="area" id="area4">易武茶区</a></span>
    <input type="hidden" name="area" value="">
</div>
</li>
<li>
<label>年份：</label>
<div class="list">
<span><a class="age" id="1">5年（含）--10年（不含）</a></span><span><a class="age" id="2">3年（含）--5年（不含）</a></span><span><a class="age" id="3">1年（含）--3年（不含）</a></span><span><a class="age" id="4">1年以下</a></span><span><a class="age" id="5">10年以上</a></span>
    <input type="hidden" name="age" value="">
</div>
</li>
<li>
<label>茶叶：</label>
<div class="list">
<span><a class="type" id="1">普洱熟茶</a></span><span><a class="type" id="2">普洱生茶</a></span>
    <input type="hidden" name="type" value="">
</div>
</li>
<li style="border:none;">
<label>价格：</label>
<div class="list">
<input type="number" placeholder="￥" id="min_price">-<input type="number" placeholder="￥" id="max_price">

</div>
</li>
</ul>
</div>
<div class="lister">
<div>
<span class="year">年份</span><span class="name">名称</span><span class="pihao">批号</span>
<span class="xz">形状</span><span class="zd">涨跌</span><span class="price">单价（元/件）</span>
<span class="data">发布日期</span><span class="zs">价格走势</span><span class="wt">委托</span>
</div>
<ul>
<?php if(isset($output['quotations'])){foreach($output['quotations'] as $v){?>
<li>
        <span class="year"><?php echo $v['year']; ?></span><span class="name"><?php echo $v['brand_name']; ?></span><span class="pihao">1401</span>
        <span class="xz">饼茶</span><span class="zd"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/sheng.png"></span><span class="price"><?php echo $v['price']; ?></span>
        <span class="data">19th.Nov.</span><span class="zs"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/hq.png"></span><span class="wt">求购</span>
    </li>
<?php }} ?>
</ul>
</div>
<div class="page">
<div class="num">
    <?php echo $output['page']; ?>
    <span class="tz">跳转到</span>
<input type="number" id="num"><input type="button" value="GO" id="btn"></div>
</div>
</div>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/js/hangqing.js"></script>
<script src="<?php echo SHOP_TEMPLATES_URL;?>/js/jquery-1.4.4.min.js"></script>
<script>
    $(document).ready(function(){
        $(".list span").click(function() {
            var url = "<?php echo $output['url']; ?>";
            var params = '';
            $("#paixu .on").each(function () {
                params += "&" + $(this).find("a").attr("class") + "="
                params += $(this).find("a").attr("id")

            })
            if($("#min_price").val()!=''){
                params += "&" + "min_price=";
                params += $("#min_price").val();
            }
            if($("#max_price").val()!=''){
                params += "&" + "max_price=";
                params += $("#max_price").val();
            }

            url = url + params;
            //alert(url)
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    $(".lister ul").html('');
                    $(".page").html('');
                    if(data.code==200){
                        json=data.content;
                        for(var i=0; i<json.length; i++)
                        {
                          var html='<li><span class="year">'+json[i].year+'</span><span class="name">'+json[i].brand_name+'</span><span class="pihao">1401</span><span class="xz">饼茶</span><span class="zd"><img src="http://localhost/localweb/shopnc/shop/templates/default/images/sheng.png"></span><span class="price">'+json[i].price+'</span><span class="data">19th.Nov.</span><span class="zs"><img src="http://localhost/localweb/shopnc/shop/templates/default/images/hq.png"></span><span class="wt">求购</span></li>';
                          $(".lister ul").append(html)
                        }
                    }
                },
                dataType: "json"
            })
        })


        $("#max_price").change(function() {
            var url = "<?php echo $output['url']; ?>";
            var params = '';
            $("#paixu .on").each(function () {
                params += "&" + $(this).find("a").attr("class") + "="
                params += $(this).find("a").attr("id")

            })
            if($("#min_price").val()!=''){
                params += "&" + "min_price=";
                params += $("#min_price").val();
            }
            if($("#max_price").val()!=''){
                params += "&" + "max_price=";
                params += $("#max_price").val();
            }

            url = url + params;
            //alert(url)
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    $(".lister ul").html('');
                    //alert(data.msg)
                    $(".page").html('');
                    if(data.code==200){
                        json=data.content;
                        for(var i=0; i<json.length; i++)
                        {
                            var html='<li><span class="year">'+json[i].year+'</span><span class="name">'+json[i].brand_name+'</span><span class="pihao">1401</span><span class="xz">饼茶</span><span class="zd"><img src="http://localhost/localweb/shopnc/shop/templates/default/images/sheng.png"></span><span class="price">'+json[i].price+'</span><span class="data">19th.Nov.</span><span class="zs"><img src="http://localhost/localweb/shopnc/shop/templates/default/images/hq.png"></span><span class="wt">求购</span></li>';
                            $(".lister ul").append(html)
                        }
                    }
                },
                dataType: "json"
            })
        })






    })

</script>