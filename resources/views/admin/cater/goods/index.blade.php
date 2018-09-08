@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                @can('cater.goods.add_goods')
                    <a class="layui-btn layui-btn-sm" href="{{ route('cater.goods.add_goods') }}">添 加</a>
                @endcan
                <button class="layui-btn layui-btn-sm" id="searchBtn">搜 索</button>
            </div>
            <div class="layui-form" >
                <div class="layui-input-inline">
                    <label for="" class="layui-form-label">商品名称：</label>
                    <div class="layui-input-block">
                        <input type="text" name="good_name" id="good_name" placeholder="请输入商品名称" class="layui-input">
                    </div>
                </div>
                <div class="layui-input-inline">
                    <label for="" class="layui-form-label">商品状态：</label>
                    <div class="layui-input-block">
                        <select name="status" lay-verify="required" id="status">
                            <option value="0">全部</option>
                            <option value="1">热卖</option>
                            <option value="2">新品</option>
                            <option value="3">推荐</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('cater.goods.add_goods')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('cater.goods.del_goods')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
            <script type="text/html" id="thumb_img">
                <a href="@{{d.thumb_img}}" target="_blank" title="点击查看"><img src="@{{d.thumb_img}}" alt="" width="28" height="28"></a>
            </script>
            <script type="text/html" id="titleTpl">
                @{{#  if(d.is_hot == 1){ }}
                <button class="layui-btn layui-btn-normal layui-btn-sm">热卖</button>
                @{{#  } else { }}
                <button class="layui-btn layui-btn-primary layui-btn-sm">热卖</button>
                @{{#  } }}

                @{{#  if(d.is_new == 1){ }}
                <button class="layui-btn layui-btn-warm layui-btn-sm">新品</button>
                @{{#  } else { }}
                <button class="layui-btn layui-btn-primary layui-btn-sm">新品</button>
                @{{#  } }}

                @{{#  if(d.is_recommend == 1){ }}
                <button class="layui-btn layui-btn-danger layui-btn-sm">推荐</button>
                @{{#  } else { }}
                <button class="layui-btn layui-btn-primary layui-btn-sm">推荐</button>
                @{{#  } }}
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
                    ,url: "{{ route('cater.goods.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {field: 'id', title: 'ID', sort: true,width:50, align:'center'}
                        ,{field: 'good_name', title: '商品名称',width:150, align:'center'}
                        ,{field: 'cate_name', title: '所属分类',width:120, align:'center'}
                        ,{field: 'thumb_img', title: '缩略图',templet: '#thumb_img',width:100, align:'center'}
                        ,{field: 'storenum', title: '库存',sort: true,width:100, align:'center'}
                        ,{field: 'sell_count', title: '销量',sort: true,width:100, align:'center'}
                        ,{field: 'original_price', title: '原价',width:100, align:'center'}
                        ,{field: 'now_price', title: '现价',width:100, align:'center'}
                        ,{field: 'introduce', title: '介绍',width:250, align:'center'}
                        ,{field: 'isout', title: '上架状态',width:120, align:'center'}
                        ,{field: 'is_hot', title: '商品状态', templet: '#titleTpl', align:'center'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
                    ]],done:function(res, curr, count){  //res 接口返回的信息
                        $("[data-field = 'isout']").children().each(function(){
                            if($(this).text() == '1'){
                                $(this).text("下架");
                            }else if($(this).text() == '2'){
                                $(this).text("上架");
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
                            $.post("{{ route('cater.goods.del_goods') }}",{_method:'delete',goods_id:[data.id]},function (result) {
                                if (result.code==0){
                                    obj.del(); //删除对应行（tr）的DOM结构
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '{{ route('cater.goods.add_goods') }}?goods_id='+data.id;
                    }
                });
                //搜索
                $("#searchBtn").click(function () {
                    var status = $("#status").val()
                    var good_name = $("#good_name").val();
                    dataTable.reload({
                        where:{status:status,good_name:good_name},
                        page:{curr:1}
                    })
                })
            })
        </script>
    @endcan
@endsection