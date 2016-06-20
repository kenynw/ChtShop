<?php
/**
 * 默认展示页面
 *
 *
 **by 多用户商城 www.abc.com 多用户商城 运营版*/


defined('InShopNC') or exit('Access Invalid!');
class tea_communityControl extends BaseHomeControl
{
    static  $hotNews;
    public function indexOp()
    {
        //print_r($_SESSION);
        /*茶客聚聚*/
        $activeModel = Model("discuz_active");
        $actives = $activeModel->order("active_id desc")->limit(5)->select();
        /*今日新声*/
        $contentModel = Model("discuz_content");
        $todayNews = $contentModel->where("uid='1'")->order("content_id desc")->limit(5)->select();
        /*魅力领袖*/
        $memberModel = Model("member");
        $members = $memberModel->order("guanzhu")->limit(6)->select();
        /*茶趣分享*/
        //$teaShare=$contentModel->where("uid!='1'")->limit(6)->select();
        $sql = "SELECT c.title,c.content,c.image,c.share,c.comment,c.view,m.member_name from shopnc_discuz_content as c left join shopnc_member as m on c.uid=m.member_id where c.uid!='1' order by c.content_id desc limit 6";
        $queryModel = Model();
        $teaShare = $queryModel->query($sql);
        //print_r($teaShare);
        Tpl::output("actives", $actives);
        Tpl::output("todayNews", $todayNews);
        Tpl::output("members", $members);
        Tpl::output("teaShare", $teaShare);
        Tpl::showpage('tea_community');
    }

    /*茶客聚聚*/

    public function teaer_togetherOp()
    {
        //print_r($_SESSION);
        $activeModel = Model("discuz_active");
        $actives = $activeModel->order("active_id desc")->page(6)->select();
        // print_r($actives);
        Tpl::output('page', $activeModel->showpage());
        Tpl::output('actives', $actives);
        Tpl::showpage('teaer_together');
    }

    /*今日新声*/
    public function today_newsOp()
    {
        $activeModel = Model("discuz_content");
        $actives = $activeModel->where("uid='1'")->limit(6)->select();
        self::$hotNews = $activeModel->where("uid='1'")->order("view desc")->limit(3)->select();
        //print_r($hotActives);
        //$hotActives=$activeModel->order("join_number desc")->limit(3)->select();
        Tpl::output('page', $activeModel->showpage());
        Tpl::output("news", $actives);
        Tpl::output("hotNews",self::$hotNews);
        Tpl::showpage('today_news');
    }
    /*领袖*/
    public function tea_leadersOp(){
        $memberModel=Model("member");
        $members=$memberModel->order("guanzhu desc")->page(20)->select();
        $topTen=$memberModel->order("guanzhu desc")->limit(10)->select();
        Tpl::output('page', $memberModel->showpage());
        Tpl::output("members", $members);
        Tpl::output("topTen", $topTen);
        Tpl::showpage('tea_leaders');
    }
    /*查询领袖*/
    public function leader_searchOp(){
        if($_POST['member_name']=='') showmessage("查询条件不能为空");
        $memberModel=Model("member");
        $selectResult=$memberModel->field("member_name,rank,guanzhu")->where("member_name like '%{$_POST['member_name']}%' ")->select();
        if(!$selectResult) showmessage("暂无你要查找的领袖");
        $topTen=$memberModel->order("guanzhu desc")->limit(10)->select();
        Tpl::output("members", $selectResult);
        Tpl::output("topTen", $topTen);
        Tpl::showpage('tea_leaders');
    }

    /*今日新声详细页*/
     public function news_detailOp(){
         $conetnet_id=intval($_GET['content_id']);
         $contentModel=Model("discuz_content");
         $detail=$contentModel->where("content_id='$conetnet_id'")->find();
         $hotNews=$contentModel->where("uid='1'")->order("view desc")->limit(6)->select();
         $commentModel=Model();
         //$comments=$contentModel->where("content_id='$conent_id'")->order("id desc")->select();
         $sql="select m.*,u.member_name,u.member_avatar from `shopnc_discuz_comment` as m left join `shopnc_member` as u on m.member_id=u.member_id where m.content_id='$conetnet_id' order by m.id DESC ";
         $comments=$commentModel->query($sql);
         //print_r($comments);
         Tpl::output("comments", $comments);
         Tpl::output("detail", $detail);
         Tpl::output("hotNews", $hotNews);
         Tpl::showpage('news_detail');
     }

    /*ajax处理报名活动 */
    public function active_joinOp()
    {
        $active_id = intval($_POST['active']);
        $array = array();
        $array['active_id'] = $active_id;
        if (!$_SESSION['is_login']) {
            $array['state'] = 0;
            echo json_encode($array);
            die();
        }
        $array['state'] = 1;
        $data = array();
        $data['member_id'] = $_SESSION['member_id'];
        $data['member_name'] = $_SESSION['member_name'];
        $data['active_id'] = $active_id;
        $data['join_time'] = date("Y-m-d H:i:s");
        $data['telphone'] = isset($_SESSION['member_mobile']) ? $_SESSION['member_mobile'] : '';
        $data['status'] = 1;
        $activeModel = Model("discuz_active_member");
        $alreadyVote = $activeModel->where("member_id='{$_SESSION['member_id']}' and active_id='$active_id'")->find();
        if ($alreadyVote) {
            $data['code'] = 404;
            $data['msg'] = '已经报名';
            echo json_encode($data);
            exit();
        }
        $result = $activeModel->insert($data);
        if ($result) {
            $data['code'] = 200;
            $array['msg'] = '加入成功';
        } else {
            $data['code'] = 200;
            $array['msg'] = '加入失败';
        }
        echo json_encode($array);


    }

    /*分享api*/
    public function shareApiOp(){
        $content_id=isset($_POST['content_id'])? intval($_POST['content_id']):'';
        $array=array();
        if (!$_SESSION['is_login']) {
            $array['state'] = 0;
            echo json_encode($array);
            die();
        }
        if($content_id==''){
            $array['code']=404;
            $array['msg']='提交数据不能为空';
            echo json_encode($array);
            die();
        }
        $conentModel=Model("discuz_content");
        $data=array();
        $result=$conentModel->where("content_id='$content_id'")->setInc("share",1);
        if($result){
            $array['code']=200;
            $array['msg']='分享成功';
        }else{
            $array['code']=404;
            $array['msg']='分享失败';
        }

    }

    public function commentApiOp(){
        $content_id=isset($_POST['content_id'])? intval($_POST['content_id']):'';
        $array=array();
        if (!$_SESSION['is_login']) {
            $array['state'] = 0;
            echo json_encode($array);
            die();
        }
        if($content_id==''){
            $array['code']=404;
            $array['msg']='提交数据不能为空';
            echo json_encode($array);
            die();
        }
        $conentModel=Model("discuz_comment");
        $data=array();



    }

    public function add_commentsOp(){
        
        if (!$_SESSION['is_login']) {
           showmessage("您还未登陆不能发表评论");
        }
        $commentModel=Model("discuz_comment");
        $data=array();
        $data['member_id']=$_SESSION['member_id'];
        $data['content_id']=$_POST['content_id'];
        $contentModel=Model("discuz_content");
        $contentUser=$contentModel->field("uid")->where("content_id='{$_POST['content_id']}'")->find();
        $data['uid']=$contentUser['uid'];
        $data['comment']=htmlspecialchars($_POST['comments']);
        $data['comment_time']=date("Y-m-d H:i:s");
        $addresult=$commentModel->insert($data);
        if($addresult){
            $contentModel->where("content_id='{$_POST['content_id']}'")->setInc('comment',1);
            showmessage("评论成功");
        }else{
            showmessage("评论失败");
        }

    }
    public function add_likeOp(){

        if (!$_SESSION['is_login']) {
            showmessage("您还未登陆不能点赞");
        }
        if($_GET['content_id']=='') showmessage("点赞文章不能为空");
        $likeModel=Model("discuz_zan");
        $data=array();
        $data['uid']=$_SESSION['member_id'];
        $data['content_id']=$_GET['content_id'];
        $alreadyLike=$likeModel->where($data)->find();
        if($alreadyLike){
            showmessage("您已经点赞过了");
        }
        $contentModel=Model("discuz_content");
        $addresult=$contentModel->where("content_id='{$_GET['content_id']}'")->setInc('view',1);
        if($addresult){
            $likeModel->insert($data);
            showmessage("点赞成功");
        }else{
            showmessage("点赞失败");
        }



    }

    /*茶趣分享*/
    public function tea_shareOp(){
        $contentModel=Model("discuz_content");
        $shareContents=$contentModel->where("uid !='1'")->page(5)->order("content_id desc")->select();
        $popularContents=$contentModel->where("uid !='1'")->order("comment desc")->limit(3)->select();
        $memberModel=Model("member");
        $hotContents=array();
        foreach($popularContents as $v){
            $memebr_id=$v['uid'];
            $memberInfo=$memberModel->field("member_name")->where("member_id='$member_id'")->find();
            $v['member_name']= isset($memberInfo['member_name'])? $memberInfo['member_name']:'无名氏';
            $hotContents[]=$v;

        }
        $memberModel=Model("member");
        $data=array();
        foreach($popularContents as $v){
            $member_id=$v['uid'];
            $memberName=$memberModel->field("member_name")->where("member_id='$member_id'")->find();
            $v['member_name']=($memberName['member_name']!='')?$memberName['member_name']:'无姓名';
            $data[]=$v;
        }
       // print_r($popularContents);
       // print_r($data);
        Tpl::output("shareContents", $shareContents);
        Tpl::output("hotContents", $data);
        Tpl::output('page', $contentModel->showpage());
        Tpl::showpage('tea_share');
    }

    /*添加关注*/
    public function add_followOp(){
       if (!$_SESSION['is_login']) {
            showmessage("您还未登陆不能关注他人");
        }
       if($_GET['member_id']=='') showmessage("请先选取关注者");
       $data=array();
       $data['member_id']=$_GET['member_id'];
       $data['uid']=$_SESSION['member_id'];
       $followModel=Model("discuz_interest");
       $alreadyFollowed=$followModel->where($data)->find();
       if($alreadyFollowed){
           showmessage("您已经关注过了");
       }
       $data['interest_time']=date("Y-m-d H:i:s");
       $doneInsert=$followModel->insert($data);
       if($doneInsert){
           $memberModel=Model("member");
           $memberModel->where("member_id='{$data['member_id']}'")->setInc("guanzhu",1);
           showmessage("关注成功");
       }else{
           showmessage("关注失败");
       }

    }

    /*添加关注*/
    public function add_shareOp(){

        if (!$_SESSION['is_login']) {
            showmessage("您还未登陆不能点赞");
        }
        if($_GET['content_id']=='') showmessage("点赞文章不能为空");
        $data=array();
        $data['uid']=$_SESSION['member_id'];
        $data['content_id']=$_GET['content_id'];
        $contentModel=Model("discuz_content");
        $addresult=$contentModel->where("content_id='{$_GET['content_id']}'")->setInc('share',1);
        if($addresult){
            //$likeModel->insert($data);
            showmessage("分享成功");
        }else{
            showmessage("分享失败");
        }



    }
    /*  茶趣分享发布页*/
    public function tea_share_publicOp(){

        Tpl::showpage('tea_share_public');
    }

    public function tea_share_public_saveOp(){
        if (!$_SESSION['is_login']) {
            showmessage("您还未登陆不能发布");
        }
       $legitType=array("image/png","image/gif","image/jpeg");
       $imageName='';
       if($_FILES!='') {
           for ($i = 0; $i < count($_FILES['files']['error']); $i++) {

               if ($_FILES['files']['error'][$i] != 0) continue;
               if (!in_array($_FILES['files']['type'][$i], $legitType)) continue;
               $type = substr($_FILES['files']['type'][$i], 6);
               $name = time() . "_$i.$type";
               $saveResult = move_uploaded_file($_FILES['files']['tmp_name'][$i], BASE_DATA_PATH . "/upload/shequ/" . $name);
               if ($saveResult) {
                   $imageName.= $name. ",";
               }
           }
       }
        $data=array();
        $data['title']=htmlspecialchars($_POST['title']);
        $data['content']=htmlspecialchars($_POST['content']);
        $data['title']=htmlspecialchars($_POST['title']);
        $data['uid']=$_SESSION['member_id'];
        $data['time']=date("Y-m-d H:i:s");
        $data['share']=0;
        $data['view']=0;
        $data['comment']=0;
        $data['image']=($imageName=='')?rtrim($imageName,','):'nopic.jpg';
        $shareModel=Model("discuz_content");
        $insertResult=$shareModel->insert($data);
        if($insertResult){
            showmessage("发表成功");
        }else {
            showmessage("发表失败");
        }

    }

}