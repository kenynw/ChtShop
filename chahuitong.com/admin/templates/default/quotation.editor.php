<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>茶市行情添加</h3>
      <ul class="tab-base">
          
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1" action="<?php echo urlAdmin('mb_chashi', 'quotation_save');?>" enctype="multipart/form-data">
      <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="vatop rowform"></td>
          <td class="vatop tips"></td>
        </tr>
       
        <tr>
          <td colspan="2" class="required"><label class="validation">品名 :</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
              <input name="brand_name" id="image" type="text" value="<?php echo $output['quotation']['brand_name']; ?>">
              
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">品牌 :</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <select name="brand_id">
                    <?php echo $output['quotation']['brand_id']; ?>
                </select>

            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">产品连接:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="goods_link" id="link" value="<?php echo $output['quotation']['goods_link']; ?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        
         <tr>
            <td colspan="2" class="required"><label class="validation">年份:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="year" id="" value="<?php echo $output['quotation']['year']; ?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">参考价:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="price" id="" type="text" value="<?php echo $output['quotation']['price']; ?>">
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">单位:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="unit" id="" type="text" value="<?php echo $output['quotation']['unit']; ?>">
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">排序:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="order" id="" type="text" value="<?php echo $output['quotation']['order']; ?>">
                <input name="op" id="" type="hidden" value="editor">
                <input name="id" id="" type="hidden" value="<?php echo $output['quotation']['id']; ?>">
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
<script>
$(document).ready(function(){
		$(".img").click(function(){
			
			
			var src=$(this).find("img").attr("src");
			
			$(".showimg").append("<div class='hideimg'><img src='"+src+"' width='300px' height='300px'></div>");
			
			$(".page").css("opacity","0.3");
			
			$(".showimg").show();
		
			})
			
		$(".showimg").click(function(){
			
			$(".showimg").html("");
			
			$(".page").css("opacity","1");
			
			$(".showimg").hide();
			
			
			})	
			
	 	$("#btn_submit").click(function(){
			
			$("#post_form").submit();
			
			
			})	
	
});
</script>
