@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>首页管理</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('cater.home.save')}}" method="post" onsubmit="return check_submit();">
                @include('admin.cater.home._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.cater.home._js')
@endsection