<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>投票活动</h3>
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
        <th>id</th>
        <th class="align-center">名称</th>
        <th class="align-center">图片</th>
        <th class="align-center">报名起始</th>
         <th class="align-center">报名结束</th>
         <th class="align-center">投票起始</th>
        <th class="align-center">投票结束</th>
         <th class="align-center">排序</th>
        <th class="align-center">状态</th>
      </tr>
    </thead>
    <tbody>
        <?php if(!empty($output['activityes']) && is_array($output['activityes'])){ ?>
        <?php foreach($output['activityes'] as $k => $v) { ?>
      <tr class="hover" id="<?php echo $v['activity_id']; ?>"  >
        <td ><input name="shequ[]" type="checkbox" value="<?php echo $v['activity_id']; ?>"></td>
        <td><?php echo $v['activity_name']; ?></td>
        <td><?php if($v['activity_name']) {echo $v['activity_name'];}else{ echo "无标题";} ?></td>
        <td><?php echo $v['activity_image'];?></td>
        <td><?php echo $v['activity_enroll_start_time'];?></td>
        <td><?php echo $v['activity_enroll_end_time'];?></td>
        <td><?php echo $v['activity_vote_start_time']; ?></td>
        <td class="w25pre align-center"><?php echo $v['activity_vote_end_time'];?></td>
        <td class="w25pre align-center"><?php echo $v['activity_state'];?></td>
        <td class="w156 align-center" style="width:15%"><a href="<?php echo urlAdmin('mb_vote_activity', 'activity_editor', array('activity_id' => $v['activity_id'])); ?>" >编辑</a><a href="<?php echo urlAdmin('mb_vote_activity', 'activity_view', array('activity_id' => $v['activity_id']));?>">查看</a></td>
      </tr>
      <?php } } ?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td class="choice" style="width:5%"><input name="choice" type="checkbox" checked="checked" value="1">全选</td>
        <td class="delall" >删除</td>
         <td ><a href="index.php?act=mb_vote_activity&op=add_activity">添加</a></td>
           <td ></td>
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