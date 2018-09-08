<script>
    layui.use(['layer', 'form', 'upload', 'element'], function () {
        var form = layui.form
            , layer = layui.layer
            , element = layui.element
            , upload = layui.upload;

        //上传图片
        var tag_token = $(".tag_token").val();

        upload.render({
            elem: '#preview_cert_id'
            , url: '{{ route("cater.system.upload") }}'
            , accept: 'file' //普通文件
            , exts: 'pem' //只允许上传证书
            , size: 1024 //限制文件大小，单位 KB
            , data: {'_token': tag_token}
            , done: function (res) {
                if (res.errcode) {
                    $("#apiclient_cert").val(res.path)
                    $('#apiclient_cert_p').html(res.path);
                } else {
                    layer.msg("上传失败", {icon: 2}, 1500);
                }
            }
            , error: function (res) {
                console.log(res)
            }
        });

        upload.render({
            elem: '#preview_key_id'
            , url: '{{ route("cater.system.upload") }}'
            , accept: 'file' //普通文件
            , exts: 'pem' //只允许上传证书
            , size: 1024 //限制文件大小，单位 KB
            , data: {'_token': tag_token}
            , done: function (res) {
                if (res.errcode) {
                    $("#apiclient_key").val(res.path)
                    $('#apiclient_key_p').html(res.path);
                } else {
                    layer.msg("上传失败", {icon: 2}, 1500);
                }
            }
            , error: function (res) {
                console.log(res)
            }
        });
    });

    //提交
    function check_submit() {
        var id = $("#id").val();
        var appid = $("#appid").val();
        var appsecret = $("#appsecret").val();
        var mch_id = $("#mch_id").val();
        var apiclient_cert = $("#apiclient_cert").val();
        var apiclient_key = $("#apiclient_key").val();

        if (appid == "" || appid == null) {
            layer.msg("appid不能为空", {icon: 2}, 1500);
            return false;
        }

        if (appsecret == "" || appsecret == null) {
            layer.msg("appsecret不能为空", {icon: 2}, 1500);
            return false;
        }

        if (mch_id == "" || mch_id == null) {
            layer.msg("商户号不能为空", {icon: 2}, 1500);
            return false;
        }

        if (apiclient_cert == "" || apiclient_cert == null) {
            layer.msg("请上传apiclient_cert", {icon: 2}, 1500);
            return false;
        }

        if (apiclient_key == "" || apiclient_key == null) {
            layer.msg("请上传apiclient_key", {icon: 2}, 1500);
            return false;
        }
    }
</script>