<?php
/**
 * 手机社区活动模型
 *
 *
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class discuz_activeModel extends Model {

    //开启状态标识
    const STATE_OPEN = 1;

    public function __construct(){
		
        parent::__construct('discuz_active');
		
    }

	/**
	 * 读取社区活动信息
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function discuzActiveInfo($condition = array()) {
		
		$shequ_info = $this->where($condition)->find();
		
        return $shequ_info;
	}

	/**
	 * 删除社区详细信息
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function delActiveInfo($condition = array()) {
		
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
    public function getActiveList($condition, $field = '*', $page = 1, $order = 'active_id desc', $limit = ''){
		
        return $this->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
		
    }
	
	/*更新社区信息*/
	
	 public function activeUpdate($data = array(), $condition = array()){
				
		return $this->where($condition)->update($data);
		
		
		}			
	/*添加社区信息*/
	
	 public function activeAdd($data=array()){
		//print_r($data); 
		$datas=array();
		$datas['active_title']=isset($data['active_title'])?$data['active_title']:'';	
		$datas['location']=isset($data['location'])?$data['location']:'';
		$datas['object']=isset($data['object'])?$data['object']:'';
		$datas['number']=isset($data['number'])?$data['number']:'';
		$datas['uid']=isset($data['uid'])?$data['uid']:'';		
		$datas['join_time']=isset($data['join_time'])?$data['join_time']:'';
		$datas['pics']=isset($data['pics'])?$data['pics']:'';	
		$datas['last_time']=isset($data['last_time'])?$data['last_time']:'';	
		$datas['content']=isset($data['content'])?$data['content']:'';	
		return $this->insert($datas);				
		}	
		
   /*更新社区详细*/
	
	 public function getActiveInfo($condition = array()){
				
		return $this->where($condition)->find();
		
		
		}
		

}
