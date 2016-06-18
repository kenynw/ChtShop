$(function() {
	$.ajax({
		url:ApiUrl+"/index.php?act=brand",
		type:'get',
		jsonp:'callback',
		dataType:'jsonp',
		success:function(result){
			var data = result.datas;
			var html = template.render('brand', data);
			$("#categroy-cnt").html(html);
		}
	});
});