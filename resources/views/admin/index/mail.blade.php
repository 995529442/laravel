@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>邮件管理</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{ route('saveMail') }}" method="post" onsubmit="return check_submit();">
                @include('admin.index.mail_form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.index.mail_js')
@endsection