@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加菜品</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('cater.goods.save_goods')}}" method="post" onsubmit="return check_submit();">
                @include('admin.cater.goods._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.cater.goods._js')
@endsection