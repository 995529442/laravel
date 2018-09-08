@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>测试短信，请输入要测试的手机号码</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{ route('testSms') }}" method="post" onsubmit="return check_submit();">
                <input type="hidden" name="_token" class="tag_token" value="{{ csrf_token() }}">
                <input type="hidden" name="type" id="type" value="{{$type}}">
                <div class="layui-form-item">
                    <label class="layui-form-label">手机号码：</label>
                    <div class="layui-input-block">
                        <input type="text" name="phone" id="phone" value="" autocomplete="off" class="layui-input"
                               style="width:20%">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                        <a  class="layui-btn" href="{{route('smsTemplate')}}" >返 回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
<script>
    function check_submit() {
        var phone = $("#phone").val();

        if (phone == "" || phone == null) {
            layer.msg('手机号码不能为空', {icon: 2}, 1500);
            return false;
        }
    }
</script>