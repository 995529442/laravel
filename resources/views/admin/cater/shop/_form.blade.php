<input type="hidden" name="_token" class="tag_token" value="{{ csrf_token() }}">
<input type="hidden" name="shop_id" value="{{$shops_info['id']}}">
<div class="layui-form-item">
    <label for="" class="layui-form-label">餐厅名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" id="name" value="{{$shops_info['name']}}" lay-verify="required" placeholder="请输入餐厅名称" class="layui-input" style="width:40%;">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">堂食</label>
    <div class="layui-input-block">
        <input type="checkbox" name="is_eat_in_box" @if($shops_info['is_eat_in'] == 2) checked
               @endif id="is_eat_in_box" lay-skin="switch" lay-text="ON|OFF" lay-filter="is_eat_in_box">
        <input type="hidden" name="is_eat_in" id="is_eat_in" value="{{$shops_info['is_eat_in']}}">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">外卖</label>
    <div class="layui-input-block">
        <input type="checkbox" name="is_take_out_box" @if($shops_info['is_take_out'] == 2) checked
               @endif id="is_take_out_box" lay-skin="switch" lay-text="ON|OFF" lay-filter="is_take_out_box">
        <input type="hidden" name="is_take_out" id="is_take_out" value="{{$shops_info['is_take_out']}}">
    </div>
</div>

<div id="take_out" @if($shops_info == "" || $shops_info['is_take_out'] == 1)style="display:none;" @endif>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">起送费</label>
        <div class="layui-input-block">
            <input type="text" name="delivery_fee" id="delivery_fee" autocomplete="off" class="layui-input"
                   value="{{$shops_info['delivery_fee']}}" oninput="clearNoNum(this)"
                   style="width:20%;display:inline-block;margin-right:5px;">元
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">配送费</label>
        <div class="layui-input-block">
            <input type="text" name="shipping_fee" id="shipping_fee" autocomplete="off" class="layui-input"
                   value="{{$shops_info['shipping_fee']}}" oninput="clearNoNum(this)"
                   style="width:20%;display:inline-block;margin-right:5px;">元
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">包装费</label>
        <div class="layui-input-block">
            <input type="text" name="package_fee" id="package_fee" autocomplete="off" class="layui-input"
                   value="{{$shops_info['package_fee']}}" oninput="clearNoNum(this)"
                   style="width:20%;display:inline-block;margin-right:5px;">元
        </div>
    </div>
</div>
<div class="layui-form-item" id="take_out_delivery" @if($shops_info == "" || $shops_info['is_take_out'] == 1)style="display:none;" @endif>
    <label for="" class="layui-form-label">配送范围</label>
    <div class="layui-input-block">
        <input type="text" name="delivery_km" id="delivery_km" autocomplete="off" class="layui-input"
               value="{{$shops_info['delivery_km']}}" oninput="clearNoNum(this)"
               style="width:20%;display:inline-block;margin-right:5px;">公里
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">营业时间</label>
    <div class="layui-input-block">
        <input type="text" name="begin_time" id="begin_time" value="{{$shops_info['begin_time']}}"
               autocomplete="off" class="layui-input" style="display:inline-block;width:20%;"
               readonly="readonly">
        <span>至</span>
        <input type="text" name="end_time" id="end_time" value="{{$shops_info['end_time']}}" autocomplete="off"
               class="layui-input" style="display:inline-block;width:20%;" readonly="readonly">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">营业状态</label>
    <div class="layui-input-block">
        <input type="radio" name="status" value="1" title="营业"
               @if($shops_info['id'] > 0) @if($shops_info['status'] == 1) checked="checked"
               @endif @else checked="checked" @endif/>
        <input type="radio" name="status" value="2" title="打烊"
               @if($shops_info['status'] == 2) checked="checked" @endif />
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">联系地址</label>
    <div class="layui-input-inline">
        <select name="provid" id="provid" lay-filter="provid">
            <option value="">请选择省</option>
            @foreach($provinces as $v)
                <option value="{{$v->id}}"
                        @if($shops_info['province_id'] == $v->id) selected @endif>{{$v->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="layui-input-inline" id="city_display">
        <select name="cityid" id="cityid" lay-filter="cityid">
            <option value="">请选择市</option>
            @if($cities != "")
                @foreach($cities as $v)
                    <option value="{{$v->id}}"
                            @if($shops_info['city_id'] == $v->id) selected @endif>{{$v->name}}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="layui-input-inline" id="area_display">
        <select name="areaid" id="areaid" lay-filter="areaid">
            <option value="">请选择县/区</option>
            @if($countris != "")
                @foreach($countris as $v)
                    <option value="{{$v->id}}"
                            @if($shops_info['area_id'] == $v->id) selected @endif>{{$v->name}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">详细地址</label>
    <div class="layui-input-block">
        <input type="text" name="address" id="address" autocomplete="off" class="layui-input"
               value="{{$shops_info['address']}}" style="display:inline-block;width:40%;">
        <button onclick="open_map()" type="button" class="layui-btn layui-btn-sm"
                style="display:inline-block;margin-top:-5px;">搜索
        </button>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">经度</label>
    <div class="layui-input-block">
        <input type="text" name="longitude" id="longitude" value="{{$shops_info['longitude']}}"
               autocomplete="off" class="layui-input" style="display:inline-block;width:27%;"
               readonly="readonly">
        <span>纬度：</span>
        <input type="text" name="latitude" id="latitude" value="{{$shops_info['latitude']}}" autocomplete="off"
               class="layui-input" style="display:inline-block;width:27%;" readonly="readonly">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">LOGO</label>
    <div class="layui-input-block">
        <button type="button" class="layui-btn layui-btn-sm" id="preview_logo_id">上传图片</button>
        <input type="hidden" class="layui-btn" name="logo" id="logo" value="{{$shops_info['logo']}}">
        <div class="layui-upload-list">
            <img class="layui-upload-img" id="preview_logo"
                 @if($shops_info['show_logo'] != "") src="{{$shops_info['show_logo']}}"
                 style="width:100px;height:100px;" @endif>
            <p id="demoText"></p>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">商家展示图：</label>
    <div class="layui-upload">
        <button type="button" class="layui-btn layui-btn-sm" id="figure_img">多图片上传</button>
        <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;margin-left: 120px;">
            预览图：
            <div class="layui-upload-list" id="preview_figure">
                <ul>
                    @if($figure_img != "")
                        @foreach($figure_img as $v)
                            <li style="display:inline-block;">
                                <input type="hidden" name="figure_img_id[]" value="{{$v->id}}">
                                <input type="hidden" name="figure_img[]" value="{{$v->img_path}}">
                                <img style="width:150px;height:100px;" src="{{$v->img_path}}" alt=""
                                     class="layui-upload-img">
                                <div style="display:inline-block;position:relative;top:-40px;width:20px;border:1px solid #F73455;border-radius: 70%;cursor: pointer;">
                                    <p style="padding-left:4px;color:#F73455;"
                                       onclick="del_figure_img(this,{{$v->id}})">X</p></div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </blockquote>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">联系电话：</label>
    <div class="layui-input-block">
        <input type="text" name="phone" id="phone" lay-verify="required|phone" autocomplete="off"
               class="layui-input" value="{{$shops_info['phone']}}" style="width:40%;">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">是否开启购物币支付：</label>
    <div class="layui-input-inline">
        <input type="checkbox" name="is_open_currency_box" @if($shops_info['is_open_currency'] == 1) checked
               @endif id="is_open_currency_box" lay-skin="switch" lay-text="ON|OFF"
               lay-filter="is_open_currency_box">
        <input type="hidden" name="is_open_currency" id="is_open_currency"
               value="{{$shops_info['is_open_currency']}}">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">是否开启短信通知：</label>
    <div class="layui-input-inline">
        <input type="checkbox" name="is_open_sms_box" @if($shops_info['is_open_sms'] == 1) checked
               @endif id="is_open_sms_box" lay-skin="switch" lay-text="ON|OFF" lay-filter="is_open_sms_box">
        <input type="hidden" name="is_open_sms" id="is_open_sms" value="{{$shops_info['is_open_sms']}}">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">是否开启邮件通知：</label>
    <div class="layui-input-inline">
        <input type="checkbox" name="is_open_mail_box" @if($shops_info['is_open_mail'] == 1) checked
               @endif id="is_open_mail_box" lay-skin="switch" lay-text="ON|OFF" lay-filter="is_open_mail_box">
        <input type="hidden" name="is_open_mail" id="is_open_mail" value="{{$shops_info['is_open_mail']}}">
    </div>
</div>

<div class="layui-form-item" id="open_mail"
     @if($shops_info == "" || $shops_info['is_open_mail'] == 0)style="display:none;" @endif>
    <div class="layui-form-item">
        <label class="layui-form-label">通知邮箱：</label>
        <div class="layui-input-block">
            <input type="text" name="shop_mail" id="shop_mail" autocomplete="off" class="layui-input"
                   value="{{$shops_info['shop_mail']}}" style="width:40%;">
        </div>
    </div>
</div>

<div class="layui-form-item layui-form-text">
    <label class="layui-form-label">餐厅介绍：</label>
    <div class="layui-input-block">
                <textarea placeholder="请输入内容" name="introduce"
                          class="layui-textarea">{{$shops_info['introduce']}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
    </div>
</div>