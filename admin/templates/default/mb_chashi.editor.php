<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>茶市信息编辑</h3>
      <ul class="tab-base">
          
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1" action="<?php echo urlAdmin('mb_chashi', 'chashi_save');?>">
     <input name="id" type="hidden" value="<?php echo $output['info']['id'] ?>">
      <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="vatop rowform"></td>
          <td class="vatop tips"></td>
        </tr>
       
        <tr>
          <td colspan="2" class="required"><label class="validation">品牌:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
              <input name="brand" id="brand" value="<?php echo $output['info']['brand'];?>" class="txt" type="text">
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">产品名:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="name" id="name" value="<?php echo $output['info']['name'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">年份:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="year" id="alipay_partner" value="<?php echo $output['info']['year'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
         <tr>
            <td colspan="2" class="required"><label class="validation">价格:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="price" id="" value="<?php echo $output['info']['price'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
          <tr>
            <td colspan="2" class="required"><label class="validation">销售方式:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="saleway" id="" type="radio" value="1" <?php  if($output['info']['saleway']==1){ echo "checked='checked'" ; }  ?>>卖 <input name="saleway" id="" type="radio" value="2" <?php  if($output['info']['saleway']==2){ echo "checked='checked'" ; }  ?>>买
               
            </td>
          <td class="vatop tips"></td>
        </tr>
   
       <tr>
            <td colspan="2" class="required"><label class="validation">排序:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="recommend" id="" type="text" value="<?php echo $output['info']['recommend'] ?>">
               
            </td>
          <td class="vatop tips"></td>
        </tr>
       
       <tr>
            <td colspan="2" class="required"><label class="validation">添加日期:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="addtime" id="" type="text" value="<?php echo $output['info']['addtime'] ?>">
               
            </td>
          <td class="vatop tips"></td>
        </tr> 
        
       <tr>
            <td colspan="2" class="required"><label class="validation">图片:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <?php
                
				   $pics=explode(",",$output['content']['depic']);
				   
				   foreach($pics as $pic){
					   
					   if($pic!=''){
					   
					   echo "<span style='display:inline-block;padding:0 10px;' class='img'><img src='/mobile/app/b2b/Public/upload/{$pic}' height='30px'></span>";
					   
					   }
					   
					   
					   }
				
				
				
				
				 ?>
               
            </td>
          <td class="vatop tips"></td>
        </tr>    
        
      <tr>
            <td colspan="2" class="required"><label class="validation">描述:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform"  colspan="2"  >
                <textarea name="content" rows="10" cols="40" style="width:400px;height:100px;"><?php echo $output['content']['content'] ?></textarea>
               
            </td>
         
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
