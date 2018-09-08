{{csrf_field()}}
<input type="hidden" name="_token" class="tag_token" value="{{ csrf_token() }}">
<input type="hidden" name="cate_id" id="cate_id" value="{{$cate_info['id']}}">
<div class="layui-form-item">
    <label class="layui-form-label">分类名称：</label>
    <div class="layui-input-block">
        <input type="text" name="cate_name" id="cate_name" value="{{$cate_info['cate_name']}}"
               autocomplete="off" class="layui-input" style="width:20%">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">排序：</label>
    <div class="layui-input-block">
        <input type="number" name="sort" id="sort" value="{{$cate_info['sort']}}" autocomplete="off"
               class="layui-input" style="width:20%">
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('cater.category.index')}}" >返 回</a>
    </div>
</div>