<?php
/**
 * 免费样品管理
 *
 *
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
define('ImgPath','../data/upload/mobile/home/');
class mb_vote_activityControl extends SystemControl{
    public function __construct(){
        parent::__construct();
    }
    public function activity_listOp(){
        $activityModel=Model("vote_activity");
        $activityes=$activityModel->select();
        //print_r($activityes);
        Tpl::output('activityes', $activityes);
        Tpl::showpage('activityes.list');
    }
    //活动添加
    public function add_activityOp(){
        Tpl::showpage('vote.activity.add');
    }
    //保存活动
    public function insert_activityOp(){
        if(empty($_POST)){
            showmessage("提交数据不能为空");
        }
        $condition=array();
        if($_FILES['activity_image']){
            $legitType=array('image/jpeg','image/png','image/gif');
            $resizeImage	= new ResizeImage();
            $name=time();
            if(in_array(strtolower($_FILES['activity_image']['type']),$legitType)){
                list(,$type)=explode("/",strtolower($_FILES['activity_image']['type']));
                if($type=="jpeg"){
                    $type="jpg";
                }
                $moveResult=move_uploaded_file($_FILES['activity_image']['tmp_name'],ImgPath.'/'.$name.".".$type);
                $condition['activity_image']=$name.".".$type;
                if($moveResult){
                    $resizeImage->newImg(ImgPath.$name.".".$type,360,360,0,"_360." , ImgPath);
                    $resizeImage->newImg(ImgPath.$name.".".$type,60,60,0,"_60." , ImgPath);
                }
            }
        }else{
            showmessage("图片不能为空");
        }
        $condition['activity_name']=$_POST['activity_name'];
        $condition['activity_enroll_start_time']=strtotime($_POST['activity_enroll_start_time']);
        $condition['activity_enroll_end_time']=strtotime($_POST['activity_enroll_end_time']);
        $condition['activity_vote_start_time']=strtotime($_POST['activity_vote_start_time']);
        $condition['activity_vote_end_time']=strtotime($_POST['activity_vote_end_time']);
        $condition['activity_description']=$_POST['activity_description'];
        $condition['activity_sort']=$_POST['activity_sort'];
        $condition['activity_state']=$_POST['activity_state'];
        $condition['activity_add_time']=time();
        $activityModel=Model("vote_activity");
        $insertResult=$activityModel->insert($condition);
        if($insertResult){
            showmessage("添加成功");
        }else{
            showmessage("添加失败");
        }
    }
    //活动编辑页面
    public function activity_editorOp(){
        $activity_id=$_GET['activity_id'];
        $activityModel=Model("vote_activity");
        $activityInfo=$activityModel->where("activity_id='$activity_id'")->find();
        Tpl::output('activityInfo', $activityInfo);
        Tpl::showpage('vote.activity.editor');
    }
    //保存活动编辑页
    public function update_activityOp(){
        if(empty($_POST)){
            showmessage("提交数据不能为空");
        }
        $condition=array();
        if(!empty($_FILES['activity_image'])){
            $legitType=array('image/jpeg','image/png','image/gif');
            $resizeImage	= new ResizeImage();
            $name=time();
            if(in_array(strtolower($_FILES['activity_image']['type']),$legitType)){
                list(,$type)=explode("/",strtolower($_FILES['activity_image']['type']));
                if($type=="jpeg"){
                    $type="jpg";
                }
                $moveResult=move_uploaded_file($_FILES['activity_image']['tmp_name'],ImgPath.'/'.$name.".".$type);
                $condition['activity_image']=$name.".".$type;
                if($moveResult){
                    unlink(ImgPath.$_POST['activity_image_bak']);
                    $resizeImage->newImg(ImgPath.$name.".".$type,360,360,0,"_360." , ImgPath);
                    $resizeImage->newImg(ImgPath.$name.".".$type,60,60,0,"_60." , ImgPath);
                }
            }
        }else{
            $condition['activity_image']=$_POST['activity_image_bak'];
        }
        $condition['activity_name']=$_POST['activity_name'];
        $condition['activity_enroll_start_time']=strtotime($_POST['activity_enroll_start_time']);
        $condition['activity_enroll_end_time']=strtotime($_POST['activity_enroll_end_time']);
        $condition['activity_vote_start_time']=strtotime($_POST['activity_vote_start_time']);
        $condition['activity_vote_end_time']=strtotime($_POST['activity_vote_end_time']);
        $condition['activity_description']=htmlspecialchars_decode($_POST['activity_description']);
        $condition['activity_sort']=$_POST['activity_sort'];
        $condition['activity_state']=$_POST['activity_state'];
        $condition['activity_add_time']=time();
        $activityModel=Model("vote_activity");
        $insertResult=$activityModel->where("activity_id=".$_POST['activity_id'])->update($condition);
        if($insertResult){
            showmessage("添加成功");
        }else{
            showmessage("添加失败");
        }
    }
    //查看活动报名情况
    public function activity_viewOp(){
        $enrollModel=Model("vote_enroll");
        $activity_id=$_GET['activity_id'];
        $enrolls=$enrollModel->where("activity_id='$activity_id'")->select();
        print_r($enrolls);
    }



}

?>
