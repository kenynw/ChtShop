<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>社区活动</h3>
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
        <th>用户</th>
        <th class="align-center">标题</th>
        <th class="align-center">地点</th>
        <th class="align-center">对象</th>
         <th class="align-center">人数</th>
         <th class="align-center">时间</th>
         <th class="align-center">报名时间</th>
        <th class="align-center">内容</th>
         <th class="align-center">图片</th>
         <th class="align-center">报名人数</th>
        <th class="align-center">操作</th>
      </tr>
    </thead>
    <tbody>
        <?php if(!empty($output['actives']) && is_array($output['actives'])){ ?>
        <?php foreach($output['actives'] as $k => $v) { ?>
      <tr class="hover" id="<?php echo $v['active_id']; ?>"  >
        <td ><input name="shequ[]" type="checkbox" value="<?php echo $v['active_id']; ?>"></td>
        <td><?php echo $v['active_id']; ?></td>
        <td><?php if($v['active_title']) {echo $v['active_title'];}else{ echo "无标题";} ?></td>
        <td><?php echo $v['location'];?></td>
        <td><?php echo $v['object'];?></td>
        <td><?php echo $v['number'];?></td>
        <td><?php echo $v['join_time']; ?></td>
        <td><?php echo $v['last_time']; ?></td>
        <td class="w25pre align-center"><?php echo $v['content'];?></td>
        <td class="w25pre align-center"><?php 
		 $str='';
		 if($v['pics']){
			 $picArray=explode(',',$v['pics']);
			 foreach($picArray as $pic){
				 $str.="<img src='../data/upload/qunzi/$pic' width='50px'>&nbsp;";				 
				 }	
			 echo $str;	 		 
			 }		
		;?></td>
        <td class="w25pre align-center"><?php echo $v['join_number'];?></td>
        <td class="w156 align-center" style="width:15%"><a href="<?php echo urlAdmin('mb_shequ', 'active_join_detail', array('active_id' => $v['active_id'])); ?>" >报名详细</a>&nbsp;<a href="<?php echo urlAdmin('mb_shequ', 'active_del', array('active_id' => $v['active_id']));?>">删除</a>&nbsp;<a href="<?php echo urlAdmin('mb_shequ', 'active_editor', array('active_id' => $v['active_id']));?>">编辑</a></td>
      </tr>
      <?php } } ?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
      
        <td class="choice" style="width:5%"><input name="choice" type="checkbox" checked="checked" value="1">全选</td>
        <td class="delall" >删除</td>
         <td ><a href="<?php echo urlAdmin('mb_shequ','active_add'); ?>" >添加</a></td>
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
	   
  $(".delall").click(function(){
	  
	  if(confirm("确定删除")){		  
		 $(".hover input:checked").each(function(){			 
			 var active_id=$(this).val();			 
			 $.ajax({		 
			 url:"/admin/index.php?act=mb_shequ&op=activeajax_del&active_id="+active_id,	 
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