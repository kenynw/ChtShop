<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>社区微博编辑</h3>
      <ul class="tab-base">
          
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1" action="<?php echo urlAdmin('mb_shequ', 'mb_newsadd');?>" enctype="multipart/form-data">
     <input name="content_id" type="hidden" value="<?php echo $output['shequ_info']['content_id'] ?>">
      <table class="table tb-type2 nobdb">
      <tbody>
         <tr>
            <td colspan="2" class="required"><label class="validation">标题:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="title" value="<?php echo $output['shequ_info']['title'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">分享数:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="share" id="share" value="<?php echo $output['shequ_info']['share'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">评论数:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="comment" id="comment" value="<?php echo $output['shequ_info']['comment'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
         <tr>
            <td colspan="2" class="required"><label class="validation">点赞数:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="view" id="view" value="<?php echo $output['shequ_info']['view'];?>" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
              
       <tr>
            <td colspan="2" class="required"><label class="validation">图片:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <?php
                
				   $pics=explode(",",$output['shequ_info']['image']);
				   
				   foreach($pics as $pic){
					   
					   if($pic!=''){
					   
					   echo "<span style='display:inline-block;padding:0 10px;' ><img src='../data/upload/qunzi/{$pic}' height='30px' class='img'><span style='color:red;padding:5px' class='delimg'>x</span></span>";
					   
					   }
					   
					   
					   }
				
				
				
				
				 ?>
               
            </td>
          <td class="vatop tips"></td>
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
                <textarea name="content" rows="10" cols="40" style="width:400px;height:100px;"><?php echo $output['shequ_info']['content'] ?></textarea>
               
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
