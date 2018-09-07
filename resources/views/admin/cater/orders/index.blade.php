@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>
            </div>
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
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('cater.orders.operate')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                </div>
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
                    ,height: 600
                    ,url: "{{ route('cater.orders.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {field: 'id', title: 'ID', sort: true,width:50, align:'center'}
                        ,{field: 'batchcode', title: '订单号',width:180, align:'center'}
                        ,{field: 'weixin_name', title: '用户',width:180, align:'center'}
                        ,{field: 'phone', title: '联系方式',width:180, align:'center'}
                        ,{field: 'type', title: '订单类型',width:100, align:'center'}
                        ,{field: 'pay_type', title: '支付状态',width:100, align:'center'}
                        ,{field: 'status', title: '订单状态',width:100, align:'center'}
                        ,{field: 'real_pay', title: '支付金额',width:100, align:'center'}
                        ,{field: 'total_num', title: '数量',width:100, align:'center'}
                        ,{field: 'create_time', title: '下单时间',width:150,align:'center'}
                        ,{field: 'remark', title: '留言', align:'center'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
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

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'edit'){
                        location.href = '{{ route('cater.goods.add_goods') }}?goods_id='+data.id;
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

            function formatDate(time){
                console.log(typeof time);
                console.log(time);
                time= time*1000;
                var date = new Date(time);

                var year = date.getFullYear(),
                    month = date.getMonth() + 1,//月份是从0开始的
                    day = date.getDate(),
                    hour = date.getHours(),
                    min = date.getMinutes(),
                    sec = date.getSeconds();
                console.log(year);
                var newTime = year + '-' +
                    month + '-' +
                    day + ' ' +
                    hour + ':' +
                    min + ':' +
                    sec;
                return newTime;
            }
        </script>
    @endcan
@endsection