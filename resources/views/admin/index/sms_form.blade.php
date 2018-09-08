<input type="hidden" name="_token" class="tag_token" value="{{ csrf_token() }}">
<input type="hidden" value="@if($sms_list){{$sms_list->id}}@endif" name="sms_id">
<div class="layui-form-item">
    <label class="layui-form-label">accountsid：</label>
    <div class="layui-input-block">
        <input type="text" name="accountsid" id="accountsid" autocomplete="off" class="layui-input"
               value="@if($sms_list){{$sms_list->accountsid}}@endif" style="display:inline-block;width:30%;">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">appid：</label>
    <div class="layui-input-block">
        <input type="text" name="appid" id="appid" autocomplete="off" class="layui-input"
               value="@if($sms_list){{$sms_list->appid}}@endif" style="display:inline-block;width:30%;">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">token：</label>
    <div class="layui-input-block">
        <input type="text" name="token" id="token" autocomplete="off" class="layui-input"
               value="@if($sms_list){{$sms_list->token}}@endif" style="display:inline-block;width:30%;">
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
    </div>
</div>