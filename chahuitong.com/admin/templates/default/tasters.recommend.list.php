<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>试茶师推荐</h3>
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
            <li>搜索:<form method="post" action="<?php echo urlAdmin('mb_chashi','chashi_list'); ?>"><input name="key" value="查找" style="text-align:center" type="text" ><input type="submit" value="搜索"></form></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2" id="list">
    <thead>
      <tr class="thead">
        <th>id</th>
        <th>产品id</th>
        <th>添加时间</th>
          <th >得分</th>
          <th class="align-center">口感</th>
        <th class="align-center">汤色</th>
        <th class="align-center">叶底</th>
        <th class="align-center">香气</th>
          <th class="align-center">排序</th>
        <th class="align-center" style="width:60px;"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
        <?php if(!empty($output['recommends']) && is_array($output['recommends'])){ ?>
        <?php foreach($output['recommends'] as $k => $v) { ?>
      <tr class="hover" id="<?php echo $v['recommend_id']; ?>"  >
        <td ><input name="chashi[]" type="checkbox" value="<?php echo $v['commend_id']; ?>"></td>
        <td><?php echo $v['recommend_goods_id']; ?></td>
        <td class="w25pre align-center"><?php echo date("Y-m-d H:i:s",$v['recommend_time']); ?></td>
          <td ><?php echo $v['recommend_score']; ?></td>
          <td class="w25pre align-center"><?php echo $v['recommend_taste']; ?></td>
        <td><?php echo $v['recommend_light']; ?></td>
        <td class="w25pre align-center"><?php echo $v['recommend_leaf']; ?></td>
        <td class="w25pre align-center"><?php echo $v['recommend_aroma']; ?></td>
          <td class="w25pre align-center"><?php echo $v['recommend_sort']; ?></td>
        <td class="w156 align-center" style="width:15%">
            <a onclick="return confirm('确定将此记录删除?')" href="<?php echo urlAdmin('mb_tasters_recommend','recommend_del',array('recommend_id'=>$v['recommend_id'])); ?>">删除</a>
            <a href="<?php echo urlAdmin('mb_tasters_recommend','recommend_editor',array('recommend_id'=>$v['recommend_id'])); ?>">编辑</a>
        </td>
      </tr>
      <?php } } ?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
          <td ></td>
        <td class="choice" style="width:10%"><input name="choice" type="checkbox" checked="checked" value="1">全选</td>
        <td class="delall" >删除</td>

           <td ><a href="<?php echo urlAdmin('mb_tasters_recommend','recommend_add'); ?>">添加</a></td>
        <td colspan="30"> <div class="pagination"> <?php echo $output['page'];?> </div></td>
        <td ></td>
      </tr>
    </tfoot>
      <?php echo $output['page']; ?>
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
		  
		  //url:"/admin/index.php?act=mb_chashi&op=chashiajax_recommend",
		  
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
			 
			 $chashi_id=$(this).val();
			 
			 $.ajax({
			 
			 url:"/admin/index.php?act=mb_chashi&op=chashiajax_del&chashi_id="+$chashi_id,
			 
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