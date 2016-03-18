<?php
/**
 * cms首页
 *
 *
 *

 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
define("Table_Pre", "shopnc_");
define("Goods_Img_Patch", "http://www.chahuitong.com/data/upload/shop/store/goods/");
define("Home_Img_Patch", "http://www.chahuitong.com/data/upload/mobile/home/");

class homeControl extends mobileHomeControl
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home_page_apiOp()
    {
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $logState = false;
        if (isset($_POST['key']) || isset($_COOKIE['key'])) {
            $key = isset($_POST['key']) ? $_POST['key'] : $_COOKIE['key'];
            $tokenModel = Model('mb_user_token');
            $findResult = $tokenModel->where("token='$key'")->find();
            if ($findResult) {
                $logState = true;
                $member_id = $findResult['member_id'];
                $memberModel = Model("member");
                $memberLable = $memberModel->field("member_lable")->where("member_id='$member_id'")->find();
                $member_lable = $memberLable['member_lable'];
            }
        }
        if (empty($member_lable) || ($member_lable == ' ')) {
            $member_lable = "cate_id=3_258&a_id=3059_3512&brand_id=444";
        }
        //$member_lable="cate_id=1_201";
        //$member_lable="cate_id=3_258&a_id=3059_3512&brand_id=444";
        $data = array();
        $data['is_login'] = $logState;
        if ($page == 1) {
            //首页轮播图
            $carouselModel = Model('home_pic');
            $carouselFigure = $carouselModel->where("location='1'")->select();
//            if ($carouselFigure) {
//                $carouselFigureCheck = array();
//                foreach ($carouselFigure as $v) {
//                    if (!strpos($v['image'], 'chahuitong.com')) {
//                        $v['goods_image'] = Home_Img_Patch . $v['image'];
//                        $carouselFigureCheck[] = $v;
//                    } else {
//                        $v['goods_image'] = $v['image'];
//                        $carouselFigureCheck[] = $v;
//                    }
//                }
//            }
            $data['adds'] = $carouselFigure;
            //免费茶样
            $samplePic = $carouselModel->where("location='3'")->find();
            /*
            $sampleModel=Model("goods_sample");
            $condition['sample_start_time'] = array('lt', TIMESTAMP);
            $condition['sample_end_time'] = array('gt', TIMESTAMP);
            $goodsSample=$sampleModel->where($condition)->find();

            $sampleImageArray=explode(',',$goodsSample['sample_image']);
            $tempArray=array();

            foreach($sampleImageArray as $key=>$value){
                list($imageName,$imageType)=explode('.',$value);
                $tempArray[$key]['original_pic']=Goods_Img_Patch.$value["store_id"].'/'.$imageName.'.'.$imageType;
                $tempArray[$key]['bmiddle_pic']=Goods_Img_Patch.$value["store_id"].'/'.$imageName.'_360.'.$imageType;
                $tempArray[$key]['small_pic']=Goods_Img_Patch.$value["store_id"].'/'.$imageName.'_60.'.$imageType;
            }
            */
//            if($samplePic['image']){
//                $tempArray=array();
//                //list($host,$imageName,$imageType)=explode('.',$samplePic['image']);
//                $imageType=substr($samplePic['image'],-3);
//                $imageName=substr($samplePic['image'],0,-4);
//                $tempArray['original_pic']=$samplePic['image'];
//                $tempArray['bmiddle_pic']=$imageName.'_360.'.$imageType;
//                $tempArray['small_pic']=$imageName.'_60.'.$imageType;
//                $sampleImage = substr($samplePic['image'], strripos($samplePic['image'], '.'));
//                print_r($sampleImage);
//            }
            $imageType = substr($samplePic['image'], -3);
            $imageName = substr($samplePic['image'], 0, -4);
            $data['sample_image'] = $imageName . '_360.' . $imageType;

            // 限时抢购
            $xianshi_result = $carouselModel->where("location='3'")->find();
            $model_xianshi_goods = Model('p_xianshi_goods');
            $xianshi_item = $model_xianshi_goods->getXianshiGoodsCommendList(1);
            $imageType = substr($xianshi_result['image'], -3);
            $imageName = substr($xianshi_result['image'], 0, -4);
            $xianshi_list = array();
            $xianshi_list['image'] = $imageName . '_360.' . $imageType;
            $xianshi_list['end_time'] = $xianshi_item[0]['end_time'];
            $data['xianshi'] = $xianshi_list;

            // 品茶师推荐
            $tastersRecommendSql = "SELECT g.goods_id,g.goods_name,g.goods_image,g.goods_price,
                                        g.goods_promotion_price,g.goods_marketprice,g.goods_promotion_type,
                                        g.store_id,r.recommend_score,r.recommend_taste,r.recommend_light,
                                        r.recommend_aroma,r.recommend_leaf
                                    FROM shopnc_tasters_recommend AS r
                                    LEFT JOIN shopnc_goods AS g
                                    ON r.recommend_goods_id=g.goods_id
                                    WHERE g.goods_verify='1'
                                    AND g.goods_commend='1'
                                    AND r.recommend_state='1'
                                    ORDER BY r.recommend_sort
                                    DESC limit 4";

            $goodsModel = Model("");
            $tasters_list = $goodsModel->query($tastersRecommendSql);
//            $tastersTem=array();
//            foreach($tastersRecommends as $key=>$value){
//                  list($imageName,$imageType)=explode(".",$value['goods_image']);
//                  $value['goods_image']=array();
//                  $value['goods_image']['original_pic']=Goods_Img_Patch.$value["store_id"].'/'.$imageName.'.'.$imageType;
//                  $value['goods_image']['bmiddle_pic']=Goods_Img_Patch.$value["store_id"].'/'.$imageName.'_360.'.$imageType;
//                  $value['goods_image']['small_pic']=Goods_Img_Patch.$value["store_id"].'/'.$imageName.'_60.'.$imageType;
//                  $tastersTem[]=$value;
//            }
            foreach ($tasters_list as $key => $value) {
                $tasters_list[$key]['goods_image_url'] = cthumb($value['goods_image'], 360, $value['store_id']);
            }
            $data['tasters_list'] = $tasters_list;

        }
        //猜你喜欢
        //情形1，未登录
        if (!$logState) {
            $member_lable = "cate_id=3_258&a_id=3059_3512&brand_id=444";
            $guess_list = $this->get_likeOp($member_lable, $page);
            //$guess_list=$goodsModel->field("goods_id,goods_name,goods_image,goods_price,goods_promotion_price,goods_marketprice,goods_promotion_type,store_id")->where("goods_state='1'")->order("goods_click desc")->page(6)->select();
        } else {
            /*按浏览记录查找，已废弃 更改为按标签查找
           //情形2-1 登陆且有浏览过页面
               $browseModel=Model();
               $sql="SELECT * FROM `shopnc_goods_browse` where member_id='$member_id' ORDER BY browsetime desc limit 1";
               $browseRecord=$browseModel->query($sql);
               //取得该商品所在目录()
               if($browseRecord[0]) {
                   $gcid = '';
                   for ($i = 3; $i > -1; $i--) {
                       if ($browseRecord[0]['gc_id_' . $i]) {
                           if($i==0){
                               $gcid = "gc_id="."'{$browseRecord[0]['gc_id_' . $i]}'";
                               break;
                           }else {
                               $gcid = "gc_id_".$i."="."'{$browseRecord[0]['gc_id_'. $i]}'";
                               break;
                           }
                       }
                   }
                   //echo $gcid;
                   $guess_list=$goodsModel->where($gcid." and goods_state='1'")->limit(6)->select();
               }else{
           //情形2-2 登陆没有浏览页面
                   $guess_list=$goodsModel->where("goods_state='1'")->order("goods_click desc")->page(6)->select();
               }
            */
            //有标签
            $goodsModel = Model("goods");
            if (!empty($member_lable)) {
                $guess_list = $this->get_likeOp($member_lable, $page);
            } else {
                //没有标签
                $guess_list = $goodsModel->field("goods_id,goods_name,goods_image,goods_price,goods_promotion_price,goods_marketprice,goods_promotion_type,store_id")->where("goods_state='1'")->order("goods_click desc")->page(6)->select();

            }
        }
        // print_r($guess_list);
        $temGuess = array();
        if ($guess_list) {
            $goodsCommonModel = Model("goods_common");
            foreach ($guess_list as $key => $value) {
//                list($imageName, $imageType) = explode(".", $value['goods_image']);
//                $value['goods_image'] = array();
//                $value['goods_image']['original_pic'] = Goods_Img_Patch . $value["store_id"] . '/' . $imageName . '.' . $imageType;
//                $value['goods_image']['bmiddle_pic'] = Goods_Img_Patch . $value["store_id"] . '/' . $imageName . '_360.' . $imageType;
//                $value['goods_image']['small_pic'] = Goods_Img_Patch . $value["store_id"] . '/' . $imageName . '_60.' . $imageType;
                $guess_list[$key]['goods_image_url'] = cthumb($value['goods_image'], 360, $value['store_id']);
//                /*获取产地属性<<*/
//                $attrArray = $goodsCommonModel->field("goods_attr")->where("goods_commonid='" . $value['goods_commonid'] . "'")->find();
//                $attrArray = @unserialize();
//                /*获取产地属性>>*/
//                $temGuess[] = $value;
            }
        }
        $data['guess_list'] = $guess_list;

        if ($page == 1) {
            //add ceshi
            // $data['member_lable']=$member_lable;
            //add ceshi
            output_json(1, $data, '查找成功');
            die();
        } else if ($data['guess_list']) {
            output_json(1, $data, '查找成功');
            die();
        } else {
            output_json(0, $data, '已经没有内容了');
            die();
        }
    }

    //标签选项
    public function get_likeOp($string = "cate_id=3_258&a_id=3059_3512&brand_id=444", $page = 1)
    {
        //筛选字符串为cate_id=201_202&a_id=3224_3230
        if (strpos($string, "cate_id") === false && strpos($string, 'a_id') === false) {
            return false;
        }
        $condition = array();
        $params = explode("&", $string);
        // 注意strpos  获取元素在 开始位置返回 0，要用！=false  判断
        if (strpos($string, "cate_id") !== false) {
            list(, $condition['cate_id']) = explode("=", $params[0]);
        }
        if (strpos($string, "brand_id") !== false) {
            list(, $condition['brand_id']) = explode("=", $params[2]);
        }
        if (strpos($string, "a_id") !== false) {
            list(, $condition['a_id']) = explode("=", $params[1]);
        }
        //生成目录数组
        $class_array = Model('goods_class')->getGoodsClassForCacheModel();
        //print_r($class_array);
        //情形1.1 筛选string中有多个cate_id,确定各个目录之间的关系
        $goodsModel = Model("goods");
        $data = array();
        $catArray = array();
        //先按目录查找
        if (isset($condition['cate_id'])) {
            $catIdArray = explode("_", $condition['cate_id']);
            foreach ($catIdArray as $cat_id) {
                if (isset($class_array[$cat_id]['child'])) {
                    $temArray = explode(',', $class_array[$cat_id]['child']);
                    $catArray = array_merge($catArray, $temArray);
                    $catArray = array_unique($catArray);
                } elseif (isset($class_array[$cat_id]) && empty($class_array[$cat_id]['child'])) {
                    if (!in_array($cat_id, $catArray)) {
                        array_push($catArray, $cat_id);
                    }
                }

            }
            //$catString=implode(',',$catArray);
            //print_r($catArray);
            //$byCatNums=$goodsModel->where("gc_id in ($inString)")->count();
            //$maxPagebyCat=floor($byCatNums/6);
            //$redundantNum=$byCatNums%6;
            //$goodsByCat=$goodsModel->where("gc_id in ($inString)")->page(6)->select();
            //if($goods){
            // print_r($goods);
            //}

        }
        //按品牌查找
        if (isset($condition['brand_id'])) {
            //先判断品牌是否属于某个分类，如果属于某个分类，则按 分类查找时候已经查找完毕
            $brandModel = Model("brand");
            $brandString = str_replace("_", ",", $condition['brand_id']);
            //已经设置了目录
            if (isset($catArray)) {
                $brandArray = $brandModel->field("brand_id,class_id")->where("brand_id in ($brandString)")->select();
                $rebuildBrandArray = array();
                foreach ($brandArray as $brand) {
                    if (!in_array($brand['class_id'], $catArray)) {
                        $rebuildBrandArray[] = $brand['brand_id'];
                    }
                }
                if ($rebuildBrandArray) {
                    $brandString = implode(",", $rebuildBrandArray);
                    /*
                    if($_POST['page']==($maxPagebyCat+1)) {
                        $_POST['page']=1;
                        $fetchNum=6-$redundantNum;
                        $sql="select * from shopnc_goods where brand_id in ($brandString) order by `goods_id` desc limit 0,$fetchNum";
                        //$goodsByBrand=$goodsModel->where("brand_id in ($brandString)")->page(2)->select();
                        $goodsByBrand=$goodsModel->query($sql);
                        print_r($goodsByBrand);

                    }else{

                    }
                   */
                }
            } else {
                //未设置目录
                $brandString = str_replace("_", ",", $condition['brand_id']);
            }
        }
        //按属性查找,目前属性按功效划划分，每个类别产品有相同功效,把属性转化为分类
        if (isset($condition['a_id'])) {
            $attrIn = str_replace("_", ",", $condition['a_id']);
            $goodsIndexModel = Model("goods_attr_index");
            $sql = "select distinct gc_id from " . Table_Pre . "goods_attr_index where attr_value_id in ($attrIn)";
            $attrArray = $goodsIndexModel->query($sql);
            if (isset($catArray)) {
                foreach ($attrArray as $attr) {
                    if (!in_array($attr['gc_id'], $catArray)) {
                        array_push($catArray, $attr['gc_id']);
                    }
                }

            } else {
                $catArray = array();
                foreach ($attrArray as $attr) {
                    $catArray[] = $attr['gc_id'];
                }
            }

        }
        //3 种情形判断完，开始查找
        if (isset($catArray) && isset($brandString)) {
            $byCat = implode(",", $catArray);
            $sql = "select goods_id,goods_name,goods_image,goods_price,goods_promotion_price,goods_marketprice,goods_promotion_type,store_id from " . Table_Pre . "goods where (`gc_id` in ($byCat) or `brand_id` in ($brandString)) and goods_state='1' order by goods_click desc limit " . (($page - 1) * 6) . ",6 ";
            $goods = $goodsModel->query($sql);
        } elseif (isset($catArray) && empty($brandString)) {
            $byCat = implode(",", $catArray);
            $sql = "select goods_id,goods_name,goods_image,goods_price,goods_promotion_price,goods_marketprice,goods_promotion_type,store_id from " . Table_Pre . "goods where `gc_id` in ($byCat) and goods_state='1' order by goods_click desc limit " . (($page - 1) * 6) . ",6 ";
            $goods = $goodsModel->query($sql);
        } elseif (empty($catArray) && isset($brandString)) {
            $sql = "select goods_id,goods_name,goods_image,goods_price,goods_promotion_price,goods_marketprice,goods_promotion_type,store_id from " . Table_Pre . "goods where `brand_id` in ($brandString) and goods_state='1' order by goods_click desc limit " . (($page - 1) * 6) . ",6 ";
            $goods = $goodsModel->query($sql);
        }
        return $goods;

    }
}

?>