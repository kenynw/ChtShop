<?php
/**
 * 免费样品管理
 *
 *
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
define('ImgPath','../data/upload/shop/store/goods/2/');
class mb_tasters_recommendControl extends SystemControl{
	public function __construct(){
		parent::__construct();
	}
    public function recommend_listOp(){
       $recommendModel=Model("tasters_recommend");
       $recommends=$recommendModel->where("recommend_state=1")->page(10)->select();
        Tpl::output('page',$recommendModel->showpage());
        Tpl::output('recommends', $recommends);
        Tpl::showpage("tasters.recommend.list");

    }
    public function recommend_addOp(){
        Tpl::showpage("tasters.recommend.add");
    }
    public function recommend_insertOp(){
        $recommendModel=Model("tasters_recommend");
        $data=array();
        $data['recommend_goods_id']=$_POST['goods_id'];
        $data['recommend_score']=$_POST['score'];
        $data['recommend_taste']=$_POST['taste'];
        $data['recommend_light']=$_POST['light'];
        $data['recommend_aroma']=$_POST['aroma'];
        $data['recommend_leaf']=$_POST['leaf'];
        $data['recommend_time']=time();
        $data['recommend_sort']=$_POST['sort'];
        $data['recommend_state']=$_POST['state'];
        $insertResult=$recommendModel->insert($data);
        if($insertResult){
            showmessage("添加成功");
        }else{
            showmessage("添加失败");
        }

    }
    public function recommend_delOp(){
        $recommendModel=Model("tasters_recommend");
        $recommend_id=$_GET['recommend_id'];
        $delResult=$recommendModel->where("recommend_id='$recommend_id'")->delete();
        if($delResult){
            showmessage('删除完成');
        }else{
            showmessage('删除失败');
        }
    }
    public function recommend_editorOp(){
        $recommendModel=Model("tasters_recommend");
        $recommend_id=$_GET['recommend_id'];
        $recommendInfo=$recommendModel->where("recommend_id='$recommend_id'")->find();
        Tpl::output('recommendInfo', $recommendInfo);
        Tpl::showpage("tasters.recommend.editor");
    }
    public function recommend_updateOp(){
        $recommendModel=Model("tasters_recommend");
        $data=array();
        $recommend_id=$_POST['recommend_id'];
        $data['recommend_goods_id']=$_POST['goods_id'];
        $data['recommend_score']=$_POST['score'];
        $data['recommend_taste']=$_POST['taste'];
        $data['recommend_light']=$_POST['light'];
        $data['recommend_aroma']=$_POST['aroma'];
        $data['recommend_leaf']=$_POST['leaf'];
        $data['recommend_sort']=$_POST['sort'];
        $data['recommend_state']=$_POST['state'];
        $insertResult=$recommendModel->where("recommend_id='$recommend_id'")->update($data);
        if($insertResult){
            showmessage("更新成功");
        }else{
            showmessage("更新失败");
        }

    }

}

?>
