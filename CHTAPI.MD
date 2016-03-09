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

### 1.登录
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

### 2.注册
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

### 3.第三方登录
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

### 4.发送验证码
URL: act=login&op=send_sms  
参数：
>mobile  

返回： 

      {
        code:  
      }

### 5.首页 
URL: act=home&op=home_page_api  
参数： 

>key  
>page   

### 6.商品详情
URL(Get): act=goods&op=goods_detail 
参数：

>goods_id 商品编号    

返回： 

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

### 7.商品介绍信息
URL(Get): act=goods&op=goods_body 
参数：

>goods_id 商品编号    

返回： html


### 8.免费茶样往期
URL(Get): act=goods_sample&op=overdue_goods 
返回：

      {
        code:  
      }

### 9.免费茶样当前
URL： act=goods_sample 

参数：

>key 登录令牌，用于判断当前用户是否领取过

返回：

    {
      "code": 1,
      "msg": "查询正常",
      "data": {
          "sample_id": "36",
          "sample_name": "[免费茶样]婀娜公主 清香铁观音 浓香 油切黑乌龙 各一包7g*3",
          "sample_image": [
              {
                  "original_pic": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05071421284587390.jpg",
                  "bmiddle_pic": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05071421284587390_360.jpg"
              },
              {
                  "original_pic": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05071421912242261.jpg",
                  "bmiddle_pic": "http://www.chahuitong.com/data/upload/shop/store/goods/2/2_05071421912242261_360.jpg"
              }
          ],
          "sample_origin_place": "福建",
          "sample_weight": "7",
          "sample_correlation_price": "0",
          "sample_freight": "0",
          "sample_limit_number": "10",
          "sample_add_time": "0",
          "sample_start_time": "1456416000",
          "sample_end_time": "1456502400",
          "sample_state": "1",
          "sample_received_number": "0",
          "sample_link": "101972",
          "sample_bak_price": "0",
          "sample_bak_promotion_price": "0",
          "allow": true
          "state": "可以申领"
      }
    }

### 10.限时抢购今日
URL： act=flash_sale&op=current_api 
参数：

>page 当前列表页数    

返回：

    {
      code: 
    }

### 11.限时抢购明日
URL： act=flash_sale&op=coming_api  
参数：

>page 当前列表页数 

返回：

    {
      code: 
    }

### 12.茶艺师推荐
URL: act=tasters_recommends 
参数：

>page 当前列表页数    
>gc_id 按类别排序时的类目ID
>byPrice 按价格进行筛选，值为1 倒序 值为 0 顺序   
>bySalenum 按销量进行筛选，值为1 倒序 值为 0 顺序   
>byClick") 按点击量进行筛选，值为1 倒序 值为 0 顺序   

返回： 

    {
      code: 
    }

### 13.忘记密码
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

### 14.更改密码
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

### 15.获取用户信息(v1)
URL: act=member_index 
参数：

>key  登录令牌    

返回： 

    {
      code: 200,
      datas: {
        user_name: 测试-廖培坤
        avator: http://www.chahuitong.com/data/upload/shop/common/default_user_portrait.gif
        point: 0
        predepoit: 0.00
      }
      
    }

### 16.获取用户信息(v3)
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

### 17.更改用户信息
URL: act=member_index&op=update_member_info 
参数：

>key  登录令牌    
>member_truename 真实姓名   
>member_sex 性别 0-男， 1-女    
>member_birthday 生日   
>member_avatar 头像，图片的Base64   

返回： 

    {
      code: 1,
      msg: "更新成功",
      data: {}
    }

### 18.购买第一步(获取订单信息)
URL: act=member_buy&op=buy_step1  
参数：

>key 登录令牌    
>cart_id  购买参数。立即购买： 第一个数字为商品编号，第二个数字为购买数量，用竖线分割。例：232|1；
          购物车购买：第一个数字为购物车编号，第二个数字为购买数量，用竖线分割。多组用半角逗号分割，例：232|1,110|2                 232商品购买1个，110商品购买2个
>ifcart 购物车购买标志 1    

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

### 19.更换收货地址
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

### 20.购买第二步(生成订单)
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

### 21.购物车列表
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

### 22.购物车添加
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

### 23.购物车删除
URL: act=member_cart&op=cart_del  
参数：

>key 登录令牌    
>cart_id 购物车编号   

返回： 

    {
      code: 200,
      datas: "1"
    }

### 24.购物车修改数量
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

### 25.收藏列表
URL: act=member_favorites&op=favorites_list
参数：

>key 登录令牌    

返回： 

    {
      code: 200,
      datas: {
        goods_name 商品名称
        goods_image_url 商品图片地址
        goods_price 商品价格
        fav_id 收藏编号
      }
    }

### 26.收藏添加
URL: act=member_favorites&op=favorites_add
参数：

>key 登录令牌    
>goods_id 商品编号    

返回： 

    {
      code: 200,
      datas: "1"
    }

### 27.收藏删除
URL: act=member_favorites&op=favorites_del
参数：

>key 登录令牌    
>fav_id 收藏编号      

返回： 

    {
      code: 200,
      datas: "1"
    }

### 28.地址列表
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

### 29.地址详细信息
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

### 30.地址删除
URL: act=member_address&op=address_del   

参数：

>key 登录令牌    
>address_id 地址编号    

返回： 

    {
      code: 200,
      datas: "1"
    }

### 31.地址添加
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

### 32.地址编辑
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

### 33.地区列表
URL: act=member_address&op=area_list   

参数：

>key 当前登录令牌
>area_id 地区编号(为空时默认返回一级分类)

返回： 

    {
      code: 200,
      datas: {
        area_list[
          {
            area_id 地区编号
            area_name 地区名称
          },
        ]
      }
    }



