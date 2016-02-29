<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>社区微博</h3>
      <ul class="tab-base"><li><a class="current"><span>列表</span></a></li></ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
           
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2" id="list">
    <thead>
      <tr class="thead">
        <th>选项</th>
        <th>用户</th>
        <th class="align-center"></th>
        <th class="align-center"></th>
        <th class="align-center"></th>
         <th class="align-center"></th>
         <th class="align-center">电话</th>
        <th class="align-center">报名时间</th>
         <th class="align-center"></th>
        <th class="align-center"></th>
      </tr>
    </thead>
    <tbody>
        <?php if(!empty($output['persons']) && is_array($output['persons'])){ ?>
        <?php foreach($output['persons'] as $k => $v) { ?>
      <tr class="hover" id="<?php echo $v['active_id']; ?>"  >
        <td ><input name="shequ[]" type="checkbox" value="<?php echo $v['active_id']; ?>"></td>
        <td><?php echo $v['member_name']; ?></td>
        <td></td>
        <td><?php echo $v['share'];?></td>
        <td><?php echo $v['telphone'];?></td>
        <td></td>
        <td></td>
        <td class="w25pre align-center"><?php echo $v['join_time'];?></td>
        <td class="w25pre align-center"><?php echo $v['image'];?></td>
        <td class="w156 align-center" style="width:15%"></td>
      </tr>
      <?php } } ?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
      
      </tr>
    </tfoot>
  </table>
</div>
<script>
  $(".choice").click(function(){
	  if($("input[name='choice']").val()==1){
	  $("#list input[type='checkbox']").attr("checked",true);
	  $("input[name='choice']").val(0);
	  }else{
		$("#list input[type='checkbox']").attr("checked",false);
		$("input[name='choice']").val(1); 
		  }	  
	  })
	
  $("input[name='search']").click(function(){
	  
	  $(this).val("");
	  
	  })
	  
  $("input[name='recommend']").change(function(){
	  
	  id=$(this).parent().parent().attr("id");
	  
	  recommend=$(this).val();
	  
	
	  $.ajax({
		  
		  url:"/admin/index.php?act=mb_chashi&op=chashiajax_recommend",
		  
		  type:"post",
			 
		  
		  data:{id:id,recommend:recommend},
		  
		  dataType:"json",
		  
		  success:function(data){
			  
			  if(data.state=='right'){
			  	$(this).val(data.info)	;
				document.location.reload();
			  }else{
				  alert(data.info)  
				  }
				
				  
			  }	  
		  
		  })
	  
	  
	  
	  
	  })	  	  
	  
  $(".delall").click(function(){
	  
	  if(confirm("确定删除")){
		  
		 $(".hover input:checked").each(function(){
			 
			 $content_id=$(this).val();
			 
			 $.ajax({
			 
			 url:"/admin/index.php?act=mb_shequ&op=shequajax_del&content_id="+$content_id,
			 
			 type:"get",
			 
			 dataType:"json",
			 
			 success:function(data){
				 
				   if(data.result==1){
					   
					   $("#"+data.id).hide();
					   
					   }
				 
				 }
			  
			  
			 })
		 
			 }) 
		  }
  
	  })	  
</script>