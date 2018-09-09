@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('cater.desk.addDesk')
                    <a class="layui-btn layui-btn-sm" href="{{ route('cater.desk.addDesk') }}">添加</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('cater.desk.operate')
                        <a class="layui-btn layui-btn-sm" lay-event="qr_code">生成二维码</a>
                    @endcan
                    @can('cater.desk.addDesk')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('cater.desk.operate')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
            <script type="text/html" id="img_path">
                <a href="@{{d.img_path}}" target="_blank" title="点击查看"><img src="@{{d.img_path}}" alt="" width="28" height="28"></a>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('cater.desk')
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
                    ,url: "{{ route('cater.desk.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {field: 'id', title: '序号', sort: true,width:80, align:'center'}
                        ,{field: 'name', title: '桌号', align:'center'}
                        ,{field: 'img_path', title: '二维码',templet: '#img_path', align:'center'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('cater.desk.operate') }}",{_method:'delete',desk_id:data.id,type:'del'},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '{{ route('cater.desk.addDesk') }}?desk_id='+data.id;
                    }else if(layEvent === 'qr_code'){
                        layer.confirm('确认生成二维码吗？', function(index){
                            $.post("{{ route('cater.desk.operate') }}",{_method:'delete',desk_id:data.id,type:'qr_code'},function (result) {
                                if (result.code==0){
                                    location.reload();
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    }
                });
            });
        </script>
    @endcan
@endsection