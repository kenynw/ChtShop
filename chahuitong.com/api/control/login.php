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

class loginControl extends mobileHomeControl
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 登录
     */
    public function indexOp() {
        if (empty($_POST['username']) || empty($_POST['usermobile'])) {
            output_error('用户名不能为空');
        }
        if (empty($_POST['password'])) {
            output_error('密码不能为空');
        }
        if (!in_array($_POST['client'], $this->client_type_array)) {
            output_error('登录失败:客户端类型错误');
        }

        $model_member = Model('member');
        $array = array();
        if (empty($_POST['member_qqopenid']) && empty($_POST['sinaopenid']) && empty($_POST['member_weixinopenid'])) {
            /*手机号码登陆*/
            if ($_POST['usermobile']) {
                $array['member_mobile'] = trim($_POST['usermobile']);
            }
            if ($_POST['username']) {
                if (is_numeric($_POST['username'])) {
                    $array['member_mobile'] = $_POST['username'];
                } else {
                    $array['member_name'] = $_POST['username'];
                }
            }
            $array['member_passwd'] = md5($_POST['password']);
        } else {
            //qq
            if ($_POST['member_qqopenid']) {
                $array['member_qqopenid'] = $_POST['member_qqopenid'];
            }
            //sina
            if ($_POST['sinaopenid']) {
                $array['member_sinaopenid'] = $_POST['sinaopenid'];
            }
            //wechat
            if ($_POST['member_weixinopenid']) {
                $array['member_weixinopenid'] = $_POST['member_weixinopenid'];
            }
        }
        $member_info = $model_member->getMemberInfo($array);
        if (!empty($member_info)) {
            $token = $this->_get_token($member_info['member_id'], $member_info['member_name'], $_POST['client']);
            if ($token) {
                output_data(array('username' => $member_info['member_name'], 'key' => $token, 'avatar' => getMemberAvatar($member_info['member_avatar'])));
            } else {
                if ($_POST['version']) {
                    output_json(0, array('key' => $token), '登录失败');
                    die();
                }
                output_error('登录失败');
                //output_error($member_info['member_name']);
            }
        } else {
            output_error('用户名密码错误');
        }
    }

    /**
     * 登录生成token
     */
    private function _get_token($member_id, $member_name, $client)
    {
        $model_mb_user_token = Model('mb_user_token');

        //重新登录后以前的令牌失效
        //暂时停用
        //$condition = array();
        //$condition['member_id'] = $member_id;
        //$condition['client_type'] = $_POST['client'];
        //$model_mb_user_token->delMbUserToken($condition);

        //生成新的token
        $mb_user_token_info = array();
        $token = md5($member_name . strval(TIMESTAMP) . strval(rand(0, 999999)));
        $mb_user_token_info['member_id'] = $member_id;
        $mb_user_token_info['member_name'] = $member_name;
        $mb_user_token_info['token'] = $token;
        $mb_user_token_info['login_time'] = TIMESTAMP;
        $mb_user_token_info['client_type'] = $_POST['client'];
        $result = $model_mb_user_token->addMbUserToken($mb_user_token_info);
        if ($result) {
            return $token;
        } else {
            return null;
        }

    }

    /**
     * 注册
     */
    public function registerOp()
    {
        $model_member = Model('member');

        $register_info = array();
        $register_info['username'] = $_POST['username'];
        $register_info['password'] = $_POST['password'];
        $register_info['password_confirm'] = $_POST['password_confirm'];
        $register_info['email'] = $_POST['email'];
        $member_info = $model_member->register($register_info);
        if (!isset($member_info['error'])) {
            $token = $this->_get_token($member_info['member_id'], $member_info['member_name'], $_POST['client']);
            if ($token) {
                output_data(array('username' => $member_info['member_name'], 'key' => $token));
            } else {
                output_error('注册失败');
            }
        } else {
            output_error($member_info['error']);
        }

    }

    /**
     * 注册
     */
    public function register_apiOp()
    {
        //create by lai 主要用于wap,app与第三方登陆，为简化原有接口而改造客户只要注册手机与密码即可
        if (isset($_POST['data'])) {
            $array = json_decode($_POST['data'], true);
            $_POST['key'] = $array['data']['key'];
            $_POST['username'] = $array['data']['username'];
            $_POST['lable'] = $array['data']['lable'];
            $_POST['mobile'] = $array['data']['mobile'];
            $_POST['password'] = $array['data']['password'];
            $_POST['openid'] = $array['data']['openid'];
            $_POST['op'] = $array['data']['op'];
            $_POST['client'] = $array['data']['client'];
        }
        $data = array();
        //output_json(0,array(),'未提交验证码或来自非合法的客户端');
        //app自行判断验证结果,提交个key 用于确定是否是app发送，wap 按正常的的验证提供验证码
        if (!isset($_POST['key']) && !(isset($_POST['verificode']))) {
            output_json(0, array(), '未提交验证码或来自非合法的客户端');
            die();
        }
        if (isset($_POST['key']) && ($_POST['key'] != md5('shopnc'))) {
            output_json(0, array(), "非法操作");
            die();
        }
        if (isset($_POST['verificode'])) {
            $checkResult = $this->check_smsOp();
            if (!$checkResult) {
                output_json(0, array(), "验证码不正确或者已经超时");
                die();
            }
        }
        $model_member = Model('member');
        $register_info = array();
        //获取标签数组用
        if ($_POST['lable']) {
            if (is_string($_POST['lable'])) {
                $_POST['lable'] = rtrim($_POST['lable'], '/');
                $lable_array = explode("/", $_POST['lable']);
            } else {
                $lable_array = $_POST['lable'];
            }
            $member_lable = $this->build_search_lableOp($lable_array);
            if ($member_lable) {
                $register_info['member_lable'] = $member_lable;
            } else {
                $register_info['member_lable'] = '';
            }
        }
        $register_info['mobile'] = $_POST['mobile'];
        $register_info['username'] = isset($_POST['username']) ? $_POST['username'] : $_POST['mobile'];
        $register_info['password'] = $_POST['password'];

        //无需客户再确认密码
        $register_info['password_confirm'] = $_POST['password'];
        $register_info['email'] = $_POST['mobile'] . "@186.com";
        /*判断第三方是否已经注册过*/
        if ($_POST['openid']) {
            if ($_POST['op'] == "qq") {
                $sql = "member_qqopenid='" . $_POST['openid'] . "'";
            }
            if ($_POST['op'] == "sina") {
                $sql = "member_sinaopenid='" . $_POST['openid'] . "'";
            }
            $memberModel = Model("member");
            $memberInfo = $memberModel->where($sql)->find();
            if (!empty($memberInfo)) {
                $token = $this->_get_token($memberInfo['member_id'], $memberInfo['member_name'], $_POST['client']);
                output_json(1, array('key' => $token), '登陆成功');
                die();
            }

        }

        //第三方登陆
        if ($_POST['openid']) {
            $op = isset($_POST['op']) ? $_POST['op'] : 'qq';
            switch ($op) {
                case "qq":
                    $register_info['member_qqopenid'] = $_POST['openid'];
                    $register_info['username'] = "QQ_" . rand(1000000, 9999990);
                    $register_info['password'] = "000000";
                    $register_info['password_confirm'] = $register_info['password'];
                    $register_info['email'] = "noemal" . rand(1000000, 9999990) . "@qq.com";
                    break;
                case "sina":
                    $register_info['member_sinaopenid'] = $_POST['openid'];
                    $register_info['username'] = "sina_" . rand(1000000, 9999999);
                    $register_info['password'] = "000000";
                    $register_info['password_confirm'] = $register_info['password'];
                    $register_info['email'] = "noemal" . rand(1000000, 9999990) . "@163.com";
                    break;
                case "wechat":
                    $register_info['member_wechatopenid'] = $_POST['openid'];
                    $register_info['username'] = "wechat_" . rand(1000000, 9999999);
                    $register_info['password'] = "000000";
                    $register_info['password_confirm'] = $register_info['password'];
                    $register_info['email'] = "noemal" . rand(1000000, 9999990) . "@wechat.com";
                    break;
            }
        }
        $member_info = $model_member->register($register_info);
        if (!isset($member_info['error'])) {
            //如果开启了注册送优惠券添加优惠劵,register_voucher_give 不是系统默认, 添加到 setting,要清除字段缓存
            $token = $this->_get_token($member_info['member_id'], $member_info['member_name'], $_POST['client']);
            if (C('register_voucher_give')) {
                $this->add_voucherOp($member_info['member_id']);
            }
            if ($token) {
                //output_data(array('username' => $member_info['member_name'], 'key' => $token));
                $data['key'] = $token;
                output_json(1, $data, '注册成功');
                die();
            } else {
                //output_error('注册失败');
                output_json(0, array(), '获取token失败');
                die();
            }
        } else {
            //output_error($member_info['error']);
            output_json(0, array(), $member_info['error']);
            die();
        }

    }

    /*标签接口*/
    public function search_lableOp()
    {
        //$_POST['page']=2;
        $lableModel = Model("search_lable");
        $lablekey = $lableModel->field("lable_text")->order("lable_order desc")->page(12)->select();
        $totalPage = $lableModel->getTotalPage();
        $data = array();
        if ($lablekey) {
            $data['totalPage'] = $totalPage;
            $data['data'] = $lablekey;
            output_json(1, $data, '查询完毕');
            die();
        } else {
            output_json(0, array(), '没数据了');
            die();
        }
    }

    /*生成查找标签字符串*/
    public function build_search_lableOp($lable = array())
    {
        //$lable=array("普洱茶","绿茶","润元昌","滇臻號","袋装","源山古茶");
        $keys = $lable;
        if (empty($keys)) {
            return false;
        }
        //生成目录，品牌，属性数组
        $goodsClassModel = Model("goods_class");
        $goodsClassArray = $goodsClassModel->field("gc_id,gc_name")->select();
        $brandModel = Model("brand");
        $brandArray = $brandModel->field("brand_id,brand_name")->page(300)->select();
        $attrValueModel = Model("attribute_value");
        $attrArray = $attrValueModel->field("attr_value_id,attr_value_name")->where("attr_value_id between 3100 and 3310")->select();
        $classArray = array();
        foreach ($goodsClassArray as $v) {
            $classArray[$v['gc_id']] = $v['gc_name'];
        }
        $brandsArray = array();
        foreach ($brandArray as $v) {
            $brandsArray[$v['brand_id']] = $v['brand_name'];
        }
        $attrsArray = array();
        foreach ($attrArray as $v) {
            $attrsArray[$v['attr_value_id']] = $v['attr_value_name'];
        }
        //print_r($classArray);
        //print_r($brandsArray);
        //print_r($attrsArray);
        //$keys 判断是否为 数组
        $catid = array();
        $aid = array();
        $brandid = array();
        if (is_array($keys)) {
            foreach ($keys as $v) {
                if (in_array($v, $classArray)) {
                    $catid[] = array_search($v, $classArray);
                    continue;
                }
                if (in_array($v, $brandsArray)) {
                    $brandid[] = array_search($v, $brandsArray);
                    continue;
                }
                //属性值较多,不适用于 in_array
                foreach ($attrsArray as $key => $att) {
                    if (strpos($att, $v) !== false) {
                        $aid[] = $key;
                    }
                }
            }
        }
        $string = '';
        if (!empty($catid)) {
            $string .= "cate_id=" . implode("_", $catid);
        }
        if (!empty($aid)) {
            $string .= "&a_id=" . implode("_", $aid);
        }
        if (!empty($brandid)) {
            $string .= "&brand_id=" . implode("_", $brandid);
        }
        //print_r($brandid);
        return $string;
    }

    //短信发送验证
    public function send_smsOp()
    {
        $ip = getIp();
        if (isset($_SESSION['customer_ip']) && ($_SESSION['customer_ip'] == $ip) && ($_SESSION['logtime'] >= 6) && (date("m.d") == date("m.d", $_SESSION['time']))) {
            output_json(0, array(), "同个ip一天只能登陆5次");
            die();
        }
        $number = isset($_POST['mobile']) ? $_POST['mobile'] : $_GET['mobile'];
        $result = array();
        if (strlen($number) != 11) {
            output_error('手机号码格式不正确');
        }
        $code = rand(100000, 999999);
        $url = "http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=cf_chahuitong&password=chahuitong2015&mobile=$number&content=您的验证码是：【" . $code . "】。请不要把验证码泄露给其他人。";
        $results = file_get_contents($url);
        $xml = simplexml_load_string($results);
        if ($xml->code == 2) {
            $result['code'] = 1;
            $result['content'] = "短信发送成功，请在1分钟内填入$code";
            $_SESSION['time'] = time();
            $_SESSION['customer_ip'] = $ip;
            $_SESSION['mobilecode'] = $code;
            $_SESSION['mobilenumber'] = $number;
            $_SESSION['logtime'] = isset($_SESSION['logtime']) ? ($_SESSION['logtime'] + 1) : 1;
            $mobileData = array();
            $mobileData['add_time'] = TIMESTAMP;
            $mobileData['verificode'] = $code;
            $mobileRecordModel = Model("mobile_record");
            $alreadyRecord = $mobileRecordModel->where("mobile='$number'")->find();
            if ($alreadyRecord) {
                $mobileRecordModel->where("mobile='$number'")->update($mobileData);
            } else {
                $mobileData['mobile'] = $number;
                $mobileRecordModel->insert($mobileData);
            }

        } else {
            $result['code'] = 0;
            $result['content'] = "发送失败，失败代码：{$xml->code}";
        }
        output_json($result['code'], '', $result['content']);
    }

    //验证短信
    private function check_smsOp()
    {
        if (!isset($_POST['verificode'])) {
            return false;
        }
        //超时时间判断,显示的是1分钟
        /*
        if((time()-$_SESSION['time'])>60){
            return false;
        }
        */

        if ($_SESSION['mobilecode'] != $_POST['verificode']) {
            $mobileRecordModel = Model("mobile_record");
            $data = array();
            $data['mobile'] = $_POST['mobile'];
            $data['verificode'] = $_POST['verificode'];
            $AlreadyExists = $mobileRecordModel->where($data)->find();
            if ($AlreadyExists) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    }

    //优惠券添加
    private function add_voucherOp($uid = 253)
    {
        $voucher_template_model = Model("voucher_template");
        $voucherModel = Model();
        $vouchers = $voucher_template_model->where("voucher_t_register_give='1'")->select();
        $insert_arr = array();
        foreach ($vouchers as $value) {
            $insert_arr['voucher_code'] = mt_rand(10, 99)
                . sprintf('%010d', time() - 946656000)
                . sprintf('%03d', (float)microtime() * 1000)
                . sprintf('%03d', (int)$uid % 1000);
            $insert_arr['voucher_t_id'] = $value['voucher_t_id'];
            $insert_arr['voucher_title'] = $value['voucher_t_title'];
            $insert_arr['voucher_desc'] = $value['voucher_t_desc'];
            $insert_arr['voucher_start_date'] = $value['voucher_t_start_date'];
            $insert_arr['voucher_end_date'] = $value['voucher_t_end_date'];
            $insert_arr['voucher_price'] = $value['voucher_t_price'];
            $insert_arr['voucher_limit'] = $value['voucher_t_limit'];
            $insert_arr['voucher_store_id'] = $value['voucher_t_store_id'];
            $insert_arr['voucher_state'] = 1;
            $insert_arr['voucher_active_date'] = time();
            $insert_arr['voucher_owner_id'] = $uid;
            $insert_arr['voucher_owner_name'] = isset($_POST['username']) ? $_POST['username'] : $_POST['mobile'];
            $voucherModel->table("voucher")->insert($insert_arr);
            $voucher_template_model->where("voucher_t_id='" . $value['voucher_t_id'] . "'")->setInc('voucher_t_giveout', 1);
        }
    }

    public function for_testOp()
    {
        $str = "黑美人";
        print_r(explode("/", $str));
    }

    /*更改密码*/
    public function change_pwdOp()
    {
        $checkResult = $this->check_smsOp();
        if (!$checkResult) {
            output_json(0, array(), "验证码不正确或者已经超时" . $_SESSION['mobilecode']);
            die();
        }
        $data = Array();
        $member_mobile = $_POST['mobile'];
        $data['member_passwd'] = md5($_POST['newpwd']);
        $memberModel = Model("member");
        $updateResult = $memberModel->where("`member_mobile`='" . $member_mobile . "'")->update($data);
        if ($updateResult) {
            output_json(1, '', '更新成功');
            die();
        } else {
            $this->check_member_login();

            output_json(0, '', '更新失败可能没用手机注册');
        }

    }

}
