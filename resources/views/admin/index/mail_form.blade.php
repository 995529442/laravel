<input type="hidden" name="_token" class="tag_token" value="{{ csrf_token() }}">
<div class="layui-form-item">
    <label class="layui-form-label">授权码：</label>
    <div class="layui-input-block">
        <input type="text" name="password" id="password" autocomplete="off" class="layui-input"
               value="@if(count($mail_list) > 0){{$mail_list[0]->password}}@endif"
               style="display:inline-block;width:20%;">
    </div>
</div>
@if(count($mail_list) > 0)
    <div class="layui-form-item" id="name_div">
        <label class="layui-form-label">邮箱账号：</label>
        @foreach($mail_list as $v)
            <input type="hidden" value="{{$v->id}}" name="mail_id[]">
            <div class="layui-input-block">
                <input type="text" name="name[]" id="name" autocomplete="off" class="layui-input"
                       value="{{$v->name}}" style="display:inline-block;width:20%;">

                <div class="layui-inline">
                    <button type="button" class="layui-btn layui-btn-normal layui-btn-xs"
                            style="width:36px;height:36px;background-color:#FF6600;" onclick="minu_time(this);">
                        -
                    </button>
                    <button type="button" class="layui-btn layui-btn-normal layui-btn-xs"
                            style="width:36px;height:36px;" onclick="add_time();">+
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="layui-form-item" id="name_div">
        <label class="layui-form-label">邮箱账号：</label>
        <div class="layui-input-block">
            <input type="text" name="name[]" id="name" autocomplete="off" class="layui-input" value=""
                   style="display:inline-block;width:20%;">

            <div class="layui-inline">
                <button type="button" class="layui-btn layui-btn-normal layui-btn-xs"
                        style="width:36px;height:36px;" onclick="add_time();">+
                </button>
            </div>
        </div>
    </div>
@endif
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
    </div>
</div>