@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
        </div>
    </div>
@endsection

@section('script')
    @can('sendLog')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 800
                    ,limit:18
                    ,url: "{{ route('send_log_data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: '序号', sort: true,width:80,align:'center'}
                        ,{field: 'send_to', title: '发送对象',width:160,align:'center'}
                        ,{field: 'content', title: '发送内容',width:700,align:'center'}
                        ,{field: 'is_success', title: '发送状态',width:160,align:'center'}
                        ,{field: 'send_time', title: '发送时间',width:160,align:'center'}
                        ,{field: 'remark', title: '备注',align:'center'}
                    ]],done:function(res, curr, count){  //res 接口返回的信息
                        $("[data-field = 'is_success']").children().each(function(){
                            if($(this).text() == '1'){
                                $(this).text("成功");
                            }else if($(this).text() == '0'){
                                $(this).text("失败");
                            }

                            $("[data-field = 'send_time']").children().each(function(){
                                if( $(this).text() != '发送时间'){
                                    console.log(parseInt($(this).text()));
                                    $(this).text(formatDate(parseInt($(this).text())));
                                }
                            })
                        })
                    }
                });
            });
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