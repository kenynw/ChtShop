<?php
/**
 * 默认展示页面
 *
 *
 **by 多用户商城 www.abc.com 多用户商城 运营版*/


defined('InShopNC') or exit('Access Invalid!');
class tea_newsControl extends BaseHomeControl{
    static $recommendNews;
    static $hotNews;
	public function indexOp(){
        $teaNewsModel=Model("cms_article");
        $class_id=isset($_GET['class_id'])?intval($_GET['class_id']):92;
        //echo $class_id;
        $news=$teaNewsModel->field("article_id,article_title,article_abstract,article_publish_time,article_image")->where("article_class_id='".$class_id."'")->page(10)->order("article_id desc")->select();
        //右侧推荐文章
        if(tea_newsControl::$recommendNews!=''){
            Tpl::output('recommends',tea_newsControl::$recommendNews);
        }else{
            tea_newsControl::$recommendNews=$teaNewsModel->field("article_id,article_title,article_abstract,article_publish_time,article_image")->limit(3)->order("article_commend_flag desc")->select();
            Tpl::output('recommends',tea_newsControl::$recommendNews);
        }
        /*栏目数组,用于模板中显示子分类*/
        $menuArray=array(88=>"综合资讯",89=>"行业政策",90=>"品牌新闻",91=>"产业动向",92=>"茶汇通新闻");

        /**/
        Tpl::output("menuArray",$menuArray);
        Tpl::output('class_id',$class_id);
        Tpl::output('page',$teaNewsModel->showpage());
        Tpl::output('news',$news);
		Tpl::showpage('tea_news');
	}
    //新闻详细页
    public function article_detailOp(){
        $teaNewsModel=Model("cms_article");
        if(tea_newsControl::$hotNews!=''){
            Tpl::output('hotNews',tea_newsControl::$hotNews);
        }else{
            tea_newsControl::$hotNews=$teaNewsModel->field("article_id,article_title,article_abstract,article_publish_time,article_image")->limit(10)->order("article_click desc")->select();
            Tpl::output('hotNews',tea_newsControl::$hotNews);
        }
        //print_r(tea_newsControl::$hotNews);
        $menuArray=array(88=>"综合资讯",89=>"行业政策",90=>"品牌新闻",91=>"产业动向",92=>"茶汇通新闻");
        $class_id=isset($_GET['class_id'])?intval($_GET['class_id']):92;
        $article_id=isset($_GET['article_id'])?intval($_GET['article_id']):6153;
        $articleInfo=$teaNewsModel->where("article_id='$article_id'")->find();
        Tpl::output("menuArray",$menuArray);
        Tpl::output('class_id',$class_id);
        Tpl::output("articleInfo",$articleInfo);
        Tpl::showpage("article_detail");
    }
	//json输出商品分类
	public function josn_classOp() {
		/**
		 * 实例化商品分类模型
		 */
		$model_class		= Model('goods_class');
		$goods_class		= $model_class->getGoodsClassListByParentId(intval($_GET['gc_id']));
		$array				= array();
		if(is_array($goods_class) and count($goods_class)>0) {
			foreach ($goods_class as $val) {
				$array[$val['gc_id']] = array('gc_id'=>$val['gc_id'],'gc_name'=>htmlspecialchars($val['gc_name']),'gc_parent_id'=>$val['gc_parent_id'],'commis_rate'=>$val['commis_rate'],'gc_sort'=>$val['gc_sort']);
			}
		}
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$array = Language::getUTF8(array_values($array));//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		} else {
			$array = array_values($array);
		}
		echo $_GET['callback'].'('.json_encode($array).')';
	}

   
	
	//闲置物品地区json输出
	public function flea_areaOp() {
		if(intval($_GET['check']) > 0) {
			$_GET['area_id'] = $_GET['region_id'];
		}
		if(intval($_GET['area_id']) == 0) {
			return ;
		}
		$model_area	= Model('flea_area');
		$area_array			= $model_area->getListArea(array('flea_area_parent_id'=>intval($_GET['area_id'])),'flea_area_sort desc');
		$array	= array();
		if(is_array($area_array) and count($area_array)>0) {
			foreach ($area_array as $val) {
				$array[$val['flea_area_id']] = array('flea_area_id'=>$val['flea_area_id'],'flea_area_name'=>htmlspecialchars($val['flea_area_name']),'flea_area_parent_id'=>$val['flea_area_parent_id'],'flea_area_sort'=>$val['flea_area_sort']);
			}
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$array = Language::getUTF8(array_values($array));//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
			} else {
				$array = array_values($array);
			}
		}
		if(intval($_GET['check']) > 0) {//判断当前地区是否为最后一级
			if(!empty($array) && is_array($array)) {
				echo 'false';
			} else {
				echo 'true';
			}
		} else {
			echo json_encode($array);
		}
	}

	//json输出闲置物品分类
	public function josn_flea_classOp() {
		/**
		 * 实例化商品分类模型
		 */
		$model_class		= Model('flea_class');
		$goods_class		= $model_class->getClassList(array('gc_parent_id'=>intval($_GET['gc_id'])));
		$array				= array();
		if(is_array($goods_class) and count($goods_class)>0) {
			foreach ($goods_class as $val) {
				$array[$val['gc_id']] = array('gc_id'=>$val['gc_id'],'gc_name'=>htmlspecialchars($val['gc_name']),'gc_parent_id'=>$val['gc_parent_id'],'gc_sort'=>$val['gc_sort']);
			}
		}
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$array = Language::getUTF8(array_values($array));//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		} else {
			$array = array_values($array);
		}
		echo json_encode($array);
	}
	
	/**
     * json输出地址数组 原data/resource/js/area_array.js
     */
    public function json_areaOp()
    {
        echo $_GET['callback'].'('.json_encode(Model('area')->getAreaArrayForJson()).')';
    }
	//判断是否登录
	public function loginOp(){
		echo ($_SESSION['is_login'] == '1')? '1':'0';
	}

	/**
	 * 头部最近浏览的商品
	 */
	public function viewed_infoOp(){
	    $info = array();
		if ($_SESSION['is_login'] == '1') {
		    $member_id = $_SESSION['member_id'];
		    $info['m_id'] = $member_id;
		    if (C('voucher_allow') == 1) {
		        $time_to = time();//当前日期
    		    $info['voucher'] = Model()->table('voucher')->where(array('voucher_owner_id'=> $member_id,'voucher_state'=> 1,
    		    'voucher_start_date'=> array('elt',$time_to),'voucher_end_date'=> array('egt',$time_to)))->count();
		    }
    		$time_to = strtotime(date('Y-m-d'));//当前日期
    		$time_from = date('Y-m-d',($time_to-60*60*24*7));//7天前
		    $info['consult'] = Model()->table('consult')->where(array('member_id'=> $member_id,
		    'consult_reply_time'=> array(array('gt',strtotime($time_from)),array('lt',$time_to+60*60*24),'and')))->count();
		}
		$goods_list = Model('goods_browse')->getViewedGoodsList($_SESSION['member_id'],5);
		if(is_array($goods_list) && !empty($goods_list)) {
		    $viewed_goods = array();
		    foreach ($goods_list as $key => $val) {
		        $goods_id = $val['goods_id'];
		        $val['url'] = urlShop('goods', 'index', array('goods_id' => $goods_id));
		        $val['goods_image'] = thumb($val, 60);
		        $viewed_goods[$goods_id] = $val;
		    }
		    $info['viewed_goods'] = $viewed_goods;
		}
		if (strtoupper(CHARSET) == 'GBK'){
			$info = Language::getUTF8($info);
		}
		echo json_encode($info);
	}
	/**
	 * 查询每月的周数组
	 */
	public function getweekofmonthOp(){
	    import('function.datehelper');
	    $year = $_GET['y'];
	    $month = $_GET['m'];
	    $week_arr = getMonthWeekArr($year, $month);
	    echo json_encode($week_arr);
	    die;
	}
}
