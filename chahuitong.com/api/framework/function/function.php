<?php
/**
 * mobile公共方法
 *
 * 公共方法
 *
 */
defined('InShopNC') or exit('Access Invalid!');
function output_data($datas, $extend_data = array()) {
    $data = array();
    $data['code'] = 1;
    $data['msg'] = 'SUCCESS';

    if (!empty($extend_data)) {
        $data = array_merge($data, $extend_data);
    }

    $data['data'] = $datas;

    if (!empty($_GET['callback'])) {
        echo $_GET['callback'] . '(' . json_encode($data) . ')';
        die;
    } else {
        echo json_encode($data);
        die;
    }
}

function output_error($message, $extend_data = array()) {
    $data = array();
    $data['code'] = 0;
    $data['msg'] = $message;
    echo json_encode($data);
    die;
}

function mobile_page($page_count) {
    //输出是否有下一页
    $extend_data = array();
    $current_page = intval($_GET['curpage']);
    if ($current_page <= 0) {
        $current_page = 1;
    }
    if ($current_page >= $page_count) {
        $extend_data['hasmore'] = false;
    } else {
        $extend_data['hasmore'] = true;
    }
    $extend_data['page_total'] = $page_count;
    return $extend_data;
}

function output_json($code, $data = array(), $msg = 'SUCCESS', $extend_data = array()) {
    if (!is_numeric($code)) return;

    $result = array();
    if (is_array($data) && empty($data) && $code == 1) {
        $result['code'] = 0;
        $result['msg'] = '暂无数据';
    } else {
        $result['code'] = $code;
    }
    if($msg) $result['msg'] = $msg;
    $result['data'] = !empty($extend_data) ? array_merge($data, $extend_data) : $data;

    echo json_encode($result);
    die();
}