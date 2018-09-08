<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cater\CaterUsers;
use DB;

class CaterUsersController extends Controller
{
    //微餐饮-用户首页
    public function index(Request $request)
    {
        return view('admin.cater.users.index');
    }

    public function data(Request $request)
    {
        $admins = Auth::guard()->user();
        $admin_id = $admins->id;

        $weixin_name = $request->input('weixin_name', '');
        $mobile = $request->input('mobile', '');
        $sex = (int)$request->input('sex', 0);

        //获取用户信息
        $CaterUsers = CaterUsers::where(["admin_id" => $admin_id, 'isvalid' => true]);

        if ($weixin_name) {
            $CaterUsers->where("weixin_name", 'like', "%$weixin_name%");
        }

        if ($mobile) {
            $CaterUsers->where("mobile", 'like', "%$mobile%");
        }

        if ($sex) {
            $CaterUsers->where("sex", '=', $sex);
        }
        $res = $CaterUsers->orderBy('id', 'desc')->paginate($request->get('limit',30))->toArray();

        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];

        return response()->json($data);
    }

    //微餐饮-购物币充值
    public function add_currency(Request $request)
    {
        $user_id = (int)$request->input('user_id', 0);

        return view('admin.cater.users.add_currency', [
            'user_id' => $user_id
        ]);
    }

    //微餐饮-保存购物币
    public function save_currency(Request $request)
    {
        $user_id = (int)$request->input('user_id', 0);
        $money = (float)$request->input('money', 0);

        $return = array(
            "errcode" => -1,
            "errmsg" => "失败"
        );

        if ($user_id > 0) {
            try {
                DB::beginTransaction();

                DB::table("cater_users")->whereId($user_id)->increment("currency_money", $money);

                DB::table("cater_currency_log")->insert([
                    "admin_id" => Auth::guard()->user()->id,
                    "operate_from" => Auth::guard()->user()->username,
                    "user_id" => $user_id,
                    "operate_to" => DB::table("cater_users")->whereId($user_id)->value("weixin_name"),
                    "remark" => "后台充值" . $money . "元",
                    "create_time" => time(),
                    "type" => 1,
                    "currency_money" => $money,
                    "isvalid" => true
                ]);

                DB::commit();

                return redirect(route('cater.users.index'))->with(['status'=>'成功']);

            } catch (\Exception $exception) {
                DB::rollback();//事务回滚
                throw $exception;
            }
        } else {
            $return['errmsg'] = "用户不存在";
        }

        return redirect(route('cater.users.index'))->with(['status'=>$return['errmsg']]);
    }

    //微餐饮-购物币日志
    public function currency_log(Request $request)
    {
        $user_id = (int)$request->input('user_id', 0);
        return view('admin.cater.users.currency_log',['user_id'=>$user_id]);
    }

    public function data_log(Request $request)
    {
        $admins = Auth::guard()->user();
        $admin_id = $admins->id;

        $user_id = (int)$request->input('user_id', 0);

        $res = DB::table("cater_currency_log")->where(['admin_id' => $admin_id, 'user_id' => $user_id, 'isvalid' => true])
            ->orderByDesc("id")->paginate($request->get('limit',30))->toArray();

        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];

        return response()->json($data);
    }
}
