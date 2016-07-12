<?php
/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/7/11
 * Time: 下午4:04
 */
class member_flea_consultControl extends mobileMemberControl {
    
    /**
     * 闲置物品咨询添加
     */
    public function save_consultOp(){
        $goods_id = intval(empty($_GET['goods_id']) ? $_POST['goods_id'] : $_GET['goods_id']);
        if ($goods_id <= 0) output_json(1, array(), Language::get('wrong_argument'));
        if(trim($_POST['content'])==="") output_json(0, array(), Language::get('error_content_null'));

        $goods	= Model('flea');
        $condition	= array();
        $condition['goods_id']	= $goods_id;
        $goods_info	= $goods->getGoodsInfo($condition);
        if (empty($goods_info)) output_json(0, $goods_info, '商品不存在');

        /**
         * 接收数据并保存
         */
        $input	= array();
        $input['seller_id']			= $goods_info['member_id'];
        $input['member_id']			= $_POST['hide_name']?0:(empty($this->member_info['member_id'])?0:$this->member_info['member_id']);
        $input['goods_id']			= $goods_id;
        $input['consult_content']	= $_POST['content'];
        $input['type_name']	        = 'flea';
        $model_consult = Model('flea_consult');
        if($result = $model_consult->addConsult($input)){
            /*	闲置物品表增加评论次数	*/
            $condition['commentnum']['value']='1';
            $condition['commentnum']['sign']='increase';
            $goods->updateGoods($condition, $goods_id);

            $consult = $model_consult->getGoodsInfo(array('consult_id' => $result));

            output_json(1, $consult, '留言发布成功');
        }else{
            output_json(0, 0, '留言发布超时');
        }
    }

    public function consult_listOp() {
        $flea_id = intval(empty($_POST['goods_id']) ? $_GET['goods_id'] : $_POST['goods_id']);
        if ($flea_id <= 0) output_json(0, array(), Language::get('wrong_argument'));

        $model_consult = Model('flea_consult');
        $condition = array();
        $condition['goods_id'] = $flea_id;
        $page = new Page();
        $page->setStyle('admin');
        $page->setEachNum($this->page);
        $consult_list = $model_consult->getConsultList($condition, $page, 'seller');
        if ($consult_list) {
            foreach ($consult_list as $key => $value) {
                $consult_list[$key]['member_avatar'] = getMemberAvatar($value['member_avatar']);
                $consult_list[$key]['consult_addtime'] = $this->_time_comb($value['consult_addtime']);
            }
        }

        output_json(1, $consult_list);
    }

    /**
     * 取得的时间间隔
     */
    private function _time_comb($goods_add_time){
        $catch_time = (time() - $goods_add_time);
        if($catch_time < 60){
            return $catch_time.Language::get('second').'前';
        }elseif ($catch_time < 60*60){
            return intval($catch_time/60).Language::get('minute').'前';
        }elseif ($catch_time < 60*60*24){
            return intval($catch_time/60/60).Language::get('hour').'前';
        }elseif ($catch_time < 60*60*24*365){
            return intval($catch_time/60/60/24).Language::get('day').'前';
        }else {
            return date('Y:m:d H:i', $goods_add_time);
        }
    }


}