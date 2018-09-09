@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
{{--            <div class="layui-btn-group ">
                <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>
            </div>--}}
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <label for="" class="layui-form-label">订单号：</label>
                    <div class="layui-input-block">
                        <input type="text" name="batchcode" id="batchcode" placeholder="请输入订单号" class="layui-input">
                    </div>
                </div>
                <div class="layui-input-inline">
                    <label for="" class="layui-form-label">用户：</label>
                    <div class="layui-input-block">
                        <input type="text" name="weixin_name" id="weixin_name" placeholder="请输入用户" class="layui-input">
                    </div>
                </div>
                <div class="layui-input-inline">
                    <label for="" class="layui-form-label">联系方式：</label>
                    <div class="layui-input-block">
                        <input type="text" name="phone" id="phone" placeholder="请输入联系方式" class="layui-input">
                    </div>
                </div>
                <div class="layui-input-inline">
                    <label for="" class="layui-form-label">订单类型：</label>
                    <div class="layui-input-block">
                        <select name="type" id="type">
                            <option value="0">全部</option>
                            <option value="1">点餐</option>
                            <option value="2">外卖</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <label for="" class="layui-form-label">支付状态：</label>
                    <div class="layui-input-block">
                        <select name="pay_type" id="pay_type">
                            <option value="-1">全部</option>
                            <option value="0">未支付</option>
                            <option value="1">已支付</option>
                        </select>
                    </div>
                </div>
                <div class="layui-input-inline">
                    <div class="layui-input-inline">
                        <label for="" class="layui-form-label">订单状态：</label>
                        <div class="layui-input-block">
                            <select name="status" id="status">
                                <option value="-2">全部</option>
                                <option value="-1">已取消</option>
                                <option value="0">待付款</option>
                                <option value="1">待接单</option>
                                <option value="2">已接单</option>
                                <option value="3">配送中</option>
                                <option value="4">配送完成</option>
                                <option value="5">已完成</option>
                                <option value="6">申请退款</option>
                                <option value="7">已退款</option>
                                <option value="8">拒绝退款</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="operate">
                @can('cater.orders.operate')
                    @{{#  if(d.status == 0 && d.pay_type == 0){ }}
                    <button class="layui-btn layui-btn-normal layui-btn-sm" onclick="operate( @{{d.id}},'cancel')">取消订单
                    </button>
                    @{{#  } else if(d.status == 1 && d.pay_type == 1) { }}
                    <button class="layui-btn layui-btn-normal layui-btn-sm" onclick="operate(@{{d.id}},'accept')">接单
                    </button>
                    <button class="layui-btn layui-btn-normal layui-btn-sm" onclick="operate(@{{d.id}},'reject')">拒单
                    </button>
                    @{{#  } else if(d.status == 2 && d.pay_type == 1) { }}
                    <button class="layui-btn layui-btn-normal layui-btn-sm" onclick="operate(@{{d.id}},'send')">配送
                    </button>
                    @{{#  } else if(d.status == 3 && d.pay_type == 1) { }}
                    <button class="layui-btn layui-btn-normal layui-btn-sm" onclick="operate(@{{d.id}},'confirm_send')">配送完成
                    </button>
                    @{{#  } else if(d.status == 4 && d.pay_type == 1) { }}
                    <button class="layui-btn layui-btn-normal layui-btn-sm" onclick="operate(@{{d.id}},'confirm')">完成
                    </button>
                    @{{#  } else if(d.status == 6 && d.pay_type == 1) { }}
                    <button class="layui-btn layui-btn-normal layui-btn-sm"
                            onclick="operate(@{{d.id}},'confirm_refund')">确认退款
                    </button>
                    <button class="layui-btn layui-btn-normal layui-btn-sm"
                            onclick="operate(@{{d.id}},'reject_refund')">拒绝退款
                    </button>
                    @{{#  } }}
                @endcan
            </script>
            <script type="text/html" id="operate1">
                @can('cater.orders.orderGoods')
                  <a href="orderGoods?order_id=@{{d.id}}" style="color:#1E9FFF;">@{{d.batchcode}}</a>
                @else
                  @{{d.batchcode}}
                @endcan
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('cater.goods')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 690
                    ,limit:15
                    ,url: "{{ route('cater.orders.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {field: 'id', title: 'ID', sort: true,width:50, align:'center'}
                        ,{field: 'batchcode', title: '订单号',width:180, align:'center',templet: '#operate1'}
                        ,{field: 'weixin_name', title: '用户',width:160, align:'center'}
                        ,{field: 'phone', title: '联系方式',width:160, align:'center'}
                        ,{field: 'type', title: '订单类型',width:100, align:'center'}
                        ,{field: 'pay_type', title: '支付状态',width:100, align:'center'}
                        ,{field: 'status', title: '订单状态',width:100, align:'center'}
                        ,{field: 'real_pay', title: '支付金额',width:100, align:'center'}
                        ,{field: 'total_num', title: '数量',width:78, align:'center'}
                        ,{field: 'create_time', title: '下单时间',width:180,align:'center'}
                        ,{field: 'remark', title: '留言',width:220, align:'center'}
                        ,{field: '', title: '操作', align:'center',width:250,templet: '#operate'}
                    ]],done:function(res, curr, count){  //res 接口返回的信息
                        $("[data-field = 'type']").children().each(function(){
                            if($(this).text() == '1'){
                                $(this).text("点餐");
                            }else if($(this).text() == '2'){
                                $(this).text("外卖");
                            }
                        })

                        $("[data-field = 'pay_type']").children().each(function(){
                            if($(this).text() == '0'){
                                $(this).text("未支付");
                            }else if($(this).text() == '1'){
                                $(this).text("已支付");
                            }
                        })

                        $("[data-field = 'status']").children().each(function(){
                            if($(this).text() == '-1'){
                                $(this).text("已取消");
                            }else if($(this).text() == '0'){
                                $(this).text("待付款");
                            }else if($(this).text() == '1'){
                                $(this).text("待接单");
                            }else if($(this).text() == '2'){
                                $(this).text("已接单");
                            }else if($(this).text() == '3'){
                                $(this).text("配送中");
                            }else if($(this).text() == '4'){
                                $(this).text("配送完成");
                            }else if($(this).text() == '5'){
                                $(this).text("已完成");
                            }else if($(this).text() == '6'){
                                $(this).text("退款中");
                            }else if($(this).text() == '7'){
                                $(this).text("已退款");
                            }else if($(this).text() == '8'){
                                $(this).text("拒绝退款");
                            }else if($(this).text() == '9'){
                                $(this).text("已拒单");
                            }
                        })

                        $("[data-field = 'create_time']").children().each(function(){
                            if( $(this).text() != '下单时间'){
                                $(this).text(formatDate(parseInt($(this).text())));
                            }
                        })
                    }
                });

                //搜索
                $("#searchBtn").click(function () {
                    var batchcode = $("#batchcode").val()
                    var weixin_name = $("#weixin_name").val();
                    var phone = $("#phone").val();
                    var type = $("#type").val();
                    var pay_type = $("#pay_type").val();
                    var status = $("#status").val();

                    dataTable.reload({
                        where:{batchcode:batchcode,weixin_name:weixin_name,phone:phone,
                            type:type,pay_type:pay_type,status:status},
                        page:{curr:1}
                    })
                })
            })

            //订单操作
            function operate(order_id, type) {
                var msg = "";

                if (type == "accept") {
                    msg = "确定要接单？";
                } else if (type == "reject") {
                    msg = "确定要拒单，并返还金额给用户？";
                } else if (type == "send") {
                    msg = "确定要配送？";
                } else if (type == "confirm_send") {
                    msg = "确定要配送完成？";
                } else if (type == "confirm") {
                    msg = "确定要完成？";
                } else if (type == "confirm_refund") {
                    msg = "确定要退款？";
                } else if (type == "reject_refund") {
                    layer.open({
                        type: 2,
                        title: false,
                        shadeClose: false,
                        shade: 0.1,
                        area: ['500px', '265px'],
                        content: 'reject_refund?order_id=' + order_id,
                        end: function () {

                        }
                    });
                    return;
                } else if (type == "cancel") {
                    msg = "确定要取消该订单？";
                }
                if (order_id > 0) {
                    layer.confirm(msg, {
                        btn: ['确定', '取消'] //按钮
                    }, function () {
                        $.ajax({
                            type: "POST",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: "{{ route('cater.orders.operate') }}",
                            data: {order_id: order_id, type: type},
                            dataType: "json",
                            success: function (data) {
                                if (data.errcode == 1) {
                                    layer.msg(data.errmsg, {icon: 1}, function () {
                                        location.reload();
                                    });
                                } else {
                                    layer.msg(data.errmsg, {icon: 2}, 1500);
                                }
                            }
                        });
                    }, function () {

                    });
                }
            }
            function formatDate(time){
                var time= time*1000;
                var date = new Date(time);

                var year = date.getFullYear(),
                    month = date.getMonth() + 1,//月份是从0开始的
                    day = date.getDate(),
                    hour = date.getHours(),
                    min = date.getMinutes(),
                    sec = date.getSeconds();

                month = formatTime(month);
                day = formatTime(day);
                hour = formatTime(hour);
                min = formatTime(min);
                sec = formatTime(sec);

                var newTime = year + '-' +
                    month + '-' +
                    day + ' ' +
                    hour + ':' +
                    min + ':' +
                    sec;
                return newTime;
            }

            function formatTime(time){
                if(time < 10){
                    time = "0" + time;
                }
                return time;
            }
        </script>
    @endcan
@endsection