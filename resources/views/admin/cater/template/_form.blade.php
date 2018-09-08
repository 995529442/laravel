{{csrf_field()}}
<input type="hidden" name="_token" class="tag_token" value="{{ csrf_token() }}">
<input type="hidden" name="temp_id" value="@if($temp_info){{$temp_info->id}}@endif">
<div class="layui-form-item">
    <label for="" class="layui-form-label">模板ID</label>
    <div class="layui-input-inline">
        <input type="text" name="template_id" id="template_id" value="@if($temp_info){{$temp_info->template_id}}@endif"
               lay-verify="required" placeholder="请输入模板ID" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">类型</label>
    <div class="layui-input-inline">
        <select name="type" id="type" lay-filter="type">
            <option value="0">请选择</option>
            <option value="1" @if($temp_info){{$temp_info->type == 1}} selected @endif>支付通知</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-inline">
        <input type="checkbox" name="is_on_box" @if($temp_info && $temp_info->is_on == 1) checked
               @endif id="is_on_box" lay-skin="switch" lay-text="ON|OFF" lay-filter="is_on_box">
        <input type="hidden" name="is_on" id="is_on" value="@if($temp_info){{$temp_info->is_on}}@endif">
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('cater.template.index')}}" >返 回</a>
    </div>
</div>