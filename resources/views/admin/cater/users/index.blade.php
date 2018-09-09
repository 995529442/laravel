@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <label for="" class="layui-form-label">微信名称：</label>
                    <div class="layui-input-block">
                        <input type="text" name="weixin_name" id="weixin_name" placeholder="请输入微信名称" class="layui-input">
                    </div>
                </div>
                <div class="layui-input-inline">
                    <label for="" class="layui-form-label">联系方式：</label>
                    <div class="layui-input-block">
                        <input type="text" name="phone" id="phone" placeholder="请输入联系方式" class="layui-input">
                    </div>
                </div>
                <div class="layui-input-inline">
                    <label for="" class="layui-form-label">性别：</label>
                    <div class="layui-input-block">
                        <select name="sex" id="sex" lay-filter="sex">
                            <option value="0">全部</option>
                            <option value="1">男</option>
                            <option value="2">女</option>
                        </select>
                    </div>
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="headimgurl">
                <a href="@{{d.headimgurl}}" target="_blank" title="点击查看"><img src="@{{d.headimgurl}}" alt="" width="28" height="28"></a>
            </script>
            <script type="text/html" id="address">
                @{{d.province}}@{{d.city}}@{{d.country}}@{{d.address}}
            </script>
            <script type="text/html" id="operate">
                @can('cater.users.add_currency')
                <a href='{{route("cater.users.add_currency")}}?user_id=@{{d.id}}' class="layui-btn layui-btn-normal layui-btn-sm" >
                    购物币充值
                </a>
                @endcan
            </script>
            <script type="text/html" id="currency_money">
                @can('cater.users.add_currency')
                <a href="{{ route('cater.users.currency_log') }}?user_id=@{{d.id}}"
                   style="color:#1E9FFF;">@{{d.currency_money}}</a>
                @else
                @{{d.currency_money}}
                @endcan
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('cater.users')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 720
                    ,limit:16
                    ,url: "{{ route('cater.users.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {field: 'id', title: 'ID', sort: true,width:50, align:'center'}
                        ,{field: 'weixin_name', title: '微信名称',width:180, align:'center'}
                        ,{field: 'headimgurl', title: '头像',width:100, align:'center',templet: '#headimgurl'}
                        ,{field: 'openid', title: '微信openid',width:280, align:'center'}
                        ,{field: 'currency_money', title: '购物币金额',width:100, align:'center',templet: '#currency_money'}
                        ,{field: 'mobile', title: '联系方式',width:130, align:'center'}
                        ,{field: 'sex', title: '性别',width:80, align:'center'}
                        ,{field: 'address', title: '用户地址',width:200, align:'center',templet: '#address'}
                        ,{field: 'order_complete_num', title: '完成订单总数量',width:130, align:'center'}
                        ,{field: 'order_num', title: '订单总数量',width:100,align:'center'}
                        ,{field: 'total_money', title: '完成订单总金额', align:'center'}
                        ,{field: '', title: '操作', align:'center',templet: '#operate'}
                    ]],done:function(res, curr, count){  //res 接口返回的信息
                        $("[data-field = 'sex']").children().each(function(){
                            if($(this).text() != '性别'){
                                if($(this).text() == '1'){
                                    $(this).text("男");
                                }else if($(this).text() == '2'){
                                    $(this).text("女");
                                }else{
                                    $(this).text("未知");
                                }
                            }
                        })
                    }
                });

                //搜索
                $("#searchBtn").click(function () {
                    var weixin_name = $("#weixin_name").val()
                    var mobile = $("#mobile").val();
                    var sex = $("#sex").val();

                    dataTable.reload({
                        where:{weixin_name:weixin_name,mobile:mobile,sex:sex},
                        page:{curr:1}
                    })
                })
            })
        </script>
    @endcan
@endsection