<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>样品列表</h3>
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
        <th>选项</th>
        <th>数量</th>
        <th>产地</th>
          <th >运费</th>
          <th class="align-center">名称</th>
        <th class="align-center">重量</th>

        <th class="align-center">图片</th>
        <th class="align-center">开始时间</th>
          <th class="align-center">结束时间</th>
          <th class="align-center">已领</th>
          <th class="align-center">状态</th>
        <th class="align-center" style="width:60px;"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
        <?php if(!empty($output['sampleList']) && is_array($output['sampleList'])){ ?>
        <?php foreach($output['sampleList'] as $k => $v) { ?>
      <tr class="hover" id="<?php echo $v['id']; ?>"  >
        <td ><input name="chashi[]" type="checkbox" value="<?php echo $v['sample_id']; ?>"></td>
        <td><?php echo $v['sample_limit_number']; ?></td>
        <td><?php echo $v['sample_origin_place']; ?></td>
          <td><?php echo $v['sample_freight']; ?></td>
          <td class="w25pre align-center"><?php echo $v['sample_name']; ?></td>
        <td><?php echo $v['sample_weight']; ?></td>

        <td class="w25pre align-center"><?php
                                          $imageArray=explode(',',$v['sample_image']);
                                          foreach($imageArray as $image){
                                              echo "<img src='../data/upload/shop/store/goods/2/$image' width='50'>";
                                          }
                                        ?></td>
        <td class="w25pre align-center"><?php echo date("Y-m-d H:i",$v['sample_start_time']); ?></td>
          <td class="w25pre align-center"><?php echo date("Y-m-d H:i",$v['sample_end_time']); ?></td>
          <td class="w25pre align-center"><?php echo $v['sample_received_number']; ?></td>
          <td class="w25pre align-center"><?php
                                           $stateArray=array(0=>'不显示',1=>'显示');
                                           echo $stateArray[$v['sample_state']];
                                          ?></td>
        <td class="w156 align-center" style="width:15%">
            <a onclick="return confirm('确定将此记录删除?')" href="<?php echo urlAdmin('mb_sample_manage','sample_delete',array('sample_id'=>$v['sample_id'])); ?>">删除</a>
            <a href="<?php echo urlAdmin('mb_sample_manage','sample_editor',array('sample_id'=>$v['sample_id'])); ?>">编辑</a>
        </td>
      </tr>
      <?php } } ?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
          <td ></td>
        <td class="choice" style="width:10%"><input name="choice" type="checkbox" checked="checked" value="1">全选</td>
        <td class="delall" >删除</td>

           <td ><a href="<?php echo urlAdmin('mb_sample_manage','sample_add'); ?>">添加</a></td>
        <td colspan="30"> <div class="pagination"> <?php echo $output['page'];?> </div></td>
        <td ></td>
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