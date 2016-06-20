<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>茶样添加</h3>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1" action="<?php echo urlAdmin('mb_tasters_recommend', 'recommend_update'); ?>" enctype="multipart/form-data">
      <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="vatop rowform"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">关联产品id:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="goods_id" id="brand" value="<?php echo $output['recommendInfo']['recommend_goods_id']; ?>" class="txt" type="text">
            </td>
            <td class="vatop tips"></td>
        </tr>
       
        <tr>
          <td colspan="2" class="required"><label class="validation">产品得分:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
              <input name="score" id="brand" value="<?php echo $output['recommendInfo']['recommend_score']; ?>" class="txt" type="text">
          </td>
          <td class="vatop tips"></td>
        </tr>

        <tr>
            <td colspan="2" class="required"><label class="validation">口感:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="taste" id="year" value="<?php echo $output['recommendInfo']['recommend_taste']; ?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
         <tr>
            <td colspan="2" class="required"><label class="validation">汤色:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="light" id="" value="<?php echo $output['recommendInfo']['recommend_light']; ?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">香气:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="aroma" id="" value="<?php echo $output['recommendInfo']['recommend_aroma']; ?>" class="txt" type="text">
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">叶底:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="leaf" id="" value="<?php echo $output['recommendInfo']['recommend_leaf']; ?>" class="txt" type="text">
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">显示状态:1为显示 0关闭:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="state" id="" type="text" value="<?php echo $output['recommendInfo']['recommend_state']; ?>">
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">排序(数字大往前):</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input id="sort" name="sort" id="" type="text" value="<?php echo $output['recommendInfo']['recommend_sort']; ?>">
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
      <input name="recommend_id" id="" type="hidden" value="<?php echo $output['recommendInfo']['recommend_id']; ?>">
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
</script>
