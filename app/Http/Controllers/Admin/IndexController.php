<?php

namespace App\Http\Controllers\Admin;

date_default_timezone_set('PRC');

use Validator;
use App\Models\Icon;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Librarys\Sms;
use DB;

class IndexController extends Controller
{
    /**
     * 后台布局
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function layout()
    {
        return view('admin.layout');
    }

    /**
     * 后台首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index.index');
    }
    public function index1()
    {
        return view('admin.index.index1');
    }
    public function index2()
    {
        return view('admin.index.index2');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 数据表格接口
     */
    public function data(Request $request)
    {
        $model = $request->get('model');
        switch (strtolower($model)) {
            case 'user':
                $query = new User();
                break;
            case 'role':
                $query = new Role();
                break;
            case 'permission':
                $query = new Permission();
                $query = $query->where('parent_id', $request->get('parent_id', 0))->with('icon');
                break;
            default:
                $query = new User();
                break;
        }
        $res = $query->paginate($request->get('limit', 30))->toArray();
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 所有icon图标
     */
    public function icons()
    {
        $icons = Icon::orderBy('sort', 'desc')->get();
        return response()->json(['code' => 0, 'msg' => '请求成功', 'data' => $icons]);
    }

    /**
     * 邮件页面
     * @return view
     */
    public function mail(Request $request)
    {
        //查找邮箱设置
        $mail_list = DB::table("mail")->where(['admin_id' => Auth::guard()->user()->id, 'type' => 1, 'isvalid' => true])->get();

        return view('admin.index.mail', ['mail_list' => $mail_list]);
    }

    /**
     * 保存邮件设置
     * @return view
     */
    public function saveMail(Request $request)
    {
        $password = $request->input("password", '');
        $mail_id = $request->input("mail_id", '');
        $name = $request->input("name", '');

        if (is_array($mail_id)) {
            $data_count = 0;

            if (is_array($name)) {
                $name_count = count($name);
            } else {
                $name_count = 0;
            }
            if (count($mail_id) >= $name_count) {
                $data_count = count($mail_id);
            } else {
                $data_count = $name_count;
            }

            for ($k = 0; $k < $data_count; $k++) {
                if (isset($mail_id[$k]) && (int)$mail_id[$k] > 0 && isset($name[$k])) { //修改
                    $update_data = array(
                        "password" => $password,
                        "name" => $name[$k]
                    );

                    $result = DB::table("mail")->whereId((int)$mail_id[$k])->update($update_data);

                } elseif (isset($mail_id[$k]) && (int)$mail_id[$k] > 0 && !isset($name[$k])) { //删除
                    $result = DB::table("mail")->whereId((int)$mail_id[$k])->update(['isvalid' => false]);
                } else {
                    $insert_data = array(
                        "admin_id" => Auth::guard()->user()->id,
                        "type" => 1,
                        "password" => $password,
                        "name" => $name[$k],
                        "isvalid" => true
                    );
                    $result = DB::table("mail")->insert($insert_data);
                }
            }
        } else {
            $insert_data = array();

            for ($k = 0; $k < count($name); $k++) {
                $data = array();

                $data['admin_id'] = Auth::guard()->user()->id;
                $data['type'] = 1;
                $data['password'] = $password;
                $data['name'] = $name[$k];
                $data['isvalid'] = true;

                array_push($insert_data, $data);

                unset($data);
            }

            $reuslt = DB::table("mail")->insert($insert_data);
        }

        return redirect(route('mail'))->with(['status'=>'成功']);
    }

    /**
     * 短信页面
     * @return view
     */
    public function sms(Request $request)
    {
        //查找邮箱设置
        $sms_list = DB::table("sms")->where(['admin_id' => Auth::guard()->user()->id, 'isvalid' => true])->first();

        return view('admin.index.sms', ['sms_list' => $sms_list]);
    }

    /**
     * 保存短信设置
     * @return view
     */
    public function saveSms(Request $request)
    {
        $sms_id = (int)$request->input("sms_id", 0);
        $accountsid = $request->input("accountsid", '');
        $appid = $request->input("appid", '');
        $token = $request->input("token", '');

        $data = array(
            "accountsid" => $accountsid,
            "appid" => $appid,
            "token" => $token
        );

        if ($sms_id > 0) { //更新
            $result = DB::table("sms")->whereId($sms_id)->update($data);
        } else {
            $data['admin_id'] = Auth::guard()->user()->id;
            $data['isvalid'] = true;

            $result = DB::table("sms")->insert($data);
        }

        return redirect(route('sms'))->with(['status'=>'成功']);
    }

    /**
     * 短信模板
     * @return view
     */
    public function smsTemplate(Request $request)
    {
        return view('admin.index.sms_template');
    }

    public function sms_data(Request $request)
    {
        $res = DB::table('sms_template')->where(['admin_id' => Auth::guard()->user()->id, 'isvalid' => true])
            ->orderBy('id', 'desc')->paginate(16)->toArray();

        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * 新增编辑短信模板
     * @return view
     */
    public function addSmsTemplate(Request $request)
    {
        $sms_template_id = (int)$request->input("sms_template_id", 0);

        $temp_info = "";

        if ($sms_template_id) {
            $temp_info = DB::table("sms_template")->whereId($sms_template_id)->first();
        }

        return view('admin.index.add_sms_template', ['temp_info' => $temp_info]);
    }

    /**
     * 保存短信模板
     * @return view
     */
    public function saveSmsTemplate(Request $request)
    {
        $sms_template_id = (int)$request->input("sms_template_id", 0);
        $template_id = $request->input("template_id", '');
        $type = (int)$request->input("type", 0);
        $is_on = (int)$request->input("is_on", 0);

        $data = array(
            'template_id' => $template_id,
            'type' => $type,
            'is_on' => $is_on
        );
        if ($sms_template_id > 0) { //修改
            $result = DB::table("sms_template")->whereId($sms_template_id)->update($data);
        } else {
            $data['admin_id'] = Auth::guard()->user()->id;
            $data['isvalid'] = true;

            $result = DB::table("sms_template")->insert($data);
        }

        return redirect(route('smsTemplate'))->with(['status'=>'成功']);
    }

    /**
     * 删除短信模板
     * @return view
     */
    public function delSmsTemplate(Request $request)
    {
        $sms_template_id = (int)$request->input("sms_template_id", 0);
        if (empty($sms_template_id)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        $template = DB::table("sms_template")->find($sms_template_id);
        if (!$template){
            return response()->json(['code'=>1,'msg'=>'数据不存在']);
        }

        $result = DB::table("sms_template")->whereId($sms_template_id)->update(['isvalid' => false]);

        if ($result) {
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }

        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }

    /**
     * 发送日志
     * @return view
     */
    public function sendLog(Request $request)
    {
        return view('admin.index.send_log');
    }

    public function send_log_data(Request $request)
    {
        $res = DB::table('send_log')->where("admin_id", Auth::guard()->user()->id)
            ->orderBy("id", "desc")->paginate(18)->toArray();

        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }
    /**
     * 测试短信
     * @return view
     */
    public function testSms(Request $request)
    {
        $type = (int)$request->input("type", 0);
        $phone = $request->input("phone", '');

        if ($request->isMethod('post')) {

            if ($type == 1) {
                $param = "123456";
            } else {
                $param = "123456,0.01,佚名,135XXXXXXXX";
            }
            $result = Sms::sendSms(Auth::guard()->user()->id, $type, $param, $phone);

            if ($result['errcode'] == 1) {
                return redirect()->route('testSms', ['type'=>$type])->with(['status'=>'成功']);
            }else{
                return redirect()->route('testSms', ['type'=>$type])->with(['status'=>$result['errmsg']]);
            }
        }
        return view('admin.index.test_sms', ['type' => $type]);
    }
}
