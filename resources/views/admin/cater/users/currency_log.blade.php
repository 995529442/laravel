@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                 <a class="layui-btn layui-btn-sm" href="{{ route('cater.users.index') }}">返回</a>n
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
        </div>
    </div>
@endsection

@section('script')
    @can('cater.users.add_currency')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 600
                    ,url: "{{ route('cater.users.data_log') }}?user_id={{$user_id}}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {field: 'id', title: 'ID', sort: true,width:50, align:'center'}
                        ,{field: 'operate_from', title: '操作人',width:180, align:'center'}
                        ,{field: 'operate_to', title: '操作对象', align:'center'}
                        ,{field: 'remark', title: '备注', align:'center'}
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
            })
        </script>
    @endcan
@endsection