<input type="hidden" name="_token" class="tag_token" value="{{ csrf_token() }}">
<input type="hidden" name="sms_template_id" value="@if($temp_info){{$temp_info->id}}@endif">
<div class="layui-form-item">
    <label class="layui-form-label">模板ID：</label>
    <div class="layui-input-block">
        <input type="text" name="template_id" id="template_id" autocomplete="off" class="layui-input"
               value="@if($temp_info){{$temp_info->template_id}}@endif" style="width:30%;">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">类型：</label>
    <div class="layui-input-inline">
        <select name="type" id="type" lay-filter="type">
            <option value="0">请选择</option>
            <option value="1" @if($temp_info){{$temp_info->type == 1}} selected @endif>验证</option>
            <option value="2" @if($temp_info){{$temp_info->type == 2}} selected @endif>下单提示</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">是否启用：</label>
    <div class="layui-input-inline">
        <input type="checkbox" name="is_on_box" @if($temp_info && $temp_info->is_on == 1) checked
               @endif id="is_on_box" lay-skin="switch" lay-text="ON|OFF" lay-filter="is_on_box">
        <input type="hidden" name="is_on" id="is_on" value="@if($temp_info){{$temp_info->is_on}}@endif">
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-filter="demo1">提交</button>
        <button type="button" class="layui-btn layui-btn-primary" onclick="javascript:history.go(-1);">取消
        </button>
    </div>
</div>