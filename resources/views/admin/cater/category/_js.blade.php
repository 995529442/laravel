<script>
    function check_submit() {
        var cate_id = $("#cate_id").val();
        var cate_name = $("#cate_name").val();
        var sort = $("#sort").val();

        if (cate_name == "" || cate_name == null) {
            layer.msg('分类名称不能为空', {icon: 2}, 1500);
            return false;
        }
        if (cate_name.length > 20) {
            layer.msg('分类名称长度不能大于20个字符', {icon: 2}, 1500);
            return false;
        }
        if (sort == "" || sort == null) {
            layer.msg('排序不能为空', {icon: 2}, 1500);
            return false;
        }
        if (sort < 0) {
            layer.msg('排序不能小于0', {icon: 2}, 1500);
            return false;
        }

    }
</script>