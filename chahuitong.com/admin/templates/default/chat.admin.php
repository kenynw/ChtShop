<script type="text/javascript" src="http://libs.baidu.com/jquery/1.8.2/jquery.min.js"></script>
<script >
  $(document).ready(function(){
    /*在线客户数组*/
    var memberArray=new Array();
    /*已经在聊的客户数组*/
    var chatArray=new Array();
    var in_array = function(arr ,value){

      if(arr.length==0){
        return false;
      }
      for(var i= 0;i<(arr.length);i++){
        if(value==arr[i]){
          return true;
        }
      }

      // 如果不在数组中就会返回false
      return false;
    }
    var diff_array=function(arr1,arr2){
      var temp=new Array();
      for(var i=0;i<(arr1.length);i++){
        if(!in_array(arr2,arr1[i])){
          temp.push(arr1[i]);
        }
      }
      return temp;
    }
    function get_online_member(){
      var chatString;
      if(chatArray.length>0){
        chatString=chatArray.join(",");
      }else{
        chatString='';
      }
      $.ajax({
        url:'index.php?act=mb_chat&op=get_online_customer',
        type:'post',
        data:{chatString:chatString},
        dataType:'json',
        success:function(data){
          var tempArray=new Array();
           if(data.code==1){
             for(var i=0;i<data.data.length;i++){
                if(!in_array(memberArray,data.data[i].id)){
                  memberArray.push(data.data[i].id);
                  tempArray.push(data.data[i].id);
                  if(data.data[i].f_chat_id==null){
                    var html="<li id='"+data.data[i].id+"'><img src='../data/upload/shop/common/default_user_portrait.jpg' >"+data.data[i].customer_name+"</li>";
                  }else{
                    var html="<li id='"+data.data[i].id+"'><img src='../data/upload/shop/common/haveNews.gif' >"+data.data[i].customer_name+"</li>";

                  }

                  $(".member_list ul").append(html);
                }else{
                  if(data.data[i].f_chat_id!=null){
                    if(!in_array(chatArray,data.data[i].id)){
                      $("#"+data.data[i].id).find("img").attr("src","../data/upload/shop/common/haveNews.gif");
                    }else{
                      console.log(data.chatContent.length)
                      for(var j=0;j<data.chatContent.length;j++){
                        $("#content_"+data.chatContent[j].f_chat_id+" .box_content ul").append("<li>"+data.chatContent[j].msg_content+"</li>");
                      }

                    }
                  }else{
                    $("#"+data.data[i].id).find("img").attr("src","../data/upload/shop/common/default_user_portrait.jpg");
                  }
                  tempArray.push(data.data[i].id);
                }
             }
             //求两个数组集差--下线客户
             var temp=diff_array(memberArray,tempArray);
             if(temp.length>0){
               for(var j=0;j<temp.length;j++){
                 $("#"+temp[j]+" img").attr("src","../data/upload/shop/common/default_user_portrait.png");
               }
             }

           }


        }
      })
    }
    get_online_member();
    setInterval(get_online_member,2000);
    $("ul li").live("click",function(){
      var chat_id=$(this).attr('id');
      $(this).find("img").attr("src","../data/upload/shop/common/default_user_portrait.jpg");
      var name=$(this).text();
      $("#box_title").text(name);
      $("input[name='chat_id']").val(chat_id);
      if(!in_array(chatArray,chat_id)){
        var name;
        chatArray.push(chat_id);
        name=$(this).text();
        var html="<div id=content_"+chat_id+" class='chat_box' chat_id="+chat_id+"><div class='chat_box_1'><h3 class='box_title'>"+name+"<div class='op'><span class='hide'>-</span><span>   </span><span class='close' chat_id='"+chat_id+"'>x</span></div></div></h3><div class='box_content'><ul></ul><input type='text' name='content' class='content'><div><img src='../data/upload/shop/common/default_user_portrait.jpg' width='25' class='bq'></div><input type='button' value='submit'></div></div></div>";
        $("#save_content").append(html);
      }

    })
    /*关闭当前窗口*/
    $("#save_content .close").live("click",function(){
      var chat_id=$(this).attr("chat_id");
      chatArray.remove(chat_id);
      $(this).parent().parent().parent().parent().fadeOut(1000);

    })
    /*隐藏当前窗口*/
    $("#save_content .hide").live("click",function(){
      $(this).parent().parent().parent().parent().fadeOut(1000);

    })

    Array.prototype.remove = function(val) {
      var index = this.indexOf(val);
      if (index > -1) {
        this.splice(index, 1);
      }
    };


  })
</script>
<style>
 .page{width:100%;height:100%;}
 .member_list{width:100px;height:100%;border:1px solid gainsboro;float:left;padding-left:40px}
 .member_list li{text-align:left;line-height:40px;height:40px;}
  .chat_box{width:400px;float:left;height:600px;background:white;border:1px solid gainsboro}
  .chat_box h3{background:red;width:100%;height:30px;margin:0px;}
  .box_content{background:white;width:100%;height:630px}
  .box_title{color:white;text-align:right:font-size:16px}
  .box_title .op{width:90px;float:right}
  li img{width:30px;border-radius:30px;}
   .close{display:inline-block;width:40px;height:20px;}
  .hide{display:inline-block;width:40px;height:20px;}
  .content{display:inline-block;width:290px;height:30px;float:left}
  .bq{display: inline-block;float:left}
  .box_content ul{height:550px;width:400px;overflow:scroll;padding:0px;margin:0px;clear:both}
</style>
  <div class="page">
    <div class="member_list">
     <ul>

     </ul>
    </div>
  </div>
 <div id="save_content"></div>
