@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>购物币充值</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{ route('cater.users.save_currency') }}" method="post" onsubmit="return check_submit();">
                {{csrf_field()}}
                <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}">
                <div class="layui-form-item">
                    <label class="layui-form-label">充值金额：</label>
                    <div class="layui-input-block">
                        <input type="text" name="money" id="money" value="" oninput="clearNoNum(this)" autocomplete="off"
                               class="layui-input" style="width:60%">
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                        <a  class="layui-btn" href="{{route('cater.users.index')}}" >返 回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
<script>
    function check_submit() {
        var user_id = $("#user_id").val();
        var money = $("#money").val();

        if (money == "" || money == null) {
            layer.msg('充值金额不能为空', {icon: 2}, 1500);
            return false;
        }

        if (money <= 0) {
            layer.msg('充值金额必须大于0', {icon: 2}, 1500);
            return false;
        }
    }

    function clearNoNum(obj) {
        obj.value = obj.value.replace(/[^\d.]/g, "");  //清除“数字”和“.”以外的字符
        obj.value = obj.value.replace(/\.{2,}/g, "."); //只保留第一个. 清除多余的
        obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, '$1$2.$3');//只能输入两个小数
        if (obj.value.indexOf(".") < 0 && obj.value != "") {//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额
            obj.value = parseFloat(obj.value);
        }
    }
</script>