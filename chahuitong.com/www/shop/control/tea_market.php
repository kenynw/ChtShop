<?php
/**
 * 默认展示页面
 *
 *
 **by 多用户商城 www.abc.com 多用户商城 运营版*/


defined('InShopNC') or exit('Access Invalid!');
class tea_marketControl extends BaseHomeControl{
    static $hotProducts ;
	public function indexOp(){
        $saleWay=isset($_GET['sale_way'])?intval($_GET['sale_way']):1;
        $teaMarketModel=Model("ecs_post");
        $teas=$teaMarketModel->where("saleway='$saleWay'")->page(10)->order("id desc")->select();
        Tpl::output('saleWay',$saleWay);
        Tpl::output('page',$teaMarketModel->showpage());
        Tpl::output('teas',$teas);
		Tpl::showpage('tea_market');
	}

    public function quotationOp(){
        $brandModel=Model("brand");
        /*获取品牌目录*/
        $brandNames=$brandModel->field("brand_id,brand_name")->where("class_id='1'")->order("brand_sort desc")->select();
        Tpl::output('brandNames',$brandNames);
        /*获取行情信息*/
        $quotationModel=Model("ecs_quotation");
        $quotations=$quotationModel->page(10)->select();
        Tpl::output('quotations',$quotations);
        Tpl::output('url','http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?act=tea_market&op=json_search');
        Tpl::output('page',$quotationModel->showpage());
        Tpl::showpage('tea_quotation');
    }

    /* 茶市详细页面*/
    public function tea_market_detailOp(){
        $id = intval($_GET['content_id']);
        if(!$id)  showmessage("非法内容");
        $contentModel=Model();
        $sql="select c.*,d.depic,d.content from `shopnc_ecs_post` as c left JOIN `shopnc_ecs_post_content` as d on c.id=d.pid where c.id='$id' ";
        $content=$contentModel->query($sql);
        $hotProductsModel=Model("ecs_post");
        self::$hotProducts=$hotProductsModel->order("recommend desc")->limit(3)->select();
        //print_r(self::$hotProducts);
        //print_r($content);
        Tpl::output('hotProducts',self::$hotProducts);
        Tpl::output('content',$content);
        Tpl::showpage('tea_market_detail');
    }


    public function json_searchOp(){

        $where='';
        if($_GET['brand']!='') $brand="brand_id='".intval($_GET['brand'])."'";
        if(isset($brand)) $where=$brand;
        //if($_GET['area']!='') $data['area']=intval($_GET['area']);
        if($_GET['age']!=''){
            $year=date("Y");
            switch($_GET['age']){
                case 1:
                    $age="$year-year>=5 and $year-year<10"  ;
                    break;
                case 2:
                    $age="$year-year>=3 and $year-year<5"  ;
                    break;
                case 3:
                    $age="$year-year>=1 and $year-year<3"  ;
                    break;
                case 4:
                    $age="$year-year<=1"  ;
                    break;
                case 5:
                    $age="$year-year>=10"  ;
                    break;
                default:
                    $age='';
            }

        }
        //echo $_GET['age'].$age;
        if($where!=''&&$age!=''){
            $where=$where." and ".$age;
        }elseif($where==''&&$age1!=''){
            $where=$age;
        }else{
            $where=$where;
        }
        if($_GET['max_price']!=''){
            if($_GET['min_price']==''){$_GET['min_price']=0;}
            $price="{$_GET['min_price']}<`price` and `price`<{$_GET['max_price']}";
        }
        if($where!=''&&$price!=''){
            $where=$where." and ".$price;
        }elseif($where==''&&$price!=''){
            $where=$price;
        }else{
            $where=$where;
        }
        //echo $where;
        $quotationModel=Model("ecs_quotation");
        $content=$quotationModel->where($where)->select();
        $info=array();
        if($content){
          $info['code']=200;
          $info['content']=$content;
          $info['msg']=$where;
        }else{
            $info['code']=404;
            $info['content']='';
            $info['msg']=$where;
        }
       echo json_encode($info);
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

    //茶市发布
     public function tea_market_publicOp(){
         if (!$_SESSION['is_login']) {
             showmessage("您还未登陆不能发布产品");
         }
         Tpl::showpage('tea_market_public');

     }
     public function tea_market_public_saveOp(){
         if(!$_SESSION['is_login']){
             showmessage("您还未登陆，不能发布");
         }
         if($_POST['name']=='') showmessage("标题不能为空");
         $publicModel=Model("ecs_post");
         $data=array();
         $data['brand']= htmlspecialchars($_POST['brand']);
         $data['name']= htmlspecialchars($_POST['name']);
         $data['year']= htmlspecialchars($_POST['year']);
         $data['address']= htmlspecialchars($_POST['location']);
         $data['price']= htmlspecialchars($_POST['price']);
         $data['weight']= htmlspecialchars($_POST['weight']);
         $data['phone']= htmlspecialchars($_POST['phone']);
         $data['unit']= htmlspecialchars($_POST['unit']);
         $data['saleway']= htmlspecialchars($_POST['saleway']);
         $imageName='';
         if($_FILES==''){
             $data['pic']='nopic.jpg';
         }else{
             $legitType=array("image/png","image/gif","image/jpeg");
             for ($i = 0;$i < count($_FILES['image']['error']); $i++) {
                 if ($_FILES['image']['error'][$i] != 0) continue;
                 if (!in_array($_FILES['image']['type'][$i], $legitType)) continue;
                 $type = substr($_FILES['image']['type'][$i], 6);
                 $name = time() . "_$i.$type";
                 $saveResult = move_uploaded_file($_FILES['image']['tmp_name'][$i], BASE_DATA_PATH . "/upload/shequ/" . $name);
                 if ($saveResult) {
                     $imageName.= $name. ",";
                 }
             }
         }
         $imageName=($imageName!='')?rtrim($imageName,','):'nopic.jpg';
         $picArray=explode(",",$imageName);
         $data['pic']=$picArray[0];
         $data['user_id']=$_SESSION['member_id'];
         $data['addtime']=date("Y-m-d H:i:s");
         $insertResult=$publicModel->insert($data);
         if($insertResult){
           $publicContentModel=Model("ecs_post_content");
           $data=array();
           $data['depic']=$imageName;
           $data['content']=htmlspecialchars($_POST['content']);
           $data['pid']=$insertResult;
           $result=$publicContentModel->insert($data);
           if($result){
               //print_r($_FILES);
               showmessage("发布成功");
           }else{
               showmessage("发布失败");
           }
         }

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
