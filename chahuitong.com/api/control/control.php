<?php
/**
 * mobile父类
 *
 *
 
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

/********************************** 前台control父类 **********************************************/

class mobileControl{

    //客户端类型
    protected $client_type_array = array('android', 'wap', 'wechat', 'ios');
    //列表默认分页数
    protected $page = 10;


	public function __construct() {
        Language::read('mobile');

        //分页数处理
        $page = intval($_GET['page']);
        if($page > 0) {
            $this->page = $page;
        }
    }
}

class mobileHomeControl extends mobileControl{
    protected $member_info = array();
	public function __construct() {
        parent::__construct();
    }
    //add by jason-lai 16.1.5用户检测用户是否登陆
    public function check_member_login(){

        $model_mb_user_token = Model('mb_user_token');
        $key = $_POST['key'];
        if(empty($key)) {
            $key = $_COOKIE['key'];
        }
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        if(empty($mb_user_token_info)) {
            output_json(0,array(),'还未登录');
            die();
        }

        $model_member = Model('member');
        $this->member_info= $model_member->getMemberInfoByID($mb_user_token_info['member_id']);
        $this->member_info['client_type'] = $mb_user_token_info['client_type'];
        if(empty($this->member_info)) {
            output_json(0,array(),'还未登录');
            die();
        }
    }
    //end by jason lai 16.1.5

}

class mobileMemberControl extends mobileControl{

    protected $member_info = array();

	public function __construct() {
        parent::__construct();

        $model_mb_user_token = Model('mb_user_token');
        $key = empty($_POST['key']) ? $_GET['key'] : $_POST['key'];
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        if(empty($mb_user_token_info)) output_json(-1, '','请登录');

        $model_member = Model('member');
        $this->member_info = $model_member->getMemberInfoByID($mb_user_token_info['member_id']);
        $this->member_info['client_type'] = $mb_user_token_info['client_type'];
        if(empty($this->member_info)) {
            output_error('请登录', array('login' => '0'));
        } else {
            //读取卖家信息
            $seller_info = Model('seller')->getSellerInfo(array('member_id'=>$this->member_info['member_id']));
            $this->member_info['store_id'] = $seller_info['store_id'];
        }
    }
}

class mobileCMSControl extends mobileMemberControl {

    //文章状态草稿箱
    const ARTICLE_STATE_DRAFT = 1;
    //文章状态待审核
    const ARTICLE_STATE_VERIFY = 2;
    //文章状态已发布
    const ARTICLE_STATE_PUBLISHED = 3;
    //文章状态回收站
    const ARTICLE_STATE_RECYCLE = 4;
    //文章类型用户投稿
    const ARTICLE_TYPE_MEMBER = 1;
    //文章类型管理员发布
    const ARTICLE_TYPE_ADMIN = 2;
    //推荐
    const COMMEND_FLAG_TRUE = 1;
    //文章评论类型
    const ARTICLE = 1;
    const PICTURE = 2;

    public function __construct() {
        parent::__construct();

        // SEO
        Tpl::output('html_title',C('cms_seo_title').'-'.C('site_name').'');
        Tpl::output('seo_keywords',C('cms_seo_keywords'));
        Tpl::output('seo_description',C('cms_seo_description'));
    }

}

class mobileSNSControl extends mobileControl {

    // 主人ID
    protected $master_id;

    // 登录用户和主人关系 0表示未登录 1表示未关注 2表示互相关注 3表示自己 4表示已关注
    protected $relation;

    // 浏览者ID
    protected $member_id;

    public function __construct() {
        parent::__construct();

        $this->_check_relation();
    }

    private function _check_relation() {
        $key = empty($_GET['key']) ? $_POST['key'] : $_GET['key'];
        $model_mb_user_token = Model('mb_user_token');
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        $this->member_id = $mb_user_token_info['member_id'];

        $this->master_id = intval(empty($_GET['mid']) ? $_POST['mid'] : $_GET['mid']);
        if ($this->master_id <= 0) $this->master_id = intval($mb_user_token_info['member_id']);

        $model_friend = Model('sns_friend');
        if ($this->master_id == $mb_user_token_info['member_id']) {
            $this->relation = 3;
        } else {
            $condition_friend = array();
            $condition_friend['friend_frommid'] = $mb_user_token_info['member_id'];
            $condition_friend['friend_tomid'] = $this->master_id;
            $friend_info = $model_friend->getFriendRow($condition_friend);
            if (empty($friend_info)) {
                $this->relation = 1;
            } elseif($friend_info['friend_followstate'] == 2) {
                $this->relation = 2;
            } elseif($friend_info['friend_followstate'] == 1) {
                $this->relation = 4;
            }
        }
    }

    /**
     * 处理动态列表
     */
    protected function _get_list_extend($trace_list) {
        if (!empty($trace_list) && is_array($trace_list)) {
            $model_trace_image = Model('sns_albumpic');
            foreach ($trace_list as $key=>$value) {
                if (!empty($value['trace_memberavatar'])) $value['trace_memberavatar'] = getMemberAvatar($value['trace_memberavatar']);
                $value['trace_addtime'] = date('Y.m.d h:i', $value['trace_addtime']);
                $value['trace_image'] = snsThumb($value['trace_image']);

                // 替换<a>中的scheme
                if ($value['trace_title']){
                    $value['trace_title'] = str_replace("%siteurl%", "com.cht.user://".DS, $value['trace_title']);
                }
                if(!empty($value['trace_content'])){
                    //替换内容中的siteurl
                    $value['trace_content'] = str_replace("%siteurl%", "com.cht.user://".DS, $value['trace_content']);
                }

                // 与登录用户关系
                $value['relation'] = $this->relation;

                // 图片列表
                $image_list = $model_trace_image->where(array('item_id' => $value['trace_id']))->field('ap_cover, item_id')->select();
                foreach ($image_list as $k=>$image) {
                    $image_list[$k]['thumb_mid'] = snsThumb($image['ap_cover'], '640');
                    $image_list[$k]['thumb_max'] = snsThumb($image['ap_cover'], '1024');
                }
                $value['trace_image_list'] = $image_list;

                // 查询点赞状态
                $model_like = Model('sns_like');
                $like_info = $model_like->getLikeInfo(array(
                    'like_memberid' => $this->member_id,
                    'like_originalid' => $value['trace_id'],
                    'like_originaltype' => 0,
                    'like_state' => 0
                ));
                if (empty($like_info)) $value['is_like'] = false;
                else $value['is_like'] = true;

                $trace_list[$key] = $value;
            }
            return $trace_list;
        }
        return array();
    }

}

class mobileMemberSNSControl extends mobileSNSControl {

    protected $member_info = array();

    public function __construct() {
        $model_mb_user_token = Model('mb_user_token');
        $key = empty($_POST['key']) ? $_GET['key'] : $_POST['key'];
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        if(empty($mb_user_token_info)) output_json(-1, '','请登录');

        $model_member = Model('member');
        $this->member_info = $model_member->getMemberInfoByID($mb_user_token_info['member_id']);
        $this->member_info['client_type'] = $mb_user_token_info['client_type'];
        if(empty($this->member_info)) {
            output_error('请登录', array('login' => '0'));
        } else {
            //读取卖家信息
            $seller_info = Model('seller')->getSellerInfo(array('member_id'=>$this->member_info['member_id']));
            $this->member_info['store_id'] = $seller_info['store_id'];
        }

        parent::__construct();
    }


}