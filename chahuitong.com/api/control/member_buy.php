<?php
/**
 * 购买
 *
 *
 *
 *
 
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');


class member_buyControl extends mobileMemberControl {

	public function __construct() {
		parent::__construct();
	}

    /**
     * 购物车、直接购买第一步:选择收获地址和配置方式
     */
    public function buy_step1Op() {

        $cart_id = explode(',', $_POST['cart_id']);
        $logic_buy = logic('buy');
        //得到购买数据
        $result = $logic_buy->buyStep1($cart_id, $_POST['ifcart'], $this->member_info['member_id'], $this->member_info['store_id']);
        if(!$result['state']) {
            output_error($result['msg']);
        } else {
            $result = $result['data'];
        }
        //整理数据
        $store_cart_list = array();
        foreach ($result['store_cart_list'] as $key => $value) {
            $store_list = array();
            $store_list['goods_list'] = $value;
            $store_list['store_goods_total'] = $result['store_goods_total'][$key];
            if(!empty($result['store_premiums_list'][$key])) {
                $result['store_premiums_list'][$key][0]['premiums'] = true;
                $result['store_premiums_list'][$key][0]['goods_total'] = 0.00;
                $store_cart_list['goods_list'][] = $result['store_premiums_list'][$key][0];
            }
            $store_list['store_mansong_rule_list'] = $result['store_mansong_rule_list'][$key];
            $store_list['store_voucher_list'] = $result['store_voucher_list'][$key];
            if(!empty($result['cancel_calc_sid_list'][$key])){
                $store_list['freight'] = false;
                $store_list['freight_message'] = $result['cancel_calc_sid_list'][$key]['desc'];
            } else {
                $store_list['freight'] = true;
            }
            $store_list['store_id'] = $key;
            $store_list['store_name'] = $value[0]['store_name'];
            $store_cart_list[] = $store_list;
        }

        $buy_list = array();
        $buy_list['store_cart_list'] = $store_cart_list;
        $buy_list['freight_hash'] = $result['freight_list'];
        $buy_list['address_info'] = $result['address_info'];
        $buy_list['ifshow_offpay'] = $result['ifshow_offpay'];
        $buy_list['vat_hash'] = $result['vat_hash'];
        $buy_list['inv_info'] = $result['inv_info'];
        $buy_list['available_predeposit'] = $result['available_predeposit'];
        $buy_list['available_rc_balance'] = $result['available_rc_balance'];
        /**/
		 /*add by la*/
        $datas = $logic_buy->changeAddr($result['freight_list'],$result['address_info']['city_id'], $result['address_info']['area_id'],$this->member_info['member_id']);
        $buy_list['allow_offpay']=$datas['allow_offpay'];
        $buy_list['offpay_hash']=$datas['offpay_hash'];
        $buy_list['offpay_hash_batch']=$datas['offpay_hash_batch'];

        output_json(1, $buy_list);
    }

    /**
     * 购物车、直接购买第二步:保存订单入库，产生订单号，开始选择支付方式
     *
     */
    public function buy_step2Op() {
        $param = array();
        $param['ifcart'] = $_POST['ifcart'];
        $param['cart_id'] = explode(',', $_POST['cart_id']);
        $param['address_id'] = $_POST['address_id'];
        $param['vat_hash'] = $_POST['vat_hash'];
        $param['offpay_hash'] = $_POST['offpay_hash'];
        $param['offpay_hash_batch'] = $_POST['offpay_hash_batch'];
        $param['pay_name'] = $_POST['pay_name'];
        $param['invoice_id'] = $_POST['invoice_id'];

        //处理代金券
        $voucher = array();
        $post_voucher = explode(',', $_POST['voucher']);
        if(!empty($post_voucher)) {
            foreach ($post_voucher as $value) {
                list($voucher_t_id, $store_id, $voucher_price) = explode('|', $value);
                $voucher[$store_id] = $value;
            }
        }
        $param['voucher'] = $voucher;

        //手机端暂时不做支付留言，页面内容太多了
        //$param['pay_message'] = json_decode($_POST['pay_message']);
        $param['pd_pay'] = $_POST['pd_pay'];
        $param['rcb_pay'] = $_POST['rcb_pay'];
        $param['password'] = $_POST['password'];
        $param['fcode'] = $_POST['fcode'];
        $param['order_from'] = 2;
        $logic_buy = logic('buy');

        $result = $logic_buy->buyStep2($param, $this->member_info['member_id'], $this->member_info['member_name'], $this->member_info['member_email']);
        if(!$result['state']) {
            //output_error($result['msg']);
            //change by lai 用于兼容新旧 Json 输出<<
            if(isset($_POST['version'])){
                output_json(0,'',$result['msg']);
                die();
            }
            output_error($result['msg']);
            //change by lai 用于兼容新旧 Json 输出>>
        }

       /*修改by-lai,output 默认只输出array('pay_sn' => $result['data']['pay_sn']),添加订单信息<<*/
	    $order=array();
	    foreach($result['data']['order_list'] as $v){
			foreach($v as $key=>$value){
				$order[$key]=$value;
				}
			}
		$order['extend_order_goods']=$result['data']['goods_list'];
        if(isset($_POST['version'])){
          output_json(1,array('pay_sn' =>$result['data']['pay_sn'],'order'=>$order),'订单生成成功');
            die();
        }
		output_data(array('pay_sn' =>$result['data']['pay_sn'],'order'=>$order));
		/*end修改by lai>>*/
    }

    /**
     * 验证密码
     */
    public function check_passwordOp() {
        if(empty($_POST['password'])) {
            output_error('参数错误');
        }

        $model_member = Model('member');

        $member_info = $model_member->getMemberInfoByID($this->member_info['member_id']);
        if($member_info['member_paypwd'] == md5($_POST['password'])) {
            output_data('1');
        } else {
            output_error('密码错误');
        }
    }

    /**
     * 更换收货地址
     */
    public function change_addressOp() {
        $logic_buy = Logic('buy');

        $data = $logic_buy->changeAddr($_POST['freight_hash'],$_POST['city_id'],$_POST['area_id'], $this->member_info['member_id']);
        if(!empty($data) && $data['state'] == 'success' ) {
            if($_POST['version']){
                output_json(1,$data,'查询正常');
                die();
            }
            output_data($data);
        } else {
            output_error('地址修改失败');
        }
    }


}

