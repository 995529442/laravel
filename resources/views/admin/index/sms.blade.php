@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>短信管理</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{ route('saveSms') }}" method="post" onsubmit="return check_submit();">
                @include('admin.index.sms_form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.index.sms_js')
@endsection