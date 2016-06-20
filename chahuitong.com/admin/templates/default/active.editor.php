<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>社区活动添加</h3>
      <ul class="tab-base">
          
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1" action="<?php echo urlAdmin('mb_shequ', 'active_update');?>" enctype="multipart/form-data">
      <table class="table tb-type2 nobdb">
      <tbody>
         <tr>
            <td colspan="2" class="required"><label class="validation">标题:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
            <input name="active_id" value="<?php echo $output['activeInfo']['active_id'];?>" class="txt" type="hidden">
            <input name="pics" value="<?php echo $output['activeInfo']['pics'];?>" class="txt" type="hidden">
                           <input name="active_title" value="<?php echo $output['activeInfo']['active_title'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">地点:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="location" id="share" value="<?php echo $output['activeInfo']['location'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">对象:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="object" id="comment" value="<?php echo $output['activeInfo']['object'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
         <tr>
            <td colspan="2" class="required"><label class="validation">人数:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="number" id="view" value="<?php echo $output['activeInfo']['number'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">报名时间:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="join_time" id="view" value="<?php echo $output['activeInfo']['join_time'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
       <tr>
            <td colspan="2" class="required"><label class="validation">活动时间:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="last_time" id="view" value="<?php echo $output['activeInfo']['last_time'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr> 
         <tr>
            <td colspan="2" class="required"><label class="validation">活动状态:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="state" id="view" value="<?php echo $output['activeInfo']['state'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr> 
              
       <tr>
            <td colspan="2" class="required"><label class="validation">图片:</label> </td>
        </tr>
        
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="image1"  type="file" >
                <input name="image2"  type="file" >
                <input name="image3"  type="file" >
                <input name="image4"  type="file" >
                <input name="image5"  type="file" >
                <input name="image6"  type="file" >
            </td>
          <td class="vatop tips"></td>
        </tr>   
        
      <tr>
            <td colspan="2" class="required"><label class="validation">内容:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform"  colspan="2"  >
                <textarea name="content" rows="10" cols="40" style="width:400px;height:100px;"><?php echo $output['activeInfo']['content'];?></textarea>
               
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
			
			
			var src=$(this).attr("src");
			
			$(".showimg").append("<div class='hideimg'><img src='"+src+"' width='300px' height='300px'></div>");
			
			$(".page").css("opacity","0.3");
			
			$(".showimg").show();
		
			})
			
		$(".showimg").click(function(){
			
			$(".showimg").html("");
			
			$(".page").css("opacity","1");
			
			$(".showimg").hide();
			
			
			})	
			
		$(".delimg").click(function(){
			
			$(this).parent().css("display","none");
			
			$(this).parent().find("img").removeClass("img");
			
			
			})	
			
	 	$("#btn_submit").click(function(){
			
			var imgarray=Array();
			
			$(".img").each(function(){
								
				imgarray.push($(this).attr("src").replace("../data/upload/qunzi/",""));
				
				
				})
			
			var string=imgarray.join(",");
			
			//alert(string);			
				
			$("input[name='oldimage']").val(string)
			
			$("#post_form").submit();
			
			
			})	
	
});
</script>
