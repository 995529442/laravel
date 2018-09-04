<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CaterCategory;
use Illuminate\Support\Facades\Auth;
use DB;

class CaterCategoryController extends Controller
{
    //微餐饮-分类首页
    public function index(Request $request)
    {
/*        $admins = Auth::guard()->user();
        $admin_id = $admins->id;

        $cate_name = $request->input("cate_name", "");

        $category = CaterCategory::where(['admin_id' => $admin_id, 'isvalid' => true]);

        if ($cate_name) {
            $category->where("cate_name", "like", "%$cate_name%");
        }

        $category_info = $category->orderBy('sort', 'desc')->paginate(12);

        return view("admin.cater.category.index", [
            'category_info' => $category_info,
            'cate_name' => $cate_name
        ]);*/
        return view("admin.cater.category.index");
    }

    public function data(Request $request)
    {

        $admins = Auth::guard()->user();
        $admin_id = $admins->id;

        $res = CaterCategory::where(['admin_id' => $admin_id, 'isvalid' => true])->orderBy('sort','desc')
            ->paginate($request->get('limit',30))->toArray();

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

        $cate_info = CaterCategory::where(['id' => $cate_id, 'isvalid' => true])->first();

        return view("admin.cater.category.add_cate", ['cate_info' => $cate_info]);
    }

    //微餐饮-保存分类
    public function save_cate(Request $request)
    {
        $cate_id = (int)$request->input('cate_id', 0);

        if ($cate_id > 0) {
            $cater_cate = CaterCategory::findOrFail($cate_id);
        } else {
            $cater_cate = new CaterCategory;

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
        $admins = Auth::guard()->user();
        $admin_id = $admins->id;

        $id = (int)$request->input('cate_id', 0);

        $return = array(
            "errcode" => -1,
            "errmsg" => "失败"
        );

        if ($id > 0) {
            $result = CaterCategory::where(['admin_id' => $admin_id, 'id' => $id])->update(array("isvalid" => false));

            $return['errcode'] = 1;
            $return['errmsg'] = "删除成功";
        }

        return json_encode($return);
    }
}
