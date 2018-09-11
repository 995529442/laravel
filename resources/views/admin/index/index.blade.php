@extends('admin.base')

@section('content')
    <div class="layui-row layui-col-space15">

        <div class="layui-col-sm6 layui-col-md3">

            <div class="layui-card">

                <div class="layui-card-header">

                    总收入

                    <span class="layui-badge layui-bg-blue layuiadmin-badge">日</span>

                </div>

                <div class="layui-card-body layuiadmin-card-list">

                    <p class="layuiadmin-big-font">{{$day_money}}</p>

                    <p>

                        同比增长
                        <span class="layuiadmin-span-color">{{round($day_money-$yesterday_money,2)}}元<i class="layui-inline layui-icon layui-icon-dollar"></i></span>

                    </p>

                </div>

            </div>

        </div>

        <div class="layui-col-sm6 layui-col-md3">

            <div class="layui-card">

                <div class="layui-card-header">

                    总收入

                    <span class="layui-badge layui-bg-cyan layuiadmin-badge">周</span>

                </div>

                <div class="layui-card-body layuiadmin-card-list">

                    <p class="layuiadmin-big-font">{{$week_money}}</p>

                    <p>

                        同比增长

                        <span class="layuiadmin-span-color">{{round($week_money-$lastweek_money,2)}}元 <i class="layui-inline layui-icon layui-icon-dollar"></i></span>

                    </p>

                </div>

            </div>

        </div>

        <div class="layui-col-sm6 layui-col-md3">

            <div class="layui-card">

                <div class="layui-card-header">

                    总收入

                    <span class="layui-badge layui-bg-green layuiadmin-badge">月</span>

                </div>

                <div class="layui-card-body layuiadmin-card-list">



                    <p class="layuiadmin-big-font">{{$month_money}}</p>

                    <p>

                        同比增长

                        <span class="layuiadmin-span-color">{{round($month_money-$lastmonth_money,2)}}元 <i class="layui-inline layui-icon layui-icon-dollar"></i></span>

                    </p>

                </div>

            </div>

        </div>

        <div class="layui-col-sm6 layui-col-md3">

            <div class="layui-card">

                <div class="layui-card-header">

                    日订单数

                    <span class="layui-badge layui-bg-orange layuiadmin-badge">日</span>

                </div>

                <div class="layui-card-body layuiadmin-card-list">



                    <p class="layuiadmin-big-font">{{$day_num}}</p>

                    <p>

                        同比增长

                        <span class="layuiadmin-span-color">{{$day_num-$yesterday_num}}单<i class="layui-inline layui-icon layui-icon-dollar"></i></span>

                    </p>

                </div>

            </div>

        </div>

        <div class="layui-col-sm12">

            <div class="layui-card">

                <div class="layui-card-header">

                    订单趋势统计

                </div>

                <div class="layui-card-body">

                    <div class="layui-row">

                        <div class="layui-col-sm8" id="container">

{{--                            <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade" lay-filter="LAY-index-pagetwo">

                                <div carousel-item id="LAY-index-pagetwo">

                                    <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>

                                </div>

                            </div>--}}

                        </div>

                        <div class="layui-col-sm4">

                            <div class="layuiadmin-card-list">

                                <p class="layuiadmin-normal-font">日收入<span style="color:red;font-size:12px;">（注：绿色代表增加，红色代表减少）</span></p>

                                <span>
                                    @if($day_ratil > 0)
                                        同上期增长
                                    @else
                                        同上期减少
                                    @endif
                                </span>

                                <div class="layui-progress layui-progress-big" lay-showPercent="yes">
                                    @if($day_ratil > 0)
                                        <div class="layui-progress-bar" lay-percent="{{$day_ratil}}%"></div>
                                    @else
                                        <div class="layui-progress-bar layui-bg-red" lay-percent="{{abs($day_ratil)}}%"></div>
                                    @endif
                                </div>

                            </div>

                            <div class="layuiadmin-card-list">

                                <p class="layuiadmin-normal-font">周收入</p>

                                <span>
                                    @if($week_ratil > 0)
                                        同上期增长
                                    @else
                                        同上期减少
                                    @endif
                                </span>

                                <div class="layui-progress layui-progress-big" lay-showPercent="yes">
                                    @if($week_ratil > 0)
                                        <div class="layui-progress-bar" lay-percent="{{$week_ratil}}%"></div>
                                    @else
                                        <div class="layui-progress-bar layui-bg-red" lay-percent="{{abs($week_ratil)}}%"></div>
                                    @endif
                                </div>

                            </div>

                            <div class="layuiadmin-card-list">

                                <p class="layuiadmin-normal-font">月收入</p>

                                <span>
                                    @if($month_ratil > 0)
                                        同上期增长
                                    @else
                                        同上期减少
                                    @endif
                                </span>
                                <div class="layui-progress layui-progress-big" lay-showPercent="yes">
                                    @if($month_ratil > 0)
                                        <div class="layui-progress-bar" lay-percent="{{$month_ratil}}%"></div>
                                    @else
                                        <div class="layui-progress-bar layui-bg-red" lay-percent="{{abs($month_ratil)}}%"></div>
                                    @endif
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="layui-col-sm4">

            <div class="layui-card">

                <div class="layui-card-header">我的消息</div>

                <div class="layui-card-body">

                    <ul class="layuiadmin-card-status layuiadmin-home2-usernote">
                        @foreach($message as $v)
                        <li>

                            <h3>{{$v->title}}</h3>

                            <p>{{$v->content}}</p>

                            <span>{{$v->created_at}}</span>

                        </li>
                        @endforeach
                    </ul>

                </div>

            </div>

        </div>

        <div class="layui-col-sm8">

            <div class="layui-row layui-col-space15">

                <div class="layui-col-sm6">

                    <div class="layui-card">

                        <div class="layui-card-header">用户消费排行榜</div>

                        <div class="layui-card-body">

                            <table class="layui-table layuiadmin-page-table" lay-skin="line">

                                <thead>

                                <tr>

                                    <th>用户名</th>

                                    <th>手机号</th>

                                    <th>订单总数量</th>

                                    <th>消费总金额</th>

                                </tr>

                                </thead>

                                <tbody>
                                 @foreach($user_info as $k=>$v)
                                    <tr>
                                        <td>
                                            @if($k==0)
                                                <span class="first">{{$v->weixin_name}}</span>
                                            @elseif($k==1)
                                                <span class="second">{{$v->weixin_name}}</span>
                                             @elseif($k==2)
                                                <span class="third">{{$v->weixin_name}}</span>
                                            @else
                                                {{$v->weixin_name}}
                                            @endif

                                        </td>

                                        <td>{{$v->mobile}}</td>

                                        <td>{{$v->order_complete_num}}</td>

                                        <td><span class="first">{{$v->total_money}}</span></td>

                                    </tr>
                                @endforeach
                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

                <div class="layui-col-sm6">

                    <div class="layui-card">

                        <div class="layui-card-header">菜品销售排行榜</div>

                        <div class="layui-card-body">

                            <table class="layui-table layuiadmin-page-table" lay-skin="line">

                                <thead>

                                <tr>

                                    <th>菜品名称</th>

                                    <th>所属分类</th>

                                    <th>库存</th>

                                    <th>实际销量</th>

                                </tr>

                                </thead>

                                <tbody>
                                @foreach($goods_info as $k=>$v)
                                    <tr>
                                        <td>
                                            @if($k==0)
                                                <span class="first">{{$v->good_name}}</span>
                                            @elseif($k==1)
                                                <span class="second">{{$v->good_name}}</span>
                                            @elseif($k==2)
                                                <span class="third">{{$v->good_name}}</span>
                                            @else
                                                {{$v->good_name}}
                                            @endif

                                        </td>

                                        <td>{{$v->cate_name}}</td>

                                        <td>{{$v->storenum}}</td>

                                        <td><span class="first">{{$v->sell_count}}</span></td>

                                    </tr>
                                @endforeach
                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('script')
    <script src="https://img.hcharts.cn/highcharts/highcharts.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/series-label.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/oldie.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
    <script>
        layui.use(['index', 'sample']);
        var categories = '{{$categories}}';
        var categories_arr = new Array();

        var tangshi = '{{$tangshi}}';
        var tangshi_arr = new Array();

        var waimai = '{{$waimai}}';
        var waimai_arr = new Array();

        if(categories != ""){
            categories_arr = categories.split(",");
        }

        if(tangshi != ""){
            tangshi_arr = tangshi.split(",");
            for(var k=0;k<tangshi_arr.length;k++){
                tangshi_arr[k] = parseInt(tangshi_arr[k]);
            }
        }

        if(waimai != ""){
            waimai_arr = waimai.split(",");
            for(var kk=0;kk<waimai_arr.length;kk++){
                waimai_arr[kk] = parseInt(waimai_arr[kk]);
            }

        }

        var chart = Highcharts.chart('container', {
            chart: {
                type: 'line'
            },
            title: {
                text: '最近7天订单趋势统计'
            },
            subtitle: {
                text: '已完成订单数'
            },
            xAxis: {
                categories: categories_arr
            },
            yAxis: {
                title: {
                    text: '订单数(/笔)'
                }
            },
            credits:{
                enabled: false // 禁用版权信息
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        // 开启数据标签
                        enabled: true
                    },
                    // 关闭鼠标跟踪，对应的提示框、点击事件会失效
                    enableMouseTracking: false
                }
            },
            series: [{
                name: '外卖',
                data: waimai_arr
            }, {
                name: '点餐',
                data: tangshi_arr
            }]
        });
    </script>
@endsection