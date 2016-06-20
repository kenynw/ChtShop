<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>分类广告</h3>
      
    </div>
  </div>
  <div class="fixed-empty"></div>
   <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['goods_class_index_help1'];?></li>
            <li><?php echo $lang['goods_class_index_help2'];?></li>
            <li><?php echo $lang['goods_class_index_help3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post'>
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="submit_type" id="submit_type" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th>排序</th>
          <th>广告连接</th>
          <th>广告语</th>
          <th>状态</th>
          <th></th>
          <th><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['advs']) && is_array($output['advs'])){ ?>
        <?php foreach($output['advs'] as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w48"><input type="checkbox" name="check_gc_id[]" value="<?php echo $v['class_id'];?>" class="checkitem">
           </td>
          <td class="w48 sort"><?php echo $v['order']; ?></td>
          <td class="w50pre name">
          <?php echo $v['goods_link']; ?>
          </td>
          <td><?php echo $v['slogan']; ?></td>
          <td><?php  echo $v['state']; ?></td>
          <td></td>
          <td class="w84"><a href="javascript:if(confirm('确实要删除该内容吗?'))location='index.php?act=goods_class&op=goods_del_adv&id=<?php echo $v['id'];?>'">删除</a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_2"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_2"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp;<a href="index.php?act=goods_class&op=goods_add_adv&gc_id=<?php echo $output['class_id'];?>">添加</a>
            </td>
        </tr>
      </tfoot>
    
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.goods_class.js" charset="utf-8"></script> 
