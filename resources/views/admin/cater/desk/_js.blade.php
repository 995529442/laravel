<script>
    function put_submit() {
        var desk_id = $("#desk_id").val();
        var name = $("#name").val();

        if (name == "" || name == null) {
            layer.msg('分类名称不能为空', {icon: 2}, 1500);
            return;
        }
        if (name.length > 20) {
            layer.msg('分类名称长度不能大于20个字符', {icon: 2}, 1500);
            return;
        }
    }
</script>