<?php
/**
 * 主动推送品牌链接到百度收录
 *
 *
 *
 * Created by PhpStorm.
 * User: Sgun
 * Date: 16/5/11
 * Time: 下午5:19
 */
defined('InShopNC') or exit('Access Invalid!');
class baidu_pushControl extends BaseHomeControl {
    public function __construct()
    {
        parent::__construct();
    }

    public function push_all() {
        $this->brand_detailOp();
        
        $this->goods_detailOp();
        
        $this->cms_articleOp();
    }
    
    /**
     * 推送品牌详情
     *
     * URL:http://www.chahuitong.com/shop/index.php/brand-504-0-0-0-0-0-0.html
     *
     */
    public function brand_detailOp() {
        $id_list = Model('brand')->limit(500)->field('brand_id')->select();
        $url_list = array();
        foreach ($id_list as $key=>$id) {
            $url_list[] = 'http://www.chahuitong.com/shop/brand-' . $id['brand_id'] . '-0-0-0-0-0-0.html';
        }
        var_dump($url_list);

        $this->_push($url_list);
    }

    /**
     * 商品
     *
     * URL:http://shop.chahuitong.com/item-102038.html
     */
    public function goods_detailOp() {
        $model_goods = Model('goods');
        $condition['goods_state']   = 1;
        $condition['goods_verify']  = 1;
        $id_list = $model_goods->getGoodsList($condition,'goods_id,goods_state,goods_verify','','',1000);
        $url_list = array();
        foreach ($id_list as $key=>$id) {
            $url_list[] = 'http://www.chahuitong.com/shop/item-' . $id['goods_id'] . '.html';
        }
//        var_dump($url_list);

        $this->_push($url_list);
    }

    /**
     * cms文章推送
     */
    public function cms_articleOp() {
        $model_article = Model('cms_article');
        $article_id_list = $model_article->limit(500)->field('article_id')->select();
        $url_list = array();
        foreach ($article_id_list as $key=>$id) {
            $url_list[] = 'http://www.chahuitong.com/cms/article-' . $id['article_id'] . '.html';
        }

        print_r($url_list);
//        $this->_push($url_list);
    }

    private function _push($url_list) {
        $api = 'http://data.zz.baidu.com/urls?site=www.chahuitong.com&token=fH18HO1487P4whbw';
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $url_list),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        echo $result;
    }

}