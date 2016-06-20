<!DOCTYPE html>
<html><head>
    <meta charset="UTF-8" />
    <title>online server</title>
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <style>
        #.scroll a{color:black}
        .page{width:100%;height:100%}
        .msg_content{width:100%;height:100%;padding-bottom:30px;}
        .msg_input{height:30px;position:fixed;bottom:0px;width: 100%;background:wheat;}

    </style>
    <script type="text/javascript" src="http://libs.baidu.com/jquery/1.8.2/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
          var username;
          var chat_id;
           function customer_online(){
              $.ajax({
                  url:'index.php?act=member_chat&op=customer_online',
                  type:'post',
                  data:{},
                  dataType:'json',
                  success:function(data){
                     if(data.code==1){
                         chat_id=data.data.chat_id;
                         username=data.data.member_name;
                     }else{
                         chat_id=data.data.chat_id;
                         username=data.data.member_name;
                     }
                  }
              })
            }
            customer_online();
           $("#sub").click(function(){
               var value=$("input[name='msg']").val();
               if(value==''){
                   alert('it is empty');
                   die();
               }
               $.ajax({
                  url:'index.php?act=member_chat&op=save_msg',
                  type:'post',
                  data:{value:value,chat_id:chat_id,member_name:username},
                  dataType:'json',
                  success:function(data){
                     $(".msg_content").append("<li>me:"+value+"</li>")
                  }
               })
           })
            
        })
    </script>
    </head>
   <body>
    <div class="page">
        <div class="msg_content">

        </div>
        <div class="msg_input">
            <input type="text" name="msg" value="" placeholder="input......">
            <input type="submit" value="submit" id="sub">
        </div>
    </div>

    </body>
</html>