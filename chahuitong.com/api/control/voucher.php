<?php
/**
 * 前台登录 退出操作
 *
 *
 *
 *
 
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class  voucherControl extends mobileHomeControl {

	public function __construct(){
		parent::__construct();
	}
    public function get_voucher_apiOp(){
        $this->check_member_login();
        if(C('register_voucher_give')){
            $_POST['username']=$this->member_info['member_name'];
            $result=$this->add_voucherOp($this->member_info['member_id']);
            if($result){
                output_json(1,array(),"领取成功");
                die();
            }else{
                output_json(0,array(),"领取失败 应该已经领取");
                die();
            }
        }
    }
    //优惠券添加
    private  function add_voucherOp($uid=253){
        $voucher_template_model=Model("voucher_template");
        $voucherModel=Model();
        $vouchers=$voucher_template_model->where("voucher_t_register_give='1'")->select();
        $insert_arr = array();
        foreach($vouchers as $value){
            $insert_arr['voucher_code'] =mt_rand(10,99)
                . sprintf('%010d',time() - 946656000)
                . sprintf('%03d', (float) microtime() * 1000)
                . sprintf('%03d', (int) $uid % 1000);
            $insert_arr['voucher_t_id'] = $value['voucher_t_id'];
            $insert_arr['voucher_title'] = $value['voucher_t_title'];
            $insert_arr['voucher_desc'] = $value['voucher_t_desc'];
            $insert_arr['voucher_start_date'] =$value['voucher_t_start_date'];
            $insert_arr['voucher_end_date'] = $value['voucher_t_end_date'];
            $insert_arr['voucher_price'] = $value['voucher_t_price'];
            $insert_arr['voucher_limit'] = $value['voucher_t_limit'];
            $insert_arr['voucher_store_id'] = $value['voucher_t_store_id'];
            $insert_arr['voucher_state'] = 1;
            $insert_arr['voucher_active_date'] = time();
            $insert_arr['voucher_owner_id'] = $uid;
            $insert_arr['voucher_owner_name'] =isset($_POST['username'])?$_POST['username']:$_POST['mobile'];
            //判断是否已经领取
            $alreadyGet=$voucherModel->table("voucher")->where("voucher_t_id='{$value['voucher_t_id']}' and voucher_owner_id='$uid'")->find();
            if(!$alreadyGet){
                $voucherModel->table("voucher")->insert($insert_arr);
                $insertResult=$voucher_template_model->where("voucher_t_id='". $value['voucher_t_id']."'")->setInc('voucher_t_giveout',1);
            }else{
                continue ;
            }
        }
        return 1;
    }

    public function testOp(){
        echo 1111;
    }

}
