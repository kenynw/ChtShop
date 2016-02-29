<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['brand_index_brand'];?></h3>
      <ul class="tab-base">
        <li></li>
        <li></li>
        <li></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="brand">
    <input type="hidden" name="op" value="brand">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th>

          </th>
          <td><select name="lable_type" id="lable_type">
                  <option value="0">选择类型</option><option value="1">目录</option><option value="2">属性</option><option value="3">品牌</option>
              </select></td>
          <th><label for="search_brand_class"><?php echo $lang['brand_index_class'];?></label></th>
          <td>
              <select name="lable_text" id="lable_text" class="lable_text">

              </select>
              <input name="lable_type" value="1" type="hidden" id="lable_type1">
          </td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['brand_index_help1'];?></li>
            <li><?php echo $lang['brand_index_help2'];?></li>
            <li><?php echo $lang['brand_index_help3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' onsubmit="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){return true;}else{return false;}" name="brandForm">
    <input type="hidden" name="form_submit" value="ok" />
    <div style="text-align:right;"><a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?>Excel</span></a></div>
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th class="w48"><?php echo $lang['nc_sort'];?></th>
          <th class="w270"><?php echo $lang['brand_index_name'];?></th>
          <th class="w150"><?php echo $lang['brand_index_class'];?></th>
          <th><?php echo $lang['brand_index_pic_sign'];?></th>
          <th class="align-center">关联类别</th>
          <th class="align-center"><?php echo $lang['nc_recommend'];?></th>
          <th class="w72 align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['choiceLables']) && is_array($output['choiceLables'])){ ?>
        <?php foreach($output['choiceLables'] as $k => $v){ ?>
        <tr class="hover edit">
          <td><input value="<?php echo $v['lable_id']?>" class="checkitem" type="checkbox" name="lable_id[]"></td>
          <td class="sort"><input class="lable_sort" id="<?php echo $v['lable_id']; ?>" value="<?php echo $v['lable_order']; ?>"></td>
          <td class="name"><span class=" editable" nc_type="inline_edit" fieldname="brand_name" ajax_branch='brand_name' fieldid="<?php echo $v['lable_id']?>" required="1"  title="<?php echo $lang['nc_editable'];?>"><?php echo $v['lable_text']?></span></td>
          <td class="class"><?php echo $v['brand_class']?></td>
          <td class="picture"><div class="brand-picture"></div></td>
          <td class="align-center"><?php $typeArray=array(1=>"目录",2=>"属性",3=>"品牌");echo $typeArray[$v['lable_type']]; ?></td>
          <td class="align-center yes-onoff"><?php if($v['brand_recommend'] == '0'){ ?>
            <a href="JavaScript:void(0);" class=" disabled" ajax_branch='brand_recommend' nc_type="inline_edit" fieldname="brand_recommend" fieldid="<?php echo $v['brand_id']?>" fieldvalue="0" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php }else{ ?>
            <a href="JavaScript:void(0);" class=" enabled" ajax_branch='brand_recommend' nc_type="inline_edit" fieldname="brand_recommend" fieldid="<?php echo $v['brand_id']?>" fieldvalue="1"  title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo ADMIN_TEMPLATES_URL;?>/images/transparent.gif"></a>
            <?php } ?></td>
          <td class="align-center"><a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='<?php echo urlAdmin('mb_search_lable', 'del_lable',array('lable_id'=>$v['lable_id']));?>';}else{return false;}"><?php echo $lang['nc_del'];?></a></td>

        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
            <?php echo $output['page']; ?>
        <?php } ?>

      </tbody>
      <tfoot>
        <?php if(!empty($output['choiceLables']) && is_array($output['choiceLables'])){ ?>
        <tr colspan="15" class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="document.brandForm.submit()"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
    <div  id="msgbox" style="display:none;width:300px;height:200px;position:fixed;left:50%;top:50%;margin-left:-150px;margin-top:-100px;line-height:200px;;background:palevioletred;">

    </div>
  <div class="clear"></div>
</div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script>
$(function(){
    $("#lable_type").change(function(){
        var lableid=$(this).val();
        $.ajax({
            url:"<?php echo urlAdmin('mb_search_lable', 'get_lable_text');?>",
            type:"post",
            data:{lable_type:lableid},
            dataType:"json",
            success:function(data){
              if(data.code==1){
                  var html='<option value="">选着标签值</option>';
                  for(var i=0;i<data.data.content.length;i++){
                      html+="<option value='"+data.data.content[i].value+"'>"+data.data.content[i].name+"</option>";
                  }
                  $("#lable_text").html('');
                  $("#lable_text").html(html);
                  var lable_type=data.data.lable_type;
                  $("#lable_type1").val(lable_type);
                  //alert(data.data.lable_type);

              }
            }

        })
    })
    // 插入标签
    $(".lable_text").change(function(){
        var lable_value=$(this).val();
        var lable_text=$(this).find("option:selected").text();
        var lable_type=$("#lable_type1").val();
        $.ajax({
            url:"<?php echo urlAdmin('mb_search_lable', 'insert_lable_key');?>",
            type:"post",
            data:{name:lable_text,value:lable_value,lable_type:lable_type},
            dataType:"json",
            success:function(data){
            if(data.code==1){
                setTimeout(alert(data.msg), 3000 );
                window.location.reload();
            }else{
                setTimeout(alert(data.msg), 3000 );
            }
            }
         })

    })
    //排序
    $(".lable_sort").change(function(){
        var order_id=$(this).val();
        var lable_id=$(this).attr("id");
        $.ajax({
            url:"<?php echo urlAdmin('mb_search_lable', 'sort_lable');?>",
            type:"post",
            data:{lable_id:lable_id,sort_num:order_id},
            dataTpe:"json",
            success:function(data){
                window.location.reload();
            }
        })

    })



});
</script>