<script>
    //减去时间段
    function minu_time(obj) {
        var num = 0;
        $("input[name='name[]']").each(function () {
            num++;
        })

        if (num == 1) {
            layer.msg('请至少输入一个邮箱账号', {icon: 2}, 1500);
        } else {
            $(obj).parent().parent().remove();
        }
    }

    //加上时间段
    function add_time() {
        var innerHtml = "";
        innerHtml += '<div class="layui-input-block">';
        innerHtml += '  <input type="text" name="name[]" id="name" autocomplete="off" class="layui-input" value="" style="display:inline-block;width:20%;">';
        innerHtml += '  <div class="layui-inline">';
        innerHtml += '      <button type="button" class="layui-btn layui-btn-normal layui-btn-xs" style="width:36px;height:36px;background-color:#FF6600;" onclick="minu_time(this);">-</button>';
        innerHtml += '      <button type="button" class="layui-btn layui-btn-normal layui-btn-xs" style="width:36px;height:36px;" onclick="add_time();">+</button>';
        innerHtml += '  </div>';
        innerHtml += '</div>';
        $("#name_div").append(innerHtml);
    }

    function check_submit() {
        var password = $("#password").val();
        var is_mail_null = 0;
        var is_mail_check = 0;

        if (password == "") {
            layer.msg('授权码不能为空', {icon: 2}, 1500);
            return false;
        }
        $("input[name='name[]']").each(function () {
            var mail_name = $(this).val();

            if (mail_name == "") {
                $is_mail_null = 1;
            }

            if (!(/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/.test(mail_name))) {
                is_mail_check = 1;
            }
        })

        if (is_mail_null == 1) {
            layer.msg('邮箱账号不能为空', {icon: 2}, 1500);
            return false;
        }

        if (is_mail_check == 1) {
            layer.msg('邮箱账号格式不正确', {icon: 2}, 1500);
            return false;
        }
    }
</script>