@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加短信模板</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('saveSmsTemplate')}}" method="post" onsubmit="return check_submit();">
                @include('admin.index.add_temp_form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.index.add_temp_js')
@endsection