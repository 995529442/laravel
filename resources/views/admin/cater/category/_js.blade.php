<script>
    function put_submit() {
        var cate_id = $("#cate_id").val();
        var cate_name = $("#cate_name").val();
        var sort = $("#sort").val();

        if (cate_name == "" || cate_name == null) {
            layer.msg('分类名称不能为空', {icon: 2}, 1500);
            return;
        }
        if (cate_name.length > 20) {
            layer.msg('分类名称长度不能大于20个字符', {icon: 2}, 1500);
            return;
        }
        if (sort == "" || sort == null) {
            layer.msg('排序不能为空', {icon: 2}, 1500);
            return;
        }
        if (sort < 0) {
            layer.msg('排序不能小于0', {icon: 2}, 1500);
            return;
        }

        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "{{ route('cater.category.save_cate') }}",
            data: {cate_id: cate_id, cate_name: cate_name, sort: sort},
            dataType: "json",
            success: function (data) {
                if (data.errcode == 1) {
                    layer.msg(data.errmsg, {icon: 1}, function () {
                        window.parent.layer.closeAll();
                        window.parent.location.reload();
                    });
                } else {
                    layer.msg(data.errmsg, {icon: 2}, 1500);
                }
            }
        });
    }
</script>