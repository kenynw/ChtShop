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
  <form id="post_form" method="post" name="form1" action="<?php echo urlAdmin('mb_shequ', 'shequ_insert');?>" enctype="multipart/form-data">
      <table class="table tb-type2 nobdb">
      <tbody>
         <tr>
            <td colspan="2" class="required"><label class="validation">标题:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="uid" value="<?php echo $output['member_id']; ?>" class="txt" type="hidden">
                <input name="title" value="" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">分享数:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="share" id="share" value="" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label class="validation">评论数:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="comment" id="comment" value="" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
         <tr>
            <td colspan="2" class="required"><label class="validation">点赞数:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="view" id="view" value="" class="txt" type="text">
            </td>
          <td class="vatop tips"></td>
        </tr>
              
       <tr>
            <td colspan="2" class="required"><label class="validation">图片:</label> </td>
        </tr>
        <tr class="noborder">
          <td class="vatop tips"></td>
        </tr>  
        
        <tr class="noborder">
            <td class="vatop rowform">
                <input name="image1"  class="image01" type="file">
                <input name="image2"  class="image02" type="file">
                <input name="image3"  class="image03" type="file">
                <input name="image4"  class="image04" type="file">
                <input name="image5"  class="image05" type="file">
            </td>
          <td class="vatop tips"></td>
        </tr>   
        
      <tr>
            <td colspan="2" class="required"><label class="validation">内容:</label> </td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform"  colspan="2"  >
                <textarea name="content" rows="10" cols="40" style="width:400px;height:100px;"></textarea>
               
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
