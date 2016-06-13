<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i; if($data["id"] != null): ?><div class="infos-item">
<div class="img-content">
<a href="<?php echo U('Index/detail?aid='.$data[id].'');?>" target="_self"><img src="<?php echo ($host); echo ($data["litpic"]); ?>" /></a>
</div>
<div class="img-title"><a href="<?php echo U('Index/detail?aid='.$data[id].'');?>" target="_self"><?php echo ($data["title"]); ?></a></div>
<div class="img-descri"><a href="<?php echo U('Index/detail?aid='.$data[id].'');?>" target="_self"><?php echo ($data["description"]); ?>...</a></div>
<div class="img-date"><?php echo ($data["writer"]); ?>|<?php echo ($data["typename"]); ?>|<?php echo ($data["pubdate"]); ?></div>
</div>
<?php else: ?>暂无相关文章<?php endif; endforeach; endif; else: echo "" ;endif; ?>