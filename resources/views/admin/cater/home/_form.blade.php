<input type="hidden" name="_token" class="tag_token" value="{{ csrf_token() }}">
<div class="layui-form-item">
    <label class="layui-form-label">商家展示图：</label>
    <div class="layui-upload">
        <button type="button" class="layui-btn layui-btn-sm" id="figure_img">多图片上传</button>
        <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;margin-left: 120px;">
            预览图：
            <div class="layui-upload-list" id="preview_figure">
                <ul>
                    @if($home_info != "")
                        @foreach($home_info as $v)
                            <li style="display:inline-block;">
                                <input type="hidden" name="figure_img_id[]" value="{{$v->id}}">
                                <input type="hidden" name="figure_img[]" value="{{$v->img_path}}">
                                <img style="width:150px;height:100px;" src="{{$v->img_path}}" alt=""
                                     class="layui-upload-img">
                                <div style="display:inline-block;position:relative;top:-40px;width:20px;border:1px solid #F73455;border-radius: 50%;cursor: pointer;">
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
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-filter="demo1">保存</button>
    </div>
</div>