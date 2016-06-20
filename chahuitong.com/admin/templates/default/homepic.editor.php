<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>首页图片编辑</h3>
      <ul class="tab-base">
          
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1" action="<?php echo urlAdmin('mb_chashi', 'adv_save');?>" enctype="multipart/form-data">
      <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="vatop rowform"></td>
          <td class="vatop tips"></td>
        </tr>
       
        <tr>
          <td colspan="2" class="required"><label class="validation">图片 :</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
              <input name="image" id="image" type="file">
              <input name="imageback" id="" type="hidden" value="<?php echo $output['pic']['image']; ?>">
              <input name="id" id="" type="hidden" value="<?php echo $output['pic']['id']; ?>">
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">产品连接:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="link" id="link" value="<?php echo $output['pic']['link']; ?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        
         <tr>
            <td colspan="2" class="required"><label class="validation">状态:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="state" id="" value="<?php echo $output['pic']['state']; ?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">位置:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <select name="location">
                    <option value="1"  <?php if($output['pic']['location']==1) echo "selected=selected"; ?>>首页轮播</option>
                    <option value="2"  <?php if($output['pic']['location']==2) echo "selected=selected"; ?>>目录轮播</option>
                    <option value="3"  <?php if($output['pic']['location']==3) echo "selected=selected"; ?>>首页品茶师推荐</option>
                    <option value="4"  <?php if($output['pic']['location']==4) echo "selected=selected"; ?>>首页限时特购</option>
                </select>
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">排序:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="order" id="" type="text" value="<?php echo $output['pic']['order']; ?>">             
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
