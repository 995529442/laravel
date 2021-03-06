<?php
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 后台公共路由部分
|
*/
Route::group(['namespace'=>'Admin','prefix'=>'admin'],function (){
    //登录、注销
    Route::get('login','LoginController@showLoginForm')->name('admin.loginForm');
    Route::post('login','LoginController@login')->name('admin.login');
    Route::get('logout','LoginController@logout')->name('admin.logout');
    Route::get('captcha', 'LoginController@captcha')->name('admin.captcha'); //验证码
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 后台需要授权的路由 admins
|
*/
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'auth'],function (){
    //后台布局
    Route::get('/','IndexController@layout')->name('admin.layout');
    //后台首页
    Route::get('/index','IndexController@index')->name('admin.index');
    Route::get('/index1','IndexController@index1')->name('admin.index1');
    Route::get('/index2','IndexController@index2')->name('admin.index2');
    //图标
    Route::get('icons','IndexController@icons')->name('admin.icons');
});

//系统管理
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>['auth','permission:system.manage']],function (){
    //数据表格接口
    Route::get('data','IndexController@data')->name('admin.data')->middleware('permission:system.role|system.user|system.permission');
    //用户管理
    Route::group(['middleware'=>['permission:system.user']],function (){
        Route::get('user','UserController@index')->name('admin.user');
        //添加
        Route::get('user/create','UserController@create')->name('admin.user.create')->middleware('permission:system.user.create');
        Route::post('user/store','UserController@store')->name('admin.user.store')->middleware('permission:system.user.create');
        //编辑
        Route::get('user/{id}/edit','UserController@edit')->name('admin.user.edit')->middleware('permission:system.user.edit');
        Route::put('user/{id}/update','UserController@update')->name('admin.user.update')->middleware('permission:system.user.edit');
        //删除
        Route::delete('user/destroy','UserController@destroy')->name('admin.user.destroy')->middleware('permission:system.user.destroy');
        //分配角色
        Route::get('user/{id}/role','UserController@role')->name('admin.user.role')->middleware('permission:system.user.role');
        Route::put('user/{id}/assignRole','UserController@assignRole')->name('admin.user.assignRole')->middleware('permission:system.user.role');
        //分配权限
        Route::get('user/{id}/permission','UserController@permission')->name('admin.user.permission')->middleware('permission:system.user.permission');
        Route::put('user/{id}/assignPermission','UserController@assignPermission')->name('admin.user.assignPermission')->middleware('permission:system.user.permission');
    });
    //角色管理
    Route::group(['middleware'=>'permission:system.role'],function (){
        Route::get('role','RoleController@index')->name('admin.role');
        //添加
        Route::get('role/create','RoleController@create')->name('admin.role.create')->middleware('permission:system.role.create');
        Route::post('role/store','RoleController@store')->name('admin.role.store')->middleware('permission:system.role.create');
        //编辑
        Route::get('role/{id}/edit','RoleController@edit')->name('admin.role.edit')->middleware('permission:system.role.edit');
        Route::put('role/{id}/update','RoleController@update')->name('admin.role.update')->middleware('permission:system.role.edit');
        //删除
        Route::delete('role/destroy','RoleController@destroy')->name('admin.role.destroy')->middleware('permission:system.role.destroy');
        //分配权限
        Route::get('role/{id}/permission','RoleController@permission')->name('admin.role.permission')->middleware('permission:system.role.permission');
        Route::put('role/{id}/assignPermission','RoleController@assignPermission')->name('admin.role.assignPermission')->middleware('permission:system.role.permission');
    });
    //权限管理
    Route::group(['middleware'=>'permission:system.permission'],function (){
        Route::get('permission','PermissionController@index')->name('admin.permission');
        //添加
        Route::get('permission/create','PermissionController@create')->name('admin.permission.create')->middleware('permission:system.permission.create');
        Route::post('permission/store','PermissionController@store')->name('admin.permission.store')->middleware('permission:system.permission.create');
        //编辑
        Route::get('permission/{id}/edit','PermissionController@edit')->name('admin.permission.edit')->middleware('permission:system.permission.edit');
        Route::put('permission/{id}/update','PermissionController@update')->name('admin.permission.update')->middleware('permission:system.permission.edit');
        //删除
        Route::delete('permission/destroy','PermissionController@destroy')->name('admin.permission.destroy')->middleware('permission:system.permission.destroy');
    });
    //菜单管理
    Route::group(['middleware'=>'permission:system.menu'],function (){
        Route::get('menu','MenuController@index')->name('admin.menu');
        Route::get('menu/data','MenuController@data')->name('admin.menu.data');
        //添加
        Route::get('menu/create','MenuController@create')->name('admin.menu.create')->middleware('permission:system.menu.create');
        Route::post('menu/store','MenuController@store')->name('admin.menu.store')->middleware('permission:system.menu.create');
        //编辑
        Route::get('menu/{id}/edit','MenuController@edit')->name('admin.menu.edit')->middleware('permission:system.menu.edit');
        Route::put('menu/{id}/update','MenuController@update')->name('admin.menu.update')->middleware('permission:system.menu.edit');
        //删除
        Route::delete('menu/destroy','MenuController@destroy')->name('admin.menu.destroy')->middleware('permission:system.menu.destroy');
    });
});


//资讯管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:zixun.manage']], function () {
    //分类管理
    Route::group(['middleware' => 'permission:zixun.category'], function () {
        Route::get('category/data', 'CategoryController@data')->name('admin.category.data');
        Route::get('category', 'CategoryController@index')->name('admin.category');
        //添加分类
        Route::get('category/create', 'CategoryController@create')->name('admin.category.create')->middleware('permission:zixun.category.create');
        Route::post('category/store', 'CategoryController@store')->name('admin.category.store')->middleware('permission:zixun.category.create');
        //编辑分类
        Route::get('category/{id}/edit', 'CategoryController@edit')->name('admin.category.edit')->middleware('permission:zixun.category.edit');
        Route::put('category/{id}/update', 'CategoryController@update')->name('admin.category.update')->middleware('permission:zixun.category.edit');
        //删除分类
        Route::delete('category/destroy', 'CategoryController@destroy')->name('admin.category.destroy')->middleware('permission:zixun.category.destroy');
    });
    //文章管理
    Route::group(['middleware' => 'permission:zixun.article'], function () {
        Route::get('article/data', 'ArticleController@data')->name('admin.article.data');
        Route::get('article', 'ArticleController@index')->name('admin.article');
        //添加
        Route::get('article/create', 'ArticleController@create')->name('admin.article.create')->middleware('permission:zixun.article.create');
        Route::post('article/store', 'ArticleController@store')->name('admin.article.store')->middleware('permission:zixun.article.create');
        //编辑
        Route::get('article/{id}/edit', 'ArticleController@edit')->name('admin.article.edit')->middleware('permission:zixun.article.edit');
        Route::put('article/{id}/update', 'ArticleController@update')->name('admin.article.update')->middleware('permission:zixun.article.edit');
        //删除
        Route::delete('article/destroy', 'ArticleController@destroy')->name('admin.article.destroy')->middleware('permission:zixun.article.destroy');
    });
    //标签管理
    Route::group(['middleware' => 'permission:zixun.tag'], function () {
        Route::get('tag/data', 'TagController@data')->name('admin.tag.data');
        Route::get('tag', 'TagController@index')->name('admin.tag');
        //添加
        Route::get('tag/create', 'TagController@create')->name('admin.tag.create')->middleware('permission:zixun.tag.create');
        Route::post('tag/store', 'TagController@store')->name('admin.tag.store')->middleware('permission:zixun.tag.create');
        //编辑
        Route::get('tag/{id}/edit', 'TagController@edit')->name('admin.tag.edit')->middleware('permission:zixun.tag.edit');
        Route::put('tag/{id}/update', 'TagController@update')->name('admin.tag.update')->middleware('permission:zixun.tag.edit');
        //删除
        Route::delete('tag/destroy', 'TagController@destroy')->name('admin.tag.destroy')->middleware('permission:zixun.tag.destroy');
    });
});
//配置管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:config.manage']], function () {
    //站点配置
    Route::group(['middleware' => 'permission:config.site'], function () {
        Route::get('site', 'SiteController@index')->name('admin.site');
        Route::put('site', 'SiteController@update')->name('admin.site.update')->middleware('permission:config.site.update');
    });
    //广告位
    Route::group(['middleware' => 'permission:config.position'], function () {
        Route::get('position/data', 'PositionController@data')->name('admin.position.data');
        Route::get('position', 'PositionController@index')->name('admin.position');
        //添加
        Route::get('position/create', 'PositionController@create')->name('admin.position.create')->middleware('permission:config.position.create');
        Route::post('position/store', 'PositionController@store')->name('admin.position.store')->middleware('permission:config.position.create');
        //编辑
        Route::get('position/{id}/edit', 'PositionController@edit')->name('admin.position.edit')->middleware('permission:config.position.edit');
        Route::put('position/{id}/update', 'PositionController@update')->name('admin.position.update')->middleware('permission:config.position.edit');
        //删除
        Route::delete('position/destroy', 'PositionController@destroy')->name('admin.position.destroy')->middleware('permission:config.position.destroy');
    });
    //广告信息
    Route::group(['middleware' => 'permission:config.advert'], function () {
        Route::get('advert/data', 'AdvertController@data')->name('admin.advert.data');
        Route::get('advert', 'AdvertController@index')->name('admin.advert');
        //添加
        Route::get('advert/create', 'AdvertController@create')->name('admin.advert.create')->middleware('permission:config.advert.create');
        Route::post('advert/store', 'AdvertController@store')->name('admin.advert.store')->middleware('permission:config.advert.create');
        //编辑
        Route::get('advert/{id}/edit', 'AdvertController@edit')->name('admin.advert.edit')->middleware('permission:config.advert.edit');
        Route::put('advert/{id}/update', 'AdvertController@update')->name('admin.advert.update')->middleware('permission:config.advert.edit');
        //删除
        Route::delete('advert/destroy', 'AdvertController@destroy')->name('admin.advert.destroy')->middleware('permission:config.advert.destroy');
    });
});
//会员管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:member.manage']], function () {
    //账号管理
    Route::group(['middleware' => 'permission:member.member'], function () {
        Route::get('member/data', 'MemberController@data')->name('admin.member.data');
        Route::get('member', 'MemberController@index')->name('admin.member');
        //添加
        Route::get('member/create', 'MemberController@create')->name('admin.member.create')->middleware('permission:member.member.create');
        Route::post('member/store', 'MemberController@store')->name('admin.member.store')->middleware('permission:member.member.create');
        //编辑
        Route::get('member/{id}/edit', 'MemberController@edit')->name('admin.member.edit')->middleware('permission:member.member.edit');
        Route::put('member/{id}/update', 'MemberController@update')->name('admin.member.update')->middleware('permission:member.member.edit');
        //删除
        Route::delete('member/destroy', 'MemberController@destroy')->name('admin.member.destroy')->middleware('permission:member.member.destroy');
    });
});
//消息管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:message.manage']], function () {
    //消息管理
    Route::group(['middleware' => 'permission:message.message'], function () {
        Route::get('message/data', 'MessageController@data')->name('admin.message.data');
        Route::get('message/getUser', 'MessageController@getUser')->name('admin.message.getUser');
        Route::get('message', 'MessageController@index')->name('admin.message');
        //添加
        Route::get('message/create', 'MessageController@create')->name('admin.message.create')->middleware('permission:message.message.create');
        Route::post('message/store', 'MessageController@store')->name('admin.message.store')->middleware('permission:message.message.create');
        //删除
        Route::delete('message/destroy', 'MessageController@destroy')->name('admin.message.destroy')->middleware('permission:message.message.destroy');
        //我的消息
        Route::get('mine/message', 'MessageController@mine')->name('admin.message.mine')->middleware('permission:message.message.mine');
        Route::post('message/{id}/read', 'MessageController@read')->name('admin.message.read')->middleware('permission:message.message.mine');

        Route::get('message/count', 'MessageController@getMessageCount')->name('admin.message.get_count');
    });

});
//基础管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:base.manage']], function () {
    //基础管理
    Route::any('Index/mail', 'IndexController@mail')->name('mail')->middleware('permission:mail'); //邮件设置
    Route::any('Index/saveMail', 'IndexController@saveMail')->name('saveMail')->middleware('permission:mail'); //保存邮件设置

    Route::any('Index/sms', 'IndexController@sms')->name('sms')->middleware('permission:sms'); //短信设置
    Route::any('Index/saveSms', 'IndexController@saveSms')->name('saveSms')->middleware('permission:sms'); //保存短信设置

    Route::any('Index/sms_template', 'IndexController@smsTemplate')->name('smsTemplate')->middleware('permission:smsTemplate'); //短信模板页面
    Route::any('Index/sms_data', 'IndexController@sms_data')->name('sms_data')->middleware('permission:smsTemplate'); //短信模板页面
    Route::any('Index/add_sms_template', 'IndexController@addSmsTemplate')->name('addSmsTemplate')->middleware('permission:addSmsTemplate'); //新增短信模板页面
    Route::any('Index/save_sms_template', 'IndexController@saveSmsTemplate')->name('saveSmsTemplate')->middleware('permission:addSmsTemplate'); //保存短信模板页面
    Route::any('Index/del_sms_template', 'IndexController@delSmsTemplate')->name('delSmsTemplate')->middleware('permission:delSmsTemplate'); //删除短信模板页面

    Route::any('Index/send_log_data', 'IndexController@send_log_data')->name('send_log_data')->middleware('permission:sendLog'); //发送记录
    Route::any('Index/send_log', 'IndexController@sendLog')->name('sendLog')->middleware('permission:sendLog'); //发送记录

    //测试短信、邮件
    Route::any('Index/test_sms', 'IndexController@testSms')->name('testSms')->middleware('permission:testSms'); //测试短信

    Route::any('Index/get_orders', 'IndexController@getOrders')->name('getOrders'); //首页获取订单
});
//后台管理
//微餐饮
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:cater.manage']], function () {
    //餐厅管理
    Route::group(['prefix' => 'cater/shop/','middleware' => 'permission:cater.shop'], function () {
        Route::get('home', 'CaterShopController@index')->name('cater.shop.index');  //餐厅管理
        Route::post('saveShop', 'CaterShopController@saveShop')->name('cater.shop.saveShop')->middleware('permission:cater.shop.saveShop'); //保存餐厅
        Route::any('map', 'CaterShopController@map')->name('cater.shop.map')->middleware('permission:cater.shop.map'); //定位地图
        Route::post('getAddress', 'CaterShopController@getAddress')->name('cater.shop.getAddress'); //获取省市区等信息
        Route::post('upload', 'CaterShopController@upload')->name('cater.shop.upload'); //上传logo图片
        Route::post('delFigureImg', 'CaterShopController@delFigureImg')->name('cater.shop.delFigureImg'); //删除logo图片
    });

    //首页管理
    Route::group(['prefix' => 'cater/home/','middleware' => 'permission:cater.home'], function () {
        Route::any('home', 'CaterHomeController@index')->name('cater.home.index'); //首页管理
        Route::any('save', 'CaterHomeController@save')->name('cater.home.save')->middleware('permission:cater.home.save'); //保存首页管理
        Route::any('upload', 'CaterHomeController@upload')->name('cater.home.upload'); //上传
        Route::any('delFigureImg', 'CaterHomeController@delFigureImg')->name('cater.home.delFigureImg'); //删除
    });

    //模板管理
    Route::group(['prefix' => 'cater/template/','middleware' => 'permission:cater.template'], function () {
        Route::get('home', 'CaterTemplateController@index')->name('cater.template.index'); //模板管理
        Route::get('data', 'CaterTemplateController@data')->name('cater.template.data');
        Route::get('addTemplate', 'CaterTemplateController@addTemplate')->name('cater.template.addTemplate')->middleware('permission:cater.template.addTemplate'); //新增
        Route::any('saveTemplate', 'CaterTemplateController@saveTemplate')->name('cater.template.saveTemplate')->middleware('permission:cater.template.addTemplate'); //保存
        Route::any('delTemplate', 'CaterTemplateController@delTemplate')->name('cater.template.delTemplate')->middleware('permission:cater.template.delTemplate'); //删除
    });

    //分类管理
    Route::group(['prefix' => 'cater/category/','middleware' => 'permission:cater.category'], function () {
        Route::get('home', 'CaterCategoryController@index')->name('cater.category.index'); //分类管理
        Route::get('data', 'CaterCategoryController@data')->name('cater.category.data');
        Route::any('operate', 'CaterCategoryController@operate')->name('cater.category.operate')->middleware('permission:cater.category.operate'); //分类操作
        Route::any('add_cate', 'CaterCategoryController@add_cate')->name('cater.category.add_cate')->middleware('permission:cater.category.add_cate'); //新增分类
        Route::any('save_cate', 'CaterCategoryController@save_cate')->name('cater.category.save_cate')->middleware('permission:cater.category.add_cate'); //保存分类
    });

    //菜品管理
    Route::group(['prefix' => 'cater/goods/','middleware' => 'permission:cater.goods'], function () {
        Route::get('home', 'CaterGoodsController@index')->name('cater.goods.index'); //菜品管理
        Route::get('data', 'CaterGoodsController@data')->name('cater.goods.data');
        Route::get('add_goods', 'CaterGoodsController@add_goods')->name('cater.goods.add_goods')->middleware('permission:cater.goods.add_goods'); //菜品添加编辑
        Route::post('upload', 'CaterGoodsController@upload')->name('cater.goods.upload'); //上传logo图片
        Route::any('save_goods', 'CaterGoodsController@save_goods')->name('cater.goods.save_goods')->middleware('permission:cater.goods.add_goods'); //保存商品
        Route::any('del_goods', 'CaterGoodsController@del_goods')->name('cater.goods.del_goods')->middleware('permission:cater.goods.del_goods'); //删除商品
        Route::any('delFigureImg', 'CaterGoodsController@delFigureImg')->name('cater.goods.delFigureImg'); //删除展示图片
    });

    //餐桌管理
    Route::group(['prefix' => 'cater/desk/','middleware' => 'permission:cater.desk'], function () {
        Route::get('home', 'CaterDeskController@index')->name('cater.desk.index'); //餐桌管理
        Route::get('data', 'CaterDeskController@data')->name('cater.desk.data');
        Route::get('addDesk', 'CaterDeskController@addDesk')->name('cater.desk.addDesk')->middleware('permission:cater.desk.addDesk'); //添加餐桌
        Route::any('saveDesk', 'CaterDeskController@saveDesk')->name('cater.desk.saveDesk')->middleware('permission:cater.desk.addDesk'); //保存餐桌
        Route::any('operate', 'CaterDeskController@operate')->name('cater.desk.operate')->middleware('permission:cater.desk.operate'); //删除餐桌，生成二维码
    });

    //订单管理
    Route::group(['prefix' => 'cater/orders/','middleware' => 'permission:cater.orders'], function () {
        Route::get('home', 'CaterOrdersController@index')->name('cater.orders.index'); //订单管理
        Route::get('data', 'CaterOrdersController@data')->name('cater.orders.data');
        Route::get('orderGoods', 'CaterOrdersController@orderGoods')->name('cater.orders.orderGoods')->middleware('permission:cater.orders.orderGoods'); //订单商品详情
        Route::any('operate', 'CaterOrdersController@operate')->name('cater.orders.operate')->middleware('permission:cater.orders.operate'); //订单操作
        Route::get('reject_refund', 'CaterOrdersController@reject_refund')->name('cater.orders.reject_refund')->middleware('permission:cater.orders.operate'); //订单拒绝退款页面
    });

    //用户管理
    Route::group(['prefix' => 'cater/users/','middleware' => 'permission:cater.users'], function () {
        Route::get('home', 'CaterUsersController@index')->name('cater.users.index'); //用户管理
        Route::get('data', 'CaterUsersController@data')->name('cater.users.data');
        Route::any('data_log', 'CaterUsersController@data_log')->name('cater.users.data_log');
        Route::any('add_currency', 'CaterUsersController@add_currency')->name('cater.users.add_currency')->middleware('permission:cater.users.add_currency'); //购物币充值
        Route::any('save_currency', 'CaterUsersController@save_currency')->name('cater.users.save_currency')->middleware('permission:cater.users.add_currency'); //购物币保存
        Route::get('currency_log', 'CaterUsersController@currency_log')->name('cater.users.currency_log')->middleware('permission:cater.users.add_currency'); //购物币日志
    });

    //小程序管理
    Route::group(['prefix' => 'cater/system/','middleware' => 'permission:cater.system'], function () {
        Route::get('home', 'CaterSystemController@index')->name('cater.system.index'); //小程序管理
        Route::any('upload', 'CaterSystemController@upload')->name('cater.system.upload'); //上传证书
        Route::any('saveSystem', 'CaterSystemController@saveSystem')->name('cater.system.saveSystem'); //保存信息
    });

    //统计管理
    Route::group(['prefix' => 'cater/statistics/','middleware' => 'permission:cater.statistics'], function () {
        Route::get('home', 'CaterStatisticsController@index')->name('cater.statistics.index'); //统计管理
    });
});

