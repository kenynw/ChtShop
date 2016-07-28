<?php
/**
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/5/27
 * Time: 下午3:57
 */
class sns_likeModel extends Model {

    public function __construct() {
        parent::__construct('sns_like');
    }

    public function addLike($insert) {
        return $this->insert($insert);
    }

    public function editLike($condition, $update) {
        return $this->where($condition)->update($update);
    }

    public function cancelLike($condition) {
        return $this->editLike($condition, array('like_state' => 1));
    }

    public function getLikeInfo($condition, $field = '*') {
        return $this->field($field)->where($condition)->find();
    }

    public function countLike($condition) {
        return $this->where($condition)->count();
    }
    
}