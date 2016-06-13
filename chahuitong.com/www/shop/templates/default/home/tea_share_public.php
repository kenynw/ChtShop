<link type="text/css" href="<?php echo SHOP_TEMPLATES_URL;?>/css/fabu.css" rel="stylesheet">
<style>
.save{width:100%;border-top:1px solid #c9c9c9;}
.save ul{width:1200px;margin:0 auto;}
</style>

<div class="shequ"></div>
<div class="mail">
<div class="title">社区>茶趣分享>发布</div>
<div class="bianji">
<form action="<?php echo urlShop('tea_community','tea_share_public_save');?>" method="post" enctype="multipart/form-data">
<ul>
<li><label>发布标题</label><input type="text" id="title" name="title" value=""></li>
<li><label>发表内容</label><textarea id="con" rows="5" name="content"></textarea></li>
<li><label>上传图片</label><input type="file" id="files" name="files[]" multiple><div id="list"></div></li>
</ul>
<input type="submit" value="发布" id="fabu">
</form>
</div>
</div>
<script>
function handleFileSelect(evt){
	document.getElementById('list').innerHTML = '';
	var files = evt.target.files;
	if(files.length > 6){
		document.getElementById('files').value = '';
	}
	for(var i =0,f;f=files[i];i++){
		if(!f.type.match('image.*')){
			continue;
		}
		files[i] = null;
		var reader = new FileReader();
		reader.onload = (function(theFile){
			return function(e){
				var span = document.createElement('span');
				span.innerHTML = ['<img class="thumb" src="',e.target.result,'" title="',theFile.name,' "/>'].join('');
				document.getElementById('list').insertBefore(span,null);
			};
		})(f);
		reader.readAsDataURL(f);
	}
}
document.getElementById('files').addEventListener('change',handleFileSelect,false);
</script>
