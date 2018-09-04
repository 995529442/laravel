<script>
    layui.use(['layer', 'form', 'element'], function () {
        var form = layui.form
            , layer = layui.layer
            , element = layui.element


        form.on('switch(is_on_box)', function (data) {
            if (this.checked) {
                $("#is_on").val(1);
            } else {
                $("#is_on").val(0);
            }
        });

    });

    //提交表单
    function check_submit() {
        var template_id = $("#template_id").val();
        var type = $("#type").val();

        if (template_id == "" || template_id == null) {
            layer.msg('模板ID不能为空', {icon: 2}, 1500);
            return false;
        }
        if (type == "" || type == 0) {
            layer.msg('请选择类型', {icon: 2}, 1500);
            return false;
        }
    }
</script>