<?php
/**
 * 手机支付方式
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class ecs_post_contentModel extends Model {

    //开启状态标识
    const STATE_OPEN = 1;

    public function __construct() {
        parent::__construct('ecs_post_content');
    }

	/**
	 * 读取茶市详细页
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getChashiInfo($condition = array()) {
		$chashi_info = $this->where($condition)->find();
        return $chashi_info;
	}

	/**
	 * 删除茶市详细信息
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function delChashiInfo($condition = array()) {
	    $del_info=$this->where($condition)->delete();
		return $del_info;
	}

	/**
	 * 读取多行
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	/*public function getChashiList($condition = array()){
        $chashi_list = $this->where($condition)->select();       
        return $chashi_list;
	}*/
    public function getChashiList($condition, $field = '*', $page = 0, $order = 'id desc', $limit = '') {
        return $this->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
    }
	/**
	 * 读取开启中的支付方式
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getMbPaymentOpenList($condition = array()){
	    $condition['payment_state'] = self::STATE_OPEN;
	    return $this->getMbPaymentList($condition);
	}
	/*更新茶市信息*/
	
	 public function contentUpdate($data = array(), $condition = array()){
		
			
		return $this->where($condition)->update($data);
		
		
		}


	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @return bool 布尔类型的返回结果
	 */
	public function editMbPayment($data, $condition){
        if(isset($data['payment_config'])) {
            $data['payment_config'] = serialize($data['payment_config']);
        }
		return $this->where($condition)->update($data);
	}
}
