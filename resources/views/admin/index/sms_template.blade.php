@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">
                @can('addSmsTemplate')
                    <a class="layui-btn layui-btn-sm" href="{{ route('addSmsTemplate') }}">添加</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('testSms')
                        <a class="layui-btn layui-btn-sm" lay-event="test">发送测试</a>
                    @endcan
                    @can('addSmsTemplate')
                      <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('delSmsTemplate')
                       <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('cater.category')
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
                    ,url: "{{ route('sms_data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {field: 'id', title: '序号', sort: true,width:80, align:'center'}
                        ,{field: 'template_id', title: '模板ID', align:'center'}
                        ,{field: 'type', title: '类型', align:'center'}
                        ,{field: 'is_on', title: '是否启用', align:'center'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options', align:'center'}
                    ]],done:function(res, curr, count){  //res 接口返回的信息
                        $("[data-field = 'type']").children().each(function(){
                            if($(this).text() == '1'){
                                $(this).text("验证通知");
                            }else if($(this).text() == '2'){
                                $(this).text("下单通知");
                            }
                        })

                        $("[data-field = 'is_on']").children().each(function(){
                            if($(this).text() == '0'){
                                $(this).text("关闭");
                            }else if($(this).text() == '1'){
                                $(this).text("开启");
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
                            $.post("{{ route('delSmsTemplate') }}",{_method:'delete',sms_template_id:data.id},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '{{ route('addSmsTemplate') }}?sms_template_id='+data.id;
                        // location.href = '/admin/position/'+data.id+'/edit';
                    }else if(layEvent === 'test'){
                        location.href = '{{ route('testSms') }}?type='+data.type;
                    }
                });
            });
        </script>
    @endcan
@endsection