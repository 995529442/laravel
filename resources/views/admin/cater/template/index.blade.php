@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('cater.template.addTemplate')
                    <a class="layui-btn layui-btn-sm" href="{{ route('cater.template.addTemplate') }}">添加</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('cater.template.addTemplate')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('cater.template.delTemplate')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('cater.template')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 500
                    ,url: "{{ route('cater.template.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                         {checkbox: true,fixed: true}
                        ,{field: 'id', title: '序号', sort: true,width:80}
                        ,{field: 'template_id', title: '模板id'}
                        ,{field: 'type', title: '类型'}
                        ,{field: 'is_on', title: '是否启用'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
                    ]],done:function(res, curr, count){  //res 接口返回的信息

                        $("[data-field = 'is_on']").children().each(function(){

                            if($(this).text() == '1'){

                                $(this).text("启用");

                            }else if($(this).text() == '0'){

                                $(this).text("关闭");
                            }
                        })

                        $("[data-field = 'type']").children().each(function(){

                            if($(this).text() == '1'){

                                $(this).text("支付通知");

                            }
                        })
                    }
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('cater.template.delTemplate') }}",{_method:'delete',temp_id:data.id},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '{{ route('cater.template.addTemplate') }}?template_id='+data.id;
                       // location.href = '/admin/position/'+data.id+'/edit';
                    }
                });
            });
        </script>
    @endcan
@endsection