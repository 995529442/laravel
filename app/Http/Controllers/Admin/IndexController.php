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
use App\Jobs\TestSms;
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
        //获取收入情况
        $day_money = 0;  //日收入情况
        $yesterday_money = 0;  //昨日收入情况

        $week_money = 0;  //周收入情况
        $lastweek_money = 0;  //上周收入情况

        $month_money = 0;  //月收入情况
        $lastmonth_money = 0;  //上月收入情况

        $day_num = 0;  //日订单数
        $yesterday_num = 0;  //昨日订单数

        $day_ratil = 0; //日收入增比
        $week_ratil = 0; //周收入增比
        $month_ratil = 0; //月收入增比

        $where = array(
            "admin_id"=>Auth::guard()->user()->id,
            "pay_type"=>1,
            "status" =>5,
            "isvalid"=>true
        );

        $day_money =  DB::table("cater_orders")->where($where)->where("create_time",">",strtotime(date("Y-m-d",time())))
            ->where("create_time","<=",strtotime(date("Y-m-d",time()))+3600*24-1)->sum('real_pay');

        $yesterday_money =  DB::table("cater_orders")->where($where)->where("create_time",">",strtotime(date("Y-m-d",strtotime("-1 day"))))
            ->where("create_time","<=",strtotime(date("Y-m-d",strtotime("-1 day")))+3600*24-1)->sum('real_pay');

        $week_money =  DB::table("cater_orders")->where($where)->where("create_time",">",strtotime(date("Y-m-d",strtotime("-6 day"))))
            ->where("create_time","<=",strtotime(date("Y-m-d",time()))+3600*24-1)->sum('real_pay');

        $lastweek_money =  DB::table("cater_orders")->where($where)->where("create_time",">",strtotime(date("Y-m-d",strtotime("-13 day"))))
            ->where("create_time","<=",strtotime(date("Y-m-d",strtotime("-7 day")))+3600*24-1)->sum('real_pay');

        $BeginDate=date('Y-m-01', strtotime(date("Y-m-d")));
        $month_money =  DB::table("cater_orders")->where($where)->where("create_time",">",strtotime($BeginDate))
            ->where("create_time","<=",strtotime("$BeginDate +1 month -1 day")+3600*24-1)->sum('real_pay');

        $lastmonth_money =  DB::table("cater_orders")->where($where)->where("create_time",">",strtotime(date("Y-m-d",strtotime(date('Y-m-01') . ' -1 month'))))
            ->where("create_time","<=",strtotime(date("Y-m-d",strtotime(date('Y-m-01') . ' -1 day')))+3600*24-1)->sum('real_pay');

        if($yesterday_money){
            $day_ratil = round(($day_money-$yesterday_money)/$yesterday_money*100,2);
        }else{
            $day_ratil = 100;
        }

        if($lastweek_money){
            $week_ratil = round(($week_money-$lastweek_money)/$lastweek_money*100,2);
        }else{
            $week_ratil = 100;
        }

        if($lastmonth_money){
            $month_ratil = round(($month_money-$lastmonth_money)/$lastmonth_money*100,2);
        }else{
            $month_ratil = 100;
        }
        unset($where['status']);
        $day_num =  DB::table("cater_orders")->where($where)->where('status','>',0)->where("create_time",">",strtotime(date("Y-m-d",time())))
            ->where("create_time","<=",strtotime(date("Y-m-d",time()))+3600*24-1)->count();

        $yesterday_num =  DB::table("cater_orders")->where($where)->where('status','>',0)->where("create_time",">",strtotime(date("Y-m-d",strtotime("-1 day"))))
            ->where("create_time","<=",strtotime(date("Y-m-d",strtotime("-1 day")))+3600*24-1)->count();

        //获取我的消息
        $message = DB::table("messages")->where(['send_uuid'=>Auth::guard()->user()->uuid])
            ->orWhere(['accept_uuid'=>Auth::guard()->user()->uuid])->orderBy('read','asc')
            ->select(['title','content','read','created_at'])->orderBy('id','desc')->paginate(16);

        //获取用户排行榜
        $user_info = DB::table("cater_users")->where(['admin_id'=>Auth::guard()->user()->id,'isvalid'=>true])
            ->select(['weixin_name','mobile','order_complete_num','total_money'])
            ->orderByDesc('total_money')
            ->limit(10)
            ->get();

        //菜品销量排行榜
        $goods_info = DB::table("cater_goods as g")->leftJoin('cater_category as ca','ca.id','=','g.cate_id')
            ->where(['g.admin_id'=>Auth::guard()->user()->id,'g.isvalid'=>true])
            ->select(['ca.cate_name','g.good_name','g.storenum','g.sell_count'])
            ->orderByDesc("sell_count")
            ->limit(10)
            ->get();

        //当前日期
        $categories = "";  //日期
        $tangshi = ""; //堂食
        $waimai = ""; //外卖

        $where['status'] = 5;
        for($k=6;$k>=0;$k--){
            $micro_time = strtotime("-$k day");
            $day = date("m-d",$micro_time);

            $categories .= $day.",";
            //获取点餐和外卖的订单情况
            $tangshi_count =  DB::table("cater_orders")->where($where)->where("create_time",">",strtotime(date("Y-m-d",$micro_time)))
                ->where("create_time","<=",strtotime(date("Y-m-d",$micro_time))+3600*24-1)->where(['type'=>1])->count();
            $waimai_count = DB::table("cater_orders")->where($where)->where("create_time",">",strtotime(date("Y-m-d",$micro_time)))
                ->where("create_time","<=",strtotime(date("Y-m-d",$micro_time))+3600*24-1)->where(['type'=>2])->count();

            $tangshi .= $tangshi_count.",";
            $waimai .= $waimai_count.",";
        }

        return view('admin.index.index',[
            'day_money' => $day_money,
            'yesterday_money' => $yesterday_money,
            'week_money' => $week_money,
            'lastweek_money' => $lastweek_money,
            'month_money' => $month_money,
            'lastmonth_money' => $lastmonth_money,
            'day_num' => $day_num,
            'yesterday_num' => $yesterday_num,
            'message' => $message,
            'user_info'=>$user_info,
            'goods_info'=>$goods_info,
            "categories" => rtrim($categories,','),
            "tangshi" => rtrim($tangshi,','),
            "waimai" => rtrim($waimai,','),
            'day_ratil'=>$day_ratil,
            'week_ratil'=>$week_ratil,
            'month_ratil'=>$month_ratil
        ]);
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
            $this->dispatch((new TestSms(Auth::guard()->user()->id, $type, $param, $phone))->onQueue('TestSms'));

            return redirect()->route('testSms', ['type'=>$type])->with(['status'=>'已尝试发送，结果请查看发送记录']);
/*            $result = Sms::sendSms(Auth::guard()->user()->id, $type, $param, $phone);

            if ($result['errcode'] == 1) {
                return redirect()->route('testSms', ['type'=>$type])->with(['status'=>'成功']);
            }else{
                return redirect()->route('testSms', ['type'=>$type])->with(['status'=>$result['errmsg']]);
            }*/
        }
        return view('admin.index.test_sms', ['type' => $type]);
    }
}
