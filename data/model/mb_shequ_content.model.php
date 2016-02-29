<?php
/**
 * 手机社区模型
 *
 *
 *
 *
 
 */
defined('InShopNC') or exit('Access Invalid!');
class mb_shequ_contentModel extends Model {

    //开启状态标识
    const STATE_OPEN = 1;

    public function __construct(){
		
        parent::__construct('discuz_content');
		
    }

	/**
	 * 读取社区详细信息
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function discuzContentiInfo($condition = array()) {
		
		$shequ_info = $this->where($condition)->find();
		
        return $shequ_info;
	}

	/**
	 * 删除社区详细信息
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function delShequInfo($condition = array()) {
		
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
    public function getShequList($condition, $field = '*', $page = 0, $order = 'content_id desc', $limit = ''){
		
        return $this->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
		
    }
	
	/*更新社区信息*/
	
	 public function contentUpdate($data = array(), $condition = array()){
				
		return $this->where($condition)->update($data);
		
		
		}
	/*更新社区信息*/
	
	 public function contentAdd($data = array(), $condition = array()){
				
		return $this->insert($data);
		
		
		}
			
		
	/*添加社区信息*/
	
	 public function newsAdd($data = array(), $condition = array()){
				
		return $this->insert($data);
		
		
		}	
		
   /*更新社区详细*/
	
	 public function getShequInfo($condition = array()){
				
		return $this->where($condition)->find();
		
		
		}
		

}
