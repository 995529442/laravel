<input type="hidden" name="_token" class="tag_token" value="{{ csrf_token() }}">
<input type="hidden" name="goods_id" value="{{$goods_info['id']}}">
<div class="layui-form-item">
    <label for="" class="layui-form-label">商品名称</label>
    <div class="layui-input-block">
        <input type="text" name="good_name" id="good_name" value="{{$goods_info['good_name']}}" lay-verify="required" placeholder="请输入商品名称" class="layui-input" style="width:20%;">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">所属分类</label>
    <div class="layui-input-inline">
        <select name="cate_id" id="cate_id" lay-filter="cate_id" >
            <option value="">请选择分类</option>
            @foreach($cate_info as $v)
                <option value="{{$v->cate_id}}"
                        @if($goods_info['cate_id'] == $v->cate_id) selected @endif>{{$v->cate_name}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">是否热卖</label>
    <div class="layui-input-block">
        <input type="checkbox" name="is_hot_box" @if($goods_info['is_hot'] == 1) checked @endif id="is_hot_box"
               lay-skin="switch" lay-text="ON|OFF" lay-filter="is_hot_box">
        <input type="hidden" name="is_hot" id="is_hot" value="{{$goods_info['is_hot']}}">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">是否新品</label>
    <div class="layui-input-block">
        <input type="checkbox" name="is_new_box" @if($goods_info['is_new'] == 1) checked @endif id="is_new_box"
               lay-skin="switch" lay-text="ON|OFF" lay-filter="is_new_box">
        <input type="hidden" name="is_new" id="is_new" value="{{$goods_info['is_new']}}">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否推荐</label>
    <div class="layui-input-block">
        <input type="checkbox" name="is_recommend_box" @if($goods_info['is_recommend'] == 1) checked
               @endif id="is_recommend_box" lay-skin="switch" lay-text="ON|OFF" lay-filter="is_recommend_box">
        <input type="hidden" name="is_recommend" id="is_recommend" value="{{$goods_info['is_recommend']}}">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">缩略图</label>
    <div class="layui-input-block">
        <button type="button" class="layui-btn layui-btn-sm" id="preview_thumb_id"
                style="display:inline-block;">上传图片
        </button>
        <span>(建议：图片尺寸100px*100px,图片大小不能大于1M)</span>
        <input type="hidden" class="layui-btn" name="thumb_img" id="thumb_img"
               value="{{$goods_info['thumb_img']}}">
        <div class="layui-upload-list">
            <img class="layui-upload-img" id="preview_thumb"
                 @if($goods_info['thumb_img'] != "") src="{{$goods_info['show_thumb_img']}}"
                 style="width:100px;height:100px;" @endif>
            <p id="demoText"></p>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">展示图：</label>
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
    <label for="" class="layui-form-label">是否上架</label>
    <div class="layui-input-block">
        <input type="checkbox" name="isout_box" @if($goods_info['isout'] == 2) checked @endif id="isout_box"
               lay-skin="switch" lay-text="ON|OFF" lay-filter="isout_box">
        <input type="hidden" name="isout" id="isout" value="{{$goods_info['isout']}}">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">原价</label>
    <div class="layui-input-block">
        <input type="text" oninput="clearNoNum(this)" name="original_price" id="original_price"
               autocomplete="off" class="layui-input" value="{{$goods_info['original_price']}}"
               style="width:20%;">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">现价</label>
    <div class="layui-input-block">
        <input type="text" oninput="clearNoNum(this)" name="now_price" id="now_price" autocomplete="off"
               class="layui-input" value="{{$goods_info['now_price']}}" style="width:20%;">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">库存</label>
    <div class="layui-input-block">
        <input type="number" oninput="clearNum(this)" name="storenum" id="storenum" autocomplete="off"
               class="layui-input" value="{{$goods_info['storenum']}}" style="width:20%;">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">虚拟销量</label>
    <div class="layui-input-block">
        <input type="number" oninput="clearNum(this)" name="virtual_sell_count" id="virtual_sell_count"
               autocomplete="off" class="layui-input" value="{{$goods_info['virtual_sell_count']}}"
               style="width:20%;">
    </div>
</div>
<div class="layui-form-item">
    <label class="layui-form-label">商品介绍</label>
    <div class="layui-input-block">
      <textarea placeholder="请输入内容" name="introduce"
                          class="layui-textarea">{{$goods_info['introduce']}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('cater.goods.index')}}" >返 回</a>
    </div>
</div>