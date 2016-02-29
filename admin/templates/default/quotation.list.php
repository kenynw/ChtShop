<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>茶市信息</h3>
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
         <th>排序</th>
         <th>品牌</th>
         <th class="align-center"></th>
         <th class="align-center"> 年份</th>
         <th class="align-center">品名</th>
          <th class="align-center">产品链接</th>
         <th class="align-center">单位</th>
         <th class="align-center" style="width:60px;"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
        <?php if(!empty($output['goods']) && is_array($output['goods'])){ ?>
        <?php foreach($output['goods'] as $k => $v) { ?>
      <tr class="hover" id="<?php echo $v['id']; ?>"  >
        <td ><input name="chashi[]" type="checkbox" value="<?php echo $v['id']; ?>"></td>
        <td><input name="order" type="text" style="width:30px" value="<?php echo $v['order']; ?>"></td>
        <td><?php echo $v['brand_id'];?></td>
        <td></td>
        <td class="w25pre align-center"><?php echo $v['year'];?></td>
        <td class="w25pre align-center"><?php echo $v['brand_name']; ?></td>
          <td class="w25pre align-center"><?php echo $v['goods_link']; ?></td>
        <td class="w25pre align-center"><?php echo $v['unit'];?></td>
        <td class="w156 align-center" style="width:15%"><a href="<?php echo urlAdmin('mb_chashi', 'quotation_editor', array('quotation_id' => $v['id'])); ?>" >编辑</a>|<a href="javascript:if(confirm('确实要删除该内容吗?'))location='<?php echo urlAdmin('mb_chashi', 'quotation_deldir', array('quotation_id' => $v['id']));?>'">删除</a></td>
      </tr>
      <?php } } ?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
      
        <td class="choice" style="width:5%"><input name="choice" type="checkbox" checked="checked" value="1">全选</td>
        <td class="delall" >删除</td>
         <td ></td>
           <td colspan="3"><a href="<?php echo urlAdmin('mb_chashi','quotation_add'); ?>" >添加</a></td>
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
			 
			 $chashi_id=$(this).val();
			 
			 $.ajax({
			 
			 url:"/admin/index.php?act=mb_chashi&op=quotation_del&quotation_id="+$chashi_id,
			 
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