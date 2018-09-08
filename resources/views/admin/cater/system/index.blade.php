@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>小程序管理</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('cater.system.saveSystem')}}" method="post" onsubmit="return check_submit();">
                @include('admin.cater.system._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.cater.system._js')
@endsection