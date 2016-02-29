<?php
/**
 * 手机支付方式
 *
 *
 *
 ***/

defined('InShopNC') or exit('Access Invalid!');
define('ImgPath','../data/upload/mobile/home/');
class mb_chatControl extends SystemControl{
    public function __construct(){
        parent::__construct();
    }

    public function indexOp() {
        Tpl::showpage('chat.admin');
    }

    public function get_online_customerOp(){
        //$customerModel=Model("chat_customer");
        //$customerData=$customerModel->page(100)->select();
        $chatString=$_POST['chatString'];
        //$chatString='12,13';
        $chatContentModel=Model('chat_content');
        $customerModel=Model();
        $sql="SELECT c . * , t.f_chat_id FROM  `shopnc_chat_customer` AS c LEFT JOIN shopnc_chat_content AS t ON c.id = t.f_chat_id LIMIT 0 , 80";
        $customerData=$customerModel->query($sql);
        if(!empty($chatString)) {
            $msgInfo = $chatContentModel->where("f_chat_id in ($chatString) and msg_is_read='0'")->select();
            /*
            if ($msgInfo) {
                $contentData = array();
                $chatArray = explode(",", $chatString);
                foreach ($msgInfo as $v) {
                    if (in_array($v['f_chat_id'], $chatArray)) {
                        $contentData[$v['f_chat_id']][] = $v;
                    }
                }
            }
            */
        }
        $array=array();
        if($customerData){
           $array['code']=1;
           $array['data']=$customerData;
            if($msgInfo){
                $array['chatContent']=$msgInfo;
            }

        }else{
            $array['code']=0;
            $array['data']='';
        }

        echo json_encode($array);
    }


}
