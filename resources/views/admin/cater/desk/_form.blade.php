{{csrf_field()}}
<input type="hidden" name="_token" class="tag_token" value="{{ csrf_token() }}">
<input type="hidden" name="desk_id" id="desk_id" value="{{$desk_id}}">
<div class="layui-form-item">
    <label class="layui-form-label">餐桌名称：</label>
    <div class="layui-input-block">
        <input type="text" name="name" id="name" value="@if($desk_info != ''){{$desk_info->name}}@endif"
               autocomplete="off" class="layui-input" style="width:20%">
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('cater.desk.index')}}" >返 回</a>
    </div>
</div>