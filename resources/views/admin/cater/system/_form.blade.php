<input type="hidden" name="_token" class="tag_token" value="{{ csrf_token() }}">
<input type="hidden" name="id" id="id" class="tag_token" value="{{$system['id']}}">
<div class="layui-form-item">
    <label class="layui-form-label">appid：</label>
    <div class="layui-input-block">
        <input type="text" name="appid" id="appid" autocomplete="off" class="layui-input"
               value="{{$system['appid']}}" style="width:40%;">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">appsecret：</label>
    <div class="layui-input-block">
        <input type="text" name="appsecret" id="appsecret" autocomplete="off" class="layui-input"
               value="{{$system['appsecret']}}" style="width:40%;">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">商户号：</label>
    <div class="layui-input-block">
        <input type="text" name="mch_id" id="mch_id" autocomplete="off" class="layui-input"
               value="{{$system['mch_id']}}" style="width:40%;">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">apiclient_cert：</label>
    <div class="layui-upload">
        <button type="button" class="layui-btn layui-btn-sm" id="preview_cert_id">上传</button>
        <input type="hidden" class="layui-btn" name="apiclient_cert" id="apiclient_cert"
               value="{{$system['apiclient_cert']}}">
        <div class="layui-upload-list">
            <p id="apiclient_cert_p">{{$system['apiclient_cert']}}</p>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">apiclient_key：</label>
    <div class="layui-upload">
        <button type="button" class="layui-btn layui-btn-sm" id="preview_key_id">上传</button>
        <input type="hidden" class="layui-btn" name="apiclient_key" id="apiclient_key"
               value="{{$system['apiclient_key']}}">
        <div class="layui-upload-list">
            <p id="apiclient_key_p">{{$system['apiclient_key']}}</p>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
    </div>
</div>