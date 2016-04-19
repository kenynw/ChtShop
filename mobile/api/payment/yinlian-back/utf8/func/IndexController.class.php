<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 首页控制器
 * @autho: Leslie Deng 
 */
class IndexController extends Controller {
	
	//系统首页
	
	public function home(){
		
		//刷选商品，暂定，限时特购商品
		$xianshi=M("p_xianshi_goods");
		
		$goods=$xianshi->where("state='1' and start_time<'".time()."' and end_time>'".time()."'")->order("`order` desc")->limit("1")->select();
		
		//print_r($goods);
		
		$this->assign("xianshigoods",$goods);
		$this->display();
		
		}
	//首页商品api
	public function homePromotionGoods(){
		
		//刷选商品，暂定，限时特购商品
		$xianshi=M("p_xianshi_goods");
		
		$goods=$xianshi->where("state='1' and start_time<'".time()."' and end_time>'".time()."'")->order("`order` desc")->limit("2")->select();
		
		//print_r($goods);
		
	    $array=array();
		
		if($goods){
			
			$array['code']=200;
			
			$array['content']=$goods;
			
			}else{
			
			$array['code']=404;
			
			$array['content']=$goods;	
				
				}
		echo json_encode($array);		
		
		}
			
	
	//首页收藏个数
	public function homeapi(){
		
		$goods_id=isset($_POST['goods_id'])?intval($_POST['goods_id']):"49";
		
		$fav=M("favorites");
		
		$info=$fav->where("fav_id='$goods_id'")->count();
		
		$array=array();
		
		if(isset($info)){			
			$array['code']=200;
			
			$array['goods_id']=$goods_id;
						
			$array['content']=$info;
						
			}else{
				
			$array['code']=404;
			
			$array['goods_id']=$goods_id;
						
			$array['content']=0;	
				
				}
				
		echo json_encode($array);		
				
		
		}		
	
	
	
	public function index(){
		
		header("location:/wap/index.php/Home/Index/home");
		
		$kehuduan=$_SERVER['HTTP_USER_AGENT'];
		
		if(strpos($kehuduan,'android')||strpos($kehuduan,'ios')){
			
			$this->assign('khd','1');
			
			}
		
		//品牌
		$brand=M('brand');		
		$recommend=$brand->where("brand_recommend='1'")->order("brand_sort desc")->limit(8)->select();
		//闪购 数据库表中p_xianshi_goods 中添加了 order 进行排序
		$xianshi=M('p_xianshi_goods');
		$xianshigoods=$xianshi->where("state='1' and xianshi_recommend='1'")->order("`order` desc")->limit(3)->select();
		$xgoods=array();
		foreach($xianshigoods as $key=>$v){
			if($key==0){
			$v['goods_image']=substr($v['goods_image'],0,-4).'_360'.substr($v['goods_image'],-4);
			$v['end_time']=floor(($v['end_time']-time())/(24*60*60));
			}else{
			$v['goods_image']=substr($v['goods_image'],0,-4).'_240'.substr($v['goods_image'],-4);	
			$v['end_time']=floor(($v['end_time']-time())/(24*60*60));
				}
			$xgoods[]=$v;
			
			}
		//print_r($xgoods);
		//第二次轮播图片
		$link=M("link");
		$pics=$link->where("link_sort='255'")->select();
		
		$this->assign('pics',$pics);		
        $this->assign('xianshi',$xgoods);
		$this->assign('recommend',$recommend);		
		$this->display();		
		}
		
    /*目录页*/		
	public function category(){
		
		  $category=M('goods_class');
		  
		  $class=$category->where("gc_parent_id='0'")->select();
		  
		  //print_r($class);
		  
		  $this->assign('class',$class);
		  
		  $this->display();
	
		}	
    /*ajax 调取下级目录*/		
	public function secondcg(){
		
		  $id=isset($_POST['id'])&&is_numeric($_POST['id'])?$_POST['id']:1;
		  
		  if($id==1){
			  
			   $html='<div class="cg_list" style="float:left"><a href="'.__ROOT__.'/index.php/Home/index/categorydetail/id/1"><img src="'.__ROOT__.'/Public/Home/img/普洱_生茶.jpg"><h3 >生茶</h3></a></div>
			   <div class="cg_list" style="float:left"><a href="'.__ROOT__.'/index.php/Home/index/categorydetail/id/1"><img src="'.__ROOT__.'/Public/Home/img/普洱_熟茶.jpg"><h3 >熟茶</h3></a></div>
			   <div class="cg_list" style="float:left"><a href="'.__ROOT__.'/index.php/Home/index/categorydetail/id/1"><img src="'.__ROOT__.'/Public/Home/img/普洱_饼茶.jpg"><h3 >饼茶</h3></a></div>
			   <div class="cg_list" style="float:left"><a href="'.__ROOT__.'/index.php/Home/index/categorydetail/id/1"><img src="'.__ROOT__.'/Public/Home/img/普洱_瓜茶.jpg"><h3 >瓜茶</h3></a></div>
			    <div class="cg_list" style="float:left"><a href="'.__ROOT__.'/index.php/Home/index/categorydetail/id/1"><img src="'.__ROOT__.'/Public/Home/img/普洱_沱茶.jpg"><h3 >沱茶</h3></a></div>
				<div class="cg_list" style="float:left"><a href="'.__ROOT__.'/index.php/Home/index/categorydetail/id/1"><img src="'.__ROOT__.'/Public/Home/img/普洱_砖茶.jpg"><h3 >砖茶</h3></a></div>
				<div class="cg_list" style="float:left"><a href="'.__ROOT__.'/index.php/Home/index/categorydetail/id/1"><img src="'.__ROOT__.'/Public/Home/img/普洱_散茶.jpg"><h3 >散茶</h3></a></div> 
			   ';
			   echo $html;
			   exit();
			  
			  
			  }
		
		  $category=M('goods_class');
		  
		  $class=$category->where("gc_parent_id='$id'")->select();
		  
		  if($class){
			  $html='';
			  foreach($class as $value){
				  
				$html.='<div class="cg_list"><a href="'.__ROOT__.'/index.php/Home/index/categorydetail/id/'.$value['gc_id'].'"><img src="'.__ROOT__.'/Public/Home/img/'.$value['gc_name'].'.jpg"><h3 >'.$value['gc_name'].'</h3></a></div>';
			  }
	           echo $html;
			  
			  }else{
				  
				  
				echo "该目录无下一级目录";  
				  
				  }
	
		}
   public function categorydetail(){
	   
	    $gc_id=isset($_GET['id'])&&is_numeric($_GET['id'])?$_GET['id']:1;
	   
	    $goods=M('goods');
	   
	    $allgoods=$goods->where("gc_id='$gc_id' and goods_state='1'")->limit(10)->order("goods_commend desc,goods_id desc")->select();
		
		//print_r($allgoods);
		$goods=array();
		foreach($allgoods as $value){
			
			$value['image_url']=substr($value['goods_image'],0,-4)."_360.".substr($value['goods_image'],-3);
			$goods[]=$value;
			}
	    $this->assign('gc_id',$gc_id);
	    $this->assign('goods',$goods);
	      
	    $this->display();
	   
	   
	   
	   }
	   /*ajax 产品列表页排序方法*/
 public function select(){
	 
	 $gc_id=isset($_POST['id'])&&is_numeric($_POST['id'])?$_POST['id']:1;
	 $orderway=isset($_POST['orderway'])&&is_numeric($_POST['orderway'])?$_POST['orderway']:1;
	 $page=isset($_POST['page'])&&is_numeric($_POST['page'])?$_POST['page']:1;
	 $pagesize=10;
	 
	 if($orderway==1){
		 $goods=M('goods');
	 $allgoods=$goods->where("gc_id='$gc_id' and goods_state='1'")->limit(($page-1)*$pagesize,10)->order("goods_salenum desc")->select();
	                }
	 if($orderway==2){
		 $goods=M('goods');
	 $allgoods=$goods->where("gc_id='$gc_id' and goods_state='1'")->limit(($page-1)*$pagesize,10)->order("goods_price")->select();
	                }	
	 if($orderway==3){
		$attr=221;/*属性*/ 
		$goods=M('');
	 $sql="select g.*,a.`attr_id`,t.`attr_value_name` from `shopnc_goods` as g left join  (`shopnc_goods_attr_index` as    a,`shopnc_attribute_value` as t) on (g.goods_id=a.goods_id and a.attr_value_id = t.attr_value_id) where a.attr_id='$attr' and  a.`gc_id`=	'$gc_id' and g.goods_state='1' order by t.`attr_value_name` asc  limit ".($page-1)*$pagesize.",10 ";
		$allgoods=$goods->query($sql);
			 
	                }
	 if($orderway==4){
		$attr=223;/*属性*/ 
		$goods=M('');
		         $sql="select g.*,a.`attr_id`,t.`attr_value_name` from `shopnc_goods` as g left join (`shopnc_goods_attr_index` as       a,`shopnc_attribute_value` as t) on (g.goods_id=a.goods_id and a.attr_value_id = t.attr_value_id) where a.attr_id='$attr' and      a.`gc_id`=	'$gc_id' and g.goods_state='1' order by t.`attr_value_name` desc limit ".($page-1)*$pagesize.",10 ";
		$allgoods=$goods->query($sql);
	 
	                }
	 if(!$allgoods){
		 
		 die();
		 
		 }						
								
	 $goods='';
		foreach($allgoods as $value){
			
			$goods.='<div class="show">
            <div class="title">
            <a href="'.__ROOT__.'/index.php/Home/index/goods/goods?goods_id='.$value['goods_id'].'"><img src="/data/upload/shop/store/goods/'.$value['store_id'].'/'.substr($value['goods_image'],0,-4)."_360.".substr($value[            'goods_image'],-3).'"><h3 style="font-weight:500">'.$value['goods_name'].'</h3></a>
            </div>
            <div class="jiage">
            <img src="'.__ROOT__.'/Public/Home/img/jiage.gif"><mark>'.$value['goods_price'].'</mark>            <a href="__URL__/goods/goods?goods_id='.$value['goods_id'].'"><img src="'.__ROOT__.'/Public/Home/img/you.png"></a>
           </div>
           </div>';			
		}
		//$goods.='<div id="Loading"><img src="'.__ROOT__.'/Public/Home/img/loader.gif"></div>';
		
	 echo $goods; 
	 
	 
	 
	 }	 
	 /*产品页面*/
	 public function goods(){
		 
		// echo $_GET['goods_id'];
		//product_detail.js  364 行需要修改新连接		
		$goods_id=isset($_GET['goods_id'])&&is_numeric($_GET['goods_id'])?$_GET['goods_id']:1;	
		$goods=M('goods');
		$id=$goods->field("goods_commonid,brand_id")->where("goods_id='$goods_id'")->find();
		//pinpai
		$brand=M("brand");
		$brandname=$brand->field("brand_name")->where("brand_id={$id['brand_id']}")->find();	 
		$goods_commonid=$id['goods_commonid'];
		$evaluate_goods=M("evaluate_goods");
		$evals=$evaluate_goods->where("geval_goodsid=$goods_id")->select();
		//取出用户头像
		$eval=array();
		$member=M('member');
		foreach($evals as $v){
			
			$v['geval_addtime']=date("Y-m-d H:i:s",$v['geval_addtime']);
			
			$img=$member->field("member_avatar")->where("member_id='{$v['geval_frommemberid']}'")->find();
			
			$v['img']=$img['member_avatar'];
			
			$eval[]=$v;
			
			
			}
			
			
			
			
		
		
		
		
		$model=M('goods_common'); 
		$info=$model->where("goods_commonid='$goods_commonid'")->find();
		//print_r($info);
		$array=array();
		foreach(unserialize($info['goods_attr']) as $v){
			
			$array[]=array_values($v);
			
			}
		/*商品评论暂时不写，在表33hao_evaluate_goods中，暂时不知道怎么存的*/	
		$info['goods_attr']=$array;	
		$this->assign('info',$info);
		$this->assign('brand_name',$brandname['brand_name']);
		$this->assign('evals',$eval);
		$this->display('good');		 
		 }  
		 
	//登陆页	 
	public function login(){
		
		//product_detail.js  226 行需要修改登陆连接
				
		 $this->display();
		
		}
	//注册页	
	public function register(){
		
		//product_detail.js  226 行需要修改登陆连接
				
		 $this->display();
		
		}			 
	 
	 public function test(){
		 
		 
		 $goods=M('');
		 $sql="select g.*,a.`attr_id`,t.`attr_value_name` from `33hao_goods` as g left join (`33hao_goods_attr_index` as           a,`33hao_attribute_value` as t) on (g.goods_id=a.goods_id and a.attr_value_id = t.attr_value_id) where a.attr_id='$attr'          and a.`gc_id`=	'$gc_id' order by t.`attr_value_name`  limit 0,10 ";
		$allgoods=$goods->query($sql);
		print_r($allgoods);
		 
		 
		 }
	//购物车	 
	public function cart(){
		
		
		
		$this->display();
		
		} 	
	//个人中心
	public function member(){
				
		if(isset($_COOKIE['key'])&&isset($_COOKIE['username'])){
			
			$token=M('mb_user_token');
			
			$name=$_COOKIE['username'];
			
			$key=$_COOKIE['key'];
			
			$userinfo=$token->field("member_id")->where("`token`='$key' and `member_name`='$name'")->find();
			
			/*用户信息*/
			$member=M('member');
			
			$userinfo=$member->where("member_id='{$userinfo['member_id']}'")->find();
			
			//print_r($userinfo);
			
			//查询订单数量
			
			$order=M('order');
			
			$time=time();
			
			$ordernumber=$order->where("order_state='10' and buyer_id='{$userinfo['member_id']}'")->count();
			
			//信息数目
			
			$message=M("message");
			
			$messagecount=$message->where("`to_member_id`='{$userinfo['member_id']}' and message_open='0'")->count();
			
			//购物车数量
			
			$cart=M('cart');
			
			$cartnumber=$cart->where("buyer_id='{$userinfo['member_id']}'")->count();
			
			
			
			$this->assign('cartnumber',$cartnumber);
			$this->assign('messagecount',$messagecount);
			$this->assign('ordernumber',$ordernumber);
			$this->assign('userinfo',$userinfo);		
						
			}	
						
		$this->display();
		
		}	
	//搜索页面
	function product_list(){
		
		$this->display();
		
		}	
	public function viewList(){
		
		$this->display();
		
		
		}	
	public function favorites(){
		
		$this->display();
		}	
	public function orderList(){
		
		$this->display();
		}	
	//订单评价接口 暂时弃用	
	public function orderapi(){
		
		$oid=isset($_POST['oid'])?intval($_POST['oid']):1;	
		
		$uid=$this->chacklogin();	
		
		$ordergoods=array();
		
		if($uid){
			$ordergoods=M("");
			$sql="SELECT o.order_sn,o.store_name,o.order_id,g.* from 33hao_order as o left join 33hao_order_goods as g on o.order_id=g.order_id where o.order_id='$oid'";			
			$goodsinfo=$ordergoods->query($sql);			
			/*$goodsorder=array();						
			foreach($goodsinfo as $value){
								
				if(isset($goodsorder[$value['store_id']])){	
													
					$goodsorder[$value['store_id']][]=$value;	
									
					}else{	
										
					$goodsorder[$value['store_id']][]=$value;	
					
						}							
				}		*/		
			}			
		  echo json_encode($goodsinfo);			
		}	
		
	public function pingjiaorder(){
		
			
		$oid=isset($_GET['oid'])?intval($_GET['oid']):1;	
		
		$uid=$this->chacklogin();	
		
		$ordergoods=array();
		
		if($uid){
			$ordergoods=M("");
			$sql="SELECT o.order_sn,o.store_name,o.order_id,g.* from shopnc_order as o left join shopnc_order_goods as g on o.order_id=g.order_id where o.order_id='$oid'";			
			$goodsinfo=$ordergoods->query($sql);			
			$goodsorder=array();						
			foreach($goodsinfo as $value){
				
				if(isset($goodsorder[$value['store_id']])){	
													
					$goodsorder[$value['store_id']][]=$value;	
									
					}else{	
										
					$goodsorder[$value['store_id']][]=$value;	
					
						}							
				}			
			}	
			
			//print_r($goodsorder);		
			
			$this->assign('ordergoods',$goodsorder);
			
			$this->display();	
		
		}	
   public function goodspingjiaajax(){
	   
	    //echo json_encode($_GET);
		if($this->chacklogin()){
	    $data['geval_scores']=intval($_GET['star']);
		$data['geval_orderid']=intval($_GET['order_id']);
		$data['geval_goodsid']=intval($_GET['goods_id']);
		$data['geval_goodsname']=addslashes($_GET['goods_name']);
       	$data['geval_goodsprice']=intval($_GET['goods_price']);
		$data['geval_storeid']=intval($_GET['store_id']);
       	$data['geval_content']='';
		$data['geval_ordergoodsid']=intval($_GET['rec_id']);
       	$data['geval_storename']=addslashes($_GET['store_name']);	
		$data['geval_orderno']=intval($_GET['orderno']);
		$data['geval_goodsimage']=addslashes($_GET['goods_image']);
		$data['geval_addtime']=time();
		$data['geval_frommemberid']=intval($_GET['buyer_id']);	
		$member=M("member");
		$name=$member->field("member_name")->where("member_id=".intval($_GET['buyer_id']))->find();
		$data['geval_frommembername']=$name['member_name'];
		
		$geval=M("evaluate_goods");
		$done=$geval->where("geval_orderid=".intval($_GET['order_id'])." and geval_goodsid=".intval($_GET['goods_id']))->find();
		if(!$done){
		$result=$geval->add($data); 
		        }else{	
		//$datas['geval_scores']=$data['geval_scores'];					
		$result=$geval->where("geval_id='{$done['geval_id']}'")->save($data); 
					
					}
		if($result){ 
		$array=array("result"=>1);
		  }else{
			  
		$array=array("result"=>0);	  
			  }
		echo json_encode($array);	  
		
		
		 }
		 
		 
		 
	   
	   }		
		
   public function pingajiestore(){
	
		$login=$this->chacklogin();
		if(!$login){$this->error("您还未登陆","member");}
	   $store=M("evaluate_store");
	   $data=array();	   		
	   $checkresult=$store->where("seval_orderid='".intval($_POST['order_id'])."'")->find();
	  
	   $data['seval_orderid']=intval($_POST['order_id']);	
	   $data['seval_orderno']=intval($_POST['orderno']);
	   $data['seval_orderno']=intval($_POST['orderno']);
	   $data['seval_addtime']=time();
	   $data['seval_storeid']=intval($_POST['store_id']);
	   $data['seval_desccredit']=intval($_POST['product']);
	   $data['seval_servicecredit']=intval($_POST['service']);
	   $data['seval_deliverycredit']=intval($_POST['deliver']);
	   $data['seval_memberid']=intval($_POST['buyer_id']);
	   $data['seval_storename']=addslashes($_POST['store_name']);
	   $member=M("member");
	   $membername=$member->field("member_name")->where("member_id={$data['seval_memberid']}")->find();
	   $data['seval_membername']=$membername['member_name'];
	   if(!$checkresult){
	   $result=$store->add($data);
	      }else{
			  
		$result=$store->where("seval_id={$checkresult['seval_id']}")->save($data);	  
			  }
	   if($result){
		   
		   if(isset($_POST['hidden'])){
			   		   
			   $datas['geval_isanonymous']=1;
			   }
		   if($_POST['content']!=''){
			   
			   $datas['geval_content']=addslashes($_POST['content']);
			   
			   }				   
			if($datas){
				
				$goods=M("evaluate_goods");
				
				$goods->where("geval_orderid={$data['seval_orderid']}")->save($datas);
							
				}   
			$this->success("您已经完成评价","member");	   
		   	   
		   }
   
	   }		
		
		
	public function buy_step1(){
		
		
		$this->display();
		
		}	
    public function order_list(){
		
		
		$this->display();
		
		}			
	/*品牌页*/
	
	
		public function brand(){	
		
		/**/
			
		$category=M('goods_class');
		$cats=$category->where("gc_parent_id='0'")->order("gc_sort Asc")->limit("7")->select();
		$this->assign("cats",$cats);		
		$this->display();		
		}	
	/*ajax获取品牌*/	
	
	  public function brandAjax(){
		  
		   $catId=isset($_POST['catId'])&&is_numeric($_POST['catId'])?$_POST['catId']:0;
		   
		   /*获取子分类id*/
		   
		   $class=M("goods_class");
		   
		   $classIds=$class->field("gc_id")->where("`gc_parent_id`='$catId'")->select();
		   
		   $id='';
		   
		   foreach($classIds as $ids){
			   
			$id.=$ids['gc_id'].',';   
			   
			   
			   }
			   
			$id=$catId.','.$id;
			
			$id=rtrim($id, ',');    
		   
		   /*end 子分类*/
		   $brand=M('brand');
		   
		   if($catId!=0){
			   
			   $where=" class_id in (".$id.")";
			   
			          }else{
				   
				$where="";   
				     }
			$brands=$brand->where($where)->select();
			
			echo json_encode($brands);	   
  
		  
		  }
	 function brandGoods(){
		 
		 $bid=isset($_GET['bid'])&&is_numeric($_GET['bid'])? $_GET['bid']:1;
		 
		 $brand=M('brand');
		 
		 //echo realpath("./desc/".$bid.".txt");
		 if(file_exists("./desc/".$bid.".txt")){
			 
			 $content=file_get_contents("./desc/".$bid.".txt");
			 			 
			 $content=iconv("GBK","UTF-8",$content);			 
			 $this->assign("desc",$content);
			 
			 }
		 
		 
		 $name=$brand->where("brand_id='$bid'")->field('brand_name')->find();
		 
		// print_r($name);
		 $this->assign('name',$name);
		 
		 $goods=M("goods");
		 
		 if($_GET['showway']&&in_array($_GET['showway'],array(1,2,3,4))){
			 
			$showway=intval($_GET['showway']);
			
			$order="";
			
			switch($showway){
				
			 case 1:			 	
			   $order=" `goods_price` ASC";			
				break;
			 case 2:
			   $order=" `goods_id` DESC";			
				break;					
			 case 3:
			   $order=" `goods_click` DESC";			
				break;	
			 case 4:
			   $order=" `goods_salenum` DESC";			
				break;				
				
				}			 
		 $brandgoods=$goods->where("brand_id='$bid' and goods_state='1'")->order($order)->select();	 
		 
		 $this->assign("showway",$showway);
		 
			 }else{
		 
		 $brandgoods=$goods->where("brand_id='$bid' and goods_state='1'")->select();
		 
			 }
		 
		 $this->assign('bid',$bid);
		 
		 
		 $this->assign("brandgoods",$brandgoods);
		 
		 //print_r($brandgoods);
		 
		 $this->display();
		 
		 
		 }	 
	 function xianshi(){
		
		$this->display();
		
		}
	
		 		  
	 function xianshiAjax(){
		 
		 $showway=isset($_POST['showway'])&&is_numeric($_POST['showway'])?$_POST['showway']:1;
		 
		 if($showway==1){
			 $where="(`start_time`<".time()." and ".time()."<end_time) and `state`=1";
			 }elseif($showway==2){				 
			 $where="(".time()."<`start_time`) and `state`=1";	 
				 }
		 
		 $xianshi=M('p_xianshi');
		 
		 $goods=$xianshi->where($where)->order("`xianshi_id` desc")->limit(10)->select();
		 
		 if($goods){
			
			$xianshigoods=M("p_xianshi_goods"); 
			$info=array();
			foreach($goods as $value){				
			$discount=$xianshigoods->field("min(xianshi_price/goods_price) as zhe")->where("xianshi_id=".$value['xianshi_id'])->find();			
			$value['zhe']=$discount['zhe']*10;		
			$info[]=$value;
					}			 
			 }		 
		 echo json_encode($info);
	 
		 }   
		 
	 //个人中心地址
	 public function address(){
		 
		  $this->display();
	 
		 }	 
     //收货地址添加		 
	 public function add_address(){
		 
		 $this->display();
		 }	
	 //编辑地址
	 public function address_edit(){		 
		 $this->display();
		 } 
	 //客户个人信息页面
	 public function myInfo(){
		 
		 $uid=$this->chacklogin();
		 
		 $member=M("member");
		 
		 $info=$member->where("member_id='$uid'")->find();
		 
		 $this->assign('info',$info);
		 
		 $this->display();
		 
		 }	 
	 //客户信息编辑页面
	 public function edit(){
		
		 $uid=$this->chacklogin();
		 
		 $member=M("member");
		 
		 $info=$member->where("member_id='$uid'")->find();
		 
		// print_r($info);
		 
		 $this->assign('info',$info); 		 
		
	     $this->display();	 
		 
		 }	 	  
	 //改变默认地址接口	 
	 public function changeaddress(){	
	    
		 if(!($this->chacklogin())){
			 $array=array();			 
			 $array['result']=0;			 
			 $array['login']=0;			 
			 echo json_encode($array);			 
			 exit();			 
			 }	 
		 $id=intval($_POST['id']);		 
		 $did=intval($_POST['did']);
		 $address=M("address");
		 $data['is_default']=0;
		 $datas['is_default']=1;
		 $result1=$address->where("address_id='$did'")->save($data);
		 $result2=$address->where("address_id='$id'")->save($datas);
		 if($result1&&$result2){
			$array=array();			 
			 $array['result']=1;			 
			 $array['login']=1;			 
			 echo json_encode($array);		 
			 }else{
			$array=array();			 
			 $array['result']=0;			 
			 $array['login']=0;			 
			 echo json_encode($array);	
				 }	 
		 
		 } 
	 //客户信息更改	  
	 public function infoupdate(){
		 if(is_uploaded_file($_FILES['member_avatar']['tmp_name'])){
			 
			 $filetype = $_FILES['member_avatar']['type']; 			 
			 $checktype=array('image/jpeg','image/jpg','image/pjpeg','image/gif');
			  if(in_array($checktype,$filetype)){
				   $this->error("图片不合法","edit");
				  }
			  $time=time();
			  $type=substr($_FILES["member_avatar"]["name"],-4);
			  $name=$time.$type;
		
			  //图片保存地址要修改
			  move_uploaded_file($_FILES['member_avatar']['tmp_name'],"../data/upload/shop/avatar/".$name);	  	 
			 }		
		   $data=array();
		   if(isset($name)) $data['member_avatar']=$name;
		   
		   if(isset($_POST['member_truename'])) $data['member_truename']=addslashes($_POST['member_truename']);
		   
		   if(isset($_POST['member_name'])) $data['member_name']=addslashes($_POST['member_name']);
		   
		   if(isset($_POST['member_sex'])) $data['member_sex']=addslashes($_POST['member_sex']);
		   
		   if(isset($_POST['member_birthday'])) $data['member_birthday']=addslashes($_POST['member_birthday']);	
		   	   
		   $member=M('member');
		   
		   $result=$member->where("member_id='".$this->chacklogin()."'")->save($data);
		   
		   if($result){
			   
			   $this->success('更新成功',"edit");
			   
			   }else{
				
				$this->success('更新失败',"edit");   
				   
				   }
 
		 }	
	 //密码修改
	 public function changepw(){
	   
	     $this->display();
		 }	  
	//密码修改
	public function changepwdapi(){
		
		$pwd=isset($_POST['pwd'])?addslashes($_POST['pwd']):'';
		$newpwd=isset($_POST['newpwd'])?addslashes($_POST['newpwd']):'';
		$repwd=isset($_POST['repwd'])?addslashes($_POST['repwd']):'';		
		$member=M('member');
		$info=$member->where("member_id='".$this->chacklogin()."'")->find();
		$result=array();
		if($info['member_passwd']!=md5($pwd)){
			$result['date']='密码错误';
			echo json_encode($result);
			exit;
			}
		if($repwd!=$newpwd){
			$result['date']='新密码不匹配';
			echo json_encode($result);
			exit;
			
			} 
		$data=array();
		$data['member_passwd']=md5($newpwd);
		$results=$member->where("member_id='".$this->chacklogin()."'")->save($data);
		if($results){
			$result['date']='更新成功';
			echo json_encode($result);
			exit;		
			}else{
			$result['date']='更新失败,新旧密码可能一致';
			echo json_encode($result);
			exit;					
				}	
		
		}
	  //系统消息
	  public function msg(){
  
		  $this->display();
		  
		  }
	  //消息api
	  public function msgapi(){	  
		  $message=M('message');
		  $memberid=$this->chacklogin();
		  $type=intval($_POST['type']);
		  $data=array();
		  if(!$memberid) {
			  $data['date']="您未登陆";
		      echo json_encode($data); 
			  exit();
		  }
		  $info=$message->where("to_member_id='$memberid' and message_type='$type'")->order("message_id desc")->limit(10)->select();
		  $data['date']=$info;
		  echo json_encode($data);		  
		  }
	  //物流信息	  
	  public function wuliu(){
		  
		  
		  $this->display();
		  
		  }	  
		  
	  public function wuliuapi(){
		  
		  //shopnc shopnc_express表 物流公司
		  
		  //$company=$_GET['company'];
		  
		 // $number=$_GET['number'];
		  
		 // $url="http://www.kuaidi100.com/query?type=$company&postid=$number";
		 
		 $this->display();
	  
		  }	  
	  //商品评价函数
	  public function message(){
		  
		  //$store=M("evaluate_store");
		  
		  //$orders=$store->where("seval_memberid='".$this->chacklogin()."'")->select();

		  $evaluate=M('evaluate_goods');
		  
		  $orders=$evaluate->where("geval_frommemberid='".$this->chacklogin()."'")->order("geval_id desc")->limit(10)->select();
		  
		  $pingjia=array();
		  
	     foreach($orders as $order){
			 
			 $order['geval_addtime']=date("Y-m-d i:h:s",$order['geval_addtime']);
			 
			 $pingjia[]=$order;
			 			 
			 }
		  
		  $this->assign('eval',$pingjia);
		  
		  //print_r($eval);
		  
		  $this->display();		  
		  
		  }	  
	  //按店铺限时闪购
	   public function xianshibystore(){
		   
		   $this->display();		   
		   } 
	  //闪购api
	 public function xianshiapi(){
		 
		 //xianshiapi.js 的api地址要修改
		 
		   $xianshiid=isset($_POST['xianshiid'])?intval($_POST['xianshiid']):7;
		  
		   $page=isset($_POST['page'])?intval($_POST['page']):1; 
		  
		   $size=isset($_POST['size'])?intval($_POST['size']):10; 
		    
		   $xianshigoods=M("p_xianshi_goods");
		   
		   $xianshi=M("p_xianshi");
		   
		   $goods=$xianshigoods->where("xianshi_id='$xianshiid' and state='1'")->order("xianshi_goods_id desc")->limit(($page-1)*$size,$size)->select();
		   
		   $xianshiinfo=$xianshi->where("xianshi_id='$xianshiid'")->find();
		   
		   $array=array();
		   
		   if($goods&&$xianshiinfo){	
		   		  
		   $array['result']=1;  
		    
		   $array['goods']=$goods;
		   
		   $array['info']=$xianshiinfo;
		   
		   }else{
		   
		   $array['result']=0;  

			   
			   }
			  // $arrays=array();
			//$arrays['result']=1;
		 echo json_encode($array);	   
		   
		 
		 }	   
	  //获取客户id	  
	  public function chacklogin(){		  
		 $token=$_COOKIE['key'];
		 $name=$_COOKIE['username'];
		 $mb_token=M('mb_user_token'); 
		 $result=$mb_token->where("member_name='$name' and token='$token'")->find();
		 if($result){
			 return $result['member_id'];
			// echo 11;
			 }else{
			 return false;	
			 //echo 00; 
				 }	  
		  }	 
	 	  
	public function pingjia(){
		
		$this->display();
		
		}
	public function pingjiapai(){
		
		$info=isset($_POST['info'])?$_POST['info']:array();
		echo $info;
		
		if($info){
			
			$info=json_decode($info);	
			
			$evaluategoods=M('evaluate_goods');	
				
			foreach($info as $value){	
					
				$data['geval_goodsimage']=$value['image'];
				
				$data['geval_storename']=$value['goods_name'];
				
				$evaluategoods->add($data);
								
				}	
								
			}	
			
		 //echo json_encode($info) ;		
				
		} 	
		
 /**
	 此方法用于手机登入
	**/	
	
	public function mobilelogin(){
		
		
		
		
		$this->display();
		
		
		}
	/*
	
	此方法用于验证输入手机号码是否有效，并且记录客户的输入次数，默认只给客户6次的输入机会
	*/
	
	public function checkmobile(){
		
		$ip=$this->getIPaddress();
		
		if(!isset($_POST['password'])){
			
			$result['code']=404;
			
			$result['content']="请输入登陆密码";
			
			echo json_encode($result);
			
			die();
			
			}
		if(strlen($_POST['password'])<6){
			
			$result['code']=404;
			
			$result['content']="请输入6位以上密码";
			
			echo json_encode($result);
			
			die();
			
			}	
		
		
		if(isset($_SESSION['customer_ip'])&&($_SESSION['customer_ip']==$ip)&&($_SESSION['logtime']>=30)&&(date("m.d")==date("m.d",$_SESSION['time']))){
			
			$result['code']=404;
			
			$result['content']="同个ip 一天只能登陆5次";
			
			echo json_encode($result);
			
			die();
			
			}
		
		$number=$_POST['mobile'];
		
		$result=array();
		
		if((!is_numeric($number))||(strlen($number)!=11)){
			
			$result['code']=404;
			
			$result['content']="你输入的手机号码不规范";
			
			echo json_encode($result);
			
			die();
			
			}
					
		 $code=rand(100000,999999);
		 	 
		 $url="http://106.ihuyi.cn/webservice/sms.php?method=Submit&account=cf_chahuitong&password=chahuitong2015&mobile=$number&content=您的验证码是：【".$code."】。请不要把验证码泄露给其他人。";
		 
		 $results=file_get_contents($url);
		 
		  $xml=simplexml_load_string($results);
		 
		 if($xml->code==2){
			 
			$result['code']=200;
			
			$result['content']="短信发送成功，请在10分钟内填入";
			
			$_SESSION['time']=time();
			
			$_SESSION['customer_ip']=$ip;
		    
		    $_SESSION['mobilecode']=$code;
			
			$_SESSION['mobilenumber']=$number;
			
			$_SESSION['logtime']=isset($_SESSION['logtime'])?($_SESSION['logtime']+1):1;
			 		 
			 }else{
			
			$result['code']=500;
			
			$result['content']="发送失败，失败代码：{$xml->code}";	 
				 
				 }		
				
      echo  json_encode($result);		
		}
		
  /*客户手机登陆*/
  
    public function loginbymobile(){
	  
	  $array=array();
	  
	  if(!isset($_POST['password'])){
			
			$result['code']=404;
			
			$result['content']="请输入登陆密码";
			
			echo json_encode($result);
			
			die();
			
			}
		if(strlen($_POST['password'])<6){
			
			$result['code']=404;
			
			$result['content']="请输入6位以上密码";
			
			echo json_encode($result);
			
			die();
			
			}	
	  
	   if(time()>($_SESSION['time']+600)){		   
		   unset($_SESSION['mobilecode']);
		   unset($_SESSION['time']);
		   unset($_SESSION['mobilenumber']);	 
		   unset($_SESSION['customer_ip']);
		   $array['code']=404;
		   $array['content']="您已超过10分钟，请再次登陆";	   
		   echo json_encode($array);		   
		   die();
		    
		   }
		if($_POST['code']==$_SESSION['mobilecode']){
			
			/*$str="abcdefghijklmnopqrstuvwxyz123456789";
			
			$password="";
			
			for($i=0;$i<(strlen($str)-1);$i++){
				
			$time=rand(0,(strlen($str)-1));	
				
			$password.=$str[$time];					
				}*/
			
			$password=trim($_POST['password']);	
				
			$member=M("member");
			
			$row=$member->where("member_name={$_SESSION['mobilenumber']} and member_mobile={$_SESSION['mobilenumber']}")->find();
			
			$data=array();
			
			if($row){
				
				$data['member_passwd']=md5($password);
				$data['member_time']=time();
				$data['member_login_time']=$row['member_time'];
				$data['member_login_ip']=$this->getIPaddress();
				$data['member_old_login_ip']=$row['member_login_ip'];
				
				$member->where("member_id='{$row['member_id']}'")->save($data);
				
				
				}else{
				$data['member_passwd']=md5($password);
				$data['member_name']=$_SESSION['mobilenumber'];	
				$data['member_mobile']=$_SESSION['mobilenumber'];
				$data['member_time']=time();
				$data['member_login_time']=time();
				$data['member_login_ip']=$_SESSION['customer_ip'];
				$data['member_old_login_ip']=$_SESSION['customer_ip'];
				
				$member->add($data);	
					}
			$post_data=array("username"=>$_SESSION['mobilenumber'],"password"=>$password,"client"=>"wap");
			$url="http://www.chahuitong.com/mobile/index.php?act=login";		
			$ch=curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);		   
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);	  
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			$output=curl_exec($ch);	
			curl_close($ch);
			$return=json_decode($output,true);
			
			if(isset($return['datas']['key'])){
				
			   setcookie("username",$return['datas']['username'],time()+3600,'/');		
	        	setcookie("key",$return['datas']['key'],time()+3600,'/');			   
		       $array['code']=200;
			   
			   $array['content']="登陆成功";
			   
			   echo json_encode($array);
				
				}else{
					
				 $array['code']=404;
		        $array['content']="系统错误，敬请联系我们";	   
		        echo json_encode($array);		
				 //echo $output;   
		        die();
					}
						
			}else{
				
			    $array['code']=404;
		        $array['content']="验证码不正确";	   
		        echo json_encode($array);		   
		        //die();					
				}     
	  
	  }	
	  
   public	function getIPaddress(){
       $IPaddress='';
       if (isset($_SERVER)){
         if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $IPaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $IPaddress = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $IPaddress = $_SERVER["REMOTE_ADDR"];
        }
       } else {
       if (getenv("HTTP_X_FORWARDED_FOR")){
          $IPaddress = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $IPaddress = getenv("HTTP_CLIENT_IP");
        } else {
          $IPaddress = getenv("REMOTE_ADDR");
        }
    }

    return $IPaddress;

    }	
	
    /*
   用于新浪微博绑定，登陆

    */	
    public function sinalogin(){
 	 
	 // print_r($_SESSION);
	 //unset($_SESSION['slast_key']);
	 
	 if(!isset($_SESSION['slast_key'])){
		 
		$this->error("请先登陆微博","login"); 
		 }
	
	$sinaopenid=$_SESSION['slast_key']['access_token'];
	
	$member=M('member');
	
	$info=$member->where("member_sinaopenid='$sinaopenid'")->find(); 
	
	if($info){
		
		$post_data=array("sinaopenid"=>$sinaopenid,"client"=>"wap");
		
	   $loginurl="http://www.chahuitong.com/mobile/index.php?act=login";	

		
		     $ch=curl_init();
		
            curl_setopt($ch, CURLOPT_URL, $loginurl);	
	   
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	  
	        curl_setopt($ch, CURLOPT_POST, 1);
	   
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	   
	        $output = curl_exec($ch);
	      
	         curl_close($ch); 
		
		 $array=json_decode($output,true);
	   
	   if(isset($array['datas']['key'])){
		
		setcookie("username",$array['datas']['username'],time()+3600,'/');
		
		setcookie("key",$array['datas']['key'],time()+3600,'/');
		
		header("Location:http://www.chahuitong.com/wap/index.php/Home/Index/member");
		
	       }else{
			   
		$this->error("授权失败","login");	   
			   
			   }
		
		
		}else{
			
		$url="https://api.weibo.com/2/users/show.json?access_token={$_SESSION['slast_key']['access_token']}&uid={$_SESSION['slast_key']['uid']}";
		
	   $userJson=file_get_contents($url);
	   
	   $_SESSION['sina_user']=json_decode($userJson,true);	
	   
	   //print_r($userArray);
	    $randnumber=rand(100,999);
	   $this->assign("name",$_SESSION['sina_user']['name']);
	   $this->assign("number",$randnumber);
	   
	   $this->display();	
			
			
		}
			 
	 
	 }
/*sina 绑定账号*/	 

public function sinabind(){
	
	  $array=array();
			
	  if(!isset($_SESSION['slast_key'])){
		  	  $array["code"]="404";
			  $array["content"]="请先登陆QQ";
			  echo json_encode($array);
			  die();
		  }	
	  /*测试*/	  
/*	  
	  $array['code']="404";
	  
	  $array['content']="测试数据";
 
      echo json_encode($array);
	  
	  die();		  	  
*/	 
     //检测用户名
	  if($_POST['username']==""){
	
	   $array['code']='404';
	   
	   $array['content']="用户名不能为空";	  
	   
	   echo json_encode($array);
	   
	   die();
		  
		  }	  
	  //检测用户名是否呗注册
	  $member=M("Member");
	  
	  $username=$_POST['username'];
	  
	  $isuserd=$member->where("member_name='$username'")->find();
	  
	  if($isuserd){
		  
	  	  $array['code']="404";
		  
		  $array['content']='用户名已经被注册';
		  
		  echo json_encode($array);
		  
		  die();
		 	  
		  }
		  
		  
		  
		 
	   if($_POST['bindway']=='logindir'){
		   
		   $str="asdfghjklqwertyuiopzxcvbnm1234567890";
		 
		   $randpassword="";
		 
		   for($i=0;$i<6;$i++){
		
		   $randpassword.=$str[rand(0,30)];	 
		   
		      }
			  
		   $password=$randpassword;	  
		   		   
		   } 	
		   
		 if($_POST['bindway']=='register'){
			 
			 
			 $password=trim($_POST['password']);
			 			 
			 }    
	  
	    $username=trim($_POST['username']);
		 
		 $info=array();
		 
		 $info['member_name']=$username;	 
		 
		 $info['member_avatar']="sina.jpg";	
		 
		 $info['member_passwd']=md5($password);
		 
		 $info['member_time']=time();
		 
		 $info['member_mobile']=isset($_POST['member_mobile'])? trim($_POST['member_mobile']):"";
		 
		 $info['member_login_time']=time();
		 
		 $info['member_sinaopenid']=$_SESSION['slast_key']['access_token'];
		 
		 $info['member_sinainfo']=serialize($_SESSION['sina_user']);
		 
		 $info['member_login_ip']=$this->getIPaddress();
		 
		 $addresult=$member->add($info);
		 
		 		  	  
		 
		 if($addresult){
			 
		    $loginurl="http://www.chahuitong.com/mobile/index.php?act=login";	
			
	        $post_data=array("username"=>$username,"password"=>$password,"client"=>"wap");	
			
			 $ch=curl_init();
		   
		    curl_setopt($ch, CURLOPT_URL, $loginurl);	
	   
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	  
	        curl_setopt($ch, CURLOPT_POST, 1);
	   
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	   
	        $output = curl_exec($ch);
	      
	         curl_close($ch); 

		     $outputArray=json_decode($output,true);
		   
		   if(isset($outputArray['datas']['key'])){
			   
			  /*发送系统消息给客户*/ 		 
		        $message=M("message");
		 
		        $mes=array();
		 
	        	 $mes['to_member_id']=$addresult;
		 
	        	 $mes['message_body']="感谢您的惠顾，您的初始密码是：$randpassword";
		 
		        $mes['message_time']=time();
		 
		        $mes['message_update_time']=time();
		 
		        $mes['message_type']=1;
		 
		        $message->add($mes);
			   
			    $array['code']="200";
				
			   
			    $array['content']="登录成功";
				
				  setcookie("username",$outputArray['datas']['username'],time()+3600,'/');
		
		         setcookie("key",$outputArray['datas']['key'],time()+3600,'/');

			   
			   echo json_encode($array);
			   
			   }else{
				   
				$array['code']="404";
				
				$array['content']="系统错误$password";   
				   
				 echo json_encode($array);  
				   
				   
				   }		 
			 
			 
			 }else{
				 
			$array['code']=404;
			
			$array['content']="写入数据失败";
			
			echo json_encode($array);
			
			die();	 
				 			 
				 
				 }
	
	
	} 


	 
/*qq登陆页面*/

public  function qqlogin(){
		  	
	  if(!isset($_SESSION['access_token'])||!isset($_SESSION['openid'])){
		  	  $this->error("请您先登陆QQ","login");
		  }

		/*判断客户是否登陆过*/  
		 
		$openid=$_SESSION['openid'];
		
		$member=M("member");
		
		$isregisted=$member->where("member_qqopenid='$openid'")->find();
		  
		if($isregisted){			
		$loginurl="http://www.chahuitong.com/mobile/index.php?act=login";	
			 
	    $post_data=array("member_qqopenid"=>$openid,"client"=>"wap");	
	   
	    $ch = curl_init();	
	   
	   curl_setopt($ch, CURLOPT_URL, $loginurl);	
	   
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	  
	   curl_setopt($ch, CURLOPT_POST, 1);
	   
       curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	   
	   $output = curl_exec($ch);
	      
	    curl_close($ch); 
		
		//echo $output;
		
	   $array=json_decode($output,true);
	   
	   if(isset($array['datas']['key'])){
		
		setcookie("username",$array['datas']['username'],time()+3600,'/');
		
		setcookie("key",$array['datas']['key'],time()+3600,'/');
		
		header("Location:http://www.chahuitong.com/wap/index.php/Home/Index/member");	
		
		}
			
			
			}else{  
		  	 
	  $url="https://graph.qq.com/user/get_user_info?access_token={$_SESSION['access_token']}&openid={$_SESSION['openid']}&appid={$_SESSION['appid']}";
	
	  $userinfoJson=file_get_contents($url);
	
	  $_SESSION['userinfo']=json_decode($userinfoJson,true);
	  
	  $randnumber=rand(100,999);
	  
	 // print_r($userinfo);
	 
	 $this->assign("randnumber",$randnumber);
	 
	  $this->assign("userinfo",$_SESSION['userinfo']);
	 
	  $this->display();
	 
	 
			}
	
	}	
	
// qq账号第一次登陆绑定用户名密码

public function qqbind(){
	
		
	  if(!isset($_SESSION['access_token'])||!isset($_SESSION['openid'])){
		  	  $this->error("请您先登陆QQ","login");
		  }	
	 if(isset($_POST['bindway'])&&($_POST['bindway']=='register')){
		
		 $data=array();
		 //检测用户名密码是否设置
         if(!isset($_POST['username'])||!isset($_POST['password'])){
			 
			 $data['code']=404;
			 
			 $data['content']="用户名或密码为空";
			 
			 echo json_encode($data);
			 
			 die();
			 
			 }
		 //检测用户名是否已经被注册，虽然概率低，还是检测下
		 $member=M("member");
		 
		 $isregistered=$member->where("member_name='{$_POST['username']}'")->find();
		 
		 if($isregistered){
			 
			 $data['code']=404;
			 
			 $data['content']="用户名已经被注册了";
			 
			 echo json_encode($data);
			 
			 die();
			 
			 
			 }
		 //现在数据都是有效的
		 
		 $info=array();
		 
		 $info['member_name']=trim($_POST['username']);	 
		 
		 $info['member_avatar']="qq.jpg";	
		 
		 $info['member_passwd']=md5(trim($_POST['password']));
		 
		 $info['member_time']=time();
		 
		 $info['member_login_time']=time();
		 
		 $info['member_qqopenid']=$_SESSION['openid'];
		 
		 $info['member_qqinfo']=serialize($_SESSION['userinfo']);
		 
		 $info['member_login_ip']=$this->getIPaddress();
		 
		 $addresult=$member->add($info);
		 
		 //检测写入结果
		 
		 if($addresult){
			 	 
		 //curl post 数据到 api接口
	     $url="http://www.chahuitong.com/mobile/index.php?act=login";
		
	     $post_data=array("member_qqopenid"=>$_SESSION['openid'],"client"=>"wap");	
	   
	     $ch = curl_init();	
	   
	      curl_setopt($ch, CURLOPT_URL, $url);	
	   
	      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	  
	      curl_setopt($ch, CURLOPT_POST, 1);
	   
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	   
	      $output = curl_exec($ch);

	      curl_close($ch); 
		  
		   $array=json_decode($output,true);
	   
	      if(isset($array['datas']['key'])){
			  
		    $data['code']=200;
		 
		    $data['content']="绑定成功";	  
		
		   setcookie("username",$array['datas']['username'],time()+3600,'/');
		
		   setcookie("key",$array['datas']['key'],time()+3600,'/');
		
		   	echo json_encode($data);
			
			//header("Location:http://www.chahuitong.com/wap/index.php/Home/Index/member");	
			 
		
		   }else{
			  
			 $data['code']=404;
		 
		    $data['content']="系统处理失败，请重新尝试";	
			
			echo json_encode($data);    
			   
			   
			   }
		 
		 
			 }else{
				 
		 $data['code']=404;
		 
		 $data['content']="绑定失败";
		 
		 echo json_encode($data);			 
				
				 }
		  	 
		
		}
		//客户直接登陆处理方式	
		if(isset($_POST['bindway'])&&($_POST['bindway']=='logindir')){
		
		  $data=array();
		 //检测用户名密码是否设置
         if(!isset($_POST['username'])){
			 
			 $data['code']=404;
			 
			 $data['content']="用户名不能为空";
			 
			 echo json_encode($data);
			 
			 die();
			 
			 }
		 //检测用户名是否已经被注册，虽然概率低，还是检测下
		 $member=M("member");
		 
		 $isregistered=$member->where("member_name='{$_POST['username']}'")->find();
		 
		 if($isregistered){
			 
			 $data['code']=404;
			 
			 $data['content']="用户名已经被注册了";
			 
			 echo json_encode($data);
			 
			 die();
			 
			 
			 }	
						
	       $str="asdfghjklqwertyuiopzxcvbnm1234567890";
		 
		   $randpassword="";
		 
		   for($i=0;$i<6;$i++){
		
		   $randpassword.=$str[rand(0,30)];	 
			 			 
			 }
		
		 $info=array();
		 
		 $info['member_name']=trim($_POST['username']);	 
		 
		 $info['member_avatar']="qq.jpg";	
		 
		 $info['member_passwd']=md5($randpassword);
		 
		 $info['member_time']=time();
		 
		 $info['member_login_time']=time();
		 
		 $info['member_qqopenid']=$_SESSION['openid'];
		 
		 $info['member_qqinfo']=serialize($_SESSION['userinfo']);
		 
		 $info['member_login_ip']=$this->getIPaddress();
		 
		 $addresult=$member->add($info);
		 
		 //检测写入结果
		 
		 if($addresult){
			 
		 $data['code']=200;
		 
		 $data['content']="绑定成功";
		 
		 //写入系统消息，告知客户密码
		 
		 $message=M("message");
		 
		 $mes=array();
		 
		 $mes['to_member_id']=$addresult;
		 
		 $mes['message_body']="感谢您的惠顾，您的初始密码是：$randpassword";
		 
		 $mes['message_time']=time();
		 
		 $mes['message_update_time']=time();
		 
		 $mes['message_type']=1;
		 
		 $message->add($mes);
		 
		 /*curl 提交给api接口*/
		 
		  $url="http://www.chahuitong.com/mobile/index.php?act=login";
		
	     $post_data=array("member_qqopenid"=>$_SESSION['openid'],"client"=>"wap");	
	   
	     $ch = curl_init();	
	   
	      curl_setopt($ch, CURLOPT_URL, $url);	
	   
	      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	  
	      curl_setopt($ch, CURLOPT_POST, 1);
	   
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	   
	      $output = curl_exec($ch);

	      curl_close($ch); 
		  
		   $array=json_decode($output,true);
	   
	      if(isset($array['datas']['key'])){
			  
		    $data['code']=200;
		 
		    $data['content']="绑定成功";	  
		
		   setcookie("username",$array['datas']['username'],time()+3600,'/');
		
		   setcookie("key",$array['datas']['key'],time()+3600,'/');
		   
		  // header("Location:http://www.chahuitong.com/wap/index.php/Home/Index/member");	
		
		
		   	 echo json_encode($data);	 
		
		   }else{
			  
			 $data['code']=404;
		 
		    $data['content']="系统处理失败，请重新尝试";	
			
			echo json_encode($data);    
			   
			   
			   }
		 
		 /*curl*/
		 			 
			 }else{
				 
		 $data['code']=404;
		 
		 $data['content']="绑定失败";
		 
		 echo json_encode($data);			 
				
				 }
		
			}	
	
	
	}	 
	
	function fav(){
		
		$bid=isset($_POST['bid'])?intval($_POST['bid']):1;
		
		$type=isset($_POST['type'])?addslashes($_POST['type']):"goods";
				
		$key=$_COOKIE['key'];
		
		$username=$_COOKIE['username'];
		
		$array=array();
		
		if(empty($key)||empty($username)){	
				
			$array['code']=404;
						
			$array['content']="还未登陆";	
			
			echo json_encode($array);
			
			exit();
			
					
			}
		
		
		$favorites=M("favorites");
		
		//用户id
		
		$token=M("mb_user_token");
		
		$userid=$token->field("member_id")->where("`member_name`='$username' and `token`='$key'")->find();
		
		
		$data=array();
		
		$data['fav_id']=$bid;
		
		$data['fav_type']=$type;
		
		$data['member_id']=$userid['member_id'];
		
		$saved=$favorites->where($data)->find();
		
		if($saved){
			
		    $array['code']=404;
						
			$array['content']="已经收藏";	
			
			echo json_encode($array);
			
			exit();
			
			}
		
		$data['fav_time']=time();
		
		
		
		$result=$favorites->add($data);
		
		if($result){
			
			$array['code']=200;
						
			$array['content']="收藏成功";
			
			}else{
				
			$array['code']=404;
						
			$array['content']="收藏失败";	
								
				}
		echo json_encode($array);
			
		
		}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		 
	
}
