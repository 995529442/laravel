@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加餐桌</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('cater.desk.saveDesk')}}" method="post" onsubmit="return check_submit();">
                @include('admin.cater.desk._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.cater.desk._js')
@endsection