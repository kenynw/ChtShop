<?php
/**
 * 支付接口
 *
 *
 */
//defined('InShopNC') or exit('Access Invalid!');
header('Content-type:text/html;charset=utf-8');
include_once 'utf8/func/common.php';
include_once 'utf8/func/SDKConfig.php';
include_once 'utf8/func/secureUtil.php';
include_once 'utf8/func/log.class.php';

/**
 * 消费交易-前台
 */
class yinlian
{

    /**
     *    以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考
     */
    // 初始化日志

    function submit($param)
    {
        $log = new PhpLog (SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL);
        $log->LogInfo("============处理前台请求开始===============");
        // 初始化日志
        $params = array(
            'version' => '5.0.0',                //版本号
            'encoding' => 'utf-8',                //编码方式
            'certId' => getSignCertId(),            //证书ID
            'txnType' => '01',                //交易类型
            'txnSubType' => '01',                //交易子类
            'bizType' => '000201',                //业务类型
            'frontUrl' => SDK_FRONT_NOTIFY_URL,        //前台通知地址
            'backUrl' => SDK_BACK_NOTIFY_URL,        //后台通知地址
            'signMethod' => '01',        //签名方法
            'channelType' => '08',        //渠道类型，07-PC，08-手机
            'accessType' => '0',        //接入类型
            'merId' => '898350254993136',                //商户代码，请改自己的测试商户号
            'orderId' => $param['order_sn'],    //商户订单号
            'txnTime' => date('YmdHis'),    //订单发送时间
            'txnAmt' => $param['order_amount'] * 100,        //交易金额，单位分
            'currencyCode' => '156',    //交易币种
            'defaultPayType' => '0001',    //默认支付方式
            //'orderDesc' => '订单描述',  //订单描述，网关支付和wap支付暂时不起作用
            'reqReserved' => ' 透传信息', //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
        );

        // 签名
        //sign ( $params );
        $log->LogInfo('=====签名报文开始======');
        if (isset($params['transTempUrl'])) {
            unset($params['transTempUrl']);
        }
        // 转换成key=val&串
        $params_str = coverParamsToString($params);
        $log->LogInfo("签名key=val&...串 >" . $params_str);

        $params_sha1x16 = sha1($params_str, FALSE);
        $log->LogInfo("摘要sha1x16 >" . $params_sha1x16);
        // 签名证书路径
        $cert_path = SDK_SIGN_CERT_PATH;
        //echo $cert_path;
        //add
        //echo file_get_contents($cert_path);
        $private_key = getPrivateKey($cert_path);
        // 签名
        $sign_falg = openssl_sign($params_sha1x16, $signature, $private_key, OPENSSL_ALGO_SHA1);

        if ($sign_falg) {
            $signature_base64 = base64_encode($signature);
            $log->LogInfo("签名串为 >" . $signature_base64);
            $params ['signature'] = $signature_base64;
        } else {
            $log->LogInfo(">>>>>签名失败<<<<<<<");
        }
        $log->LogInfo('=====签名报文结束======');

        // 前台请求地址
        $front_uri = SDK_FRONT_TRANS_URL;
        $log->LogInfo("前台请求地址为>" . $front_uri);
        // 构造 自动提交的表单
        $html_form = create_html($params, $front_uri);

        $log->LogInfo("-------前台交易自动提交表单>--begin----");
        $log->LogInfo($html_form);
        $log->LogInfo("-------前台交易自动提交表单>--end-------");
        $log->LogInfo("============处理前台请求 结束===========");
        echo $html_form;
    }

    /*银联前台同步跳转地址*/
    public function getReturnInfo($payment_config)
    {
        if (isset($_POST['signature'])) {
            return array(
                //商户订单号
                'out_trade_no' => $_POST['orderId'],
                //支付宝交易号
                'trade_no' => $_POST['queryId'],
            );
        } else {
            return false;
        }
    }

    /*银联支付异步后台通知地址*/
    public function getNotifyInfo($payment_config)
    {
        if (isset($_POST['signature'])) {
            return array(
                //商户订单号
                'out_trade_no' => $_POST['orderId'],
                //支付宝交易号
                'trade_no' => $_POST['queryId'],
            );
        } else {
            return false;
        }
    }


}