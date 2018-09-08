<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cater\CaterCategory as CategoryModel;
use Illuminate\Support\Facades\Auth;
use DB;

class CaterCategoryController extends Controller
{
    //微餐饮-分类首页
    public function index(Request $request)
    {
        return view("admin.cater.category.index");
    }

    public function data(Request $request)
    {

        $admins = Auth::guard()->user();
        $admin_id = $admins->id;

        $res = CategoryModel::where(['admin_id' => $admin_id, 'isvalid' => true])->orderBy('sort','desc')
            ->paginate($request->get('limit',16))->toArray();

        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    //微餐饮-新增/编辑分类
    public function add_cate(Request $request)
    {
        $cate_id = (int)$request->input('cate_id', 0);

        $cate_info = CategoryModel::where(['id' => $cate_id, 'isvalid' => true])->first();

        return view("admin.cater.category.add_cate", ['cate_info' => $cate_info]);
    }

    //微餐饮-保存分类
    public function save_cate(Request $request)
    {
        $cate_id = (int)$request->input('cate_id', 0);

        if ($cate_id > 0) {
            $cater_cate = CategoryModel::findOrFail($cate_id);
        } else {
            $cater_cate = new CategoryModel;

            $admins = Auth::guard()->user();
            $admin_id = (int)$admins->id;

            $cater_cate->admin_id = $admin_id;
            $cater_cate->isvalid = true;
        }

        $cater_cate->cate_name = $request->input('cate_name', '');
        $cater_cate->sort = $request->input('sort', 0);

        $result = $cater_cate->save();

        if ($result) {
            return redirect(route('cater.category.index'))->with(['status'=>'成功']);
        } else {
            return redirect(route('cater.category.index'))->with(['status'=>'失败']);
        }
    }

    //微餐饮-分类操作
    public function operate(Request $request)
    {
        $id = (int)$request->input('cate_id', 0);
        if (empty($id)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        $cate = CategoryModel::find($id);
        if (!$cate){
            return response()->json(['code'=>1,'msg'=>'数据不存在']);
        }

        $result = CategoryModel::whereId($id)->update(array("isvalid" => false));

        if ($result) {
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }

        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }
}
