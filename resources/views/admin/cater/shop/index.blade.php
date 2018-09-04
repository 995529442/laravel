@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>餐厅管理</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('cater.shop.saveShop')}}" method="post" onsubmit="return check_submit();">
                @include('admin.cater.shop._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.cater.shop._js')
@endsection