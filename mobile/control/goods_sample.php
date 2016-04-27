<?php
/**
 * 免费茶样<暂时弃用>
 *
 *
 *

 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
class goods_sampleControl extends mobileHomeControl
{
    const SAMPLE_STATE_NORMAL = 1;

    public function __construct()
    {
        parent::__construct();
    }

    public function indexOp()
    {
        $model_sample = Model('goods_sample');
        $model_goods = Model('goods');

        $condition = array();
        $condition['sample_state'] = self::SAMPLE_STATE_NORMAL;
        $sample_list = $model_sample->where($condition)->order('sample_end_time desc')->limit(1)->select();

        $field_goods = 'store_id,goods_salenum,goods_storage';
        $goods_info = $model_goods -> getGoodsOnlineInfoByID($sample_list[0]['sample_link'],$field_goods);

        $sample_info = array_merge($sample_list[0], $goods_info);
        $sample_info['allow'] = 1;
        $sample_info['state_text'] = '申领';

        // 判断库存
        if ($sample_info['goods_storage'] <= 0) {
            $sample_info['allow'] = 0;
            $sample_info['state_text'] = '已领光';
        }
        
        // 处理图片
        $image_list = explode(",", $sample_info['sample_image']);
        $sample_info['sample_image'] = array();
        foreach ($image_list as $key => $v) {
            $sample_info['sample_image'][$key]['bmiddle_pic'] = cthumb($v, 360, $sample_info['store_id']);
            $sample_info['sample_image'][$key]['original_pic'] = cthumb($v, 1280, $sample_info['store_id']);
        }
        
        // 处理日期
        if ($sample_info['sample_start_time'] > TIMESTAMP) {
            $sample_info['allow'] = 0;
            $sample_info['state_text'] = '未开始';
        } elseif ($sample_info['sample_end_time'] < TIMESTAMP) {
            $sample_info['allow'] = 0;
            $sample_info['state_text'] = '已结束';
        }
        
        /*检测是否有权限*/
        $key = $_POST['key'];
        if (empty($key)) {
            $key = $_GET['key'];
        }
        if (!empty($key)) {
            $model_mb_user_token = Model('mb_user_token');
            $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
            if (empty($mb_user_token_info)) {
                $sample_info['allow'] = 0;
                $sample_info['state_text'] = '请重新登录';
            } else {
                $buyer_id = $mb_user_token_info['member_id'];
                $goods_id = $sample_info['sample_link'];
                $sql = "select gs.goods_id,o.add_time from shopnc_order_goods as gs left join shopnc_order as o on gs.order_id=o.order_id where gs.goods_id=$goods_id and o.add_time>" . $sample_info["sample_start_time"] . " and o.add_time<" . $sample_info["sample_end_time"] . " and o.buyer_id='" . $buyer_id . "'";
                $model = Model();
                $result = $model->query($sql);
                if ($result) {
                    $sample_info['allow'] = 0;
                    $sample_info['state_text'] = '已领取';
                }
            }
        }
        output_json(1, $sample_info, '查询正常');
    }

    //往期列表
    public function overdue_goodsOp()
    {
        $sampleModel = Model("goods_sample");
        $condition = array();
        $condition['sample_state'] = SAMPLE_SATATE;
        $condition['sample_end_time'] = array('lt', TIMESTAMP);
        $overdueGoodsSample = $sampleModel->where($condition)->order("sample_end_time desc")->page(15)->select();
        $tempArray = array();
        foreach ($overdueGoodsSample as $value) {
            if ($value['sample_image'] != '') {
                $imageArray = explode(',', $value['sample_image']);
                $value['sample_image'] = array();
                foreach ($imageArray as $key => $v) {
                    $originalImageString = IMAGE_PACH . $v;
                    $value['sample_image'][$key]['original_pic'] = $originalImageString;
                    list($str1, $str2) = explode('.', $v);
                    $midpic = IMAGE_PACH . $str1 . "_360" . '.' . $str2;
                    $value['sample_image'][$key]['bmiddle_pic'] = $midpic;
                    $smallpic = IMAGE_PACH . $str1 . "_60" . '.' . $str2;
                    $value['sample_image'][$key]['small_pic'] = $smallpic;
                }
                /*恢复原价判断sample_bak_price 是否为0 ，不能0 还未恢复<<*/
                if ($value['sample_bak_price'] > 0) {
                    $goodsModel = Model("goods");
                    $priceArray = array();
                    $priceArray['goods_price'] = $value['sample_bak_price'];
                    $priceArray['goods_promotion_price'] = $value['sample_bak_promotion_price	'];
                    $goodsModel->table("goods")->where("goods_id='" . $value['sample_link'] . "'")->update($priceArray);

                    $priceArray = array();
                    $priceArray['sample_bak_price'] = 0.0;
                    $priceArray['sample_bak_promotion_price'] = 0.0;
                    $sampleModel->where("sample_link='" . $value['sample_link'] . "'")->update($priceArray);
                    $value['sample_goods_price'] = $value['sample_bak_price'];
                } else {
                    $goodsModel = Model("goods");
                    $priceArray = $goodsModel->table("goods")->where("goods_id='" . $value['sample_link'] . "'")->find();
                    if ($priceArray['goods_promotion_price'] != 0.00) {
                        $value['sample_goods_price'] = $priceArray['goods_promotion_price'];
                    } else {
                        $value['sample_goods_price'] = $priceArray['goods_price'];
                    }
                }
                /*恢复原价判断sample_bak_price 是否为0 ，不能0 还未恢复>>*/
            }
            //$value['sample_thumbnail']=IMAGE_PACH.$value['sample_image'];
            $tempArray[] = $value;
        }
        $data = !empty($overdueGoodsSample) ? $tempArray : '';
        if ($overdueGoodsSample) {
            output_json(1, $data, '查询正常');
        } else {
            output_json(0, $data, '已经没有数据了');
        }
    }

    //免费茶样领取
    public function sample_applyOp()
    {
        $this->check_member_login();
        if ($_POST['member_mobile'] == '' || $_POST['member_address'] == '' || $_POST['sample_id'] == '') {
            output_json(0, '', '客户手机和地址样品id不能为空');
            die();
        }
        $data = array();
        $condition = array();
        $sample_id = $_POST['sample_id'];
        $sampleModel = Model("goods_sample");
        $sampleInfo = $sampleModel->where("sample_id='$sample_id'")->find();
        if ($sampleInfo['sample_limit_number'] <= 0) {
            output_json(0, '', '样品已经分发完毕');
            die();
        }
        $condition['sample_name'] = $sampleInfo['sample_name'];
        $condition['sample_image'] = $sampleInfo['sample_image'];
        $condition['sample_start_time'] = $sampleInfo['sample_start_time'];
        $condition['sample_end_time'] = $sampleInfo['sample_end_time'];
        $condition['sample_start_time'] = $sampleInfo['sample_start_time'];
        $condition['sample_order_add_time'] = time();
        $condition['sample_id'] = $sampleInfo['sample_id'];
        $condition['sample_link'] = $sampleInfo['sample_link'];
        $condition['sample_member_name'] = $this->member_info['member_name'];
        $condition['sample_member_id'] = $this->member_info['member_id'];
        $condition['sample_member_address'] = $_POST['member_address'];
        $condition['sample_member_mobile'] = $_POST['member_mobile'];
        $samoleOderModel = Model("sample_order");
        $insetResult = $samoleOderModel->insert($condition);
        if ($insetResult) {
            $sampleModel->where("sample_id='$sample_id'")->setInc("sample_received_number", 1);
            $sampleModel->where("sample_id='$sample_id'")->setDec("sample_limit_number", 1);
            output_json(1, array('sample_order_id' => $insetResult), '添加成功');
        } else {
            output_json(0, '', '添加失败');
        }

    }


}

?>