<?php
/**
 * mobile公共方法
 *
 * 公共方法
 *

 */
defined('InShopNC') or exit('Access Invalid!');

function output_data($datas, $extend_data = array())
{
    $data = array();
    $data['code'] = 200;

    if (!empty($extend_data)) {
        $data = array_merge($data, $extend_data);
    }

    $data['datas'] = $datas;

    if (!empty($_GET['callback'])) {
        echo $_GET['callback'] . '(' . json_encode($data) . ')';
        die;
    } else {
        echo json_encode($data);
        die;
    }
}

function output_error($message, $extend_data = array())
{
    $datas = array('error' => $message);
    output_data($datas, $extend_data);
}

function mobile_page($page_count)
{
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

function output_json($state = 1, $data = '', $msg = '')
{
    $datas = array();
    $datas['code'] = $state;
    if($msg) $datas['msg'] = $msg;
    //$datas['data'] = (($state == 1) && is_array($data)) ? $data : '';
    if(!empty($data)){
        $datas['data']=$data;
    }
    echo json_encode($datas);
}

function outpu_json_error($state = 0, $msg = '')
{
    $datas['code'] = $state;
    $datas['msg'] = $msg;
    echo json_encode($datas);
}
