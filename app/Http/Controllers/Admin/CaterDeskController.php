<?php
/**
 * Created by PhpStorm.
 * User: 12183
 * Date: 2018/9/7
 * Time: 13:50
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Librarys\MiniappApi;
use DB;

class CaterDeskController extends Controller
{
    //微餐饮-餐桌首页
    public function index(Request $request)
    {
        var_dump( \Request::getRequestUri());
        exit;
        abort("401");
        return view("admin.cater.desk.index");
    }

    public function data(Request $request)
    {

        $admins = Auth::guard()->user();
        $admin_id = $admins->id;

        $res = DB::table("cater_desk")->where(['admin_id' => $admin_id, 'isvalid' => true])->orderBy('id', 'desc')
            ->paginate($request->get('limit',16))->toArray();

        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    //微餐饮-添加餐桌
    public function addDesk(Request $request)
    {
        $admins = Auth::guard()->user();
        $admin_id = $admins->id;

        $desk_id = (int)$request->input("desk_id", 0);

        $desk_info = "";
        if ($desk_id) {
            $desk_info = DB::table("cater_desk")->whereId($desk_id)->first();
        }

        return view("admin.cater.desk.add_desk", [
            'desk_id' => $desk_id,
            'desk_info' => $desk_info
        ]);
    }

    //微餐饮-保存餐桌
    public function saveDesk(Request $request)
    {
        $admins = Auth::guard()->user();
        $admin_id = $admins->id;

        $desk_id = (int)$request->input("desk_id", 0);
        $name = $request->input("name", "");

        if ($desk_id > 0) {
            $result = DB::table("cater_desk")->whereId($desk_id)->update(['name' => $name]);

            if ($result) {
                return redirect(route('cater.desk.index'))->with(['status'=>'成功']);
            } else {
                return redirect(route('cater.desk.index'))->with(['status'=>'成功']);
            }
        } else {
            $data = array(
                "admin_id" => $admin_id,
                "name" => $name,
                "isvalid" => true
            );
            $result = DB::table("cater_desk")->insert($data);

            if ($result) {
                return redirect(route('cater.desk.index'))->with(['status'=>'成功']);
            } else {
                return redirect(route('cater.desk.index'))->with(['status'=>'失败']);
            }
        }

        return json_encode($return);
    }

    //微餐饮-餐桌处理
    public function operate(Request $request)
    {
        $admins = Auth::guard()->user();
        $admin_id = $admins->id;

        $desk_id = (int)$request->input("desk_id", 0);
        $type = $request->input("type", '');

        $return = array(
            "code" => 1,
            "msg" => "失败"
        );

        if ($desk_id) {
            if ($type == 'del') {  //删除
                $result = DB::table("cater_desk")->whereId($desk_id)->update(['isvalid' => false]);

                if ($result) {
                    $return['code'] = 0;
                    $return['msg'] = '删除成功';
                }
            } else {  //生成二维码
                $result = MiniappApi::createQrCode($admin_id, '/cater/desk');

                if ($result['errcode'] == 1) { //成功
                    $return['code'] = 0;
                    $return['msg'] = '生成成功';

                    $path = $result['path'];

                    DB::table("cater_desk")->whereId($desk_id)->update(['img_path' => $path]);
                } else {
                    $return['msg'] = $result['errmsg'];
                }
            }
        } else {
            $return['msg'] = '系统错误';
        }

        return response()->json($return);
    }
}
