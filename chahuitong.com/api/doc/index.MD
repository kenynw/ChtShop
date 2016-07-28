# 茶汇通APP接口文档

### 规则

1.请求数据全部为JSON格式输出

2.获取方式主要为POST和GET（若为GET方式会在URL处标记）

3.POST方式提交Version字段将会获取到不同版本的接口格式

4.不同版本返回的数据结构不一样。
* v1.

  请求成功

      {
        code: 200 响应码，固定为200
        datas:  数据实体
      }
  
  请求失败

      {
        code: 200
        datas: {
          error: "失败描述"
        }
      }

* v2. 

  请求成功

      {
        code: 200 响应码，200时表示请求数据成功，404表示请求失败
        content: 数据实体
      }

  请求失败

      {
          code: 404 请求失败响应码
          content: 错误描述
      }
    
* v3.

  请求成功

      {
        code: 1 请求成功响应码
        msg:  结果描述
        data: 数据实体
      }
      
  请求失败

      {
        code: 0 请求失败响应码 
        msg: 错误详情描述
      }
      
      {
        code: -1 用户未登录响应码
        msg: "请登录"
      }

### URL规则
    BASE_URL:http://api.chahuitong.com
    
    例如登录接口为:http://api.chahuitong.com?act=login

### 注册
URL: act=login&op=register_api  

参数：

>mobile   
>password   
>verificode   
>label  
>client   

返回： 

      {
        code:  
      }

### 登录
URL：act=login   

参数：

>username 用户名  
>password 密码  
>client 客户端类型(android wap ios wechat)  

返回

      {
        code: 200
        datas: {
          username 用户名
          key 登录令牌
        }
      }

### 注销登录
URL：act=logout   

参数：

>mobile 手机号  
>client 客户端类型(android wap ios wechat)  

返回

      {
        code: 1
        data: '1'
        msg:'SUCCESS'
      }

### 第三方登录
URL: act=login&op=register_api  

参数：

>key  shopNC的MD5值，固定为『804451dc13014b1c785fb73b1617b760』     
>client   客户端类型，可选：android，ios，web   
>op   第三方类型，可选：sina,wechat,qq  
>openid   第三方授权返回的唯一标识,如微博登录的Uid，腾讯的openId

返回： 

      {
        code:  
      }

### 发送验证码
URL: act=login&op=send_sms  
参数：
>mobile  

返回： 

      {
        code:  
      }

### 首页
URL: ~~act=home&op=home_page_api~~	<已被act=home替换>
	
参数： 

>key    登录令牌,如果用户登录了会根据当前来获取特定的数据	
>page   猜你喜欢的页数

返回:

    {
        "code": 1,
        "msg": "查找成功",
        "data": {
            "is_login": true,
            "adds": [
                {
                    "id": "14",
                    "image": "http://www.chahuitong.com/data/upload/mobile/home/1458113957.jpg",
                    "state": "1",
                    "order": "1",
                    "link": "http://www.chahuitong.com/example/web/raiders.html#",
                    "location": "1"
                }
            ],
            "sample_image": "http://www.chahuitong.com/data/upload/mobile/home/1454378839_360.png",
            "xianshi": {
                "image": "http://www.chahuitong.com/data/upload/mobile/home/1454378839_360.png",
                "end_time": "1476220800"
            },
            "tasters_list": [
                {
                    "goods_id": "101758",
                    "goods_name": "大益 普洱茶8582 生茶 357g 买二送一",
                    "goods_image": "2_05060208241996128.png",
                    "goods_price": "480.00",
                    "goods_promotion_price": "480.00",
                    "goods_marketprice": "480.00",
                    "goods_promotion_type": "0",
                    "store_id": "2",
                    "recommend_score": "9",
                    "recommend_taste": "回甘快",
                    "recommend_light": "金黄",
                    "recommend_aroma": "纯正",
                    "recommend_leaf": "柔匀",
                    "goods_image_url": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05060208241996128_360.png"
                }
            ],
            "guess_list": [
                {
                    "goods_id": "101403",
                    "goods_name": "齐云春 极品特级 藤茶礼盒装 84g",
                    "goods_image": "2_05062071097871226.png",
                    "goods_price": "534.00",
                    "goods_promotion_price": "534.00",
                    "goods_marketprice": "668.00",
                    "goods_promotion_type": "0",
                    "store_id": "2",
                    "goods_image_url": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05062071097871226_360.png"
                }
            ]
        }
    }
    
### 首页
URL: act=home
	
参数： 

>key    登录令牌,根据浏览记录获取猜你喜欢商品列表

返回:

    {
    "code": 1,
    "data": {
        "adds": [
            {
                "id": "14",
                "image": "http://www.chahuitong.com/data/upload/mobile/home/1458113957.jpg",
                "state": "1",
                "order": "1",
                "link": "http://www.chahuitong.com/example/web/raiders.html#",
                "location": "1"
            }
        ],
        "sample_image": "http://www.chahuitong.com/data/upload/shop/common/default_goods_image_240.gif",
        "xianshi": {
            "end_time": "1548812800",
            "goods_image_url": "http://www.chahuitong.com/data/upload/shop/common/default_goods_image_240.gif"
        },
        "tasters_list": [
            {
                "goods_id": "101758",
                "goods_name": "大益 普洱茶8582 生茶 357g 买二送一",
                "goods_image": "2_05060208241996128.png",
                "goods_price": "480.00",
                "goods_promotion_price": "480.00",
                "goods_marketprice": "480.00",
                "goods_promotion_type": "0",
                "store_id": "2",
                "recommend_score": "9",
                "recommend_taste": "回甘快",
                "recommend_light": "金黄",
                "recommend_aroma": "纯正",
                "recommend_leaf": "柔匀",
                "goods_image_url": "http://www.chahuitong.com/data/upload/shop/common/default_goods_image_360.gif"
            }
        ],
        "guess_list": [
            {
                "goods_id": "101724",
                "goods_commonid": "101009",
                "store_id": "2",
                "goods_name": "云源号 普洱生茶2011年乔木早春官正宗品包邮云南布朗茶叶380g",
                "goods_price": "188.00",
                "goods_marketprice": "315.00",
                "goods_image": "2_05034182403801496.jpg",
                "goods_salenum": "0",
                "evaluation_good_star": "5",
                "evaluation_count": "0",
                "goods_image_url": "http://www.chahuitong.com/data/upload/shop/common/default_goods_image_360.gif",
                "origin": "云南"
            }
        ]
    },
    "msg": "SUCCESS"
}


### 商品列表
URL(Get): act=goods&op=goods_list

参数：

>version 版本号	
>key 排序方式 1-销量 2-浏览量 3-价格 空-按最新发布排序	
>order 排序方式 1-升序 2-降序	
>page 每页数量	
>curPage 当前页码	
>gc_id 分类编号	
>keyword 搜索关键字 注：gc_id和keyword二选一不能同时出现	

返回：

    {
        "code": 1,
        "data": {
            "list": [
                {
                    "goods_id": "102064",
                    "goods_name": "倚澜岩 武夷山岩茶 虎肉 两盒装 250g",
                    "goods_price": "300.00",
                    "goods_marketprice": "399.00",
                    "goods_image": "2_05102418687282446.jpg",
                    "goods_salenum": "0",
                    "evaluation_good_star": "5",
                    "evaluation_count": "0",
                    "is_virtual": "0",
                    "is_presell": "0",
                    "is_fcode": "0",
                    "have_gift": "0",
                    "group_flag": false,
                    "xianshi_flag": false,
                    "goods_image_url": "http://www.chahuitong.com/data/upload/shop/common/default_goods_image_360.gif"
                }
            ],
            "hasmore": true,
            "page_total": 145
        },
        "msg": "SUCCESS"
    }

### 商品详情
URL(Get): act=goods&op=goods_detail 

参数：

>goods_id 商品编号    
>version 接口版本号 大于等于3-返回3.0版本数据结构 其他-旧版数据

返回： 

    V3.0:
    
    {
        "code": 1,
        "data": {
            "goods_info": {
                "goods_name": "芳津茶业  蜂窝玲珑茶具套装（四色可选） 红色",
                "goods_jingle": "",
                "gc_id_1": "662",
                "gc_id_2": "663",
                "gc_id_3": "0",
                "store_id": "2",
                "spec_value": [
                    {
                        "spec_name": "颜色",
                        "spec_value": [
                            {
                                "spec_value_text": "白色",
                                "goods_id": "101699"
                            },
                            {
                                "spec_value_text": "花色",
                                "goods_id": "101700"
                            },
                            {
                                "spec_value_text": "红色",
                                "goods_id": "101701"
                            },
                            {
                                "spec_value_text": "蓝色",
                                "goods_id": "101702"
                            }
                        ]
                    }
                ],
                "goods_attr": [
                    {
                        "attr_name": "产地",
                        "attr_value": "福建"
                    },
                    {
                        "attr_name": "颜色",
                        "attr_value": "不限"
                    }
                ],
                "mobile_body": "",
                "goods_specname": "",
                "goods_price": "200.00",
                "goods_marketprice": "200.00",
                "goods_costprice": "0.00",
                "goods_discount": "100",
                "goods_serial": "",
                "goods_storage_alarm": "0",
                "transport_id": "0",
                "transport_title": "",
                "goods_freight": "0.00",
                "goods_vat": "0",
                "areaid_1": "13",
                "areaid_2": "204",
                "goods_stcids": "",
                "plateid_top": "0",
                "plateid_bottom": "0",
                "is_virtual": "0",
                "virtual_indate": "0",
                "virtual_limit": "0",
                "virtual_invalid_refund": "0",
                "is_fcode": "0",
                "is_appoint": "0",
                "appoint_satedate": "0",
                "is_presell": "0",
                "presell_deliverdate": "0",
                "is_own_shop": "1",
                "goods_id": "101701",
                "goods_promotion_price": "95.00",
                "goods_promotion_type": "2",
                "goods_click": 49,
                "goods_salenum": "0",
                "goods_collect": "0",
                "goods_spec": "红色",
                "goods_storage": "200",
                "color_id": "0",
                "evaluation_good_star": "5",
                "evaluation_count": "0",
                "have_gift": "0",
                "is_goods_sample": "0",
                "groupbuy_info": null,
                "promotion_type": "xianshi",
                "title": "年终大促限时抢购",
                "remark": "年终大促限时抢购",
                "promotion_price": "95.00",
                "down_price": "105.00",
                "lower_limit": "1",
                "goods_url": "http://www.chahuitong.com/shop/index.php?act=goods&op=index&goods_id=101701"
                "is_favorite": false
            },
            "spec_image": [
                "http://www.chahuitong.com/data/upload/shop/common/default_goods_image_60.gif"
            ],
            "mansong_info": null,
            "gift_array": [],
            "goods_image": "http://www.chahuitong.com/data/upload/shop/common/default_goods_image_360.gif,http://www.chahuitong.com/data/upload/shop/common/default_goods_image_360.gif,http://www.chahuitong.com/data/upload/shop/common/default_goods_image_360.gif,http://www.chahuitong.com/data/upload/shop/common/default_goods_image_360.gif"
        },
        "msg": "SUCCESS"
    }

    其他:
    
    {
      code: 200,
      datas {
        goods_info 商品信息
          goods_name 商品名称
          goods_jingle 商品说明
          spec_name 规格名称
          spec_value 规格名
          goods_price 商品价格
          goods_marketprice 商品市场价
          goods_id 商品编号
          goods_click 商品点击数
          goods_commentnum 商品评论数
          goods_salenum 商品销量
          goods_spec 商品规格
          goods_storage 商品库存
          evaluation_good_star 评价等级
          evaluation_count 评价数
          promotion_type 促销类型 groupbuy-抢购 xianshi-限时折扣
          promotion_price 促销价格
          upper_limit 最多购买数
          is_virtual 是否为虚拟商品 1-是 0-否
          virtual_indate 虚拟商品有效期
          virtual_limit 虚拟商品购买上限
          is_fcode 是否为F码商品 1-是 0-否
          is_appoint 是否是预约商品 1-是 0-否
          is_presell 是否是预售商品 1-是 0-否
          have_gift 是否拥有赠品 1-是 0-否
        spec_list 规格列表
        gift_array 赠品数组
        spec_image 规格图片
        goods_image 商品图片
        goods_commend_list 推荐商品列表
        mansong_info 满即送信息
          mansong_name 活动名称
          start_time 开始时间
          end_time 结束时间
          price 活动金额
          discount 减现金
          mansong_goods_name 赠送商品名称
          goods_id 赠送商品编号
          goods_image_url 赠送商品图片地址
      }
    }

### 商品介绍信息
URL(Get): act=goods&op=goods_body 

参数：

>goods_id 商品编号    

返回： html

### 商品评论列表
URL(GET): act=goods&op=comments_list

参数：

>goods_id 商品编号    

返回： 

    {
        "code": 1,
        "data": {
            "list": [
                {
                    "geval_id": "1",
                    "geval_orderid": "36",
                    "geval_orderno": "7000000000003401",
                    "geval_ordergoodsid": "40",
                    "geval_goodsid": "101758",
                    "geval_goodsname": "高顶古茶 布朗·传家宝 380g",
                    "geval_goodsprice": "0.10",
                    "geval_goodsimage": "2_04879527997639713.jpg",
                    "geval_scores": "5",
                    "geval_content": "包装很精美，很高档的茶叶，味道很好，是正品",
                    "geval_isanonymous": "0", // 是否匿名 0-未匿名 1-匿名
                    "geval_addtime": "1435641129",
                    "geval_storeid": "2",
                    "geval_storename": "茶汇通商城",
                    "geval_frommemberid": "3", // 评论者的用户ID
                    "geval_frommembername": "test",
                    "geval_state": "0",
                    "geval_remark": null,
                    "geval_explain": null,
                    "geval_image": null,
                    "geval_frommemberavatar": "http://www.chahuitong.com/data/upload/shop/common/default_user_portrait.gif",
                    "add_time_text": "2015-06-30 13:12"
                }
            ],
            "hasmore": false,
            "page_total": 1
        },
        "msg": "SUCCESS"
    }

### 热搜词
URL: act=goods&op=hot_search

参数：

>无  

返回： 

    {
        "code": 1,
        "data": [
            "大益",
            "老班章",
            "源山古茶",
            "中茶",
            "古树茶"
        ],
        "msg": "SUCCESS"
    }

### 免费茶样往期
URL(Get): act=goods_sample&op=overdue_goods 

返回：

      {
        code:  
      }

### 免费茶样当前

URL： act=goods_sample<将会被act=group_buy&op=sample_info代替>

参数：

>key 登录令牌，用于判断当前用户是否领取过	

返回：

    {
        "code": 1,
        "data": {
            "sample_id": "36",
            "sample_name": "[免费茶样]婀娜公主 清香铁观音 浓香 油切黑乌龙 各一包7g*3",
            "sample_image": [
                {
                    "bmiddle_pic": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05071421284587390_360.jpg",
                    "original_pic": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05071421284587390_1280.jpg"
                },
                {
                    "bmiddle_pic": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05071421912242261_360.jpg",
                    "original_pic": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05071421912242261_1280.jpg"
                }
            ],
            "sample_origin_place": "福建",
            "sample_weight": "7",
            "sample_correlation_price": "0",
            "sample_freight": "0",
            "sample_limit_number": "10",
            "sample_add_time": "0",
            "sample_start_time": "1460390400",
            "sample_end_time": "1461830880",
            "sample_state": "1",
            "sample_received_number": "0",
            "sample_link": "101972",
            "sample_bak_price": "0",
            "sample_bak_promotion_price": "0",
            "store_id": "2",
            "goods_salenum": "3",
            "goods_storage": "7",
            "goods_state": "1",
            "goods_verify": "1",
            "allow": 1,
            "state_text": "申领"
        },
        "msg": "查询正常"
    }


### 免费茶样当前

URL： act=group_buy&op=sample_info   

参数：

>key 登录令牌，用于判断当前用户是否领取过	

返回：

    {
        "code": 1,
        "data": {
            "groupbuy_id": "18",
            "groupbuy_name": "免费茶样",
            "start_time": "1461654180",
            "end_time": "1461740580",
            "goods_id": "101972",
            "goods_commonid": "101101",
            "goods_name": "[免费茶样]婀娜公主 清香铁观音 浓香 油切黑乌龙 各一包7g*3",
            "store_id": "2",
            "store_name": "茶汇通商城",
            "goods_price": "0.10",
            "groupbuy_price": "0.01",
            "groupbuy_rebate": "1.00",
            "virtual_quantity": "1",
            "upper_limit": "1",
            "buyer_count": "2",
            "buy_quantity": "2",
            "groupbuy_intro": "",
            "state": "20",
            "recommended": "0",
            "views": "10",
            "class_id": "4",
            "s_class_id": "0",
            "groupbuy_image": "2_05149981604676766.jpg",
            "groupbuy_image1": "2_05149981672690476.jpg",
            "remark": "免费茶样",
            "is_vr": "0",
            "vr_city_id": null,
            "vr_area_id": null,
            "vr_mall_id": null,
            "vr_class_id": null,
            "vr_s_class_id": null,
            "button_text": "已领取",
            "goods_image_list": [
                {
                    "goods_image": "2_05071421284587390.jpg",
                    "goods_image_small": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05071421284587390_240.jpg",
                    "goods_image_mid": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05071421284587390_360.jpg"
                },
                {
                    "goods_image": "2_05071421912242261.jpg",
                    "goods_image_small": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05071421912242261_240.jpg",
                    "goods_image_mid": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05071421912242261_360.jpg"
                }
            ],
            "origin": ""
        },
        "msg": "SUCCESS"
    }


### ~~限时抢购今日~~<已被act=goods&op=current_list替换>
URL： act=flash_sale&op=current_api

参数：

>page 当前列表页数    

返回：

    {
      code: 
    }

### ~~限时抢购明日~~<已弃用>
URL： act=flash_sale&op=coming_api  
参数：

>page 当前列表页数 

返回：

    {
      code: 
    }

### 限时抢购今日
URL(GET)： act=goods&op=current_list
参数：

>curpage 当前列表页数
>page 每页默认数

返回：

    {
        "code": 1,
        "data": {
            "list": [
                {
                    "xianshi_goods_id": "156",
                    "xianshi_id": "21",
                    "goods_id": "101672",
                    "store_id": "2",
                    "xianshi_price": "99.00",
                    "goods_name": "可以兴 2014年盛世茶会 特级普洱茶生茶饼200g 云南勐海布朗山茶叶 买一送一",
                    "goods_image": "2_05041997917573703.gif",
                    "goods_price": "140.00",
                    "start_time": "1460995200",
                    "end_time": "1461168000",
                    "state": "1",
                    "xianshi_recommend": "1",
                    "goods_salenum": "0",
                    "goods_storage": "999",
                    "goods_image_url": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05041997917573703_360.gif"
                }
            ],
            "hasmore": false,
            "page_total": 1
        },
        "msg": "SUCCESS"
    }

### 茶艺师推荐列表

URL(GET): act=goods&op=recommend_list

参数：

>key 排序方式 1-销量 2-浏览量 3-价格 空-按最新发布排序	
>order 排序方式 1-升序 2-降序	
>page 每页数量	
>curPage 当前页码	
>gc_id 分类编号	

返回： 

    {
        "code": 1,
        "data": {
            "list": [
                {
                    "goods_id": "101758",
                    "goods_name": "大益 普洱茶8582 生茶 357g 买二送一",
                    "goods_image": "2_05060208241996128.png",
                    "goods_price": "480.00",
                    "goods_promotion_price": "480.00",
                    "goods_marketprice": "480.00",
                    "goods_promotion_type": "0",
                    "recommend_score": "9",
                    "recommend_taste": "回甘快",
                    "recommend_light": "金黄",
                    "recommend_aroma": "纯正",
                    "recommend_leaf": "柔匀",
                    "group_flag": false,
                    "xianshi_flag": false,
                    "goods_image_url": "http://www.chahuitong.com/data/upload/shop/common/default_goods_image_360.gif",
                    "origin": "云南"
                }
            ],
            "hasmore": true,
            "page_total": 4
        },
        "msg": "SUCCESS"
    }

### 忘记密码

URL: act=login&op=change_pwd  

参数：

>mobile 手机号码    
>verificode 验证码	
>newpwd 新密码    

返回： 

    {
      code: 1,
      msg: "更新成功"
    }

### 更改密码
URL: act=member_index&op=update_member_pwd  
参数：

>key  登录状态下才能操作    
>oldpwd 旧密码    
>newpwd 新密码    

返回： 

    {
      code: 1,
      msg: "更新成功"
    }

### 获取用户信息

URL: act=member_index 

参数：

>key  登录令牌    

返回： 

    {
        "code": 1,
        "data": {
            "member_name": "内测帐号",
            "member_avatar": "http://www.chahuitong.com/data/upload/shop/common/default_user_portrait.gif",
            "member_points": "176", //积分
            "available_predeposit": "0.00", //余额
            "member_exppoints": "3348", //经验值
            "member_title": "茶界泰斗", //头衔
            "order_new_count": "19", //待支付订单数
            "order_pay_count": "29", //待发货订单数
            "order_send_count": "1", //待收货订单数
            "order_eval_count": "0"  //待评价订单数
        },
        "msg": "SUCCESS"
    }

### 个人中心

URL: act=member_index 

参数：

>key  登录令牌    

返回： 

    {
      code: 1,
      msg: "获取成功",
      data: {
        member_name: 测试-廖培坤
        member_truename: 廖培坤
        member_avatar: http://www.chahuitong.com/data/upload/shop/common/default_user_portrait.gif
        member_birthday: 1991-06-11
        member_sex: 男
      }
      
    }

### 获取个人资料

URL: act=member_index&op=member_info 

参数：

>key  登录令牌    
>member_avatar      头像，图片的Base64  
>member_name        昵称 
>member_sex         性别 1-男， 2-女    
>member_birthday    出生年月   
>member_areainfo    所在地区 
>member_intro       个人简介 

返回： 

    {
        "code": 1,
        "msg": "获取成功",
        "data": {
            "member_name": "内测帐号",
            "member_avatar": "http://img.chahuitong.com/shop/common/default_user_portrait.gif",
            "member_birthday": "1991-06-11",
            "member_sex": "男",
            "member_areainfo": "福建厦门",
            "member_intro": "这是简介"
        }
    }

### 更改用户头像

URL: act=member_index&op=upload_avatar

参数：

>key    登录令牌    
>image  图片,File类型   

返回： 

    {
      code: 1,
      msg: "更新成功",
      data: true
    }

### 更改用户信息

URL: act=member_index&op=update_member_info 

参数：

##### 第一种方法POST各个字段 

>key  登录令牌    
>member_name        昵称 只支持中英文、数字、下划线   
>member_sex         性别 1-男， 2-女  传数字或者字符都行  
>city_id            市区ID    
>province_id        省份ID    
>area_info          位置文本信息 例:福建厦门    
>birthday           生日 格式为 yyyy-mm-dd   
>member_intro       个人简介 最大为140个字符 

##### 第二种方法用JSON格式

    {
        "member_name": "内测帐号",
        "member_sex": "男" // 1-男， 2-女  传数字或者字符都行  
        "member_cityid": "", 
        "member_province_id": "",
        "member_areainfo": "福建厦门",
        "member_birthday": "1991-06-11",
        "member_intro": "这是简介"
    }

返回： 

    {
      code: 1,
      msg: "更新成功",
      data: true
    }

### 购买第一步(获取订单信息)

URL: act=member_buy&op=buy_step1  

参数：

>key        登录令牌    
>cart_id    购买参数。立即购买： 第一个数字为商品编号，第二个数字为购买数量，用竖线分割。例：232|1；
            购物车购买：第一个数字为购物车编号，第二个数字为购买数量，用竖线分割。多组用半角逗号分割，例：232|1,110|2 232商品购买1个，110商品购买2个    
>ifcart     购物车购买标志 1    

返回： 

    {
      code: 200,
      datas: {
        ifcart 购物车购买标志 1
        store_cart_list 购物车列表 店铺编号为下标的数组
          goods_list 商品列表
            goods_num 购买数量
            goods_id 商品编号
            goods_commonid 商品通用编号
            store_id 店铺编号
            goods_name 商品名称
            goods_price 商品价格
            goods_image_url 商品图片
            transport_id 运费模板编号
            goods_freight 运费
            goods_storage 库存
            state 商品是否有效 true
            storage_state
            cart_id 购物车编号
            bl_id 组合销售编号
            promotions_id
            ifxianshi
            premiums 赠品标志 true
            goods_total 总价
          store_goods_total 店铺商品总价 店铺编号为下标的数组
          store_mansong_rule_list 满送规则列表 店铺编号为下标的数组
          store_vouche_list 店铺代金券列表 数组下标是voucher_t_id
          freight 0-免运费 1-需要计算运费
          freight_message 免运费时的说明
          store_name 店铺名称
        freight_hash 运费hash，选择地区时作为参数提交
        address_info 收货地址信息
        ifshow_offpay 支持货到付款时为true
        vat_hash 发票信息hash
        inv_info 发票信息
        available_predeposit 可用预存款
      }
    }

### 更换收货地址
URL: act=member_buy&op=change_address  
参数：

>key 登录令牌    
>freight_hash 运费hash，第一步返回结果里有直接提交    
>city_id 城市编号   
>area_id 地区编号   

返回： 

    {
      code: 200,
      datas: {
        content 运费列表，以店铺编号为下标数组，值为运费
        allow_offpay 是否允许货到付款 1-允许 0-不允许
        offpay_hash 货到付款hash
        offpay_hash_batch 店铺是否支持货到付款hash
      }
    }

### 购买第二步(生成订单)
URL: act=member_buy&op=buy_step2    
参数：

>key 登录令牌    
>ifcart 购物车购买标志 1   
>cart_id 购买参数    
>address_id 收货地址编号   
>vat_hash 发票信息hash，第一步接口提供   
>offpay_hash 是否支持货到付款hash，通过更换收货地址接口获得    
>offpay_hash_batch 店铺是否支持货到付款hash    
>pay_name 付款方式，可选值 online(线上付款) offline(货到付款)    
>invoice_id 发票信息编号   
>voucher 代金券，内容以竖线分割 voucher_t_id|store_id|voucher_price，多个店铺用逗号分割，例：10|2|10,1|3|10    
>pd_pay 是否使用预存款支付 1-使用 0-不使用   
>password 用户支付密码，启动预存款支付时需要提交   
>fcode F码购买时需提交   

返回： 

    {
      code: 200,
      datas: {
        pay_sn 支付编号
      }
    }

### 购物车列表
URL: act=member_cart&op=cart_list 
参数：

>key 登录令牌    

返回： 

    {
      code: 200,
      datas: {
        cart_list
        cart_id 购物车编号
        buyer_id 买家member_id
        store_id 店铺编号
        store_name 店铺名称
        goods_id 商品编号
        goods_name 商品名称
        goods_price 商品价格
        goods_num 购买数量
        goods_image_url 图片地址
        goods_sum 商品总价
        sum 购物车总价
      }
    }

### 购物车添加
URL: act=member_cart&op=cart_add  
参数：

>key 登录令牌    
>goods_id 商品编号
>quantity 购买数量

返回： 

    {
      code: 200,
      datas: "1"
    }

### 购物车删除
URL: act=member_cart&op=cart_del  
参数：

>key 登录令牌    
>cart_id 购物车编号   

返回： 

    {
      code: 200,
      datas: "1"
    }

### 购物车修改数量
URL: act=member_cart&op=cart_edit_quantity  
参数：

>key 登录令牌    
>cart_id 购物车编号   
>quantity 新的购买数量    

返回： 

    {
      code: 200,
      datas: {
        quantity 购买数量
        goods_price 商品价格
        total_price 商品总价
      }
    }

### 收藏列表
URL: act=member_favorites&op=favorites_list
参数：

>key 登录令牌    

返回： 

    "code": 1,
        "data": {
            "list": [
                {
                    "goods_id": "100747",
                    "goods_name": "醇一杯 2015年 福龙香（黄） 坦洋工夫红茶 400g",
                    "goods_price": "300.00",
                    "goods_image": "2_04878541545247904.jpg",
                    "store_id": "2",
                    "fav_id": "100747",
                    "goods_image_url": "http://www.chahuitong.com/data/upload/shop/common/default_goods_image_240.gif"
                }
            ],
            "hasmore": false,
            "page_total": 1
        },
        "msg": "SUCCESS"

### 收藏添加
URL: act=member_favorites&op=favorites_add
参数：

>key 登录令牌    
>goods_id 商品编号    

返回： 

    {
      code: 200,
      datas: "1"
    }

### 收藏删除
URL: act=member_favorites&op=favorites_del
参数：

>key 登录令牌    
>fav_id 收藏编号      

返回： 

    {
      code: 200,
      datas: "1"
    }

### 地址列表
URL: act=member_address&op=address_list
参数：

>key 登录令牌    

返回： 

    {
      code: 200,
      datas: {
        address_list: [
          {
            city_id 城市编号
            area_id 地区编号
            area_info 地址
            address 详细地址
            tel_phone 固定电话机
            mob_phone 手机
          },
        ]
      }
    }

### 地址详细信息
URL: act=member_address&op=address_info   

参数：

>key 登录令牌    
>address_id 地址编号    

返回： 

    {
      code: 200,
      datas: {
        area_info 地址
        address 详细地址
        tel_phone 固定电话机
        mob_phone 手机
      }
    }

### 地址删除
URL: act=member_address&op=address_del   

参数：

>key 登录令牌    
>address_id 地址编号    

返回： 

    {
      code: 200,
      datas: "1"
    }

### 地址添加
URL: act=member_address&op=address_add   

参数：

>key 登录令牌    
>true_name 姓名
>city_id 城市编号(地址联动的第二级)
>area_id 地区编号(地址联动的第三级)
>area_info 地区信息，例：天津 天津市 红桥区
>address 地址信息，例：水游城8层
>tel_phone 电话号码
>mob_phone 手机

返回： 

    {
      code: 200,
      datas: {
        address_id: "2" 新添加的地址ID
      }
    }

### 地址编辑
URL: act=member_address&op=address_edit   

参数：

>key 登录令牌    
>address_id 地址编号
>true_name 姓名
>area_id 地区编号
>city_id 城市编号
>area_info 地区信息，例：天津 天津市 红桥区
>address 地址信息，例：水游城8层
>tel_phone 电话号码
>mob_phone 手机

返回： 

    {
      code: 200,
      datas: "1"
    }

### 设置默认地址
URL: act=member_address&op=set_default   

参数：

>key 登录令牌    
>address_id 地址编号

返回： 

    {
      code: 1,
      data: 11,
      msg: 'SUCCeSS'
    }

### 地区列表
URL: act=member_address&op=area_list   

参数：

>key 当前登录令牌
>area_id 地区编号(为空时默认返回一级分类)

返回： 

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": {
            "list": [
                {
                    "area_id": "1",
                    "area_name": "北京"
                }
            ],
            "hasmore": false,
            "page_total": 0
        }
    }


### 订单列表
URL: act=member_order&op=order_list

参数：

>key 当前登录令牌
>version 版本号
>order_state 订单状态
>curpage 当前列表页,用GET方式
>page 每页显示项目数,默认15,用GET方式

返回：

    {
        "code": 1,
        "data": {
            "order_list": [
                {
                    "order_id": "1225",
                    "order_sn": "8000000000127701",
                    "pay_sn": "330513290162301164",
                    "store_id": "2",
                    "store_name": "茶汇通商城",
                    "buyer_id": "164",
                    "buyer_name": "内测帐号",
                    "buyer_email": "",
                    "add_time": "1459946162",
                    "payment_code": "online",
                    "payment_time": "0",
                    "finnshed_time": "0",
                    "goods_amount": "480.00",
                    "order_amount": "480.00",
                    "rcb_amount": "0.00",
                    "pd_amount": "0.00",
                    "shipping_fee": "0.00",
                    "evaluation_state": "0",
                    "order_state": "10",
                    "refund_state": "0",
                    "lock_state": "0",
                    "delete_state": "0",
                    "refund_amount": "0.00",
                    "delay_time": "0",
                    "order_from": "2",
                    "shipping_code": "",
                    "state_desc": "待付款",
                    "payment_name": "在线付款",
                    "extend_order_goods": [
                        {
                            "rec_id": "1440",
                            "order_id": "1225",
                            "goods_id": "101758",
                            "goods_name": "大益 普洱茶8582 生茶 357g 买二送一",
                            "goods_price": "480.00",
                            "goods_num": "1",
                            "goods_image": "2_05060208241996128.png",
                            "goods_pay_price": "480.00",
                            "store_id": "2",
                            "buyer_id": "164",
                            "goods_type": "1",
                            "promotions_id": "0",
                            "commis_rate": "0",
                            "gc_id": "1067",
                            "brand_id": "365",
                            "brand_name": "大益",
                            "goods_image_url": "http://www.chahuitong.com/data/upload/shop/common/default_goods_image_240.gif"
                        }
                    ],
                    "if_cancel": true, #是否显示取消按键
                    "if_receive": false, #是否显示确认收货
                    "if_lock": false, #是否显示锁定中
                    "if_deliver": false, #是否显示查看物流
                    "if_evaluation": false, #是否显示评价
                    "pay_amount": 480 #支付总额，该字段存在且大于0时显示支付按钮
                }
            ],
            "hasmore": true,
            "page_total": 49
        },
        "msg": "查找成功"
    }


### 34.订单详情
URL: act=member_order&op=order_info

参数：

>key 当前登录令牌
>order_id 订单ID

返回：

    {
        "code": 1,
        "data": {
            "order_id": "1349",
            "order_sn": "8000000000140101",
            "pay_sn": "190515012774555164",
            "store_id": "2",
            "store_name": "茶汇通商城",
            "buyer_id": "164",
            "buyer_name": "内测帐号",
            "buyer_email": "",
            "add_time": "1461668774",
            "payment_code": "alipay",
            "payment_time": "1461668799",
            "finnshed_time": "0",
            "goods_amount": "0.01",
            "order_amount": "0.01",
            "rcb_amount": "0.00",
            "pd_amount": "0.00",
            "shipping_fee": "0.00",
            "evaluation_state": "0",
            "order_state": "20",
            "refund_state": "0",
            "lock_state": "0",
            "delete_state": "0",
            "refund_amount": "0.00",
            "delay_time": "0",
            "order_from": "1",
            "shipping_code": "",
            "state_desc": "待发货",
            "payment_name": "支付宝",
            "address_info": {
                "phone": "15375870891",
                "mob_phone": "15375870891",
                "tel_phone": null,
                "address": "福建 厦门市 湖里区 高林社区190号",
                "area": "福建 厦门市 湖里区",
                "street": "高林社区190号"
            }
        },
        "msg": "SUCCESS"
    }
    
### 物流信息
URL: act=member_order&op=search_deliver

参数：

>key 当前登录令牌
>order_id 订单ID
>version

返回：

    {
        "code": 1,
        "data": {
            "express_name": "中通快递",
            "shipping_code": "778783716120",
            "deliver_info": [
                "2016-02-29 20:21:51  [广州新芳村] 广州新芳村 的 客户281 已收件 ",
                "2016-02-29 20:39:05  [广州新芳村] 快件在广州新芳村装车,正发往厦门",
                "2016-02-29 20:40:19  [广州新芳村] 快件在广州新芳村,正发往厦门",
                "2016-02-29 20:54:19  [广州新芳村] 快件在广州新芳村装车,正发往广州中心",
                "2016-02-29 23:38:53  [广州中心] 快件到达广州中心,上一站是广州新芳村目的地是",
                "2016-02-29 23:41:35  [广州中心] 快件在广州中心装车,正发往厦门",
                "2016-03-01 06:11:08  [广州中心] 粤BR8857在广州中心已发车，下一站厦门，",
                "2016-03-01 19:46:54  [厦门中转部] 粤BR8857已经到达厦门中转部",
                "2016-03-01 20:53:29  [厦门中转部] 快件在厦门中转部装车,正发往厦门思明九部",
                "2016-03-02 08:56:16  [厦门思明九部] 快件到达厦门思明九部,上一站是厦门中转部 目的地是",
                "2016-03-02 09:38:43  [厦门思明九部] 厦门思明九部的张正军正在派件",
                "2016-03-02 13:08:20  [厦门思明九部] 派件已 签收 ,签收人是拍照签收签收网点是厦门思明九部"
            ]
        },
        "msg": "SUCCESS"
    }

### 好友动态列表
URL: act=member_sns_trace&op=trace_list

参数：

>key 当前登录令牌

返回：

    {
        "code": 1,
        "data": {
            "list": [
                {
                    "trace_id": "15",
                    "trace_originalid": "0",
                    "trace_memberid": "2",
                    "trace_membername": "茶汇通",
                    "trace_memberavatar": "http://img.chahuitong.com/shop/common/default_user_portrait.gif",
                    "trace_title": "test test 茶汇通 茶汇通",
                    "trace_image": "http://img.chahuitong.com/shop/common/default_goods_image_240.gif"
                    "trace_addtime": "2016.05.25 09:00",
                    "trace_state": "0",
                    "trace_privacy": "0",
                    "trace_commentcount": "0"
                }
            ],
            "hasmore": false,
            "page_total": 1
        },
        "msg": "SUCCESS"
    }
    
### 动态详情

URL: act=member_sns_trace&op=trace_detail

参数：

>key 当前登录令牌     
>id 动态id    

返回：

    {
        "data": {
            "trace_orgcopycount": "0",
            "trace_commend_flag": "0",
            "trace_content": "",
            "trace_id": "18",
            "relation": 3,  //登录用户和主人关系 0表示未登录 1表示未关注 2表示互相关注 3表示自己 4表示已关注
            "trace_originalid": "0",
            "trace_originalmemberid": "0",
            "trace_image": "http://img.chahuitong.com/shop/member/164/164_05199450589333909_240.jpg,",
            "trace_image_list": [
                {
                    "ap_id": "19",
                    "ap_name": "164_05221729986739646.jpeg", 
                    "ac_id": "93",
                    "ap_cover": "164_05221729986739646.jpeg",
                    "thumb_mid": "http://www.chahuitong.com/data/upload/shop/common/default_goods_image_240.gif",
                    "thumb_max": "http://www.chahuitong.com/data/upload/shop/common/default_goods_image_240.gif",
                    "ap_size": "0",
                    "ap_spec": "1200x860", 
                    "member_id": "164",
                    "upload_time": "1468828998",
                    "ap_type": "0", 
                    "item_id": "35" // 动态ID 
                }
            ],
            "trace_title": "@茶汇通",
            "trace_from": "1",
            "trace_memberavatar": "http://120.25.216.71/data/upload/shop/common/default_user_portrait.gif",
            "trace_membername": "内测帐号",
            "trace_orgcommentcount": "1",
            "trace_copycount": "0",
            "trace_privacy": "0",
            "trace_addtime": "2016.06.03 23:28",
            "trace_likecount": "0",
            "comment_list": [
                {
                    "comment_addtime": "2016.07.01 17:21",
                    "comment_ip": "120.36.193.168",
                    "comment_id": "13",
                    "comment_memberavatar": "http://120.25.216.71/data/upload/shop/common/default_user_portrait.gif",
                    "comment_content": "地",
                    "comment_membername": "内测帐号",
                    "comment_memberid": "164",
                    "comment_originaltype": "0",
                    "comment_state": "0",
                    "comment_originalid": "18"
                }
            ],
            "trace_memberid": "164",
            "trace_state": "0",
            "trace_originalstate": "0",
            "trace_commentcount": "1"
        },
        "msg": "SUCCESS",
        "code": 1
    }
     
### 添加动态

#### 第一步先上传图片

URL: act=member_sns_trace&op=trace_image_upload

参数：

>key 当前登录令牌     
>image （File） 图片文件,为File类型 

返回：

    {
        "code": 1,
        "data": 16, // 图片ID
        "msg": "SUCCESS"
    }
     
#### 第二步先上传文字

URL: act=member_sns_trace&op=trace_add

参数：

>key 当前登录令牌     
>content 动态内容   
>privacy 权限 0-公开 1-仅自己可见 默认为0
>image_id 封面图片ID,由第一步返回

返回：

    {
        "code": 1,
        "data": 16, // 添加的动态id
        "msg": "SUCCESS"
    }

### 删除动态

URL(Get/Post): act=member_sns_trace&op=trace_del

参数：

>key 当前登录令牌     
>id 动态id    

返回：

    {
        "code": 1,
        "data": 16, // 添加的动态id
        "msg": "删除成功"
    }
      
### 动态评论列表

URL(Get/Post): act=member_sns_trace&op=comment_list

参数：

>key 当前登录令牌     
>id 动态id    

返回：

    {
        "code": 1,
        "data": {
            "list": [
                {
                    "comment_id": "12",
                    "comment_memberid": "164",
                    "comment_membername": "内测帐号",
                    "comment_memberavatar": "http://img.chahuitong.com/shop/common/default_user_portrait.gif",
                    "comment_originalid": "10",
                    "comment_originaltype": "0",
                    "comment_content": "test2",
                    "comment_addtime": "2016.05.26 19:35",
                    "comment_ip": "127.0.0.1",
                    "comment_state": "0"
                    "is_like": true 是否点赞过
                    "relation": 0-其他人 1-自己发表的
                }
            ],
            "hasmore": false,
            "page_total": 1
        },
        "msg": "SUCCESS"
    }
       
### 添加动态评论

URL(Post): act=member_sns_trace&op=comment_add

参数：

>key 当前登录令牌     
>id 动态id    
>content 评论内容    

返回：

    {
        "code": 1,
        "data": 13{
            "comment_id": "12",
            "comment_memberid": "164",
            "comment_membername": "内测帐号",
            "comment_memberavatar": "http://img.chahuitong.com/shop/common/default_user_portrait.gif",
            "comment_originalid": "10",
            "comment_originaltype": "0",
            "comment_content": "test2",
            "comment_addtime": "2016.05.26 19:35",
            "comment_ip": "127.0.0.1",
            "comment_state": "0"
        },
        "msg": "SUCCESS"
    }
        
### 回复评论

URL(Get/Post): act=member_sns_trace&op=comment_reply

参数：

>key 当前登录令牌     
>id 动态id    

返回：

    {
        "code": 1,
        "data": 13,
        "msg": "SUCCESS"
    }
              
### 删除动态评论

URL(Get/Post): act=member_sns_trace&op=comment_del

参数：

>key 当前登录令牌     
>id 动态id    

返回：

    {
        "code": 1,
        "data": 13,
        "msg": "SUCCESS"
    }
           
### 点赞

URL: act=member_sns_trace&op=like_add

参数：

>key 当前登录令牌     
>id 动态id    
>type 原帖类型 0表示动态 1表示分享商品 2表示评论 默认为0

返回：

    {
        "code": 1,
        "data": true,
        "msg": "SUCCESS"
    }

### 个人主页

URL: act=member_sns_home

参数：

>key 当前登录令牌        
>mid 主页用户ID     

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": {
            "member_id": "164",
            "member_name": "内测帐号",
            "member_truename": "廖培坤",
            "member_avatar": "http://120.25.216.71/data/upload/shop/common/default_user_portrait.gif",
            "member_sex": "1",
            "member_areainfo": null,
            "relation": 3, // 登录用户和主人关系 0表示未登录 1表示未关注 2表示互相关注 3表示自己 4表示已关注
            "following": "2",
            "followers": "3",
            "trace_count": "9"
        }
    }
              
### 全部动态列表

URL(Get): act=member_sns_home&op=trace_list

参数：

>mid 登录令牌,查看自己的动态列表    
>mid 用户ID 可以指定某个用户的动态列表,如果不传则默认返回全部列表    
    
返回：

    {
        "code": 1,
        "data": {
            "list": [
                {
                    "trace_id": "19",
                    "trace_originalid": "0",
                    "trace_memberid": "164",
                    "trace_membername": "内测帐号",
                    "trace_memberavatar": "http://img.chahuitong.com/shop/common/default_user_portrait.gif",
                    "trace_title": "ttttt",
                    "trace_image": "http://img.chahuitong.com/shop/common/default_goods_image_240.gif"
                    "trace_addtime": "2016.06.01 08:03",
                    "trace_state": "0",
                    "trace_privacy": "0",
                    "trace_commentcount": "0"
                }
            ],
            "hasmore": false,
            "page_total": 1
        },
        "msg": "SUCCESS"
    }
                     
### 推荐好友列表,根据粉丝数排名

URL(Get): act=member_sns_friend&op=popular_list

参数：

>key 当前登录令牌     
>name 搜索的用户名     

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": {
            "list": [
                {
                    "member_id": "164",
                    "member_name": "内测帐号",
                    "member_avatar": "http://img.chahuitong.com/shop/common/default_user_portrait.gif",
                    "follow_state": 0-未关注 1-已关注 2-相互关注
                    "trace_list": [
                        {
                            "trace_id": "19",
                            "trace_image": "http://img.chahuitong.com/shop/common/default_goods_image_240.gif"
                        },
                        {
                            "trace_id": "19",
                            "trace_image": "http://img.chahuitong.com/shop/common/default_goods_image_240.gif"
                        },
                        {
                            "trace_id": "19",
                            "trace_image": "http://img.chahuitong.com/shop/common/default_goods_image_240.gif"
                        }
                    ]
                }
            ],
            "hasmore": true,
            "page_total": 3
        }
    }
                       
### 搜索用户列表

URL(Get): act=member_sns_friend&op=find_list

参数：

>key 当前登录令牌     
>name 搜索的用户名     

返回：

    {
        "code": 1,
        "data": {
            "list": [
                {
                    "member_id": "5083",
                    "member_name": "品茶人",
                    "member_avatar": "http://img.chahuitong.com/shop/common/default_user_portrait.gif",
                    "member_sex": "1",
                    "member_state": "1",
                    "follow_state": 0-未关注 1-已关注 2-相互关注
                }
            ],
            "hasmore": true,
            "page_total": 6
        },
        "msg": "SUCCESS"
    }
        
### 添加关注

URL(Get): act=member_sns_friend&op=add_follow

参数：

>key 当前登录令牌     
>mid 用户ID    

返回：

    {
        "code": 1,
        "data": 2, // 返回该用户目前的状态和登录用户的关系 登录用户和主人关系 0表示未登录 1表示未关注 2表示互相关注 3表示自己 4表示已关注
        "msg": "SUCCESS"
    }
     
### 取消关注

URL(Get): act=member_sns_friend&op=del_follow

参数：

>key 当前登录令牌     
>mid 用户ID      

返回：

    {
        "code": 1,
        "data": 11,
        "msg": "SUCCESS"
    }
    
### 关注好友列表

URL: act=member_sns_friend&op=follow_list

参数：

>key 当前登录令牌     

返回：

    {
            "code": 1,
            "data": {
                "list": [
                    {
                        "friend_id": "9",
                        "friend_frommid": "167",
                        "friend_frommname": "15375870891",
                        "friend_frommavatar": "",
                        "friend_tomid": "164",
                        "friend_tomname": "内测帐号",
                        "friend_tomavatar": "164_60.jpg",
                        "friend_addtime": "1464180914",
                        "friend_followstate": "1"
                    }
                ],
                "hasmore": false,
                "page_total": 1
            },
            "msg": "SUCCESS"
        }
       
### 粉丝列表

URL: act=member_sns_friend&op=followers_list

参数：

>key 当前登录令牌     

返回：

    {
        "code": 1,
        "data": {
            "list": [
                {
                    "friend_id": "9",
                    "friend_frommid": "167",
                    "friend_frommname": "15375870891",
                    "friend_frommavatar": "",
                    "friend_tomid": "164",
                    "friend_tomname": "内测帐号",
                    "friend_tomavatar": "164_60.jpg",
                    "friend_addtime": "1464180914",
                    "friend_followstate": "1"
                }
            ],
            "hasmore": false,
            "page_total": 1
        },
        "msg": "SUCCESS"
    }

### 消息列表

URL: act=member_message&op=message_list

参数：

>key 当前登录令牌     
>type 消息类型 0为私信、1为系统消息、2为留言、3为新的粉丝、4为评论和赞、5为@我 

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": {
            "list": [
                {
                    "message_id": "535",
                    "message_parent_id": "0",
                    "from_member_id": "0",
                    "to_member_id": "164",
                    "message_title": null,
                    "message_body": "内测帐号关注了你",
                    "message_time": "2016.06.07 15:30",
                    "message_update_time": "1465284615",
                    "message_open": "0",
                    "message_state": "0",
                    "message_type": "3",
                    "read_member_id": "",
                    "del_member_id": "",
                    "message_ismore": "0",
                    "from_member_name": "内测帐号",
                    "to_member_name": "qweqwe",
                    "from_member_avatar": "http://img.chahuitong.com/shop/common/default_user_portrait.gif"
                }
            ],
            "hasmore": true,
            "page_total": "82"
        }
    }
  
### 新消息数量

URL: act=member_message&op=new_count

参数：

>key 当前登录令牌     
>type 消息类型 0为私信、1为系统消息、2为留言、3为新的粉丝、4为评论和赞、5为@我 

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": {
            "new_fans": "1", // 新的粉丝
            "new_comment": "2", // 新的评论 
            "new_at": "1", // @我
            "new_system": "62", // 系统消息
            "count_new_msg": 64 总消息数
        }
    }
   
        
### 发现首页

URL(Post): act=discover

参数：
    无

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": {
            "trace_list": [
                {
                    "trace_id": "33",
                    "trace_image": "http://120.25.216.71/data/upload/shop/common/default_goods_image_240.gif"
                }
            ],
            "flea_list": [
                {
                    "goods_id": "24",
                    "goods_commend": "1",
                    "goods_image_url": "http://120.25.216.71/data/upload/shop/common/default_goods_image_240.gif"
                }
            ],
            "class_list": [
                {
                    "gc_id": "1",
                    "gc_name": "普洱茶",
                    "gc_parent_id": "0",
                    "gc_sort": "1",
                    "gc_thumb": "http://www.chahuitong.com/data/upload/mobile/category/05220056207590144.jpg"
                }
            ],
            "member_list": [
                {
                    "member_id": "132",
                    "member_name": "郑明锡",
                    "member_avatar": "http://120.25.216.71/data/upload/shop/common/default_user_portrait.gif"
                }
            ]
        }
    }
   
### 文章列表

URL: act=article&op=article_list

参数：

>key 当前登录令牌     
>class_id 文章类目ID 
>tag_id 标签ID 

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": {
            "list": [
                {
                    "article_id": "6356",
                    "article_title": "白牡丹茶是什么茶？",
                    "article_class_id": "92",
                    "article_origin": "",
                    "article_origin_address": "",
                    "article_author": "茶汇通",
                    "article_image": "http://120.25.216.71/data/upload/cms/article/2/1_list.png",
                    "article_publish_time": "1456502400",
                    "article_click": "15",
                    "article_sort": "255",
                    "article_commend_flag": "0",
                    "article_state": "3",
                    "article_publisher_name": "茶汇通",
                    "article_publisher_id": "2",
                    "article_attachment_path": "2",
                    "article_comment_count": "0",
                    "article_url": "http://120.25.216.71/api/index.php?act=article&op=article_detail=6356",
                    "article_publisher_avatar": "http://120.25.216.71/data/upload/shop/common/default_user_portrait.gif"
                }
            ],
            "hasmore": true,
            "page_total": 31
        }
    }
   
### 文章详情介绍信息
URL(Get): act=article&op=article_detail 

参数：

>key 当前登录令牌     
>article_id 文章编号    

返回： html

### 文章评论列表

URL: act=article_comment&op=comment_list

参数：

>key 当前登录令牌  
>order 排序 0-热度 1-时间 默认为热度
>object_id 文章ID 
>type 类型 1-文章 2-画报 默认为文章

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": [
            {
                "comment_id": "5",
                "comment_type": "1",
                "comment_object_id": "6356",
                "comment_message": "tttt",
                "comment_member_id": "164",
                "comment_time": "1466495092",
                "comment_quote": "",
                "comment_up": "0",
                "member_id": "164",
                "member_name": "内测帐号",
                "member_avatar": "164_60.jpg"
            }
        ]
    }
   
### 添加文章评论

URL(Get): act=article_comment&op=comment_add

参数：

>key 当前登录令牌     
>object_id 文章或画报ID 
>comment_message 评论内容 
>comment_type 评论类型 1-文章 2-画报 默认为1 

返回：

    {
        "code": 1,
        "msg": "评论发表成功",
        "data": 5 // 成功的评论ID
    }
   
### 删除文章评论

URL(Post): act=article_comment&op=comment_del

参数：

>key 当前登录令牌     
>comment_id 评论编号
>comment_type 评论类型 1-文章 2-画报 默认为1 

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": true
    }
     
### 文章评论点赞

URL: act=article_comment&op=comment_up

参数：

>key 当前登录令牌     
>comment_id 评论编号

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": true
    }
    
### 我发布的茶市商品

URL: act=member_flea

参数：     

>key 登录信息   

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": {
            "list": [
                {
                    "goods_id": "5",
                    "goods_name": "普洱茶 08年鹏程茶厂特级布朗山熟茶",
                    "member_id": "1354",
                    "goods_tag": "普洱茶",
                    "goods_store_price": "1680.00",
                    "goods_show": "0",
                    "goods_click": "0",
                    "goods_add_time": "7月",
                    "flea_pname": "",
                    "flea_pphone": "13618799142",
                    "goods_image_url": "http://img.chahuitong.com/shop/common/default_goods_image_240.gif",
                    "goods_abstract": "7年干仓陈化，2008年勐海鹏程茶厂特级布朗山熟饼，现货37件出售，性价比高，口感醇和，生津明显。有意者打电话或加微信【397762737】私聊。"
                }
            ],
            "hasmore": true,
            "page_total": 5
        }
    }
 
### 茶市商品列表

URL: act=member_flea&op=flea_list

参数：     

>key 登录信息   

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": {
            "list": [
                {
                    "goods_id": "5",
                    "goods_name": "普洱茶 08年鹏程茶厂特级布朗山熟茶",
                    "member_id": "1354",
                    "goods_tag": "普洱茶",
                    "goods_store_price": "1680.00",
                    "goods_show": "0",
                    "goods_click": "0",
                    "goods_add_time": "7月",
                    "flea_pname": "",
                    "flea_pphone": "13618799142",
                    "goods_image_url": "http://img.chahuitong.com/shop/common/default_goods_image_240.gif",
                    "goods_abstract": "7年干仓陈化，2008年勐海鹏程茶厂特级布朗山熟饼，现货37件出售，性价比高，口感醇和，生津明显。有意者打电话或加微信【397762737】私聊。"
                }
            ],
            "hasmore": true,
            "page_total": 5
        }
    }
 
### 茶市商品详情

URL: act=member_flea&op=flea_detail

参数：

>key 登录信息   
>goods_id 商品ID  如果不传或者传0将会返回用户的信息

返回：
    
    查看详情页时:
    {
        "code": 1,
        "msg": "SUCCESS",
        "data": {
            "goods_id": "1",
            "goods_name": "雲頂茶业 滇系列熟茶2015-301",
            "gc_id": "0",
            "gc_name": "",
            "member_id": "151",
            "member_name": "18659255555",
            "goods_image": "1443436860_1.jpg",
            "goods_tag": "",
            "goods_price": "0.00",
            "goods_store_price": "0.00",
            "goods_show": "0",
            "goods_click": "6",
            "flea_collect_num": "3",
            "goods_commend": "0",
            "goods_add_time": "2016-07-21 18:59",
            "goods_keywords": "",
            "goods_description": "",
            "goods_body": "这个卖家太懒了，宝贝描述里面一个字都不肯写。",
            "commentnum": "7",
            "salenum": "0",
            "flea_quality": "0",
            "flea_pname": "",
            "flea_pphone": "18650167777",
            "flea_area_id": "0",
            "flea_area_name": "北京",
            "member_avatar": "http://img.chahuitong.com/shop/common/default_user_portrait.gif",
            "belong_me": false, // 是否是属于我的
            "favorite": true, // 是否收藏 
            "desc_image": [
                {
                    "file_thumb": "1443436860_1.jpg",
                    "store_id": "151",
                    "upload_type": "12",
                    "item_id": "1",
                    "thumb_small": "http://img.chahuitong.com/shop/member/151/1443436860_1.jpg",
                    "thumb_mid": "http://img.chahuitong.com/shop/member/151/1443436860_1.jpg",
                    "thumb_max": "http://img.chahuitong.com/shop/member/151/1443436860_1.jpg"
                }
            ],
            "consult_list": [
                {
                    "member_id": "164",
                    "consult_id": "9",
                    "goods_id": "1",
                    "consult_content": "aaa",
                    "consult_addtime": "10天前",
                    "consult_reply": null,
                    "consult_reply_time": null,
                    "member_name": "内测帐号",
                    "member_avatar": "http://img.chahuitong.com/shop/common/default_user_portrait.gif"
                }
            ]
        }
    }
    发布新商品时,返回用户信息用于自动填充用户已经保存过资料的信息
    {
        "code": 1,
        "msg": "SUCCESS",
        "data": {
            "member_id": "164",
            "member_mobile": "15375870891",
            "member_truename": "廖培坤",
            "member_areainfo": "福建厦门湖里区"
        }
    }
     
### 茶市发布商品

URL: act=member_flea&op=image_upload

参数：

>key 登录信息   
>upload_id 原图片ID,用于编辑时更改图片,需要把原图片ID传入用来删除原图片    
>image 图片   

返回：
    
    {
        "code": 1,
        "msg": "SUCCESS",
        "data": {
            "upload_id": 135,
            "file_name": "164_05204352615783671_240.png",
            "file_path": "164_05204352615783671_240.png"
        }
    }
    
#### 第二步再上传文字内容

URL: act=member_flea&op=save_goods

参数：

>key 登录信息   
>goods_file_id 封面图片ID,由第一步上传成功后返回的第一张图片的ID  
>*goods_name 图片   
>cate_id 分类ID   			 
>cate_name 分类名称     			 
>flea_pname 联系人名称		 
>area_id 地区ID    	 
>area_info 地区名称 	 
>flea_pphone 联系电话     		 
>goods_tag 标签   		 
>price 价格 传0表示不供价    
>g_body 描述  		 

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": 56
    }
            
### 茶市删除商品

URL: act=member_flea&op=drop_goods

参数：

>key 登录信息   
>goods_id 要删除的商品ID,可批量删除,多个ID用逗号分割 

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": true / false
    }
          
### 茶市编辑商品

URL: act=member_flea&op=edit_goods

参数：

>key 登录信息   
>goods_id 商品ID
>goods_file_id 封面图片ID,由第一步上传成功后返回的第一张图片的ID
>*goods_name 图片   
>cate_id 分类ID   			 
>cate_name 分类名称     			 
>flea_pname 联系人名称		 
>area_id 地区ID    	 
>area_info 地区名称 	 
>flea_pphone 联系电话     		 
>goods_tag 标签   		 
>price 价格 传0表示不供价    
>g_body 描述  		 

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": 56
    }
     
### 茶市商品留言

URL: act=member_flea&op=save_consult

参数：

>key 登录令牌
>goods_id 商品ID  
>content 留言内容

返回：

    {
        "code": 1,
        "msg": "咨询发布成功",
        "data": {
                    "member_id": "164",
                    "consult_id": "5",
                    "goods_id": "21",
                    "consult_content": "test",
                    "consult_addtime": "1467025302",
                    "consult_reply": null,
                    "consult_reply_time": null,
                    "member_name": "内测帐号",
                    "member_avatar": "164_60.jpg"
                }
    }
 
### 茶市类别列表

URL: act=member_flea&op=class_list

参数：

>key 登录令牌   
>class_id 类别ID,如果不传默认返回一级类目  

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": [
            {
                "gc_id": "1",
                "gc_name": "普洱茶",
                "gc_name_index": "",
                "gc_parent_id": "0",
                "gc_sort": "1",
                "gc_show": "1",
                "gc_index_show": "1"
                "has_child": true 是否有下级
            }
        ]
    }
 
### 茶市收藏列表

URL: act=member_flea&op=favorites

参数：

>key 登录令牌   

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": [
            {
                "goods_id": "5",
                "goods_name": "普洱茶 08年鹏程茶厂特级布朗山熟茶",
                "goods_image": "http://img.chahuitong.com/shop/common/default_goods_image_240.gif",
                "gc_name": "",
                "member_id": "1354",
                "fav_time": "2016.07.21 16:48"
            }
        ]
    }
 
### 茶市添加收藏

URL(Post/Get): act=member_flea&op=add_favorites

参数：

>key 登录令牌   
>goods_id 商品ID  

返回：

    {
        "code": 0,
        "msg": "已经收藏过了",
        "data": false // 是否成功
    }
 
### 茶市删除收藏

URL(Post/Get): act=member_flea&op=del_favorites

参数：

>key 登录令牌   
>goods_id 商品ID 如果批量删除用逗号隔开    

返回：

    {
        "code": 1,
        "msg": "删除成功",
        "data": true
    }
 
### 意见反馈

URL: act=member_feedback&op=feedback_add

参数：

>key 登录令牌   
>feedback 反馈内容  
>contact 联系方式

返回：

    {
        "code": 1,
        "msg": "SUCCESS",
        "data": 1
    }
                        