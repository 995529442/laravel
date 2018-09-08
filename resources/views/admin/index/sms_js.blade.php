<script>
    function check_submit() {
        var accountsid = $("#accountsid").val();
        var appid = $("#appid").val();
        var token = $("#token").val();

        if (accountsid == "") {
            layer.msg('accountsid不能为空', {icon: 2}, 1500);
            return false;
        }
        if (appid == "") {
            layer.msg('appid不能为空', {icon: 2}, 1500);
            return false;
        }
        if (token == "") {
            layer.msg('token不能为空', {icon: 2}, 1500);
            return false;
        }
    }
</script>