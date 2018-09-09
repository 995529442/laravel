<script>
    layui.use(['form','upload','laydate'],function () {
        var form = layui.form
            ,upload = layui.upload
            ,laydate = layui.laydate;

        //监听指定开关
        form.on('switch(is_eat_in_box)', function (data) {
            if (this.checked) {
                $("#is_eat_in").val(2);
            } else {
                $("#is_eat_in").val(1);
            }
        });

        form.on('switch(is_take_out_box)', function (data) {
            if (this.checked) {
                $("#is_take_out").val(2);
                $("#take_out").show();
                $("#take_out_delivery").show();
            } else {
                $("#is_take_out").val(1);
                $("#take_out").hide();
                $("#take_out_delivery").hide();
            }
        });

        form.on('switch(is_open_currency_box)', function (data) {
            if (this.checked) {
                $("#is_open_currency").val(1);
            } else {
                $("#is_open_currency").val(0);
            }
        });

        form.on('switch(is_open_sms_box)', function (data) {
            if (this.checked) {
                $("#is_open_sms").val(1);
            } else {
                $("#is_open_sms").val(0);
            }
        });

        form.on('switch(is_open_mail_box)', function (data) {
            if (this.checked) {
                $("#is_open_mail").val(1);
                $("#open_mail").show();
            } else {
                $("#is_open_mail").val(0);
                $("#open_mail").hide();
            }
        });

        //日期
        laydate.render({
            elem: '#begin_time'
            , type: 'time'
        });
        laydate.render({
            elem: '#end_time'
            , type: 'time'
        });

        //获取城市
        form.on('select(provid)', function (data) {
            var provid = data.value;

            //重置县区
            $("#areaid").html('<option value="0">请选择县/区</option>');

            if (provid > 0) { //选择省份，遍历城市
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('cater.shop.getAddress') }}",
                    data: {provid: provid},
                    dataType: "json",
                    success: function (data) {
                        if (data != "" && data != null) {
                            var innerHtml = '<option value="0">请选择市</option>';
                            for (var key in data) {
                                innerHtml += '<option value="' + data[key]['id'] + '">' + data[key]['name'] + '</option>';
                            }
                            $("#cityid").html(innerHtml);

                            form.render('select');
                        }
                    }
                });
            }
        });

        //获取县区
        form.on('select(cityid)', function (data) {
            var cityid = data.value;
            if (cityid > 0) { //选择省份，遍历城市
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('cater.shop.getAddress') }}",
                    data: {cityid: cityid},
                    dataType: "json",
                    success: function (data) {
                        if (data != "" && data != null) {
                            var innerHtml = '<option value="0">请选择县/区</option>';
                            for (var key in data) {
                                innerHtml += '<option value="' + data[key]['id'] + '">' + data[key]['name'] + '</option>';
                            }
                            $("#areaid").html(innerHtml);

                            form.render('select');
                        }
                    }
                });
            }
        });
        //上传图片
        var tag_token = $(".tag_token").val();

        var uploadInst = upload.render({
            elem: '#preview_logo_id'
            , url: '{{ route("cater.shop.upload") }}'
            , accept: 'file' //普通文件
            , exts: 'jpg|png|gif|bmp|jpeg' //只允许上传图片文件
            , size: 1024 //限制文件大小，单位 KB
            , data: {'_token': tag_token}
            , before: function (obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function (index, file, result) {
                    $('#preview_logo').css('width', '100px'); //图片链接（base64）
                    $('#preview_logo').css('height', '100px'); //图片链接（base64）
                    $('#preview_logo').attr('src', result); //图片链接（base64）
                });
            }
            , done: function (res) {
                console.log(res)
                var errcode = res.errcode;

                if (errcode == 1) {
                    $("#logo").val(res.path);
                }
            }
            , error: function (res) {
                console.log(res)
            }
        });

        //多图片上传
        upload.render({
            elem: '#figure_img'
            , url: '{{ route("cater.shop.upload") }}'
            , multiple: true
            , accept: 'file' //普通文件
            , exts: 'jpg|png|gif|bmp|jpeg' //只允许上传图片文件
            , size: 1024 //限制文件大小，单位 KB
            , data: {'_token': tag_token, type: 'figure'}
            , before: function (obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function (index, file, result) {

                });
            }
            , done: function (res) {
                if (res.errcode == 1) {
                    lis = $("#preview_figure ul li").length;

                    if (lis < 3) {
                        $('#preview_figure ul').append('<li style="display:inline-block;"><input type="hidden" name="figure_img_id[]" value="0"><input type="hidden" name="figure_img[]" value="' + res.path + '"><img style="width:150px;height:100px;" src="' + res.path + '" alt="' + res.path + '" class="layui-upload-img"><div style="display:inline-block;position:relative;top:-40px;width:20px;border:1px solid #F73455;border-radius: 50%;cursor: pointer;"><p style="padding-left:4px;color:#F73455;" onclick="del_figure_img(this,0)">X</p></div></li>')
                    } else {
                        layer.msg("商家展示图最多为3张", {icon: 2}, 1500);
                    }
                }
                //上传完毕
            }
        });
    })

    //提交判断
    function check_submit() {
        var name = $("#name").val();
        var begin_time = $("#begin_time").val();
        var end_time = $("#end_time").val();
        var provid = $("#provid").val();
        var cityid = $("#cityid").val();
        var areaid = $("#areaid").val();
        var address = $("#address").val();
        var longitude = $("#longitude").val();
        var latitude = $("#latitude").val();
        var latitude = $("#latitude").val();
        var phone = $("#phone").val();
        var logo = $("#logo").val();
        var is_eat_in = $("#is_eat_in").val();
        var is_take_out = $("#is_take_out").val();
        var delivery_km = $("#delivery_km").val();
        var is_open_mail = $("#is_open_mail").val();
        var shop_mail = $("#shop_mail").val();

        if (name == "" || name == null) {
            layer.msg('餐厅名称不能为空', {icon: 2}, 1500);
            return false;
        }
        if (is_eat_in == 0 && is_take_out == 0) {
            layer.msg('堂食和外卖请至少开启一个', {icon: 2}, 1500);
            return false;
        }
        if (is_take_out == 1 && delivery_km == "") {
            layer.msg('配送范围不能为空', {icon: 2}, 1500);
            return false;
        }
        if (begin_time == "" || begin_time == null) {
            layer.msg('营业开始时间不能为空', {icon: 2}, 1500);
            return false;
        }
        if (end_time == "" || end_time == null) {
            layer.msg('营业结束时间不能为空', {icon: 2}, 1500);
            return false;
        }
        if (provid == "" || provid == null) {
            layer.msg('请选择省', {icon: 2}, 1500);
            return false;
        }
        if (cityid == "" || cityid == null) {
            layer.msg('请选择市', {icon: 2}, 1500);
            return false;
        }
        if (areaid == "" || areaid == null) {
            layer.msg('请选择县/区', {icon: 2}, 1500);
            return false;
        }
        if (address == "" || address == null) {
            layer.msg('详细地址不能为空', {icon: 2}, 1500);
            return false;
        }
        if (longitude == "" || longitude == null) {
            layer.msg('经度不能为空', {icon: 2}, 1500);
            return false;
        }
        if (latitude == "" || latitude == null) {
            layer.msg('纬度不能为空', {icon: 2}, 1500);
            return false;
        }
        if (logo == "" || logo == null) {
            layer.msg('请先上传餐厅LOGO', {icon: 2}, 1500);
            return false;
        }
        if (phone == "" || phone == null) {
            layer.msg('联系方式不能为空', {icon: 2}, 1500);
            return false;
        }
        if (!(/^1[34578]\d{9}$/.test(phone))) {
            layer.msg('联系方式有误，请重填', {icon: 2}, 1500);
            return false;
        }

        if (is_open_mail == 1 && shop_mail == "") {
            layer.msg('通知邮箱不能为空', {icon: 2}, 1500);
            return false;
        }
        if (shop_mail != "") {
            if (!(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(shop_mail))) {
                layer.msg('通知邮箱格式有误，请重填', {icon: 2}, 1500);
                return false;
            }
        }
    }

    //地址解析
    function open_map() {
        var province = $("#provid option:selected");
        var city = $("#cityid option:selected");
        var area = $("#areaid option:selected");
        var address = $("#address").val();

        if (province.val() == "" || province.val() == null) {
            layer.msg('请选择省份', {icon: 2}, 1500);
            return;
        }
        if (city.val() == "" || city.val() == null) {
            layer.msg('请选择城市', {icon: 2}, 1500);
            return;
        }
        if (area.val() == "" || area.val() == null) {
            layer.msg('请选择县区', {icon: 2}, 1500);
            return;
        }
        if (address == "" || address == null) {
            layer.msg('详细地址不能为空', {icon: 2}, 1500);
            return;
        }

        layer.open({
            type: 2,
            title: '选择地址',
            area: ['700px', '68%'],
            content: 'map?province=' + province.text() + "&city=" + city.text() + "&area=" + area.text() + "&address=" + address
        });
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

    function del_figure_img(obj, img_id) {
        if (img_id > 0) {
            layer.confirm('确定要删除此图片？', {
                btn: ['确定', '取消'] //按钮
            }, function () {
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('cater.shop.delFigureImg') }}",
                    data: {img_id: img_id},
                    dataType: "json",
                    success: function (res) {
                        if (res.errcode == 1) { //成功
                            $(obj).parent().parent().remove();
                        }

                        layer.closeAll();
                    }
                });
            }, function () {

            });
        } else {
            layer.confirm('确定要删除此图片？', {
                btn: ['确定', '取消'] //按钮
            }, function () {
                $(obj).parent().parent().remove();
                layer.closeAll();
            }, function () {

            });
        }
    }
</script>
