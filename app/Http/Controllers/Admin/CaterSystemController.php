<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cater\CaterSystem;
use App\Librarys\uploadFile;
use DB;

class CaterSystemController extends Controller
{
    //微餐饮-小程序管理
    public function index(Request $request)
    {
        $admins = Auth::guard()->user();
        $admin_id = $admins->id;

        $system = CaterSystem::where(["admin_id" => $admin_id, "isvalid" => true])->first();

        return view('admin.cater.system.index', ['system' => $system]);
    }

    //微餐饮-保存信息
    public function saveSystem(Request $request)
    {
        $id = (int)$request->input("id", '');

        if ($id) {
            $CaterSystem = CaterSystem::find($id);
        } else {
            $admins = Auth::guard()->user();
            $admin_id = $admins->id;

            $CaterSystem = new CaterSystem;
            $CaterSystem->admin_id = $admin_id;
            $CaterSystem->isvalid = true;
        }

        $return = array(
            "errcode" => -1,
            "errmsg" => "失败"
        );
        $CaterSystem->appid = $request->input("appid", '');
        $CaterSystem->appsecret = $request->input("appsecret", '');
        $CaterSystem->mch_id = $request->input("mch_id", '');
        $CaterSystem->apiclient_cert = $request->input("apiclient_cert", '');
        $CaterSystem->apiclient_key = $request->input("apiclient_key", '');

        $result = $CaterSystem->save();

        if ($result) {
            return redirect(route('cater.system.index'))->with(['status'=>'成功']);
        }else{
            return redirect(route('cater.system.index'))->with(['status'=>'失败']);
        }

    }

    //微餐饮-上传证书接口
    public function upload(Request $request)
    {
        if ($request->isMethod('post')) {
            $admins = Auth::guard()->user();
            $admin_id = $admins->id;

            $result = uploadFile::uploadImg($admin_id, $_FILES, '/cater/system/');
        } else {
            $result = ['errcode' => -1, 'errmsg' => '参数错误'];
        }
        return json_encode($result);
    }
}
