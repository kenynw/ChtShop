<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>茶样添加</h3>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1" action="<?php echo urlAdmin('mb_sample_manage', 'sample_save'); ?>" enctype="multipart/form-data">
      <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="vatop rowform"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">产品id:(填入产品id 可自动获取样品名称和样品图片)</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="goods_id" id="brand" value="" class="txt" type="text">
            </td>
            <td class="vatop tips"></td>
        </tr>
       
        <tr>
          <td colspan="2" class="required"><label class="validation">样品名:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
              <input name="sample_name" id="brand" value="" class="txt" type="text">
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="smaple_img">
            <td colspan="2" class="required"><label class="validation">样品图片:</label> </td>
        </tr>
        <tr class="noborder smaple_img">
            <td class="vatop rowform">
                <input name="sample_image[]" id="year"  class="txt" type="file">
                <input name="sample_image[]" id="year"  class="txt" type="file">
                <input name="sample_image[]" id="year"  class="txt" type="file">
                <input name="sample_image[]" id="year"  class="txt" type="file">
                <input name="sample_image[]" id="year"  class="txt" type="file">
                <input name="sample_image[]" id="year"  class="txt" type="file">
                <input name="sample_image_hidden" id="" type="hidden" value="">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">产地:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="sample_origin_place" id="year" value="" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
         <tr>
            <td colspan="2" class="required"><label class="validation">重量:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="sample_weight" id="" value="" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">价格:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="sample_price" id="" value="" class="txt" type="text">
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">运费:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="sample_freight" id="" type="text" value="免费">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">样品数量:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="sample_limit_number" id="" type="text" value="">
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">开始时间:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input id="start_time" name="sample_start_time" id="" type="text" value="">
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">结束时间:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input id="end_time" name="sample_end_time" id="" type="text" value="">
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">关联产品Id:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input id="sample_link" name="sample_link" id="" type="text" value="">
            </td>
            <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="btn_submit" ><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<div style="position:fixed;top:40%;left:35%;display:none;width:300px;height:300px;" class="showimg"></div>
<script type="text/javascript" src="../data/resource/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="../data/resource/js/common.js"></script>
<script type="text/javascript" src="../data/resource/js/ToolTip.js"></script>
<script src="../data/resource/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="../data/resource/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" type="text/css" href="../data/resource/js/jquery-ui/themes/ui-lightness/jquery.ui.css">
<link rel="stylesheet" type="text/css" href="../data/resource/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css">

<script>
    $(function(){$("#btn_submit").click(function(){

            $("#post_form").submit();
    });
    });
$(document).ready(function(){
    $("input[name='goods_id']").change(function(){
        var goods_id=$(this).val();
        $.ajax({
            url:"<?php echo urlAdmin('mb_sample_manage', 'get_info_by_goods_id');?>",
            type:"post",
            data:{goods_id:goods_id},
            dataType:'json',
            success:function(data){
                if(data.code==404){
                    alert(data.content);
                }else{
                    $("input[name='sample_name']").val(data.content.goods_name);
                    $("input[name='sample_image_hidden']").val(data.content.goods_image);
                    $("input[name='sample_link']").val(goods_id);
                    $(".smaple_img").hide();
                }
            }

        })
    })
    //开始时间
    $('#start_time').datetimepicker({
        controlType: 'select'
    });
    //结束时间
    $('#end_time').datetimepicker({
        controlType: 'select'
    });

});
</script>
