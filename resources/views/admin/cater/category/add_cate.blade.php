@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加分类</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('cater.category.save_cate')}}" method="post" onsubmit="return check_submit();">
                @include('admin.cater.category._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.cater.category._js')
@endsection