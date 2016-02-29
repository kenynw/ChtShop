<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>首页图片管理</h3>
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
        <th></th>
        <th class="align-center">图片</th>
        <th class="align-center">链接</th>
        <th class="align-center">状态</th>
        <th class="align-center">位置</th>
        <th class="align-center" style="width:60px;"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
        <?php if(!empty($output['pics']) && is_array($output['pics'])){ ?>
        <?php foreach($output['pics'] as $k => $v) { ?>
      <tr class="hover" id="<?php echo $v['id']; ?>"  >
        <td ><input name="chashi[]" type="checkbox" value="<?php echo $v['id']; ?>"></td>
        <td><input name="order" type="text" style="width:30px" value="<?php echo $v['order']; ?>"></td>
        <td></td>
        <td><img src="<?php echo $v['image']; ?>" width="50" height="50"></td>
        <td class="w25pre align-center"><?php echo $v['link'];?></td>
        <td class="w25pre align-center"><?php echo $v['state'];?></td>
        <td class="w25pre align-center"><?php
           switch($v['location']){
             case 1;
                   echo "首页轮播";
                   break;
             case 2:
                   echo "目录轮播";
                   break;
             case 3;
                   echo "首页茶样";
                   break;
             case 4:
                   echo "首页限时抢购";
                   break;
             default:
                   echo "位置错误";
                   break;

           }

          ?></td>
        <td class="w25pre align-center"></td>
        <td class="w156 align-center" style="width:15%"><a href="<?php echo urlAdmin('mb_chashi', 'homepic_editor', array('id' => $v['id'])); ?>" >编辑</a>|<a href="<?php echo urlAdmin('mb_chashi', 'homepic_del', array('id' => $v['id'])); ?>" >删除</a></td>
      </tr>
      <?php } } ?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
      
        <td class="choice" style="width:5%"><input name="choice" type="checkbox" checked="checked" value="1">全选</td>
        <td class="delall" >删除</td>
         <td colspan="30"><a href="<?php echo urlAdmin('mb_chashi', 'homepic_add'); ?>" >添加</a></td>
           <td ></td>
        <td colspan="30"> <div class="pagination"> <?php echo $output['page'];?> </div></td>
        <td ></td>
      </tr>
    </tfoot>
  </table>
</div>

